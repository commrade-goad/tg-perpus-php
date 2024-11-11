<?php
include "session.php";
session_start();
check_session("/example/dashboard.php", null);
?>
<html>
    <head>
        <title>Dashboard</title>
    </head>
    <body>
        <h1>..: LOGIN :..</h1>
        <input placeholder="id" type="text" id="id">
        <br>
        <input placeholder="password" type="password" id="password">
        <!-- U0FZQSBBRE1JTgo= -->
        <br>
        <button onclick="login()">Login</button>
        <script>
        function login() {
            const id = document.getElementById("id").value;
            const password = document.getElementById("password").value;
            fetch(`/api/auth_user?id=${encodeURIComponent(id)}&password=${encodeURIComponent(password)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success == 0) {
                        alert("Failed to login!");
                    }
                    window.location.href = "/example";
                })
                .catch(error => console.error('Error fetching data:', error));
        }
        </script>
    </body>
</html>
