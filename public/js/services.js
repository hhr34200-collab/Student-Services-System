function openModal()
{
document
.getElementById('serviceModal')
.style.display = 'flex';
}

function closeModal()
{
document
.getElementById('serviceModal')
.style.display = 'none';
}
function openEditModal(
id,
serviceName,
description
)
{
document
.getElementById('edit_service_name')
.value = serviceName;


document
    .getElementById('edit_description')
    .value = description;

document
    .getElementById('editForm')
    .action =
    '/services/update/' + id;

document
    .getElementById('editModal')
    .style.display = 'flex';


}

function closeEditModal()
{
document
.getElementById('editModal')
.style.display = 'none';
}
window.onload = function()
{
    let msg =
    document.getElementById(
        'successMessage'
    );

    if(msg)
    {
        setTimeout(function(){

            msg.style.transition =
            '0.5s';

            msg.style.opacity =
            '0';

            setTimeout(function(){

                msg.remove();

            },500);

        },5000);
    }
    const searchInput =
document.getElementById('search');

searchInput.addEventListener(
'keyup',
function () {

    let value = this.value;

    fetch('/services/search?search=' + encodeURIComponent(value))

    .then(response => response.json())

    .then(data => {

        let table =
        document.getElementById(
            'servicesTable'
        );

        table.innerHTML = '';

        data.forEach(function(service){
let status = `
<div class="status-wrapper">

    <label class="switch">
        <input
            type="checkbox"
            onchange="window.location='/services/${service.service_id}/status'"
            ${service.status === 'active' ? 'checked' : ''}>

        <span class="slider"></span>
    </label>

    <span class="status-text ${service.status === 'active' ? 'active' : 'inactive'}">
        ${service.status === 'active' ? 'مفعل' : 'موقفة'}
    </span>

</div>
`;

            table.innerHTML +=
            `
            <tr>

                <td>${service.service_name}</td>

                <td>${service.description ?? ''}</td>

                <td>${status}</td>

                <td>

<button
class="action-icon edit-btn"

onclick="openEditModal(

'${service.service_id}',

'${service.service_name}',

'${service.description ?? ''}'

)">

<i class="fas fa-edit"></i>

</button>

<a
href="/services/${service.service_id}/delete"
onclick="return confirm('هل أنت متأكد من حذف الخدمة؟')">

<button class="action-icon delete-btn">

<i class="fas fa-trash"></i>

</button>

</a>

                </td>

            </tr>
            `;

        });

    });

});
}

