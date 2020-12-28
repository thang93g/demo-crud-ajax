<!doctype html>
<html lang="en">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="container">

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        add customer
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">customer properties</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Name</label>
                            <input type="text" class="form-control" id="name-input" name="name">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Age</label>
                            <input type="text" class="form-control" id="age-input" name="age">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Address</label>
                            <input type="text" class="form-control" id="address-input" name="address">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button onclick="addCustomer()" type="button" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>\
                <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input type="text" class="form-control" id="name-edit" name="name">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Age</label>
                        <input type="text" class="form-control" id="age-edit" name="age">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Address</label>
                        <input type="text" class="form-control" id="address-edit" name="address">
                        <input type="hidden" class="form-control" id="id-edit" name="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="updateCustomer()" type="button" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            Customers List
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                <tbody id="customer-table">

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

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

    let deleteCustomer = function(id){
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


</script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
