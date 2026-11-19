<?php
// The cvrapi.dk-compatible endpoint: same parameters, same JSON.
// Works without a key (50 lookups a day); a key adds its own quota on top.
// Usage: php cvrapi-dropin.php "novo nordisk"
require __DIR__ . '/companydata.php';

$query = $argv[1] ?? 'novo nordisk';
$company = companydata_get('/cvrapi/api', ['search' => $query, 'country' => 'dk']);

echo $company['vat'], ' ', $company['name'], PHP_EOL;
echo $company['address'], ' ', $company['zipcode'], ' ', $company['city'], PHP_EOL;
echo $company['industrycode'], ' ', $company['industrydesc'], PHP_EOL;
echo 'Owners: ', implode(', ', array_column($company['owners'] ?? [], 'name')), PHP_EOL;
