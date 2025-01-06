<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form id="registerForm">
        <label for="username">Username</label>
        <input type="text" id="username" required><br>

        <label for="email">Email</label>
        <input type="email" id="email" required><br>

        <label for="password">Password</label>
        <input type="password" id="password" required><br>

        <button type="submit">Register</button>
    </form>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent default form submission
            
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const data = {
                username: username,
                email: email,
                password: password
            };

            fetch('/user/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    // If response is not OK, throw an error with the status text
                    return response.json().then(error => {
                        throw new Error(error.error || 'Something went wrong');
                    });
                }
                return response.json(); // Parse JSON if response is OK
            })
            .then(result => {
                alert(result.message); // Show success message
                window.location.href = "/user/login"; // Redirect to login page
            })
            .catch(error => {
                // Catch and display any errors
                alert(error.message);
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
