#!/bin/sh

#made change on branch1
echo "Don't use this, i haven't tested it"
#mad change on branch2
exit(0)
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
