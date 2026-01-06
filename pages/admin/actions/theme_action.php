<?php
require_once "../../../Classes/db.php";
require_once "../../../Classes/Theme.php";

$pdo = DB::connect();

$theme = new Theme($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_theme"])) {
        $theme->__set("name", $_POST["title"]);
        $theme->__set("media", $_POST["image"]);
        $theme->__set("description", $_POST["description"]);

        if ($theme->createTheme()) {
            header("location: ../themes.php?msg=all_good");
            exit();
        } else {
            header("location: ../themes.php?msg=problem");
            exit();
        }
    }

    if (isset($_POST["edit_theme"])) {
        $theme->__set("name", $_POST["title"]);
        $theme->__set("media", $_POST["image"]);
        $theme->__set("description", $_POST["description"]);
        $theme->__set("themeId", $_POST["theme_id"]);

        if ($theme->editTheme()) {
            header("location: ../themes.php?msg=allgood");
            exit();
        } else {
            header("location: ../themes.php?msg=bad");
            exit();
        }
    }

    if (isset($_POST["delete_theme"])) {
        $theme->__set("themeId", $_POST["theme_id"]);
        if ($theme->deleteTheme()) {
            header("location: ../themes.php?msg=allgood");
            exit();
        } else {
            header("location: ../themes.php?msg=bad");
            exit();
        }
    }
}
