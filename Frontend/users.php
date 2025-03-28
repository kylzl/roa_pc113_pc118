<?php
include 'partials/header.php';
include 'partials/sidebar.php';
include 'modals/create-user-modal.php';
include 'modals/update-user-modal.php';
?>

<div class="content">
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand  h1">Users</span>
            <div class="mb-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUserModal">Create User</button>

        </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover table-striped table-bordered table-responsive" id="myTable">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 10%;">Actions</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/verify-token.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    let table = $('#myTable').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        columnDefs: [
            { orderable: false, targets: 0 } // Disable sorting for the Actions column
        ]
    });

    function fetchUsers() {
        let token = localStorage.getItem('token');

        if (!token) {
            alert("You are not logged in. Please login first.");
            window.location.href = "login-form.php";
            return;
        }

        $.ajax({
            url: 'http://127.0.0.1:8000/api/users',
            method: 'GET',
            dataType: 'json',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            success: function (response) {
                table.clear();

                if (Array.isArray(response.data)) {
                    response.data.forEach((user, index) => {
                        let actions = `
                            <div class="text-center">
                                <i class="fas fa-edit text-primary update-btn me-2" data-id="${user.id}" data-name="${user.name}" data-email="${user.email}" data-role="${user.role}" style="cursor: pointer;" title="Update"></i>
                                <i class="fas fa-trash-alt text-danger delete-btn" data-id="${user.id}" style="cursor: pointer;" title="Delete"></i>
                            </div>
                        `;

                        table.row.add([
                            actions,
                            index + 1 + '. ' + user.name, 
                            user.email,
                            user.role
                        ]);
                    });

                    table.draw();
                } else {
                    console.error('Unexpected response format:', response);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching users:', error);
                console.error('Server response:', xhr.responseText);
            }
        });
    }

    $(document).on('click', '.update-btn', function () {
        let userId = $(this).data('id');
        let userName = $(this).data('name');
        let userEmail = $(this).data('email');
        let userRole = $(this).data('role');

        $('#updateUserId').val(userId);
        $('#updateUserName').val(userName);
        $('#updateUserEmail').val(userEmail);
        $('#updateUserRole').val(userRole);

        $('#updateUserModal').modal('show');
    });

    $('#updateUserForm').on('submit', function (e) {
        e.preventDefault();

        let token = localStorage.getItem('token');
        let userId = $('#updateUserId').val();
        let updatedData = {
            name: $('#updateUserName').val(),
            email: $('#updateUserEmail').val(),
            role: $('#updateUserRole').val()
        };

        $.ajax({
            url: `http://127.0.0.1:8000/api/users/${userId}`,
            method: 'PUT',
            dataType: 'json',
            contentType: 'application/json',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            data: JSON.stringify(updatedData),
            success: function (response) {
                alert('User updated successfully!');
                $('#updateUserModal').modal('hide'); 
                fetchUsers();
            },
            error: function (xhr, status, error) {
                console.error('Error updating user:', error);
                console.error('Server response:', xhr.responseText);
            }
        });
    });

    $(document).on('click', '.delete-btn', function () {
        let userId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteUser(userId);
            }
        });
    });

    function deleteUser(userId) {
        let token = localStorage.getItem('token');

        $.ajax({
            url: `http://127.0.0.1:8000/api/users/${userId}`,
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            success: function (response) {
                Swal.fire(
                    'Deleted!',
                    'The user has been deleted.',
                    'success'
                );
                fetchUsers(); 
            },
            error: function (xhr, status, error) {
                Swal.fire(
                    'Error!',
                    'There was an error deleting the user.',
                    'error'
                );
                console.error("Error deleting user:", error);
                console.error("Server response:", xhr.responseText);
            }
        });
    }

    fetchUsers();
});
</script>