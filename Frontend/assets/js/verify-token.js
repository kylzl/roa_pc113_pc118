if (localStorage.getItem('token')) {
    let token = localStorage.getItem('token');

    fetch('http://127.0.0.1:8000/api/user-info', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('User Info:', data);

        sessionStorage.setItem('user', JSON.stringify(data));
        document.getElementById('auth-user-name').textContent = data.name ;
        document.getElementById('user-role').textContent = data.role;
        document.getElementById('user-email').textContent = data.email;
    })
    .catch(error => console.error('Fetch Error:', error));
} else {
    alert('You are not logged in!');
    window.location.href = 'login-form.php';
}
