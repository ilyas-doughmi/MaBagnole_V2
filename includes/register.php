<?php



if(isset($_POST["register"]))
{
    require_once(__DIR__ . "/../Classes/db.php");
    require_once(__DIR__ . "/../Classes/client.php");


    $pdo = DB::connect();
    $user = new client($pdo);

    $user->__set("fullname",$_POST["full_name"]);
    $user->__set("email",$_POST["email"]);
    $user->__set("password",$_POST["password"]);

    if($user->register()){
        header("location: ../pages/login.php?msg=Register SUCCESS");
        exit();
    }
    else{
        header("location: ../pages/inscription.php?msg=Register Problem");
        exit();
    }

}
else{
    header("location: ../pages/inscription.php?msg=You Don't Have Permission");
    exit();
}


