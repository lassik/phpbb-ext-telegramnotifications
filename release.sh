#!/bin/sh -
set -eu
cd "$(dirname "$0")"
ver="${1:-HEAD}"
zip="phpbb_telegramnotifications_$(echo $ver | tr . _).zip"
rm -f "$zip"
git archive \
	--output "$zip" \
	--prefix ext/lassik/telegramnotifications/ \
	"$ver"
