"""Revenue, profit and equity from the filed annual reports. Pro tier.

Usage: COMPANYDATA_API_KEY=sk_live_... python financials.py 24256790
"""
import sys

from companydata import ApiError, get

cvr = sys.argv[1] if len(sys.argv) > 1 else "24256790"
try:
    financials = get(f"/v1/companies/{cvr}/financials")
except ApiError as error:
    if error.status == 403:
        sys.exit("This endpoint needs a Pro key: https://companydata.dk/priser")
    raise

print(f"{'Year':<6}{'Revenue':>18}{'Profit':>18}{'Equity':>18}  Currency")
for year in financials["summary"][:5]:
    print(
        f"{year['period_end'][:4]:<6}"
        f"{year.get('revenue') or 0:>18,}"
        f"{year.get('profit_loss') or 0:>18,}"
        f"{year.get('equity') or 0:>18,}"
        f"  {year.get('currency')}"
    )
