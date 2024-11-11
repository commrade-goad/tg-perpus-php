<?php
session_start();
function check_session($cRedirect, $fRedirect) {
    if (isset($_SESSION["id"]) || isset($_SESSION["role"])) {
        if ($cRedirect == null || $cRedirect == "") {
            return;
        }
        header("Location: " . $cRedirect);
        return;
    }
    if ($fRedirect == null || $fRedirect == "") {
        return;
    }
    header("Location: " . $fRedirect);
    return;
}
