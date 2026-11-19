"""Minimal client for the CompanyData API. Standard library only, Python 3.8+."""
import json
import os
import urllib.error
import urllib.parse
import urllib.request

BASE_URL = os.environ.get("COMPANYDATA_API_URL", "https://api.companydata.dk")


class ApiError(Exception):
    def __init__(self, status, body, retry_after=None):
        super().__init__(f"HTTP {status}: {body}")
        self.status = status
        self.body = body
        self.retry_after = retry_after


def get(path, params=None, api_key=None):
    """GET a path and return the decoded JSON.

    Raises ApiError on any non-2xx answer. 401 means the key is missing or wrong,
    403 that the endpoint needs Pro, 429 that you hit the rate limit or the monthly
    quota (retry_after holds the seconds to wait).
    """
    url = BASE_URL + path
    if params:
        url += "?" + urllib.parse.urlencode(params)
    headers = {"Accept": "application/json", "User-Agent": "cvr-api-examples-python"}
    key = api_key if api_key is not None else os.environ.get("COMPANYDATA_API_KEY")
    if key:
        headers["Authorization"] = f"Bearer {key}"
    request = urllib.request.Request(url, headers=headers)
    try:
        with urllib.request.urlopen(request, timeout=30) as response:
            return json.load(response)
    except urllib.error.HTTPError as error:
        body = error.read().decode("utf-8", "replace")
        raise ApiError(error.code, body, error.headers.get("Retry-After")) from None
