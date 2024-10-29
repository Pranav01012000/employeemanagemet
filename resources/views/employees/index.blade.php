@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
.error {
    color: red;
    font-size: 12px;
}
</style>

<div class="container">
    <h2>Employee List</h2>
    <button type="button" class="btn btn-primary mb-10" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
        Add New Employee
    </button>

    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLabel">Update Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editemployeeForm" enctype="multipart/form-data">
                        @csrf
                    </form>
                    <div id="success_message" class="alert alert-success" style="display:none;"></div>
                    <div id="error_message" class="alert alert-danger" style="display:none;"></div>
                </div>


            </div>
        </div>
    </div>

    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLabel">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="employeeForm" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>


                        <div class="form-group mb-3">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>


                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>


                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country_code">Country Code</label>
                                    <select name="country_code" class="form-control">
                                        <option value="+1">+1 (USA)</option>
                                        <option value="+91">+91 (India)</option>
                                        <option value="+44">+44 (UK)</option>
                                        <option value="+61">+61 (Australia)</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="number" name="mobile" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control" required></textarea>
                        </div>


                        <div class="form-group mb-3">
                            <label>Gender</label>
                            <div class="d-flex gap-3">

                                <input type="radio" name="gender" value="Male" required checked> Male

                                <input type="radio" name="gender" value="Female" required> Female

                                <input type="radio" name="gender" value="Other" required> Other

                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="hobby">Hobby</label>
                            <div class="d-flex gap-3">
                                <div>
                                    <input type="checkbox" name="hobby[]" value="Reading" checked> Reading
                                </div>
                                <div>
                                    <input type="checkbox" name="hobby[]" value="Sports"> Sports
                                </div>
                                <div>
                                    <input type="checkbox" name="hobby[]" value="Music"> Music
                                </div>

                            </div>
                        </div>


                        <div class="form-group mb-3">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" class="form-control-file" required>
                        </div>


                        <div class="modal-footer">
                            <button type="submit" id="submitBtn" class="btn btn-primary">Add Employee</button>
                        </div>
                    </form>


                </div>


            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $index => $employee)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $employee->first_name }}</td>
                <td>{{ $employee->last_name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->country_code }} {{ $employee->mobile }}</td>
                <td>
                    <a href="javascript:void(0)" onclick="modal_edit({{$employee->id}})"
                        class="btn btn-warning">Edit</a>

                    <button onclick="delete_record({{$employee->id}})" id="deleteBtn"
                        class="btn btn-danger">Delete</button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@push('scripts')



@push('scripts')


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function modal_edit(id) {
    $.ajax({
        type: 'GET',
        url: '/edit?id=' + id, // Adjust this URL based on your routes
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('#editsubmitBtn').text('Submitting...').attr('disabled', true);
        },
        success: function(response) {

            $("#editemployeeForm").html(response.html);
            $("#editEmployeeModal").modal('show');
        },
        error: function(xhr) {

        }
    });

}


function delete_record(id) {
    Swal.fire({
        title: 'Are you sure?',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: '/delete?id=' + id,
                contentType: false,
                processData: false,
                beforeSend: function() {

                },
                success: function(response) {

                    window.location.reload();
                },
                error: function(xhr) {

                }
            });
        }
    });
}

$(document).ready(function() {

    $('#employeeForm').validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2
            },
            last_name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            mobile: {
                required: true,
                minlength: 10,
                number: true
            },
            address: {
                required: true
            },
            gender: {
                required: true
            }

        },
        messages: {

        },
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent());
        },
        submitHandler: function(form) {
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: '/store',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#submitBtn').text('Submitting...').attr('disabled', true);
                },
                success: function(response) {
                    $('#submitBtn').text('Add Employee').attr('disabled', false);
                    $('#success_message').text(response.success).show();
                    $('#employeeForm')[0].reset();
                    setTimeout(function() {
                        $('#success_message').fadeOut();
                    }, 3000);

                    window.location.reload();
                },
                error: function(xhr) {
                    $('#submitBtn').text('Add Employee').attr('disabled', false);
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('#' + key + '_error').text(value[0]);
                    });
                }
            });



        }
    });


    $('#editemployeeForm').validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2
            },
            last_name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            mobile: {
                required: true,
                minlength: 10,
                number: true
            },
            address: {
                required: true
            },
            gender: {
                required: true
            }

        },
        messages: {

        },
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent());
        },
        submitHandler: function(form) {
            var formData = new FormData(form);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/update/' + $("#emp_id")
            .val(), // Adjust this URL based on your routes
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#editsubmitBtn').text('Submitting...').attr('disabled', true);
                },
                success: function(response) {
                    $('#editsubmitBtn').text('Add Employee').attr('disabled', false);
                    $('#success_message').text(response.success).show();
                    $('#employeeForm')[0].reset();
                    setTimeout(function() {
                        $('#success_message').fadeOut();
                    }, 3000);
                    window.location.reload();
                },
                error: function(xhr) {

                    console.log(xhr);
                    $('#editsubmitBtn').text('Add Employee').attr('disabled', false);

                    $("#error_message").text(xhr.responseJSON.message);
                    $("#error_message").show();
                }
            });



        }
    });
});
</script>
@endpush