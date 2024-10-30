<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        * {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f3f4f6;
        }

        .login-page {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            color: #555;
            font-size: 14px;
            text-align: left;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        .login-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .login-button:hover {
            background-color: #0056b3;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-page">
        <h2>Login User</h2>
        <form action="" method="post">
            <label for="username">Username :</label>
            <input type="text" name="username" id="username" placeholder="Masukan NPM Anda">
            
            <label for="password">Password :</label>
            <input type="password" name="password" id="password" placeholder="Masukan Password Anda">
            <label for="showPassword">
                <input type="checkbox" id="showPasswordUser">
                Tampilkan Password
            </label>
        </form>
    </div>


    <script>
        const inputPassword = document.getElementById("password");
        const showPassword = document.getElementById("showPasswordUser");

        showPassword.addEventListener("input", (e) => {
            if (e.target.checked) {
                inputPassword.setAttribute("type", "text");
            } else {
                inputPassword.setAttribute("type", "password");
            }
        })
    </script>
</body>
</html>