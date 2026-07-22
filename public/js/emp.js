// فتح نافذة الاختيار الرئيسية
function openSelectionModal() {
    document.getElementById('selectionModal').classList.add('open');
}

// إغلاق نافذة الاختيار الرئيسية
function closeSelectionModal() {
    document.getElementById('selectionModal').classList.remove('open');
}

// الانتقال من نافذة الاختيار إلى نافذة الإدخال المحددة
function navigateFromSelection(type) {
    closeSelectionModal();
    if (type === 'new') {
        document.getElementById('newEmpModal').classList.add('open');
    } else if (type === 'existing') {
        document.getElementById('existingEmpModal').classList.add('open');
    }
}

// زر الرجوع للخلف: من نافذة الإدخال إلى نافذة الاختيار الرئيسية
function backToSelection(type) {
    closeModal(type);
    openSelectionModal();
}

// إغلاق نافذة الإدخال نهائياً
// إغلاق نافذة الإدخال نهائياً وإعادة تعيين الحقول
function closeModal(type) {
    if (type === 'new') {
        document.getElementById('newEmpModal').classList.remove('open');
    } else if (type === 'existing') {
        document.getElementById('existingEmpModal').classList.remove('open');
        document.getElementById('linkExistingForm').style.display = 'none';
        document.getElementById('searchSection').style.display = 'block'; // إعادة إظهار مربع البحث عند الإغلاق
        document.getElementById('empSearchQuery').value = '';
        document.getElementById('searchResultsDropdown').innerHTML = '';
        document.getElementById('linkExistingForm').reset(); // تنظيف الحقول تماماً لمنع الحفظ بالخطأ
    }
}

// فتح وإغلاق نافذة التعديل
function openEditModal(id, name, email, collegeId, departmentId, jobTitle, phone) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_college_id').value = collegeId;
    document.getElementById('edit_department_id').value = departmentId;
    document.getElementById('edit_job_title').value = jobTitle;
    document.getElementById('edit_phone').value = phone;

    document.getElementById('editForm').action = '/employees/update/' + id;
    document.getElementById('editModal').classList.add('open');
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('open');
}

// البحث الفوري التلقائي في الشاشة الرئيسية عند الكتابة مباشرة
document.getElementById('mainSearchInput').addEventListener('input', function() {
    clearTimeout(this.delay);
    this.delay = setTimeout(function() {
        document.getElementById('mainSearchForm').submit();
    }, 500);
});
// تشغيل البحث عن موظف سابق
function triggerExistingSearch() {
    const query = document.getElementById('empSearchQuery').value.trim();
    const dropdown = document.getElementById('searchResultsDropdown');
    
    if (query.length < 1) {
        dropdown.innerHTML = '<div class="search-dropdown-item">الرجاء إدخال الاسم أو الرقم الوظيفي للبحث</div>';
        return;
    }

    fetch(`/employees/search-existing?search=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            dropdown.innerHTML = '';
            
            // التحقق من الرسالة القادمة من السيرفر إذا كان لديه حساب
            if (data.status === 'has_account') {
                dropdown.innerHTML = `<div class="search-dropdown-item" style="color: #ef4444; font-weight: bold; background: #fee2e2;">⚠️ ${data.message}</div>`;
                return;
            }
            
            if (data.length === 0) {
                dropdown.innerHTML = '<div class="search-dropdown-item">لا يوجد موظف سابق مطابق للبحث</div>';
                return;
            }
            
            data.forEach(emp => {
                const item = document.createElement('div');
                item.className = 'search-dropdown-item';
                item.innerText = `${emp.full_name} (${emp.employee_number})`;
                item.onclick = function() {
                    selectEmployeeForAccount(emp.employee_id, emp.full_name);
                };
                dropdown.appendChild(item);
            });
        }).catch(err => {
            dropdown.innerHTML = '<div class="search-dropdown-item">حدث خطأ أثناء البحث</div>';
        });
}

/// اختيار الموظف السابق من القائمة المنسدلة
function selectEmployeeForAccount(id, name) {
    document.getElementById('searchResultsDropdown').innerHTML = '';
    document.getElementById('empSearchQuery').value = name;
    document.getElementById('selected_emp_id').value = id;
    document.getElementById('selected_emp_name').value = name;
    
    // 1. إخفاء مربع البحث تماماً كما طلبت
    document.getElementById('searchSection').style.display = 'none';
    
    // 2. إظهار بقية الحقول لإكمال الحساب
    document.getElementById('linkExistingForm').style.display = 'block';
}
// تأكيد الحذف
function confirmDeleteEmployee(id) {
    if (confirm('هل أنت متأكد من حذف هذا الموظف وحسابه نهائياً؟')) {
        window.location.href = '/employees/delete/' + id;
    }
}

// الإغلاق عند الضغط خارج نافذة المحتوى
window.onclick = function(event) {
    const selectionModal = document.getElementById("selectionModal");
    const newModal = document.getElementById("newEmpModal");
    const existingModal = document.getElementById("existingEmpModal");
    const editModal = document.getElementById("editModal");

    if (event.target == selectionModal) closeSelectionModal();
    if (event.target == newModal) closeModal('new');
    if (event.target == existingModal) closeModal('existing');
    if (event.target == editModal) closeEditModal();
};

// إخفاء رسائل النظام تلقائياً
setTimeout(function(){
    let success = document.querySelector('.success-message');
    let error = document.querySelector('.error-message');
    if(success) success.style.display = 'none';
    if(error) error.style.display = 'none';
}, 4000);