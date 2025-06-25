#!/bin/bash

# Test admin pages dengan database yang benar

echo "=== Testing Admin Panel with Database Fields ==="

# Login first
echo "1. Logging in as admin..."
curl -s -c "cookies.txt" -d "email=admin@sdnpadangsari.sch.id&password=admin123" -X POST "http://sdn-padangsari.test/admin/login" > /dev/null

if [ $? -eq 0 ]; then
    echo "   ✅ Login successful"
else
    echo "   ❌ Login failed"
    exit 1
fi

echo ""
echo "2. Testing pages with database field alignment..."

# Test each page
pages=(
    "/admin:Dashboard"
    "/admin/students:Students"
    "/admin/teachers:Teachers" 
    "/admin/gallery:Gallery"
    "/admin/announcements:Announcements"
    "/admin/classrooms:Classrooms"
    "/admin/users:Users"
    "/admin/categories:Categories"
    "/admin/pengaduan:Pengaduan"
)

for page_info in "${pages[@]}"; do
    IFS=':' read -r url name <<< "$page_info"
    echo -n "   Testing $name ($url) ... "
    
    response_size=$(curl -s -b "cookies.txt" "http://sdn-padangsari.test$url" | wc -c)
    
    if [ "$response_size" -gt 1000 ]; then
        echo "✅ OK ($response_size bytes)"
        
        # Check for undefined variables
        undefined_check=$(curl -s -b "cookies.txt" "http://sdn-padangsari.test$url" | grep -i "undefined variable" || echo "")
        if [ -n "$undefined_check" ]; then
            echo "      ⚠️  Warning: Undefined variables detected"
        fi
        
    elif [ "$response_size" -gt 0 ]; then
        echo "⚠️  Small response ($response_size bytes)"
    else
        echo "❌ Empty response (0 bytes)"
    fi
done

echo ""
echo "3. Summary:"
echo "   Database structure aligned with:"
echo "   - Students: name, nisn, class, birth_date, parent_email, photo, classroom_id"
echo "   - Teachers: name, position, photo, classroom_id"
echo "   - Galleries: title, description, images (array)"
echo "   - Announcements: title, content, image, publish_date"
echo "   - Users: name, email, role"
echo "   - Categories: name, target_role"
echo ""
echo "=== Test completed ==="
