$(document).ready(function () {

    $('#createUserForm').on('submit', function (e) {
        e.preventDefault();

        let token = localStorage.getItem('token');
        let formData = new FormData();
        formData.append('name', $('#createUserName').val());
        formData.append('email', $('#createUserEmail').val());
        formData.append('password', $('#createUserPassword').val());
        formData.append('role', $('#createUserRole').val());
        formData.append('image', $('#createUserImage')[0].files[0]); 
                
        $.ajax({
            url: 'http://127.0.0.1:8000/api/users',
            method: 'POST',
            processData: false,
            contentType: false,
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            data: formData,
            success: function (response) {
                $('#createUserModal').modal('hide');
                setTimeout(function () {
                    window.location.reload();
                }, 5000);
                Swal.fire({
                    title: "User created!",
                    icon: "success",
                    confirmButtonText: "OK",
                });
            },
            error: function (xhr) {
                const message = xhr.responseJSON?.message || "Something went wrong.";
                Swal.fire({
                    title: "Error!",
                    text: message,
                    icon: "error"
                });
            }
        });
    });

});