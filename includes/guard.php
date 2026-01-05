<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_login()
{
    if (!isset($_SESSION["id"])) {
        header("location: /MaBagnole/pages/login.php");
        exit();
    }
}

function require_role($role_needed)
{
    if (!isset($_SESSION["role"]) || $_SESSION["role"] != $role_needed) {
        header("location: /MaBagnole/index.php?message=no_access");
        exit();
    }
}
