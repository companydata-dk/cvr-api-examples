#!/usr/bin/env bash
# Search companies by name. Free tier.
# Usage: COMPANYDATA_API_KEY=sk_live_... ./search.sh "novo nordisk"
set -euo pipefail
BASE="${COMPANYDATA_API_URL:-https://api.companydata.dk}"
QUERY="${1:-novo nordisk}"

curl -sS --fail-with-body --get "$BASE/v1/companies" \
  --data-urlencode "q=$QUERY" \
  --data-urlencode "limit=5" \
  -H "Authorization: Bearer $COMPANYDATA_API_KEY"
echo
