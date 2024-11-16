<?php
include "session.php";
session_start();
check_session(null, "/example/login.php");
if ($_SESSION["role"] == 0) {
    header("Location: /example");
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
            <button id="srcbtn" onclick="searchBookad()">Search</button>
            <div id="sbook" style="display: flex; flex-direction:row;"></div>
            <h2> all books (edit book + tag doesnt work)</h2>
            <button onclick="addbook()">add</button>
            <div id="allbooks"></div>
            <p> page <button id="page" onclick="nextBooks()">1</button><button onclick="prevBooks()">prev</button></p>
            <br>
            <div id="addeditdiv"></div>
            <h2> all user </h2>
            <div id="userlist"></div>
            <div id="userform"></div>
        </div>
        <script src="/example/dashboard.js">
        </script>
        <!-- <script src="/example/search.js"> -->
        <!-- </script> -->
        <script src="/example/admin.js">
        </script>
    </body>
</html>
