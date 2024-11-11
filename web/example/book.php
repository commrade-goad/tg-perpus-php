<?php
include "session.php";
session_start();
check_session(null, "/example/login.php");
?>
<html>
    <head>
        <title>Book</title>
    </head>
    <body>
        <h1>..: Book :..</h1>
        <button onclick="logout()">Logout</button>
        <button onclick="back()">back</button>
        <div id="inside">
            <div id="book"></div>
        </div>
        <script src="/example/book.js">
        </script>
    </body>
</html>
