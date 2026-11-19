<?php
// Minimal client for the CompanyData API. PHP 8.0+ with the curl extension.

class CompanyDataApiError extends Exception
{
    public function __construct(public int $status, public string $body, public ?string $retryAfter = null)
    {
        parent::__construct("HTTP $status: $body");
    }
}

/**
 * GET a path and return the decoded JSON as an array.
 *
 * Throws CompanyDataApiError on any non-2xx answer: 401 means the key is missing or
 * wrong, 403 that the endpoint needs Pro, 429 that you hit the rate limit or the
 * monthly quota (retryAfter holds the seconds to wait).
 */
function companydata_get(string $path, array $params = [], ?string $apiKey = null): array
{
    $base = getenv('COMPANYDATA_API_URL') ?: 'https://api.companydata.dk';
    $url = $base . $path . ($params ? '?' . http_build_query($params) : '');
    $apiKey ??= getenv('COMPANYDATA_API_KEY') ?: null;

    $headers = ['Accept: application/json'];
    if ($apiKey) {
        $headers[] = "Authorization: Bearer $apiKey";
    }

    $retryAfter = null;
    $curl = curl_init($url);
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_USERAGENT => 'cvr-api-examples-php',
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HEADERFUNCTION => function ($curl, $line) use (&$retryAfter) {
            if (stripos($line, 'retry-after:') === 0) {
                $retryAfter = trim(substr($line, 12));
            }
            return strlen($line);
        },
    ]);
    $body = curl_exec($curl);
    if ($body === false) {
        throw new RuntimeException('Request failed: ' . curl_error($curl));
    }
    $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    curl_close($curl);

    if ($status < 200 || $status >= 300) {
        throw new CompanyDataApiError($status, $body, $retryAfter);
    }
    return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
}
