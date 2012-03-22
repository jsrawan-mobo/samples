#!/bin/sh

git filter-branch --commit-filter '
        if [ "$GIT_COMMITTER_NAME" = "jsrawan-ampush" ];
        then
                GIT_COMMITTER_NAME="jsrawan-mobo";
                GIT_AUTHOR_NAME="jsrawan";
                GIT_COMMITTER_EMAIL="jsrawan@gmail.com";
                GIT_AUTHOR_EMAIL="jsrawan@gmail.com";
                git commit-tree "$@";
        else
                git commit-tree "$@";
        fi' HEAD
