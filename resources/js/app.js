import './bootstrap';

console.log('App JS Loaded');

/*
|--------------------------------------------------------------------------
| تشغيل صوت الإشعار
|--------------------------------------------------------------------------
*/

function playNotificationSound() {

    console.log('playNotificationSound called');

    const audio = document.getElementById(
        'notificationSound'
    );

    if (audio) {

        audio.play()
        .then(() => {

            console.log('Sound played');

        })
        .catch(error => {

            console.log('Sound error:', error);

        });

    }

}

/*
|--------------------------------------------------------------------------
| الاستماع إلى الإشعارات الفورية
|--------------------------------------------------------------------------
*/

if (window.userId) {

    console.log(
        'Listening on channel:',
        `user.${window.userId}`
    );

    window.Echo
        .private(
            `user.${window.userId}`
        )
        .listen(
            '.new-notification',
            (event) => {

                console.log(
                    'Notification received:',
                    event
                );

                /*
                |--------------------------------------------------------------------------
                | تشغيل الصوت
                |--------------------------------------------------------------------------
                */

                playNotificationSound();

                /*
                |--------------------------------------------------------------------------
                | عرض SweetAlert
                |--------------------------------------------------------------------------
                */

                if (typeof showAlert === "function") {

                    showAlert(

                        event.type ?? "info",

                        event.title,

                        event.message

                    );

                }

                /*
                |--------------------------------------------------------------------------
                | تحديث عداد الإشعارات
                |--------------------------------------------------------------------------
                */

                const counter = document.querySelector(
                    '.notification-count'
                );

                if (counter) {

                    let count = parseInt(counter.innerText);

                    if (isNaN(count)) {

                        count = 0;

                    }

                    counter.innerText = count + 1;

                }

            }
        );

}