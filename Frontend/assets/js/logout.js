
document.getElementById('logoutButton').addEventListener('click', async (event) => {
    event.preventDefault();
    
    let token = localStorage.getItem('token');

    try {
        let res = await fetch('http://127.0.0.1:8000/api/logout', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        if (res.ok) {
            localStorage.removeItem('token');
            alert("Logged out successfully!");
            window.location.href = "login-form.php";
        } else {
            alert("Logout failed. Please try again.");
        }
    } catch (error) {
        console.error("Logout error:", error);
        alert("An error occurred. Please try again.");
    }
});