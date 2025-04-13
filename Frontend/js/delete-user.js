delete-user.js$(document).on('click', '.delete-btn', function () {
    let userId = $(this).data('id');     
    console.log('User ID for delete:', userId);

    if (!userId) {
        alert('User ID is missing or undefined');
        return;
    }

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
