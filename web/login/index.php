<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
        const inputPassword = documen.getElementById("password");
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