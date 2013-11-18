#!/bin/bash

set -e

cd "$(dirname "$0")"

VERSION="$1"

if [[ -n $(git status -s) ]]; then
	git status
	echo "Working tree must be clean to perform this action" >$2
	exit 1
fi

git tag "$1"
git push origin "$1"

make package

git checkout releases

cp package/dbviz.phar "dbviz-${VERSION}.phar"
HASH="$(sha1sum package/dbviz.phar | grep -o '^[^ ]*')"

cat > manifest.json <<EOF
[
	{
	"name": "cliph.phar",
		"sha1": "$HASH",
		"url": "https://raw.github.com/SuRaMoN/dbviz/releases/dbviz-${VERSION}.phar",
		"version": "$VERSION"
	}
]

EOF

git add manifest.json
git add "dbviz-${VERSION}.phar"

git commit -m "Added package for version $VERSION"

git push origin releases

git checkout master

