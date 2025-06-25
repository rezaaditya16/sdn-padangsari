#!/bin/bash

cd /Users/rezaaditya/Herd/sdn-padangsari

echo "=== Dashboard HTTP Debug Test ==="

# Start dengan session baru
rm -f cookies.txt

echo "1. Getting login page and token..."
curl -s -c cookies.txt "http://127.0.0.1:8001/login" > login_response.html

# Extract CSRF token
TOKEN=$(grep -o 'name="_token" value="[^"]*"' login_response.html | cut -d'"' -f4)
echo "   Token: $TOKEN"

if [ -z "$TOKEN" ]; then
    echo "❌ Could not get CSRF token!"
    exit 1
fi

echo "2. Attempting login..."
LOGIN_RESPONSE=$(curl -i -s -L -c cookies.txt -b cookies.txt \
    -X POST \
    -d "email=admin@sdnpadangsari.sch.id" \
    -d "password=admin123" \
    -d "_token=$TOKEN" \
    "http://127.0.0.1:8001/login")

echo "   Login response headers:"
echo "$LOGIN_RESPONSE" | head -20

echo -e "\n3. Accessing dashboard..."
DASHBOARD_RESPONSE=$(curl -i -s -L -b cookies.txt "http://127.0.0.1:8001/admin")

echo "   Dashboard response headers:"
echo "$DASHBOARD_RESPONSE" | head -20

echo -e "\n4. Dashboard response body (first 500 chars):"
echo "$DASHBOARD_RESPONSE" | tail -n +20 | head -c 500

echo -e "\n\n5. Checking for blank/empty body..."
BODY_LENGTH=$(echo "$DASHBOARD_RESPONSE" | tail -n +20 | wc -c)
echo "   Body length: $BODY_LENGTH bytes"

if [ "$BODY_LENGTH" -lt 100 ]; then
    echo "❌ Dashboard response is too short (blank/empty)"
else
    echo "✅ Dashboard response has content"
fi

echo -e "\n=== Test completed ==="
