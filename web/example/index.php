<?php

include "session.php";

session_start();
check_session("/example/dashboard.php", "/example/login.php");
