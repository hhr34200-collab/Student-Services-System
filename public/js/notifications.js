/*
|--------------------------------------------------------------------------
| زر الإعدادات
|--------------------------------------------------------------------------
*/

const settingsBtn =
document.getElementById('settingsBtn');

const settingsMenu =
document.getElementById('settingsMenu');

if (settingsBtn && settingsMenu) {

    settingsBtn.addEventListener('click', function () {

        settingsMenu.classList.toggle('show');

    });

    // إغلاق القائمة عند الضغط خارجها
    document.addEventListener('click', function (e) {

        if (
            !settingsBtn.contains(e.target) &&
            !settingsMenu.contains(e.target)
        ) {

            settingsMenu.classList.remove('show');

        }

    });

}


/*
|--------------------------------------------------------------------------
| تحديد الكل
|--------------------------------------------------------------------------
*/

const selectAllBtn =
document.getElementById('selectAllBtn');

if (selectAllBtn) {

    selectAllBtn.addEventListener('click', function () {

        let checks =
        document.querySelectorAll(
            'input[type="checkbox"]'
        );

        let allChecked =
        [...checks].every(item => item.checked);

        checks.forEach(function (item) {

            item.checked = !allChecked;

        });

    });

}