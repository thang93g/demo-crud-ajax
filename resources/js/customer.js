let display = function (response) {
    let str = '';
    for (let i = 0; i < response.length; i++) {
        str += `<tr id="customer${response[i].id}"><td>${i + 1}</td><td>${response[i].name}</td><td>${response[i].age}</td>
<td>${response[i].address}</td><td><button onclick="editCustomer(${response[i].id})" class="btn btn-success pl-4 pr-4">Edit</button>
<button onclick="deleteCustomer(${response[i].id})" class="btn btn-danger">Delete</button></td>`
    }
    $('#customer-table').html(str);
}

let getAllCustomer = function () {
    $.ajax({
        type: "GET",
        url: "api/customers",
        success: function (response) {
            console.log(response);
            display(response);
            $('#exampleModal').modal("hide");
        }
    })
}

let getCustomer = function (id) {
    $.ajax({
        type: "GET",
        url: "api/customers/" + id,
        success: function (response) {
            console.log(response);
            $('#name-edit').val(response.name);
            $('#age-edit').val(response.age);
            $('#address-edit').val(response.address);
            $('#id-edit').val(response.id);
        }
    })
}

$(document).ready(function () {
    getAllCustomer();
})

let addCustomer = function () {
    let name = $('#name-input').val();
    let age = $('#age-input').val();
    let address = $('#address-input').val();
    let customer = {name, age, address};
    $.ajax({
        type: "POST",
        url: "api/customers",
        data: customer,
        success: function () {
            getAllCustomer();
            $('#name-input').val('');
            $('#age-input').val('');
            $('#address-input').val('');
        }
    })
}

let deleteCustomer = function (id) {
    $.ajax({
        type: "DELETE",
        url: "api/customers/" + id,
        success: function () {
            getAllCustomer();
        }
    })
}

let editCustomer = function (id) {
    $('#editModal').modal('show');
    getCustomer(id);
}

let updateCustomer = function () {
    let id = $('#id-edit').val();
    let name = $('#name-edit').val();
    let age = $('#age-edit').val();
    let address = $('#address-edit').val();
    let customer = {name, age, address};
    $.ajax({
        type: "PUT",
        url: "api/customers/" + id,
        data: customer,
        success: function () {
            $('#editModal').modal('hide');
            getAllCustomer();
        }
    })
}


