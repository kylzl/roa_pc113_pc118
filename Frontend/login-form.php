<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | AMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            /* background-color: #09033B; */
            background-image: url('images/background-image.jpg');
            background-size: cover;
            background-position: center;    
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .backdrop {
            background-color: rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center overlay">

    <div class="backdrop-blur-sm bg-black/10 p-10 rounded-3xl shadow-2xl flex flex-col md:flex-row max-w-4xl w-full">
        
        <div class="md:w-1/2 text-black px-6 py-8">
            <h2 class="text-4xl font-extrabold mb-4 text-center">Welcome Back!</h2>
            <p class="text-center text-black-300 mb-8">Attendance Monitoring System</p>

            <form id="loginForm" class="space-y-5">
                <div>
                    <label class="block mb-1" for="email">Email</label>
                    <input id="email" type="email" class="w-full px-4 py-3 border border-black-300 text-black rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter your email" required>
                </div>

                <div>
                    <label class="block text-black-300 mb-1" for="password">Password</label>
                    <input id="password" type="password" class="w-full px-4 py-3 border border-black-300 text-black rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="••••••••" required>
                </div>

                <button type="submit" class="w-full py-3 bg-blue-900 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300 " style="background-color: #09033B;">
                    Log In
                </button>
            </form>

            <p id="errorMessage" class="text-red-400 mt-4 text-center hidden"></p>
        </div>

        <div class="md:w-1/2 flex items-center justify-center p-6" >
            <img src="images/ams-logo.png" alt="AMS Logo" class="w-3/4 md:w-2/3 rounded-xl shadow-lg" style="background-color: #09033B">
        </div>
    </div>

    <script>
        if (localStorage.getItem('token')) {
            window.location.href = 'admin/dashboard.php';
        }

        document.getElementById('loginForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const errorMessage = document.getElementById('errorMessage');

            if (!email || !password) {
                errorMessage.textContent = "Both email and password are required.";
                errorMessage.classList.remove('hidden');
                return;
            }

            errorMessage.classList.add('hidden');

            try {
                const response = await fetch('http://127.0.0.1:8000/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || "Login failed. Please try again.");
                }

                localStorage.setItem('token', data.token);
                window.location.href = 'admin/dashboard.php';
            } catch (error) {
                errorMessage.textContent = error.message || "An unexpected error occurred.";
                errorMessage.classList.remove('hidden');
            }
        });
    </script>

</body>
</html>
