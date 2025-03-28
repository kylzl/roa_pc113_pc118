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
