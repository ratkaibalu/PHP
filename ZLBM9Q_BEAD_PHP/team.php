<?php declare(strict_types=1);
    session_start();

    $tjson = file_get_contents("teams.json");
    $teams = json_decode($tjson,true);

    $mjson = file_get_contents("matches.json");
    $matches = json_decode($mjson,true);

    $cjson = file_get_contents("comments.json");
    $comments = json_decode($cjson, true);
    $number = count((array)$comments);

    $ujson = file_get_contents("users.json");
    $users = json_decode($ujson, true);

    $teamName = $_GET["name"];
    foreach ($teams as $key => $team) {
        if($teamName === $team["name"]){
            $teamId = $team["id"];
            $teamCity = $team["city"];
        }
    }

    function find($e , $teams){
        foreach ($teams as $key => $team) {
            if($e === $team["id"]){
                echo $team["name"];
            }
        }
    }
    $hiba ="";
    if(isset($_POST["Megjegyzés"])){
        if(trim($_POST["text"]) === ""){
            $hiba = "Üres szöveg nem küldhető!";
        }else{
            global $comments;
            $comments["commentid" . $number]["author"] = $_SESSION["username"];
            $comments["commentid" . $number]["text"] = $_POST["text"];
            $comments["commentid" . $number]["teamid"] = $teamId;
            file_put_contents("comments.json", json_encode($comments));            
        }

    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="team.css">
    <title><?=$teamName?></title>
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

    <h1><?=$teamName?></h1>
    <?php if(isset($_SESSION["username"])) : ?>
           <?=$_SESSION["username"]?> 
    <?php endif ?>

    <div style="width:20%">
        <?php foreach ($matches as $match) : ?>
            <?php if ($teamId === $match["home"]["id"]) :?>
                <?php if ($match["home"]["score"] > $match["away"]["score"] && $match["home"]["score"] !== "?") : ?>
                    <p style="background:green"><?=$teamName?> - <?php find($match["away"]["id"], $teams)?></p>
                    <p><?=$match["home"]["score"]?> - <?=$match["away"]["score"]?></p>
                <?php endif ?>
                <?php if ($match["home"]["score"] == $match["away"]["score"] && $match["home"]["score"] !== "?") : ?>
                    <p style="background:yellow"><?=$teamName?> - <?php find($match["away"]["id"], $teams)?></p>
                    <p><?=$match["home"]["score"]?> - <?=$match["away"]["score"]?></p>
                <?php endif ?>
                <?php if ($match["home"]["score"] < $match["away"]["score"] && $match["home"]["score"] !== "?") : ?>
                    <p style="background:red"><?=$teamName?> - <?php find($match["away"]["id"], $teams)?></p>
                    <p><?=$match["home"]["score"]?> - <?=$match["away"]["score"]?></p>
                <?php endif ?>
                <?php if($match["home"]["score"] === "?") :?>
                    <p><?=$teamName?> - <?php find($match["away"]["id"], $teams)?></p>
                    <p><?=$match["home"]["score"]?> - <?=$match["away"]["score"]?></p>
                <?php endif ?>

            <?php endif ?>
            <?php if ($teamId === $match["away"]["id"]) : ?>
                <?php if ($match["away"]["score"] > $match["home"]["score"] && $match["home"]["score"] !== "?") : ?>
                    <p style="background:green"><?php find($match["home"]["id"], $teams)?> - <?=$teamName?></p>
                    <p><?=$match["home"]["score"]?> - <?=$match["away"]["score"]?></p>
                <?php endif ?>
                <?php if ($match["away"]["score"] == $match["home"]["score"] && $match["home"]["score"] !== "?") : ?>
                    <p style="background:yellow"><?php find($match["home"]["id"], $teams)?> - <?=$teamName?></p>
                    <p><?=$match["home"]["score"]?> - <?=$match["away"]["score"]?></p>
                <?php endif ?>
                <?php if ($match["away"]["score"] < $match["home"]["score"] && $match["home"]["score"] !== "?") : ?>
                    <p style="background:red"><?php find($match["home"]["id"], $teams)?> - <?=$teamName?></p>
                    <p><?=$match["home"]["score"]?> - <?=$match["away"]["score"]?></p>
                <?php endif ?>
                <?php if($match["home"]["score"] === "?") :?>
                    <p><?php find($match["away"]["id"], $teams)?> - <?=$teamName?></p>
                    <p><?=$match["away"]["score"]?> - <?=$match["home"]["score"]?></p>
                <?php endif ?>

            <?php endif ?>
        <?php endforeach?>
    </div>
        <h2>Hozzászólások</h2>
        <?=$hiba?>
        <?php if (isset($_SESSION["username"])) : ?>
            <form action="" novalidate method="post">
            <textarea id="textarea" name="text"></textarea><br>
            <input type="submit" name="Megjegyzés">
        </form> 
        <?php else : ?>
            <form action="" novalidate method="post"> 
            <textarea disabled id="textarea" name="text"></textarea><br>
            <input disabled type="submit" name="Megjegyzés">
        </form>
        <?php endif ?>
       
        <?php foreach ($comments as $key => $comment) : ?>
            <?php if($teamId ==  $comment["teamid"]) : ?>
                <h3><?=$comment["author"]?></h3>
                <p><?=$comment["text"] ?></p>
            <?php endif ?>
        <?php endforeach ?>
</body>
</html>