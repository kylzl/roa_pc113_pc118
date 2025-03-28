$(document).ready(function () {
    function fetchEmployees() {
        let token = localStorage.getItem('token');

        if (!token) {
            alert("You are not logged in. Please login first.");
            window.location.href = "login-form.php";
            return;
        }

        $.ajax({
            url: 'http://127.0.0.1:8000/api/employee', 
            method: 'GET',
            dataType: 'json',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            success: function (response) {
                let tableBody = $('#myTable tbody');
                tableBody.empty(); 

                console.log("API Response:", response);

                console.log("Total Employees:", response.total);

                if (response.total !== undefined) {
                    $('#total-employees').text(response.total); 
                }

                if (response.data && Array.isArray(response.data)) {
                    response.data.forEach((employee, index) => {
                        let row = `<tr>
                            <td>${index + 1}</td>
                            <td>${employee.name}</td>
                            <td>${employee.email}</td>
                            <td>
                                <button class="btn btn-primary btn-sm update-btn" data-id="${employee.id}">Update</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${employee.id}">Delete</button>
                            </td>
                        </tr>`;
                        tableBody.append(row);
                    });
                } else {
                    console.error("Unexpected response format:", response);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching employees:", error);
                console.error("Server response:", xhr.responseText);
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
            deleteEmployee(employeeId);
        }
    });

    function deleteEmployee(employeeId) {
        let token = localStorage.getItem('token');
        $.ajax({
            url: `http://127.0.0.1:8000/api/employee/${employeeId}`,
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            success: function (response) {
                alert('Employee deleted successfully!');
                fetchEmployees();
            },
            error: function (xhr, status, error) {
                console.error("Error deleting employee:", error);
                console.error("Server response:", xhr.responseText);
            }
        });
    }

    fetchEmployees(); 
});
