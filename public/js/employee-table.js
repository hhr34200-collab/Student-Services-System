const search=document.getElementById("tableSearch");

search.addEventListener("keyup",function(){

let value=this.value.toLowerCase();

let rows=document.querySelectorAll("#requestsTable tbody tr");

rows.forEach(function(row){

let text=row.innerText.toLowerCase();

row.style.display=text.includes(value)?"":"none";

});

});
/*=========================================================
                طباعة الصفحة
=========================================================*/

function printPage()
{
    window.print();
}

/*=========================================================
                الرجوع
=========================================================*/

function backPage()
{
    history.back();
}