// Minimal client for the CompanyData API. No dependencies, Node 18+ (built-in fetch).
const BASE_URL = process.env.COMPANYDATA_API_URL ?? "https://api.companydata.dk";

export class ApiError extends Error {
  constructor(status, body, retryAfter) {
    super(`HTTP ${status}: ${body}`);
    this.status = status;
    this.body = body;
    this.retryAfter = retryAfter;
  }
}

// GET a path and return the decoded JSON. Throws ApiError on any non-2xx answer:
// 401 means the key is missing or wrong, 403 that the endpoint needs Pro, 429 that you
// hit the rate limit or the monthly quota (retryAfter holds the seconds to wait).
export async function get(path, params = {}, apiKey = process.env.COMPANYDATA_API_KEY) {
  const url = new URL(path, BASE_URL);
  for (const [name, value] of Object.entries(params)) url.searchParams.set(name, value);

  const headers = { Accept: "application/json", "User-Agent": "cvr-api-examples-node" };
  if (apiKey) headers.Authorization = `Bearer ${apiKey}`;

  const response = await fetch(url, { headers });
  if (!response.ok) {
    throw new ApiError(response.status, await response.text(), response.headers.get("retry-after"));
  }
  return response.json();
}
