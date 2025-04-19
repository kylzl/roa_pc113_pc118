<?php
    include 'template.php';
    include '../modals/create-user-modal.php';
    include '../modals/update-user-modal.php';

?>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<style>
    .top{
        display: flex;
        justify-content: space-between;
    }
    table.dataTable {
    }

    table.dataTable td {
        padding: 6px 10px;
    }

    .table-head {
        background-color: rgb(18, 51, 100);
        color: white;
        font-weight: bold;
    }


</style>
<div class="content">
<nav class="bar m-0 d-flex justify-content-between align-items-center">
    <div>
        <h5 class="mb-0">USERS LIST</h5>
    </div>
    <div>
        <button type="button" class="btn text-white" style="background-color: #09033B;" id="createUserBtn"
            data-bs-toggle="modal" data-bs-target="#createUserModal">
            ADD USER
        </button>
    </div>
</nav>


    <div class="container mt-5 px-0"></div>
        <div class="card shadow-sm">
            <div class="card-body">
            <table class="table table-hover table-responsive" id="myTable">
                <thead class="table-secondary table-head text-center">
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
    document.addEventListener('DOMContentLoaded', function () {
        const tableElement = document.getElementById('myTable');

        if (tableElement) {
            const dataTable = $('#myTable').DataTable({
                ordering: true,
                responsive: true,
                destroy: true
            });

            function fetchUsers() {
                let token = localStorage.getItem('token');

                if (!token) {
                    alert("You are not logged in. Please login first.");
                    window.location.href = "../login-form.php";
                    return;
                }

                $.ajax({
                    url: 'http://amsbackend.test/api/users',
                    method: 'GET',
                    dataType: 'json',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    },
                    success: function (response) {
                        dataTable.clear();

                        if (response.total !== undefined) {
                            $('#total-users').text(`Total Users: ${response.total}`);
                        }

                        if (Array.isArray(response.data)) {
                            response.data.forEach((user) => {
                                if (user.role === 'admin') {
                                    return;
                                }

                                let actions = `
                                    <div class="text-center">
                                        <i class="fas fa-edit text-primary update-btn" 
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
                                    ? `<img src="http://amsbackend.test/storage/${user.image}" alt="User Image" class="img-thumbnail" style="width: 30px; height: 30px;">` 
                                    : `<img src="../images/default-image.png" alt="Default Image" class="img-thumbnail" style="width: 30px; height: 30px;">`;

                                dataTable.row.add([
                                    actions,
                                    image,
                                    user.id,
                                    user.name, 
                                    user.email,
                                    user.role
                                ]);
                            });

                            dataTable.draw();
                        } else {
                            console.error('Unexpected response format:', response);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching users:', error);
                        console.error('Server response:', xhr.responseText);
                        alert("Failed to load user data. Please try again.");
                        window.location.href = 'dashboard.php';
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
                    url: `http://amsbackend.test/api/users/${userId}`,
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
        }
    });
</script>


