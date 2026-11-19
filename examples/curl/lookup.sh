#!/usr/bin/env bash
# Look a company up by its CVR number. Free tier.
# Usage: COMPANYDATA_API_KEY=sk_live_... ./lookup.sh 24256790
set -euo pipefail
BASE="${COMPANYDATA_API_URL:-https://api.companydata.dk}"
CVR="${1:-24256790}"

curl -sS --fail-with-body "$BASE/v1/companies/$CVR" \
  -H "Authorization: Bearer $COMPANYDATA_API_KEY"
echo
