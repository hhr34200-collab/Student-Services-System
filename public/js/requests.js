/*==================================================
                عناصر الصفحة
==================================================*/

const modal = document.getElementById("requestModal");

/*==================================================
        فتح نافذة معلومات الطلب
==================================================*/

function openRequestModal(requestId) {
    fetch(`/admin/requests/${requestId}/json`)
        .then(response => response.json())
        .then(res => {
            if (!res.success) {
                alert('حدث خطأ في جلب بيانات الطلب');
                return;
            }

            const item = res.data;

            /*=============================
                    تعبئة البيانات
            =============================*/

            document.getElementById("modalRequestNumber").textContent = item.request_number;
            document.getElementById("modalStudent").textContent = item.student_name;
            document.getElementById("modalService").textContent = item.service_name;
            document.getElementById("modalEmployee").textContent = item.current_employee;
            document.getElementById("summaryService").textContent = item.service_name;
            document.getElementById("summaryEmployee").textContent = item.current_employee;
            document.getElementById("summaryStatus").textContent = item.status_text;

            /*=============================
                    الحالة
            =============================*/

            const statusBox = document.getElementById("modalStatus");
            statusBox.textContent = item.status_text;
            statusBox.className = "status-large";
            applyStatusStyle(statusBox, item.status_key);

            /*=============================
                    Timeline
            =============================*/

            updateTimeline(item.status_key);

            modal.classList.add("open");
            document.body.style.overflow = "hidden";
        })
        .catch(error => {
            console.error(error);
            alert("تعذر الاتصال بالخادم، يرجى المحاولة مرة أخرى.");
        });
}

/*==================================================
            تلوين الحالة
==================================================*/

function applyStatusStyle(box, status) {
    const styles = {
        'submitted': { background: '#DBEAFE', color: '#2563EB' },
        'student_affairs_review': { background: '#FEF3C7', color: '#B45309' },
        'department_head_review': { background: '#FEF3C7', color: '#B45309' },
        'dean_review': { background: '#FEF3C7', color: '#B45309' },
        'attachments_required': { background: '#FDE68A', color: '#92400E' },
        'returned': { background: '#FCE7F3', color: '#BE185D' },
        'on_hold': { background: '#E2E8F0', color: '#475569' },
        'approved': { background: '#DCFCE7', color: '#15803D' },
        'rejected': { background: '#FEE2E2', color: '#DC2626' },
        'cancelled': { background: '#FEE2E2', color: '#DC2626' }
    };

    const style = styles[status] || { background: '#E2E8F0', color: '#475569' };
    box.style.background = style.background;
    box.style.color = style.color;
}

/*==================================================
                تحديث الـ Timeline
==================================================*/

function updateTimeline(status) {
    const stages = {
        'submitted': 0,
        'student_affairs_review': 1,
        'department_head_review': 2,
        'dean_review': 3,
        'approved': 4
    };

    const current = stages[status] ?? 0;

    const steps = [
        document.getElementById("step-submitted"),
        document.getElementById("step-affairs"),
        document.getElementById("step-department"),
        document.getElementById("step-dean"),
        document.getElementById("step-approved")
    ];

    steps.forEach((step, index) => {
        if (step) {
            step.classList.remove("completed", "current");

            if (index < current) {
                step.classList.add("completed");
            } else if (index === current) {
                step.classList.add("current");
            }
        }
    });
}

/*==================================================
                إغلاق النافذة
==================================================*/

function closeRequestModal() {
    modal.classList.remove("open");
    document.body.style.overflow = "auto";
}

/* الضغط خارج النافذة */
window.addEventListener("click", function(e) {
    if (e.target === modal) {
        closeRequestModal();
    }
});

/* زر ESC */
document.addEventListener("keydown", function(e) {
    if (e.key === "Escape" && modal.classList.contains("open")) {
        closeRequestModal();
    }
});

/*==================================================
                البحث الفوري
==================================================*/

const searchInput = document.getElementById("mainSearchInput");

if (searchInput) {
    searchInput.addEventListener("keyup", function() {
        const value = this.value.toLowerCase().trim();

        document.querySelectorAll(".request-row").forEach(row => {
            const requestNumber = row.querySelector(".request-number")?.textContent.toLowerCase() || "";
            const studentName = row.querySelector(".student-cell")?.textContent.toLowerCase() || "";
            const serviceBadge = row.querySelector(".service-badge")?.textContent.toLowerCase() || "";
            const employeeCell = row.querySelector(".employee-cell")?.textContent.toLowerCase() || "";

            if (
                requestNumber.includes(value) ||
                studentName.includes(value) ||
                serviceBadge.includes(value) ||
                employeeCell.includes(value)
            ) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
}

/*==================================================
            فلتر البطاقات والتبويبات
==================================================*/

// فلتر البطاقات الإحصائية
document.querySelectorAll('.stat-card').forEach(card => {
    card.addEventListener('click', function() {
        const filter = this.dataset.filter;
        applyFilter(filter);
        
        // تفعيل البطاقة المحددة
        document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        
        // إلغاء تفعيل أزرار الفلتر
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelector(`.filter-btn[data-filter="${filter}"]`)?.classList.add('active');
    });
});

// فلتر أزرار التبويبات
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const filter = this.dataset.filter;
        applyFilter(filter);
        
        // تفعيل الزر المحدد
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // إلغاء تفعيل البطاقات
        document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active'));
        document.querySelector(`.stat-card[data-filter="${filter}"]`)?.classList.add('active');
    });
});

/*==================================================
            تطبيق الفلتر
==================================================*/

function applyFilter(filter) {
    const rows = document.querySelectorAll('.request-row');
    let visibleCount = 0;

    rows.forEach(row => {
        if (filter === 'all') {
            row.style.display = '';
            visibleCount++;
        } else if (filter === 'delayed') {
            // الطلبات المتأخرة (أكثر من 3 أيام)
            const createdAt = row.dataset.createdAt;
            if (createdAt) {
                const days = Math.floor((Date.now() - new Date(createdAt)) / (1000 * 60 * 60 * 24));
                if (days >= 3) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            } else {
                row.style.display = 'none';
            }
        } else {
            const status = row.dataset.status;
            if (status === filter) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
    });

    // تحديث العدد في البطاقات
    updateCardCounts();
}

/*==================================================
            تحديث أعداد البطاقات
==================================================*/

function updateCardCounts() {
    const rows = document.querySelectorAll('.request-row');
    const total = rows.length;
    const review = document.querySelectorAll('.request-row[data-status="review"]').length;
    const attachments = document.querySelectorAll('.request-row[data-status="attachments_required"]').length;
    const delayed = document.querySelectorAll('.request-row[data-status="delayed"]').length;

    // تحديث الأعداد في البطاقات
    document.querySelector('.stat-card[data-filter="all"] .stat-info h2').textContent = total;
    document.querySelector('.stat-card[data-filter="review"] .stat-info h2').textContent = review;
    document.querySelector('.stat-card[data-filter="attachments_required"] .stat-info h2').textContent = attachments;
    document.querySelector('.stat-card[data-filter="delayed"] .stat-info h2').textContent = delayed;
}