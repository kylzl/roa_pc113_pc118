
document.getElementById('logoutButton').addEventListener('click', async (event) => {

    event.preventDefault();

    const result = await Swal.fire({
        title: "Are you sure?",
        text: "You are about to log out.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, log out!",
        width: "400px" });

    if (result.isConfirmed) {
        try {
            let token = localStorage.getItem('token');
            let res = await fetch('http://amsbackend.test/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            if (res.ok) {
                localStorage.removeItem('token');
                await Swal.fire("Logged out!", "You have been logged out successfully.", "success");
                window.location.href = "../login-form.php";
            } else {
                Swal.fire("Error", "Logout failed. Please try again.", "error");
            }
        } catch (error) {
            console.error("Logout error:", error);
            Swal.fire("Error", "An error occurred. Please try again.", "error");
        }
    }
});

// function logout() {
//     sessionStorage.removeItem('user');
//     window.location.href = 'login-form.php'; 
// }

// logout();
