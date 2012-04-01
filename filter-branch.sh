#!/bin/sh



# This is on main, will be rejected by release branch when we do git merge -s ours from RELEASE branch
#New line 1 on main
#echo "Don't use this, i haven't tested it"
#New line 2 on main
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
