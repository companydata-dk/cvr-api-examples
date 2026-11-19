// The cvrapi.dk-compatible endpoint: same parameters, same JSON.
// Works without a key (50 lookups a day); a key adds its own quota on top.
// Usage: node cvrapi-dropin.mjs "novo nordisk"
import { get } from "./companydata.mjs";

const query = process.argv[2] ?? "novo nordisk";
const company = await get("/cvrapi/api", { search: query, country: "dk" });

console.log(company.vat, company.name);
console.log(company.address, company.zipcode, company.city);
console.log(company.industrycode, company.industrydesc);
console.log("Owners:", (company.owners ?? []).map((owner) => owner.name).join(", "));
