#! /bin/bash

# jekyll build
gpg --output signed-updates.txt --clearsign verify.txt 
# (echo "---\nlayout: raw\n---\n\`\`\`" && cat signed-updates.tmp && echo "\n\`\`\`") > signed-updates.md
