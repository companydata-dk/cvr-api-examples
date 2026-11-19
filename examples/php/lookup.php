<?php
// Look a company up by its CVR number. Free tier.
// Usage: COMPANYDATA_API_KEY=sk_live_... php lookup.php 24256790
require __DIR__ . '/companydata.php';

$cvr = $argv[1] ?? '24256790';
$company = companydata_get("/v1/companies/$cvr")['data'];

echo $company['name'], PHP_EOL;
echo 'CVR:       ', $company['cvr'], PHP_EOL;
echo 'Status:    ', $company['status'], PHP_EOL;
echo 'Type:      ', $company['company_type'] ?? '', PHP_EOL;
echo 'Address:   ', $company['address']['street'] ?? '', ' ', $company['address']['postal_code'] ?? '', ' ', $company['address']['city'] ?? '', PHP_EOL;
echo 'Industry:  ', $company['industry']['primary_code'] ?? '', ' ', $company['industry']['primary_text'] ?? '', PHP_EOL;
echo 'Employees: ', $company['employees']['count'] ?? '', PHP_EOL;
