"""The cvrapi.dk-compatible endpoint: same parameters, same JSON.

Works without a key (50 lookups a day); a key adds its own quota on top.
Usage: python cvrapi_dropin.py "novo nordisk"
"""
import sys

from companydata import get

query = sys.argv[1] if len(sys.argv) > 1 else "novo nordisk"
company = get("/cvrapi/api", {"search": query, "country": "dk"})

print(company["vat"], company["name"])
print(company["address"], company["zipcode"], company["city"])
print(company["industrycode"], company["industrydesc"])
print("Owners:", ", ".join(owner["name"] for owner in company.get("owners") or []))
