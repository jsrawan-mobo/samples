#!/usr/bin/env python3
"""Archive one Facebook post using a browser session you control.

Saves visible post text, metadata, HTML, a full-page screenshot, and directly
accessible image/video files. It does not bypass Facebook privacy controls.

Install:
    python3 -m pip install playwright
    python3 -m playwright install chromium

Examples:
    python3 facebook_post_downloader.py URL
    python3 facebook_post_downloader.py URL --show-browser

On the first run, use --show-browser, sign in if needed, then press Enter in
the terminal. The login session is retained in ~/.fb-post-downloader-profile.
"""

from __future__ import annotations

import argparse
import hashlib
import json
import mimetypes
import re
import sys
from pathlib import Path
from typing import TYPE_CHECKING
from urllib.parse import urlparse

if TYPE_CHECKING:
    from playwright.sync_api import BrowserContext, Page


ALLOWED_HOSTS = {"facebook.com", "www.facebook.com", "m.facebook.com"}
MEDIA_TYPES = {"image/jpeg", "image/png", "image/webp", "image/gif", "video/mp4"}


def safe_name(value: str) -> str:
    value = re.sub(r"[^A-Za-z0-9._-]+", "-", value).strip("-.")
    return value[:90] or "facebook-post"


def post_id_from_url(url: str) -> str:
    patterns = (r"/posts/(\d+)", r"/permalink/(\d+)", r"story_fbid=(\d+)")
    for pattern in patterns:
        match = re.search(pattern, url)
        if match:
            return match.group(1)
    return hashlib.sha256(url.encode()).hexdigest()[:12]


def extension_for(content_type: str, url: str) -> str:
    suffix = Path(urlparse(url).path).suffix.lower()
    if suffix in {".jpg", ".jpeg", ".png", ".webp", ".gif", ".mp4"}:
        return suffix
    return mimetypes.guess_extension(content_type) or ".bin"


def close_login_prompt(page: "Page") -> None:
    for label in ("Close", "Not now"):
        try:
            page.get_by_role("button", name=label, exact=True).click(timeout=1500)
            return
        except Exception:
            pass


def visible_post_text(page: "Page") -> str:
    articles = page.locator("div[role='article']")
    if articles.count():
        texts = [t.strip() for t in articles.all_inner_texts() if t.strip()]
        if texts:
            return max(texts, key=len)
    body = page.locator("body").inner_text(timeout=10_000).strip()
    return body


def download_media(context: "BrowserContext", page: "Page", folder: Path) -> list[dict]:
    urls: list[str] = page.locator("img[src], video[src], video source[src]").evaluate_all(
        "els => [...new Set(els.map(e => e.currentSrc || e.src).filter(Boolean))]"
    )
    saved: list[dict] = []
    seen_hashes: set[str] = set()
    folder.mkdir(exist_ok=True)

    for index, url in enumerate(urls, 1):
        if url.startswith(("blob:", "data:")):
            continue
        try:
            response = context.request.get(url, timeout=30_000)
            if not response.ok:
                continue
            content_type = response.headers.get("content-type", "").split(";", 1)[0]
            if content_type not in MEDIA_TYPES:
                continue
            body = response.body()
            digest = hashlib.sha256(body).hexdigest()
            if digest in seen_hashes or len(body) < 2_000:
                continue
            seen_hashes.add(digest)
            filename = f"media-{index:02d}{extension_for(content_type, url)}"
            (folder / filename).write_bytes(body)
            saved.append({"file": f"media/{filename}", "content_type": content_type, "bytes": len(body)})
        except Exception as exc:
            saved.append({"url": url, "error": str(exc)})
    return saved


def archive_post(url: str, output: Path, profile: Path, headless: bool) -> Path:
    try:
        from playwright.sync_api import sync_playwright
    except ImportError as exc:
        raise RuntimeError(
            "Playwright is not installed. Run: python3 -m pip install playwright && "
            "python3 -m playwright install chromium"
        ) from exc

    parsed = urlparse(url)
    if parsed.scheme not in {"http", "https"} or parsed.hostname not in ALLOWED_HOSTS:
        raise ValueError("URL must be a facebook.com post URL")

    post_dir = output / safe_name(f"facebook-post-{post_id_from_url(url)}")
    post_dir.mkdir(parents=True, exist_ok=True)

    with sync_playwright() as playwright:
        context = playwright.chromium.launch_persistent_context(
            str(profile), headless=headless, viewport={"width": 1440, "height": 1100}
        )
        page = context.pages[0] if context.pages else context.new_page()
        page.goto(url, wait_until="domcontentloaded", timeout=60_000)
        page.wait_for_timeout(2500)
        close_login_prompt(page)

        if not headless and page.locator("input[name='email']").count():
            print("If the post needs authentication, sign in in the browser now.")
            input("When the post is visible, press Enter here to continue... ")
            page.goto(url, wait_until="domcontentloaded", timeout=60_000)
            page.wait_for_timeout(2500)
            close_login_prompt(page)

        text = visible_post_text(page)
        if not text:
            raise RuntimeError("The post is not visible. Try again with --show-browser and sign in.")

        canonical_url = page.url
        (post_dir / "post.txt").write_text(text + "\n", encoding="utf-8")
        (post_dir / "page.html").write_text(page.content(), encoding="utf-8")
        page.screenshot(path=str(post_dir / "screenshot.png"), full_page=True)
        media = download_media(context, page, post_dir / "media")
        metadata = {
            "requested_url": url,
            "final_url": canonical_url,
            "title": page.title(),
            "post_id": post_id_from_url(canonical_url),
            "media": media,
        }
        (post_dir / "metadata.json").write_text(
            json.dumps(metadata, ensure_ascii=False, indent=2) + "\n", encoding="utf-8"
        )
        context.close()
    return post_dir


def main() -> int:
    parser = argparse.ArgumentParser(description="Archive one Facebook post")
    parser.add_argument("url", help="Facebook post/permalink URL")
    parser.add_argument("-o", "--output", type=Path, default=Path("facebook-downloads"))
    parser.add_argument(
        "--profile", type=Path, default=Path.home() / ".fb-post-downloader-profile",
        help="persistent Chromium profile directory",
    )
    parser.add_argument(
        "--show-browser", action="store_true",
        help="show Chromium so you can sign in or inspect the post",
    )
    args = parser.parse_args()
    try:
        result = archive_post(args.url, args.output, args.profile, not args.show_browser)
    except Exception as exc:
        print(f"Error: {exc}", file=sys.stderr)
        return 1
    print(f"Saved to: {result.resolve()}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
