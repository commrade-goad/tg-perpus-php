<?php

$db_path = "";
include "config.php";

function connect_db($db_path) {
    $db = new SQLite3($db_path);

    if (!$db) {
        echo "Connection failed: " . SQLite3::lastErrorMsg();
        return null;
    }
    return $db;
}

function close_db(SQLite3 &$db) {
    $db->close();
}

function check_exist(SQLite3 &$db, string $name) {
    $statement = "SELECT COUNT(*) as count FROM sqlite_master WHERE type='table' AND name='" . $name . "'";
    $results = $db->query($statement);
    if ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        if ($row['count'] >= 1) {
            return true;
        } else {
            return false;
        }
    } else {
        echo "Query failed.";
    }
}

function create_table_book(SQLite3 &$db) {
    $statement = 
        "CREATE TABLE book (
        book_id INTEGER PRIMARY KEY,
        title TEXT,
        author TEXT,
        desc TEXT,
        year TEXT,
        cover TEXT
        )";
    if (!$db->exec($statement)) {
        return false;
    }
    return true;
}

function create_table_book_tags(SQLite3 &$db) {
    $statement = 
        "CREATE TABLE book_tags (
        btag_id TEXT PRIMARY KEY,
        book_id INTEGER,
        tags_id INTEGER,
        FOREIGN KEY (book_id) REFERENCES book(book_id),
        FOREIGN KEY (tags_id) REFERENCES all_tags(tags_id)
        )";
    if (!$db->exec($statement)) {
        return false;
    }
    return true;
}

function create_table_all_tags(SQLite3 &$db) {
    $statement = 
        "CREATE TABLE all_tags (
        tags_id INTEGER PRIMARY KEY,
        name TEXT,
        img TEXT
        )";
    if (!$db->exec($statement)) {
        return false;
    }
    return true;
}

function create_table_user(SQLite3 &$db) {
    $statement = 
        "CREATE TABLE user(
        id INTEGER PRIMARY KEY,
        password TEXT,
        type INTEGER
        )";
    if (!$db->exec($statement)) {
        return false;
    }
    return true;
}

function check_and_create(SQLite3 &$db) {
    if (!check_exist($db, "user")) {
        create_table_user($db);
    }
    if (!check_exist($db, "book")) {
        create_table_book($db);
    }
    if (!check_exist($db, "all_tags")) {
        create_table_all_tags($db);
    }
    if (!check_exist($db, "book_tags")) {
        create_table_book_tags($db);
    }
}

$db = connect_db($db_path);
