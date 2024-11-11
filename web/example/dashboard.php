<?php
include "session.php";
session_start();
check_session(null, "/example/login.php");
if ($_SESSION["role"] == 1) {
    header("Location: /example/admin.php");
}
?>
<html>
    <head>
        <title>Dashboard</title>
    </head>
    <body>
        <h1>..: Dashboard :..</h1>
        <button onclick="logout()">Logout</button>
        <div id="inside">
            <h2> Book from tag </h2>
            <div id="ptag" style="display: flex; flex-direction:row;"></div>
            <h2> search </h2>
            <input id="srcbox" type="text" placeholder="search title, author, year, tag" style="width: 250px">
            <button id="srcbtn" onclick="searchBook()">Search</button>
            <div id="sbook" style="display: flex; flex-direction:row;"></div>
        </div>
        <script src="/example/dashboard.js">
        </script>
        <script src="/example/search.js">
        </script>
    </body>
</html>
