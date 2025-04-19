console.log("fetch-students.js active");

document.addEventListener('DOMContentLoaded', function () {
    const tableElement = document.getElementById('studentTable');

    if (tableElement) {
        const dataTable = $('#studentTable').DataTable({
            // searching: false, 
            ordering: true,
            responsive: true,
            destroy: true 
        });

        function fetchStudents() {
            const token = localStorage.getItem('token');

            if (!token) {
                alert("You are not logged in. Please login first.");
                window.location.href = "../login-form.php";
                return;
            }

            $.ajax({
                url: 'http://amsbackend.test/api/students',
                method: 'GET',
                dataType: 'json',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                },
                success: function (response) {
                    dataTable.clear();

                    console.log('Total Students:', response.total);
                    console.log(document.getElementById('total-students'));

                    const totalElement = document.getElementById('total-students');
                    if (totalElement && response.total !== undefined) {
                        totalElement.textContent = response.total;
                    }

                    if (Array.isArray(response.data)) {
                        response.data.forEach((student) => {
                            const actions = `
                                <div class="text-center">
                                    <i class="fas fa-edit text-primary edit-btn me-2" 
                                       data-id="${student.id}" 
                                       style="cursor: pointer;" 
                                       title="Edit"></i>
                                    <i class="fas fa-trash-alt text-danger delete-btn" 
                                       data-id="${student.id}" 
                                       style="cursor: pointer;" 
                                       title="Delete"></i>
                                </div>
                            `;

                            dataTable.row.add([
                                student.id,
                                student.firstname,
                                student.lastname,
                                student.email,
                                actions
                            ]);
                        });

                        dataTable.draw();
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

        // Delete button handler
        $(document).on('click', '.delete-btn', function () {
            const studentId = $(this).data('id');

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
            const token = localStorage.getItem('token');

            $.ajax({
                url: `http://amsbackend.test/api/student/${studentId}`,
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                },
                success: function () {
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
                        xhr.responseJSON?.message || 'Something went wrong.',
                        'error'
                    );
                    console.error("Error deleting student:", error);
                    console.error("Server response:", xhr.responseText);
                }
            });
        }

        fetchStudents();
    }
});
