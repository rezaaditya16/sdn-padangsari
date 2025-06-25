#!/bin/bash

cd /Users/rezaaditya/Herd/sdn-padangsari

echo "=== Admin Panel Pages Test ==="

# Login sebagai super admin
echo "1. Logging in as super admin..."
curl -s -c cookies.txt -L "http://127.0.0.1:8001/test-login/super-admin" > /dev/null

if [ $? -eq 0 ]; then
    echo "   ✅ Login successful"
else
    echo "   ❌ Login failed"
    exit 1
fi

# Array halaman untuk ditest
declare -a pages=(
    "admin"
    "admin/gallery"
    "admin/announcements"
    "admin/students"
    "admin/users"
    "admin/categories"
    "admin/pengaduan"
    "admin/teachers"
    "admin/classrooms"
)

echo -e "\n2. Testing pages..."

for page in "${pages[@]}"; do
    echo -n "   Testing /$page ... "
    response_size=$(curl -s -b cookies.txt "http://127.0.0.1:8001/$page" | wc -c)
    
    if [ "$response_size" -gt 1000 ]; then
        echo "✅ OK ($response_size bytes)"
    elif [ "$response_size" -eq 0 ]; then
        echo "❌ BLANK (0 bytes)"
    else
        echo "⚠️  Small response ($response_size bytes)"
    fi
done

echo -e "\n3. Summary:"
echo "   Testing completed. Check results above."
echo "   ✅ = Page loads correctly (>1000 bytes)"
echo "   ⚠️  = Small response (possible issue)"
echo "   ❌ = Blank page (0 bytes)"

echo -e "\n=== Test completed ==="
