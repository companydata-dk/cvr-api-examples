#!/usr/bin/env bash
# Annual reports as parsed figures: revenue, profit, equity, ratios. Pro tier.
# Usage: COMPANYDATA_API_KEY=sk_live_... ./financials.sh 24256790
set -euo pipefail
BASE="${COMPANYDATA_API_URL:-https://api.companydata.dk}"
CVR="${1:-24256790}"

curl -sS --fail-with-body "$BASE/v1/companies/$CVR/financials" \
  -H "Authorization: Bearer $COMPANYDATA_API_KEY"
echo
