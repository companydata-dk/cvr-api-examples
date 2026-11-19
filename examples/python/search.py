"""Search companies by name. Free tier.

Usage: COMPANYDATA_API_KEY=sk_live_... python search.py "novo nordisk"
"""
import sys

from companydata import get

query = sys.argv[1] if len(sys.argv) > 1 else "novo nordisk"
result = get("/v1/companies", {"q": query, "limit": 5})

for company in result["data"]:
    city = (company.get("address") or {}).get("city")
    print(company["cvr"], company["name"], f"({company['status']}, {city})")
print("Total matches:", result["pagination"]["total"])
