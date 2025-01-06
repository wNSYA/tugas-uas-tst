<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <!-- Display error message if login fails -->
    <?php if (session()->getFlashdata('error')) : ?>
        <p style="color: red;"><?php echo session()->getFlashdata('error'); ?></p>
    <?php endif; ?>

    <!-- Login form -->
    <form id="loginForm">
        <input type="email" id="email" placeholder="Email" required />
        <input type="password" id="password" placeholder="Password" required />
        <button type="submit">Login</button>
    </form>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Prepare the data to send as JSON
            const data = { email, password };

            // Send the login request using fetch
            fetch('/user/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    // If login is successful, redirect to dashboard
                    window.location.href = '/dashboard';
                } else if (data.error) {
                    // If there is an error, display the error message
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
