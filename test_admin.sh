#!/bin/bash

# Test Login dan akses halaman admin
cd /Users/rezaaditya/Herd/sdn-padangsari

echo "=== Testing Admin Login and Pages ==="

# 1. Get login page and extract CSRF token
echo "1. Getting login page..."
LOGIN_PAGE=$(curl -s -c cookies.txt http://127.0.0.1:8000/admin/login)
CSRF_TOKEN=$(echo "$LOGIN_PAGE" | grep -o 'data-csrf="[^"]*"' | cut -d'"' -f2)
echo "CSRF Token: $CSRF_TOKEN"

# 2. Login with admin credentials
echo "2. Attempting login..."
LOGIN_RESPONSE=$(curl -s -b cookies.txt -c cookies.txt \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: $CSRF_TOKEN" \
  -X POST \
  -d '{
    "fingerprint": {
      "id": "p0yrz1Ja7w4WhlrW6fwL",
      "name": "admin.login",
      "locale": "en",
      "path": "admin/login",
      "method": "GET"
    },
    "serverMemo": {
      "checksum": "e09e4247dbb8617252a27ecc58529b15094ffa15bccfac0be6a79c76522138f1"
    },
    "updates": [
      {
        "type": "callMethod",
        "payload": {
          "id": "inh8",
          "method": "login",
          "params": []
        }
      }
    ]
  }' \
  http://127.0.0.1:8000/livewire/update)

echo "Login response:"
echo "$LOGIN_RESPONSE" | head -5

# 3. Test access to admin pages
echo "3. Testing admin dashboard..."
DASHBOARD_RESPONSE=$(curl -s -b cookies.txt -I http://127.0.0.1:8000/admin/dashboard)
echo "Dashboard status: $(echo "$DASHBOARD_RESPONSE" | head -1)"

echo "4. Testing teachers page..."
TEACHERS_RESPONSE=$(curl -s -b cookies.txt -I http://127.0.0.1:8000/admin/teachers)
echo "Teachers status: $(echo "$TEACHERS_RESPONSE" | head -1)"

echo "5. Testing students page..."
STUDENTS_RESPONSE=$(curl -s -b cookies.txt -I http://127.0.0.1:8000/admin/students)
echo "Students status: $(echo "$STUDENTS_RESPONSE" | head -1)"

echo "6. Testing gallery page..."
GALLERY_RESPONSE=$(curl -s -b cookies.txt -I http://127.0.0.1:8000/admin/gallery)
echo "Gallery status: $(echo "$GALLERY_RESPONSE" | head -1)"

echo "=== Test Completed ==="
