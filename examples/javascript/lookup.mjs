// Look a company up by its CVR number. Free tier.
// Usage: COMPANYDATA_API_KEY=sk_live_... node lookup.mjs 24256790
import { get } from "./companydata.mjs";

const cvr = process.argv[2] ?? "24256790";
const { data: company } = await get(`/v1/companies/${cvr}`);

console.log(company.name);
console.log("CVR:      ", company.cvr);
console.log("Status:   ", company.status);
console.log("Type:     ", company.company_type);
console.log("Address:  ", company.address?.street, company.address?.postal_code, company.address?.city);
console.log("Industry: ", company.industry?.primary_code, company.industry?.primary_text);
console.log("Employees:", company.employees?.count);
