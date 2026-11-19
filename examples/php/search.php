<?php
// Search companies by name. Free tier.
// Usage: COMPANYDATA_API_KEY=sk_live_... php search.php "novo nordisk"
require __DIR__ . '/companydata.php';

$query = $argv[1] ?? 'novo nordisk';
$result = companydata_get('/v1/companies', ['q' => $query, 'limit' => 5]);

foreach ($result['data'] as $company) {
    printf("%s %s (%s, %s)\n", $company['cvr'], $company['name'], $company['status'], $company['address']['city'] ?? '');
}
echo 'Total matches: ', $result['pagination']['total'], PHP_EOL;
