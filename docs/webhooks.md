# Webhooks: verify the signature

With Pro, CompanyData sends changes to your system as they are detected: new annual reports, ownership changes, board and director changes, status changes and more. The full list of event types is at `GET /v1/webhooks/event-types`, and the delivery format is in the [API documentation](https://api.companydata.dk/v1/docs).

Every delivery carries these headers:

| Header | Content |
|---|---|
| `X-Companydata-Signature` | `sha256=<hex>`, the HMAC-SHA256 of the raw request body with your webhook secret |
| `X-Companydata-Event` | The event type |
| `X-Companydata-Delivery` | A unique delivery id, new on every retry |

Verify the signature against the raw body, before you parse the JSON, and compare in constant time.

## Python

```python
import hashlib
import hmac


def verify(raw_body: bytes, signature_header: str, secret: str) -> bool:
    expected = "sha256=" + hmac.new(secret.encode(), raw_body, hashlib.sha256).hexdigest()
    return hmac.compare_digest(expected, signature_header)
```

## JavaScript

```javascript
import { createHmac, timingSafeEqual } from "node:crypto";

function verify(rawBody, signatureHeader, secret) {
  const expected = Buffer.from("sha256=" + createHmac("sha256", secret).update(rawBody).digest("hex"));
  const received = Buffer.from(signatureHeader);
  return expected.length === received.length && timingSafeEqual(expected, received);
}
```

## PHP

```php
function verify(string $rawBody, string $signatureHeader, string $secret): bool
{
    $expected = 'sha256=' . hash_hmac('sha256', $rawBody, $secret);
    return hash_equals($expected, $signatureHeader);
}
```

## Good to know

- A delivery is tried up to 3 times, about 2 minutes apart. Anything outside 2xx, or no answer within 10 seconds, counts as a failure.
- Events are not strictly ordered. Use `detected_at` to put changes for one company in order.
- If your receiver has been down, fetch the affected companies again with `GET /v1/companies/{cvr}`.
