

if (localStorage.getItem('token')) {
    const notyf = new Notyf(); 
    let token = localStorage.getItem('token');

    fetch('http://amsbackend.test/api/user-info', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (response.status === 401) {
            notyf.error('Session has expired. Please log in again.');
            localStorage.removeItem('token');
            window.location.href = '../login-form.php';
            return;
        }
        return response.json();
    })
    .then(data => {
        console.log('User Info:', data);
        sessionStorage.setItem('user', JSON.stringify(data));

        if (data && data.name && data.email) {
            document.getElementById('auth-user-name').textContent = data.name;
            document.getElementById('auth-user-email').textContent = data.email;

            let userImage = data.image && typeof data.image === 'string' && data.image.trim() !== "" 
                ? (data.image.startsWith('http') ? data.image : `http://amsbackend.test/storage/${data.image}`)
                : '../images/default-image.png';

            document.getElementById('auth-user-image').src = userImage;
        } else {
            console.error('Invalid user data:', data);
            document.getElementById('auth-user-name').textContent = 'Unknown User';
            document.getElementById('auth-user-email').textContent = 'No Email Available';
            notyf.error('Failed to retrieve user information.');
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error);
        notyf.error('Something went wrong. Please try again later.');
    });
} else {
    const notyf = new Notyf(); // Initialize Notyf.js
    notyf.error('You are not logged in!');
    window.location.href = '../login-form.php';
}
