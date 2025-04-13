$(document).ready(function () {
    let table = $('#studentTable').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        columnDefs: [
            { orderable: false, targets: 4 }
        ]
    });

    function fetchStudents() {
        let token = localStorage.getItem('token');

        if (!token) {
            alert("You are not logged in. Please login first.");
            window.location.href = "../login-form.php";
            return;
        }

        $.ajax({
            url: 'http://127.0.0.1:8000/api/students',
            method: 'GET',
            dataType: 'json',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            success: function (response) {
                table.clear();

                if (response.total !== undefined) {
                    $('#total-students').text(`Total Students: ${response.total}`);
                }

                if (Array.isArray(response.data)) {
                    response.data.forEach((student) => {
                        let actions = `
                            <div class="text-center">
                                <i class="fas fa-edit text-primary edit-btn me-2" 
                                data-id="${student.id}" 
                                style="cursor: pointer;" title="Edit"></i>
                                <i class="fas fa-trash-alt text-danger delete-btn" 
                                data-id="${student.id}" 
                                style="cursor: pointer;" title="Delete"></i>
                            </div>
                        `;

                        table.row.add([
                            student.id,
                            student.firstname,
                            student.lastname,
                            student.email,
                            actions
                        ]);
                    });

                    table.draw();
                } else {
                    console.error('Unexpected response format:', response);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching students:', error);
                console.error('Server response:', xhr.responseText);
                alert("Failed to load student data. Please try again.");
            }
        });
    }

    $(document).on('click', '.delete-btn', function () {
        let studentId = $(this).data('id');

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
                deleteStudent(studentId);
            }
        });
    });

    function deleteStudent(studentId) {
        let token = localStorage.getItem('token');

        $.ajax({
            url: `http://127.0.0.1:8000/api/student/${studentId}`,
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            success: function (response) {
                Swal.fire(
                    'Deleted!',
                    'The student has been deleted.',
                    'success'
                );
                fetchStudents();
            },
            error: function (xhr, status, error) {
                Swal.fire(
                    'Error!',
                    xhr.responseJSON.message,
                    'error'
                );
                console.error("Error deleting student:", error);
                console.error("Server response:", xhr.responseText);
            }
        });
    }

    fetchStudents();
});
