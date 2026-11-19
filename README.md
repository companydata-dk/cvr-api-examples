# CVR API til udviklere: eksempler til CompanyData

[![licens MIT](https://img.shields.io/badge/licens-MIT-blue)](LICENSE)
[![dokumentation](https://img.shields.io/badge/dokumentation-api.companydata.dk-1f5eff)](https://api.companydata.dk/v1/docs)

[English version](README.en.md)

**Hent danske virksomhedsdata som JSON: stamdata fra CVR, regnskabstal, ejere og ledelse i ét API.**

Her er kørende eksempler til [CompanyDatas CVR API](https://companydata.dk/da/api) i curl, Python, JavaScript og PHP. Du kan slå en virksomhed op på CVR-nummer, søge på navn, hente regnskabstal og skifte fra cvrapi.dk uden at skrive din integration om. Eksemplerne har ingen afhængigheder, så du kan kopiere en fil og køre den.

```bash
curl "https://api.companydata.dk/v1/companies/24256790" \
  -H "Authorization: Bearer sk_live_din_nøgle"
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

Svaret er forkortet her. Det fulde svar har også navnehistorik, kapital, formål, ejere, bestyrelse, direktion og produktionsenheder.

## Kom i gang

1. Opret en gratis konto på [companydata.dk](https://companydata.dk), og lav en API-nøgle under [API-nøgler](https://companydata.dk/da/api-nogler). Den gratis nøgle giver 1.000 kald om måneden.
2. Sæt nøglen som miljøvariabel:

   ```bash
   export COMPANYDATA_API_KEY=sk_live_din_nøgle
   ```

3. Kør et eksempel:

   ```bash
   python examples/python/lookup.py 24256790
   node examples/javascript/lookup.mjs 24256790
   php examples/php/lookup.php 24256790
   ./examples/curl/lookup.sh 24256790
   ```

Vil du bare se et svar først? Det cvrapi.dk-kompatible endpoint virker uden nøgle:

```bash
curl "https://api.companydata.dk/cvrapi/api?search=lego&country=dk"
```

## Eksemplerne

| Hvad du vil | Endpoint | Adgang | curl | Python | JavaScript | PHP |
|---|---|---|---|---|---|---|
| Slå en virksomhed op på CVR-nummer | `GET /v1/companies/{cvr}` | Gratis | [lookup.sh](examples/curl/lookup.sh) | [lookup.py](examples/python/lookup.py) | [lookup.mjs](examples/javascript/lookup.mjs) | [lookup.php](examples/php/lookup.php) |
| Søge på virksomhedsnavn | `GET /v1/companies?q=` | Gratis | [search.sh](examples/curl/search.sh) | [search.py](examples/python/search.py) | [search.mjs](examples/javascript/search.mjs) | [search.php](examples/php/search.php) |
| Hente regnskabstal fra årsrapporterne | `GET /v1/companies/{cvr}/financials` | Pro | [financials.sh](examples/curl/financials.sh) | [financials.py](examples/python/financials.py) | [financials.mjs](examples/javascript/financials.mjs) | [financials.php](examples/php/financials.php) |
| Køre videre med din cvrapi.dk-integration | `GET /cvrapi/api` | Uden nøgle | [cvrapi-dropin.sh](examples/curl/cvrapi-dropin.sh) | [cvrapi_dropin.py](examples/python/cvrapi_dropin.py) | [cvrapi-dropin.mjs](examples/javascript/cvrapi-dropin.mjs) | [cvrapi-dropin.php](examples/php/cvrapi-dropin.php) |

Hvert sprog har en lille klientfil (`companydata.py`, `companydata.mjs`, `companydata.php`) på omkring 40 linjer, som sætter nøglen i headeren og giver en fejl med statuskode, når API'et svarer med andet end 2xx.

Sådan ser regnskabseksemplet ud, når det kører:

```
$ python examples/python/financials.py 24256790
Year             Revenue            Profit            Equity  Currency
2025     309,064,000,000   102,434,000,000   194,047,000,000  DKK
2024     290,403,000,000   100,988,000,000   143,486,000,000  DKK
2023     232,261,000,000    83,683,000,000   106,561,000,000  DKK
```

## Det får du med API'et

- **Stamdata fra CVR** for over 860.000 aktive virksomheder og 1,4 mio. ophørte: navn, adresse, status, branche, virksomhedsform, ansatte og produktionsenheder.
- **Regnskabstal** fra de indberettede årsrapporter tilbage til 2012: omsætning, resultat, egenkapital, balance og nøgletal som færdige tal.
- **Ejere og ledelse**: legale og reelle ejere, bestyrelse, direktion og hele ejerstrukturen op gennem holdingselskaberne.
- **Screening** af hele registret på nøgletal, størrelse, branche og geografi.
- **Meddelelser fra Statstidende**, ejendomme og EAN-numre.
- **Webhooks**, der sender ændringer til dit system: nye regnskaber, ejerskifter, ledelsesændringer og statusændringer.

Data bliver opdateret fra registrene flere gange om dagen, og hele companydata.dk kører på det samme API.

## Adgang og kvoter

| | Uden nøgle | Gratis konto | Pro | Team |
|---|---|---|---|---|
| Kald | 50 om dagen på `/cvrapi/api` | 1.000 om måneden | 300.000 om måneden | 500.000 om måneden i fælles pulje |
| Hastighed | | 60 i minuttet | 300 i minuttet | |
| Endpoints | cvrapi-formatet | Søgning og virksomhedsopslag | Alle | Alle |
| Pris | 0 kr | 0 kr | 299 kr/md | 1.995 kr/md |

Priserne er inklusive moms. Har du brug for flere kald, aftaler vi en kvote, der passer til dig: [se priserne](https://companydata.dk/da/priser).

Hvert svar fortæller, hvor meget du har tilbage, i headerne `X-RateLimit-Remaining` og `X-Monthly-Remaining`. Rammer du grænsen, får du `429` med en `Retry-After`-header. Et Pro-endpoint svarer `403`, hvis nøglen er gratis.

## Skifter du fra cvrapi.dk?

Ret adressen fra `cvrapi.dk/api` til `api.companydata.dk/cvrapi/api`, og behold resten af din kode. Parametrene, felterne og fejlkoderne er de samme. Se [guiden til at skifte](docs/cvrapi-migration.md).

## Brug API'et fra en AI-agent

CompanyData har en MCP-server på `https://api.companydata.dk/mcp`, så Claude, Cursor, VS Code og andre MCP-klienter kan søge og hente virksomhedsdata. Se [opsætningen](docs/mcp.md).

## Webhooks

Med Pro kan du få ændringer sendt til dit system i stedet for at spørge efter dem. Se [eksemplet på at verificere signaturen](docs/webhooks.md).

## Dokumentation

- [API-dokumentation](https://api.companydata.dk/v1/docs) med alle endpoints og svarformater
- [OpenAPI-specifikation](https://api.companydata.dk/v1/openapi.json) til Postman eller en klientgenerator
- [Overblik over API'et](https://companydata.dk/da/api)

Spørgsmål? Skriv til support@companydata.dk, eller opret et issue her.

## Licens

Eksemplerne er under [MIT-licensen](LICENSE). Brug dem, som du vil.
