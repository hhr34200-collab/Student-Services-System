/*
|--------------------------------------------------------------------------
| تنفيذ جميع الأكواد بعد تحميل الصفحة
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", function () {

    /*
    |--------------------------------------------------------------------------
    | عناصر نافذة الإضافة
    |--------------------------------------------------------------------------
    */

    const addModal = document.getElementById("addAssignmentModal");

    const openAddModal = document.getElementById("openAddModal");

    const closeAddModal = document.getElementById("closeAddModal");



    /*
    |--------------------------------------------------------------------------
    | عناصر نافذة التعديل
    |--------------------------------------------------------------------------
    */

    const editModal = document.getElementById("editAssignmentModal");

    const closeEditModal = document.getElementById("closeEditModal");

    const editForm = document.getElementById("editAssignmentForm");



    /*
    |--------------------------------------------------------------------------
    | فتح نافذة الإضافة
    |--------------------------------------------------------------------------
    */

    openAddModal.addEventListener(

        "click",

        function(){

            addModal.style.display = "flex";

        }

    );



    /*
    |--------------------------------------------------------------------------
    | إغلاق نافذة الإضافة
    |--------------------------------------------------------------------------
    */

    closeAddModal.addEventListener(

        "click",

        function(){

            addModal.style.display = "none";

        }

    );



    /*
    |--------------------------------------------------------------------------
    | إغلاق نافذة التعديل
    |--------------------------------------------------------------------------
    */

    closeEditModal.addEventListener(

        "click",

        function(){

            editModal.style.display = "none";

        }

    );



    /*
    |--------------------------------------------------------------------------
    | إغلاق النوافذ عند الضغط خارجها
    |--------------------------------------------------------------------------
    */

    window.addEventListener(

        "click",

        function(event){

            if(event.target == addModal){

                addModal.style.display = "none";

            }

            if(event.target == editModal){

                editModal.style.display = "none";

            }

        }

    );



    /*
    |--------------------------------------------------------------------------
    | فتح نافذة التعديل
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(".btn-edit").forEach(function(button){

        button.addEventListener("click",function(){


            /*
            |--------------------------------------------------------------------------
            | رابط التعديل
            |--------------------------------------------------------------------------
            */

            editForm.action =

            "/course-assignments/" +

            this.dataset.id +

            "/update";



            /*
            |--------------------------------------------------------------------------
            | تعبئة بيانات النموذج
            |--------------------------------------------------------------------------
            */

            document.getElementById(

                "edit_course_id"

            ).value = this.dataset.course;



            document.getElementById(

                "edit_department_id"

            ).value = this.dataset.department;



            document.getElementById(

                "edit_employee_id"

            ).value = this.dataset.employee;



            document.getElementById(

                "edit_academic_year"

            ).value = this.dataset.year;



            document.getElementById(

                "edit_semester"

            ).value = this.dataset.semester;



            /*
            |--------------------------------------------------------------------------
            | فتح النافذة
            |--------------------------------------------------------------------------
            */

            editModal.style.display = "flex";

        });

    });

});