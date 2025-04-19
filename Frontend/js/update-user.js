// Preview selected image in the modal
const previewImage = e =>
    $('#update-profile-img-preview').attr('src', URL.createObjectURL(e.target.files[0]));

$(document).on('click', '.update-btn', function () {
    let userId = $(this).data('id');
    let userName = $(this).data('name');
    let userEmail = $(this).data('email');
    let userRole = $(this).data('role');
    let userImage = $(this).data('image');

    $('#updateUserId').val(userId);
    $('#updateUserName').val(userName);
    $('#updateUserEmail').val(userEmail);
    $('#updateUserRole').val(userRole);

    // ✅ Use full URL directly
    let imagePath = userImage
        ? userImage
        : '../images/default-image.png';

    $('#update-profile-img-preview').attr('src', imagePath);

    $('#updateUserModal').modal('show');
});


$('#updateUserForm').on('submit', function (e) {
    e.preventDefault();

    let token = localStorage.getItem('token');
    let userId = $('#updateUserId').val();

    let formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('name', $('#updateUserName').val());
    formData.append('email', $('#updateUserEmail').val());
    formData.append('role', $('#updateUserRole').val());

    let imageFile = $('input[name="profile_image"]')[0].files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }

    $.ajax({
        url: `http://amsbackend.test/api/update-user/${userId}`,
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            alert('User updated successfully!');
            $('#updateUserModal').modal('hide');
            fetchUsers(); // Refresh user list
        },
        error: function (xhr, status, error) {
            console.error('Error updating user:', error);
            if (xhr.status === 404) {
                alert('User not found or invalid ID.');
            } else if (xhr.status === 400) {
                alert('Invalid data provided.');
            } else {
                alert(xhr.responseJSON?.message || 'Something went wrong.');
            }
        }
    });
});

$('#updateUserModal').on('hidden.bs.modal', function () {
    $('#update-profile-img-preview').attr('src', '../images/default-image.png');
    $('input[name="profile_image"]').val('');
});
