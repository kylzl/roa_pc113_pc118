
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- mag need internet if mogamit tailwindcss -->
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="bg-white p-6 rounded-2xl shadow-lg flex max-w-4xl w-full">
        <div class="w-1/2 p-6">
            <h2 class="text-3xl font-semibold mb-6">Login</h2>
            
            <form id="loginForm">
                <div class="mb-4">
                    <label class="block text-gray" for="email">Email</label>
                    <input id="email" type="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Your Email" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray" for="password">Password</label>
                    <input id="password" type="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Your Password" required>
                </div>

                <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">Login</button>
            </form>

            <p id="errorMessage" class="text-red-500 mt-2 hidden"></p> 

        </div>
        <div class="w-1/2 flex items-center justify-center">
            <img src="assets/images/uiia.png" alt="photo" class="w-3/4">
        </div>
    </div>

    <script>
            if (localStorage.getItem('token')) {
            window.location.href = 'dashboard.php';
    }
    </script>

    <script>
    
         document.getElementById('loginForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            let email = document.getElementById('email').value.trim();
            let password = document.getElementById('password').value.trim();
            let errorMessage = document.getElementById('errorMessage');

            if (!email || !password) {
                errorMessage.textContent = "Both fields are required.";
                errorMessage.classList.remove('hidden');
                return;
            }

            errorMessage.classList.add('hidden');

            try {
                let response = await fetch('http://127.0.0.1:8000/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                let data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || "Login failed. Please try again.");
                }

                localStorage.setItem('token', data.token);
                
                window.location.href = 'dashboard.php';
                } catch (error) {
                console.error('Error:', error);
                errorMessage.textContent = error.message || "An unexpected error occurred.";
                errorMessage.classList.remove('hidden');
            }
        });
    </script>


</body>
</html>
