#!/bin/sh

git filter-branch -f --env-filter "
    GIT_AUTHOR_NAME='Jag Srawan'
    GIT_AUTHOR_EMAIL='jsrawan@gmail.com'
    GIT_COMMITTER_NAME='jsrawan-mobo'
    GIT_COMMITTER_EMAIL='jsrawan@gmail.com'
  " HEAD
