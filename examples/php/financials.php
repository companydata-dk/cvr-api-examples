<?php
// Revenue, profit and equity from the filed annual reports. Pro tier.
// Usage: COMPANYDATA_API_KEY=sk_live_... php financials.php 24256790
require __DIR__ . '/companydata.php';

$cvr = $argv[1] ?? '24256790';
try {
    $financials = companydata_get("/v1/companies/$cvr/financials");
} catch (CompanyDataApiError $error) {
    if ($error->status === 403) {
        fwrite(STDERR, "This endpoint needs a Pro key: https://companydata.dk/priser\n");
        exit(1);
    }
    throw $error;
}

printf("%-6s%18s%18s%18s  %s\n", 'Year', 'Revenue', 'Profit', 'Equity', 'Currency');
foreach (array_slice($financials['summary'], 0, 5) as $year) {
    printf(
        "%-6s%18s%18s%18s  %s\n",
        substr($year['period_end'], 0, 4),
        number_format($year['revenue'] ?? 0),
        number_format($year['profit_loss'] ?? 0),
        number_format($year['equity'] ?? 0),
        $year['currency'] ?? ''
    );
}
