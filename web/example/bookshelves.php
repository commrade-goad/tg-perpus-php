<?php
include "session.php";
session_start();
check_session(null, "/example/login.php");
?>
<html>
    <head>
        <title>Bookshelves</title>
    </head>
    <body>
        <h1>..: Bookshelves :..</h1>
        <button onclick="logout()">Logout</button>
        <button onclick="back()">back</button>
        <div id="inside">
            <h2 id="change-me"> Book from tag </h2>
            <div id="ptag" style="display: flex; flex-direction:row;"></div>
        </div>
        <script src="/example/bookshelves.js">
        </script>
    </body>
</html>
