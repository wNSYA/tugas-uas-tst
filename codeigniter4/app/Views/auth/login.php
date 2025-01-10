<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #184e68 0%, #57ca85 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            position: relative;
            overflow: hidden;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent 40%,
                rgba(255, 255, 255, 0.2) 45%,
                transparent 50%
            );
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        h2 {
            color: #184e68;
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
            position: relative;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group input {
            width: 100%;
            padding: 15px;
            border: none;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            outline: none;
            box-shadow: 0 4px 10px rgba(87, 202, 133, 0.3);
        }

        .input-group label {
            position: absolute;
            left: 15px;
            top: -10px;
            background: white;
            padding: 0 5px;
            color: #184e68;
            font-size: 14px;
            border-radius: 4px;
        }

        .error-message {
            background: rgba(255, 107, 107, 0.1);
            border-left: 4px solid #ff6b6b;
            color: #d63031;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #184e68 0%, #57ca85 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(87, 202, 133, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Welcome</h2>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="error-message">
                <?php echo session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form id="loginForm" method="POST" action="/user/login">
            <div class="input-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required 
                    autocomplete="email"
                />
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                />
            </div>
            
            <button type="submit">Sign In</button>
        </form>
    </div>
</body>
</html>