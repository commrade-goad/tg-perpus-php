<?php

// get ENV
$env =getenv();

// PATH TO DB
$db_path = "/home/fernando/git/tg-perpus-php/private/db.sqlite";
$simp_key = "U0FZQSBBRE1JTgo=";

// check env
if (isset($env["DB_PATH"])) {
    $db_path = $env["DB_PATH"];
}

if (isset($env["ROOT_PASSWORD"])) {
    $simp_key = $env["ROOT_PASSWORD"];
}
