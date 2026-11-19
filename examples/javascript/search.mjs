// Search companies by name. Free tier.
// Usage: COMPANYDATA_API_KEY=sk_live_... node search.mjs "novo nordisk"
import { get } from "./companydata.mjs";

const query = process.argv[2] ?? "novo nordisk";
const result = await get("/v1/companies", { q: query, limit: 5 });

for (const company of result.data) {
  console.log(company.cvr, company.name, `(${company.status}, ${company.address?.city})`);
}
console.log("Total matches:", result.pagination.total);
