<?php
    session_start();

$tjson = file_get_contents("teams.json");
$teams = json_decode($tjson,true);

$mjson = file_get_contents("matches.json");
$matches = json_decode($mjson,true);

function cmp($a, $b){
    return strcmp( $b["date"], $a["date"]);
}

usort($matches, "cmp");
$valtozo = 5;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>ELTE STADION</title>
</head>
<body>
    <div id="top">
        <table id="table1">
            <tr>
                <th id="left">
                    <p>Online futball,foci eredmények</p>
                </th>
                <th id="right">
                    <?= isset($_SESSION["username"]) ? $_SESSION["username"] : "" ?>
                    <?php if(!isset($_SESSION["username"])) : ?>
                        <a style="color: rgb(194, 194, 194)" href="signup.php">Regisztráció</a>
                    <?php endif ?>
                    </th>
                <th id="right">
                    <?php if(isset($_SESSION["username"])) : ?>
                        <a style="color: rgb(194, 194, 194)" href="logout.php">Kijelentkezés</a>
                    <?php endif ?>
                    <?php if(!isset($_SESSION["username"])) : ?>
                        <a style="color: rgb(194, 194, 194)" href="login.php">Bejelentkezés</a>
                    <?php endif ?>
                </th>
            </tr>
        </table>


    </div>
    <div id="image">
        <img src="https://clientcdn.fra1.cdn.digitaloceanspaces.com/beac.hu/images/_1200x630_crop_center-center_82_none/elte-beac-logo_2020-08-14-201003.png?mtime=20200814221003&focal=none&tmtime=20200918164908">
    </div>
    <div id="table2div">
        <table id="table2">
            <tr>
                <th>
                    <h2>Csapatok</h2>
                </th>
            </tr>
            <tr>
                <td>
                    <div id="teams">
                        <ul>
                            <?php foreach ($teams as $key => $team) : ?>
                                <li><a href="team.php/?name=<?=$team["name"]?>"><?=$team["name"]?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </td>
                <td>
                    <div id="matches">
                        <?php foreach($matches as $match) : ?>
                            <?php foreach ($teams as $team) : ?>
                                <?php if ($match["home"]["id"] === $team["id"]) : ?>
                                    <?php $home = $team["name"]?>
                                <?php endif ?>
                                
                                <?php if ($match["away"]["id"] === $team["id"]) : ?>
                                    <?php $away = $team["name"] ?>
                                <?php endif ?>
                            <?php endforeach ?>
                            <?php if ($valtozo > 0) : ?>
                                <?php $valtozo -= 1 ?>
                                <p style="text-align:center"><?=$home?> - <?=$away?></p>
                                <p style="text-align:center"><?= $match["home"]["score"]?> - <?= $match["away"]["score"]?> </p>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>