// ==========================================
// رسم بياني الطلبات
// ==========================================

const ctx = document
    .getElementById("requestsChart")
    .getContext("2d");

new Chart(ctx,{

    type:"doughnut",

    data:{

        labels:[

            "قيد المراجعة",

            "تمت الموافقة",

            "تم رفضها",

            "تحتاج استكمال"

        ],

        datasets:[{

            data:[

                reportData.review,

                reportData.approved,

                reportData.rejected,

                reportData.returned

            ],

            backgroundColor:[

                "#1976D2",

                "#2E7D32",

                "#D32F2F",

                "#F9A825"

            ],

            borderWidth:2

        }]

    },

   options:{

    responsive:true,

    maintainAspectRatio:false,

    plugins:{

        legend:{

            position:"bottom"

        }

    }

}

  

});


// ==========================================
// طباعة التقرير
// ==========================================

function printReport(){

    window.print();

}