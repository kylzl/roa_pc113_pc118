<?php
include 'partials/header.php';
include 'partials/sidebar.php';
?>
<div class="content">
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Employees</span>
        </div>
    </nav>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered table-responsive bg-body-tertiary" id="myTable">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th> 
                        </tr>
                    </thead>
                    <tbody></tbody>  
                </table>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/verify-token.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    let table = $('#myTable').DataTable();

    function fetchEmployee() {
        let token = localStorage.getItem('token');

        if (!token) {
            alert("You are not logged in. Please login first.");
            window.location.href = "login-form.php";
            return;
        }

        $.ajax({
            url: 'http://127.0.0.1:8000/api/employee', // Ensure the endpoint matches the backend
            method: 'GET',
            dataType: 'json',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            success: function (response) {
                console.log("API Response:", response); // Debugging log
                table.clear();

                if (Array.isArray(response.data)) {
                    response.data.forEach((employee, index) => {
                        let actions = `
                            <button class="btn btn-primary btn-sm update-btn" data-id="${employee.id}">Update</button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${employee.id}">Delete</button>
                        `;

                        table.row.add([
                            index + 1,
                            employee.name,
                            employee.email,
                            actions
                        ]);
                    });

                    table.draw();
                } else {
                    console.error('Unexpected response format:', response);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching Employee:', error);
                console.error('Server response:', xhr.responseText);
            }
        });
    }

    $(document).on('click', '.update-btn', function () {
        let employeeId = $(this).data('id');
        window.location.href = `update-employee.php?id=${employeeId}`;
    });

    $(document).on('click', '.delete-btn', function () {
        let employeeId = $(this).data('id');
        if (confirm('Are you sure you want to delete this employee?')) {
            deleteemployee(employeeId);
        }
    });

    function deleteemployee(employeeId) {
        let token = localStorage.getItem('token');

        $.ajax({
            url: `http://127.0.0.1:8000/api/employee/${employeeId}`, // Corrected variable usage
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            success: function (response) {
                alert('Employee deleted successfully!');
                fetchEmployee(); // Refresh the table
            },
            error: function (xhr, status, error) {
                console.error("Error deleting employee:", error);
                console.error("Server response:", xhr.responseText);
            }
        });
    }

    fetchEmployee();
});
</script>
