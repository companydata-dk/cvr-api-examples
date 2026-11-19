#!/usr/bin/env bash
# The cvrapi.dk-compatible endpoint: same parameters, same JSON. Works without a key
# (50 lookups a day); a key adds its own quota on top.
# Usage: ./cvrapi-dropin.sh "novo nordisk"
set -euo pipefail
BASE="${COMPANYDATA_API_URL:-https://api.companydata.dk}"
QUERY="${1:-novo nordisk}"

curl -sS --fail-with-body --get "$BASE/cvrapi/api" \
  --data-urlencode "search=$QUERY" \
  --data-urlencode "country=dk" \
  -H "User-Agent: my-company my-project"
echo
