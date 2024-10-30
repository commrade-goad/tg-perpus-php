<?php

$db = new SQLite3('./db.sqlite');

if (!$db) {
    echo "Connection failed: " . SQLite3::lastErrorMsg();
} else {
    echo "Connected to the SQLite database successfully.";
}

$db->close();
