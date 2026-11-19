"""Look a company up by its CVR number. Free tier.

Usage: COMPANYDATA_API_KEY=sk_live_... python lookup.py 24256790
"""
import sys

from companydata import get

cvr = sys.argv[1] if len(sys.argv) > 1 else "24256790"
company = get(f"/v1/companies/{cvr}")["data"]

address = company.get("address") or {}
industry = company.get("industry") or {}
employees = company.get("employees") or {}

print(company["name"])
print("CVR:      ", company["cvr"])
print("Status:   ", company["status"])
print("Type:     ", company.get("company_type"))
print("Address:  ", address.get("street"), address.get("postal_code"), address.get("city"))
print("Industry: ", industry.get("primary_code"), industry.get("primary_text"))
print("Employees:", employees.get("count"))
