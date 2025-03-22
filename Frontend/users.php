<?php
include 'partials/sidebar.php';

?>
<div class="content">
    <nav class="navbar navbar-light bg-light mb-4">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Users</span>
        </div>
    </nav>
    <div class="container mt-3">
        <div class="">

            <div class="card-body">
            <table class="table table-striped table-bordered table-responsive shadow bg-body-tertiary rounded" id="myTable">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
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
                let tableBody = $('#myTable tbody');
                tableBody.empty(); 
                
                if (Array.isArray(response.data)) {
                    response.data.forEach((user, index) => {
                        let row = `<tr>
                            <td>${index + 1}</td>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.role}</td>
                        </tr>`;
                        tableBody.append(row);
                    });
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
    
    fetchUsers(); 
});
</script>