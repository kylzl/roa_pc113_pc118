<?php
    include 'template.php';
    include '../modals/create-user-modal.php';
    include '../modals/update-user-modal.php';

?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<style>
    .top{
        display: flex;
        justify-content: space-between;
    }

</style>
<div class="content">
    <nav class="bar m-0">
            <div class="top">
            <button type="button" class="btn fa-solid btn-success m-0" id="createUserBtn"
            data-bs-toggle="modal" data-bs-target="#createUserModal">
                Add User
            </button>
            
            
            <span class="navbar-brand h1" id="total-users"></span>
        </div>
    </nav>

    <div class="container mt-5 px-0"></div>
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover table-striped table-bordered table-responsive" id="myTable">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 5%;">Actions</th>
                            <th style="width:4%;">Image</th>
                            <th style="width:4%;">ID</th>
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

<script>
$(document).ready(function () {
    let table = $('#myTable').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        columnDefs: [
            { orderable: false, targets: 0 }
        ]
    });

    function fetchUsers() {
        let token = localStorage.getItem('token');

        if (!token) {
            alert("You are not logged in. Please login first.");
            window.location.href = "../login-form.php";
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

                if(response.total !== undefined){
                    $('#total-users').text(`Total Users: ${response.total}`);
                }

                if (Array.isArray(response.data)) {
                    response.data.forEach((user, index) => {
                        let actions = `
                            <div class="text-center">
                                <i class="fas fa-edit text-primary update-btn " 
                                data-id="${user.id}" 
                                data-name="${user.name}" 
                                data-email="${user.email}" 
                                data-role="${user.role}" 
                                style="cursor: pointer;" title="Update"></i>
                                <i class="fas fa-trash-alt text-danger delete-btn" 
                                data-id="${user.id}" 
                                style="cursor: pointer;" title="Delete"></i>
                            </div>
                        `;

                        let image = user.image 
                            ? `<img src="http://127.0.0.1:8000/storage/${user.image}" alt="User Image" class="img-thumbnail" style="width: 50px; height: 50px;">` 
                            : `<img src="../images/default-image.png" alt="Default Image" class="img-thumbnail" style="width: 50px; height: 50px;">`;

                        table.row.add([
                            actions,
                            image,
                            user.id,
                            user.name, 
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
                alert("Failed to load user data. Please try again.");
                window.location.href= 'dashboard.php';
            }
        });
    }

    
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


