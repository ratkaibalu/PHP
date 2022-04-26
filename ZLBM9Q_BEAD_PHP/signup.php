<?php
    $hibak = [];
    $ujson = file_get_contents("users.json");
    $users = json_decode($ujson,true);
    $number = count((array)$users);
    
function ellenoriz(array &$hibak, &$users) : bool{
    
    if(!isset($_POST["username"]) || trim($_POST["username"]) === ""){
        $hibak[] = "Hihányzik a felhasználónév!";
    }else{
        foreach ($users as $key => $user) {
            if($_POST["username"] === $user["username"]){
                $hibak[] = "Ez a felhasználónév már létezik!";
            }
        }
    }
    if (!isset($_POST["email"]) || trim($_POST["email"]) === "") {
        $hibak[] = "Hiányzik az e-mail cím!";
    }else{
        if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false){
            $hibak[] = "Rossz e-mail cím forma!";
        }
        foreach ($users as $key => $user) {
            if($_POST["email"] === $user["email"]){
                $hibak[] = "Ezzel az e-mailel már regisztráltak!";
            }          
        }

    }
    if(!isset($_POST["password"]) || trim($_POST["password"]) === ""){
        $hibak[] = "Hiányzik a jelszó!";
    }
    if(!isset($_POST["password2"]) || trim($_POST["password2"]) === ""){
        $hibak[] = "Hiányzik a jelszó megerősítése!";
    }
    if($_POST["password"] !== $_POST["password2"]){
        $hibak[] = "A jelszavaknak meg kell egyezniük!";
    }

    if(count($hibak) > 0){
        return false;
    }else{
        return true;       
    }

}

if(count($_POST) > 0){
    if(ellenoriz($hibak, $users)){
        global $users;
        $users["userid" . $number]["username"] = $_POST["username"];
        $users["userid" . $number]["email"] = $_POST["email"];
        $users["userid" . $number]["password"] = $_POST["password"];

    file_put_contents("users.json",json_encode($users));
    header("location:login.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <title>Regisztráció</title>
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
                <input type="text" name="username" value="<?= $_POST["username"] ?? '' ?>">
                <h3>E-mail cím</h3>
                <input type="text" name="email" value="<?=$_POST["email"] ?? ''?>">
                <h3>Jelszó</h3>
                <input type="password" name="password" value="<?=$_POST["password"] ?? ''?>">
                <h3>Jelszó megerősítése</h3>
                <input type="password" name="password2" value="<?=$_POST["password2"] ?? ''?>">
                <br>
                <input type="submit" value="Regisztrálás!">
            </form>
        </table>
    </div>

</body>
</html>