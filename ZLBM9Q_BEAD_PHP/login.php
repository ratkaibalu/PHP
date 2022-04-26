<?php
    session_start();
    $hibak = [];
    $ujson = file_get_contents("users.json");
    $users = json_decode($ujson,true);

    function ellenoriz(array &$hibak, &$users) : bool {
        if(!isset($_POST["username"]) || trim($_POST["username"]) === ""){
            $hibak[] = "Hianyzik a felhasználónév!";
        }
        if(!isset($_POST["password"]) || trim($_POST["password"]) === ""){
            $hibak[] = "Hiányzik a jelszó!";
        }
        $jelszo = false;
        $felhasznalo = false;
        foreach ($users as $key => $user) {
            if($_POST["username"] === $user["username"]){
                $felhasznalo = true;
                if($_POST["password"] === $user["password"]){
                    $jelszo = true;
                }
            }
            
        }
        if(!($felhasznalo) && $_POST["username"] !== ""){
            $hibak[] = "Rossz felhasználónév!";
        }
        if(!($jelszo) && $_POST["password"] !== ""){
            $hibak[] = "Rossz jelszó!";
        }
        if($felhasznalo && $jelszo){
            return true;
        }else{
            return false;
        }
    }

if(count($_POST) > 0){
    if(ellenoriz($hibak, $users)){

        $_SESSION["username"] =$_POST["username"] ;
        header("location:index.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Bejelentkezés</title>
</head>
<body>
<div id="top">
        <table id="table1">
            <tr>
                <th id="left">
                    <p>Online futball,foci eredmények</p>
                </th>
            </tr>
        </table>
    </div>
    
    <div id="image">
        <img src="https://clientcdn.fra1.cdn.digitaloceanspaces.com/beac.hu/images/_1200x630_crop_center-center_82_none/elte-beac-logo_2020-08-14-201003.png?mtime=20200814221003&focal=none&tmtime=20200918164908">
    </div>

    <div id="table2div">
        <table id="table2">
            <?php if(count($hibak)>0): ?>
                <h2>Hibák!</h2>
                <ul>
                    <?php foreach ($hibak as $key => $hiba) : ?>
                        <li><?=$hiba?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            <form action="" method="post" novalidate>
                <h3>Felhasználói név</h3>
                <input type="text" name="username" value="<?=$_POST["username"] ?? "" ?>">
                <h3>Jelszó</h3>
                <input type="password" name="password" value="">
                <br>
                <input type="submit" value="Belépés">
            </form>
        </table>
    </div>
</body>
</html>