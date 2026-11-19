# Skift fra cvrapi.dk til CompanyData

Du skifter ved at rette én adresse. Resten af din integration kører videre.

```diff
- https://cvrapi.dk/api?search=lego&country=dk
+ https://api.companydata.dk/cvrapi/api?search=lego&country=dk
```

Prøv det med det samme, uden nøgle:

```bash
curl "https://api.companydata.dk/cvrapi/api?search=lego&country=dk"
```

```json
{
  "vat": 54562519,
  "name": "LEGO A/S",
  "address": "Åstvej 1",
  "zipcode": "7190",
  "city": "Billund",
  "industrycode": 701010,
  "industrydesc": "Ikke-finansielle hovedsæders aktiviteter",
  "owners": [{ "name": "LEGO Foundation Investments A/S" }, { "name": "LEGO Holding A/S" }]
}
```

Svaret er forkortet her.

## Det samme, som du kender

- Parametrene `search`, `vat`, `name`, `produ`, `phone`, `country`, `format`, `version`, `token` og `callback`.
- Felterne i samme rækkefølge og med samme formater, for eksempel `startdate` som `01/04 - 1964`.
- Fejlkoderne, for eksempel `NOT_FOUND` med HTTP 404.
- JSON, XML og JSONP, og åben CORS til kald direkte fra browseren.

## Fire forskelle, du skal kende

1. Kun danske virksomheder: `country=no` giver fejlen `UNSUPPORTED_COUNTRY`.
2. `owners` viser også de danske selskaber, der ejer virksomheden.
3. `productionunits` viser de aktive enheder først, med hovedafdelingen øverst.
4. Med JSONP forbliver tekstfelter tekst, også postnummer og telefonnummer.

## Adgang

| | Opslag |
|---|---|
| Uden nøgle | 50 om dagen pr. IP-adresse |
| Gratis konto | 1.000 om måneden oven i de 50 om dagen |
| Pro (299 kr/md inkl. moms) | 300.000 om måneden oven i de 50 om dagen |

Skal du bruge flere end 50 om dagen, sætter du din API-nøgle i `token=` eller i headeren `Authorization: Bearer sk_live_...`. En gammel cvrapi.dk-token i din konfiguration gør ingen skade. Den bliver ignoreret.

## Eksempler

- [curl](../examples/curl/cvrapi-dropin.sh)
- [Python](../examples/python/cvrapi_dropin.py)
- [JavaScript](../examples/javascript/cvrapi-dropin.mjs)
- [PHP](../examples/php/cvrapi-dropin.php)

## Når du vil videre

Den samme nøgle giver adgang til resten af API'et: regnskabstal fra årsrapporterne, ejere og ledelse, produktionsenheder, screening og webhooks. Se [oversigten](../README.md) og [dokumentationen](https://api.companydata.dk/v1/docs).
