$(document).ready(function () {

    $('#createUserForm').on('submit', function (e) {
        e.preventDefault();

        let token = localStorage.getItem('token');
        let newUser = {
            name: $('#createUserName').val(),
            email: $('#createUserEmail').val(),
            password: $('#createUserPassword').val(),
            role: $('#createUserRole').val()
        };
        console.log(newUser);

        $.ajax({
            url: 'http://127.0.0.1:8000/api/users',
            method: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            data: JSON.stringify(newUser),
            success: function (response) {
                alert('User created successfully!');
                $('#createUserModal').modal('hide');
                fetchUsers();
            },
            error: function (xhr, status, error) {
                console.error('Error creating user:', error);
                console.error('Server response:', xhr.responseText);
            }
        });
    });

});