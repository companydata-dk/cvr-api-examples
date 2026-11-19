# CompanyData MCP server: Danish company data for AI agents

CompanyData runs a remote MCP server, so an AI agent can search the Danish company register and fetch financials, owners and management on its own.

- **Endpoint:** `https://api.companydata.dk/mcp` (streamable HTTP)
- **Auth:** your API key as `Authorization: Bearer sk_live_...`, or OAuth sign-in from clients that support it
- **Registry name:** `dk.companydata/companydata` in the [official MCP Registry](https://registry.modelcontextprotocol.io)

Get a key under [API keys](https://companydata.dk/en/api-nogler). A free account is enough to try it.

## Claude Code

```bash
claude mcp add --transport http companydata https://api.companydata.dk/mcp \
  --header "Authorization: Bearer sk_live_your_key"
```

## Claude (web and desktop)

Open Settings, then Connectors, choose "Add custom connector" and paste `https://api.companydata.dk/mcp`. Claude sends you to CompanyData to sign in.

## Cursor

`.cursor/mcp.json`:

```json
{
  "mcpServers": {
    "companydata": {
      "url": "https://api.companydata.dk/mcp",
      "headers": { "Authorization": "Bearer sk_live_your_key" }
    }
  }
}
```

## VS Code

`.vscode/mcp.json`:

```json
{
  "servers": {
    "companydata": {
      "type": "http",
      "url": "https://api.companydata.dk/mcp",
      "headers": { "Authorization": "Bearer sk_live_your_key" }
    }
  }
}
```

## Tools

| Area | Tools |
|---|---|
| Companies | `search_companies`, `get_company`, `get_financials`, `get_timeline`, `get_similar_companies`, `enrich_companies`, `preview_lead_list` |
| Owners and management | `get_participants`, `get_beneficial_owners`, `get_portfolio`, `search_participants`, `get_participant`, `get_participant_portfolio`, `get_ownership_network`, `get_indirect_ownership` |
| Production units | `get_production_units`, `search_production_units`, `nearby_production_units`, `get_production_unit` |
| Properties | `get_properties`, `get_property`, `lookup_property` |
| Notices and invoicing | `get_legal_notices`, `search_legal_notices`, `get_e_invoicing` |
| Reference data | `lookup_industry`, `lookup_municipality` |

The live list is always at `GET https://api.companydata.dk/mcp`.

## Things to ask

- "Find the Danish company LEGO A/S and show its revenue for the last five years."
- "Who are the beneficial owners of the company with CVR number 24256790?"
- "Which companies does this person sit on the board of?"
