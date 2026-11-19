# CVR API for developers: examples for CompanyData

[![license MIT](https://img.shields.io/badge/license-MIT-blue)](LICENSE)
[![docs](https://img.shields.io/badge/docs-api.companydata.dk-1f5eff)](https://api.companydata.dk/v1/docs)

[Dansk version](README.md)

**Get Danish company data as JSON: register data from the CVR, financials, owners and management in one API.**

These are runnable examples for the [CompanyData API](https://companydata.dk/en/api) in curl, Python, JavaScript and PHP. You can look a Danish company up by its CVR number (the Danish company registration number), search by name, fetch figures from the annual reports, and move off cvrapi.dk without rewriting your integration. The examples have no dependencies, so you can copy one file and run it.

```bash
curl "https://api.companydata.dk/v1/companies/24256790" \
  -H "Authorization: Bearer sk_live_your_key"
```

```json
{
  "data": {
    "cvr": "24256790",
    "name": "NOVO NORDISK A/S",
    "status": "active",
    "company_type": "A/S",
    "address": { "street": "Novo Alle 1", "postal_code": "2880", "city": "Bagsværd" },
    "industry": { "primary_code": "212000", "primary_text": "Fremstilling af farmaceutiske præparater" },
    "employees": { "count": 27279 }
  }
}
```

The answer is shortened here. The full one also has name history, capital, purpose, owners, board, directors and production units.

## Get started

1. Create a free account at [companydata.dk](https://companydata.dk/en) and make an API key under [API keys](https://companydata.dk/en/api-nogler). The free key gives 1,000 calls a month.
2. Set the key as an environment variable:

   ```bash
   export COMPANYDATA_API_KEY=sk_live_your_key
   ```

3. Run an example:

   ```bash
   python examples/python/lookup.py 24256790
   node examples/javascript/lookup.mjs 24256790
   php examples/php/lookup.php 24256790
   ./examples/curl/lookup.sh 24256790
   ```

Want to see an answer first? The cvrapi.dk-compatible endpoint works without a key:

```bash
curl "https://api.companydata.dk/cvrapi/api?search=lego&country=dk"
```

## The examples

| What you want | Endpoint | Access | curl | Python | JavaScript | PHP |
|---|---|---|---|---|---|---|
| Look a company up by CVR number | `GET /v1/companies/{cvr}` | Free | [lookup.sh](examples/curl/lookup.sh) | [lookup.py](examples/python/lookup.py) | [lookup.mjs](examples/javascript/lookup.mjs) | [lookup.php](examples/php/lookup.php) |
| Search by company name | `GET /v1/companies?q=` | Free | [search.sh](examples/curl/search.sh) | [search.py](examples/python/search.py) | [search.mjs](examples/javascript/search.mjs) | [search.php](examples/php/search.php) |
| Get figures from the annual reports | `GET /v1/companies/{cvr}/financials` | Pro | [financials.sh](examples/curl/financials.sh) | [financials.py](examples/python/financials.py) | [financials.mjs](examples/javascript/financials.mjs) | [financials.php](examples/php/financials.php) |
| Keep your cvrapi.dk integration running | `GET /cvrapi/api` | No key | [cvrapi-dropin.sh](examples/curl/cvrapi-dropin.sh) | [cvrapi_dropin.py](examples/python/cvrapi_dropin.py) | [cvrapi-dropin.mjs](examples/javascript/cvrapi-dropin.mjs) | [cvrapi-dropin.php](examples/php/cvrapi-dropin.php) |

Each language has a small client file (`companydata.py`, `companydata.mjs`, `companydata.php`) of about 40 lines. It puts the key in the header and raises an error with the status code when the API answers with anything but 2xx.

This is the financials example when it runs:

```
$ python examples/python/financials.py 24256790
Year             Revenue            Profit            Equity  Currency
2025     309,064,000,000   102,434,000,000   194,047,000,000  DKK
2024     290,403,000,000   100,988,000,000   143,486,000,000  DKK
2023     232,261,000,000    83,683,000,000   106,561,000,000  DKK
```

## What the API gives you

- **Register data** on over 860,000 active Danish companies and 1.4 million ceased ones: name, address, status, industry, legal form, employees and production units.
- **Financials** from the filed annual reports back to 2012: revenue, profit, equity, balance sheet and key ratios as ready numbers.
- **Owners and management**: legal and beneficial owners, board, directors and the whole ownership structure up through the holding companies.
- **Screening** of the whole register on key figures, size, industry and geography.
- **Notices from Statstidende** (the Danish official gazette), properties and EAN numbers.
- **Webhooks** that send changes to your system: new annual reports, ownership changes, management changes and status changes.

The data is updated from the registers several times a day, and all of companydata.dk runs on the same API.

## Access and quotas

| | No key | Free account | Pro | Team |
|---|---|---|---|---|
| Calls | 50 a day on `/cvrapi/api` | 1,000 a month | 300,000 a month | 500,000 a month, pooled |
| Rate | | 60 a minute | 300 a minute | |
| Endpoints | The cvrapi format | Search and company lookup | All | All |
| Price | 0 DKK | 0 DKK | 299 DKK a month | 1,995 DKK a month |

Prices include Danish VAT. If you need more calls, we agree on a quota that fits you: [see the prices](https://companydata.dk/en/priser).

Every answer tells you how much you have left in the headers `X-RateLimit-Remaining` and `X-Monthly-Remaining`. When you hit a limit you get `429` with a `Retry-After` header. A Pro endpoint answers `403` to a free key.

## Coming from cvrapi.dk?

Change the address from `cvrapi.dk/api` to `api.companydata.dk/cvrapi/api` and keep the rest of your code. The parameters, fields and error codes are the same. See [the migration guide](docs/cvrapi-migration.md) (in Danish).

## Use the API from an AI agent

CompanyData has an MCP server at `https://api.companydata.dk/mcp`, so Claude, Cursor, VS Code and other MCP clients can search and fetch company data. See [the setup](docs/mcp.md).

## Webhooks

With Pro you can have changes sent to your system. See [how to verify the signature](docs/webhooks.md).

## Documentation

- [API documentation](https://api.companydata.dk/v1/docs) with every endpoint and response format
- [OpenAPI specification](https://api.companydata.dk/v1/openapi.json) for Postman or a client generator
- [Overview of the API](https://companydata.dk/en/api)

Questions? Write to support@companydata.dk or open an issue here.

## License

The examples are under the [MIT license](LICENSE). Use them as you like.
