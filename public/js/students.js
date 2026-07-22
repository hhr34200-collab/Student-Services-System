// =======================================
// فتح نافذة إضافة طالب
// =======================================

function openModal()
{
    let modal =
    document.getElementById(
        "studentModal"
    );

    if(modal)
    {
        modal.style.display =
        "flex";
         // تفريغ جميع الحقول
        modal.querySelector("form").reset();
    }
}

// =======================================
// إغلاق نافذة إضافة طالب
// =======================================

function closeModal()
{
    let modal =
    document.getElementById(
        "studentModal"
    );

    if(modal)
    {
        modal.style.display =
        "none";
    }
}

// =======================================
// فتح نافذة تعديل الطالب
// =======================================

function openEditModal(
    student_id,
    full_name,
    college_name,
    department_name,
    level,
    
)
{
    let modal =
    document.getElementById(
        "editModal"
    );

    if(modal)
    {
        modal.style.display =
        "flex";
    }

    document.getElementById(
        "edit_name"
    ).value =full_name;

    document.getElementById(
        "edit_college"
    ).value = college_name;

    document.getElementById(
        "edit_major"
    ).value = department_name;

    document.getElementById(
        "edit_level"
    ).value = level;

    

    document.getElementById("editForm").action =
    "/students/" + student_id + "/update";
}

// =======================================
// إغلاق نافذة التعديل
// =======================================

function closeEditModal()
{
    let modal =
    document.getElementById(
        "editModal"
    );

    if(modal)
    {
        modal.style.display =
        "none";
    }
}

// =======================================
// إخفاء رسائل النجاح والخطأ
// =======================================

setTimeout(function(){

    let success =
    document.querySelector(
        ".success-message"
    );

    if(success)
    {
        success.style.opacity =
        "0";

        setTimeout(function(){

            success.remove();

        },500);
    }

    let error =
    document.querySelector(
        ".error-message"
    );

    if(error)
    {
        error.style.opacity =
        "0";

        setTimeout(function(){

            error.remove();

        },500);
    }

},3000);


// =======================================
// البحث الفوري
// =======================================

const searchInput = document.getElementById("searchInput");

if (searchInput) {

    searchInput.addEventListener("keyup", function () {

        fetch("/students/search?search=" + encodeURIComponent(this.value))

        .then(response => response.json())

        .then(data => {

            let table = document.getElementById("studentsTable");

            table.innerHTML = "";

            data.forEach(function(student){

                let status = `
                <a href="/students/${student.student_id}/toggle-status">

                    <span class="status-badge ${student.academic_status === 'active' ? 'active' : 'inactive'}">

                        ${student.academic_status === 'active'
                            ? '🟢 مفعل'
                            : '🔴 موقوف'}

                    </span>

                </a>
                `;

                table.innerHTML += `
                <tr>

                    <td>${student.full_name}</td>

                    <td>${student.student_number}</td>

                    <td>${student.college ? student.college.college_name : '-'}</td>

                    <td>${student.department ? student.department.department_name : '-'}</td>

                    <td>${student.level}</td>

                    <td>${status}</td>

                    <td>

                        <button
                            class="action-icon edit-btn"
                            onclick="openEditModal(
                                '${student.student_id}',
                                '${student.full_name}',
                                '${student.college_id}',
                                '${student.department_id}',
                                '${student.level}'
                            )">

                            <i class="fas fa-edit"></i>

                        </button>

                        <button
                            class="action-icon delete-btn"
                            onclick="confirmDeleteStudent('${student.student_id}')">

                            <i class="fas fa-trash"></i>

                        </button>

                    </td>

                </tr>
                `;

            });

        });

    });

}
function confirmDeleteStudent(id)
{
    if(confirm("هل تريد حذف الطالب؟"))
    {
        let form = document.createElement("form");

        form.method = "POST";

        form.action = "/students/" + id + "/delete";

        let csrf = document.createElement("input");
        csrf.type = "hidden";
        csrf.name = "_token";
        csrf.value = document.querySelector(
            'meta[name="csrf-token"]'
        ).content;

        form.appendChild(csrf);

        document.body.appendChild(form);

        form.submit();
    }
}