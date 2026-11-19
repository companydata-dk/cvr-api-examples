// Revenue, profit and equity from the filed annual reports. Pro tier.
// Usage: COMPANYDATA_API_KEY=sk_live_... node financials.mjs 24256790
import { ApiError, get } from "./companydata.mjs";

const cvr = process.argv[2] ?? "24256790";
let financials;
try {
  financials = await get(`/v1/companies/${cvr}/financials`);
} catch (error) {
  if (error instanceof ApiError && error.status === 403) {
    console.error("This endpoint needs a Pro key: https://companydata.dk/priser");
    process.exit(1);
  }
  throw error;
}

console.table(
  financials.summary.slice(0, 5).map((year) => ({
    year: year.period_end.slice(0, 4),
    revenue: year.revenue,
    profit: year.profit_loss,
    equity: year.equity,
    currency: year.currency,
  })),
);
