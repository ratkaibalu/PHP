<?php
$machines = ["Budapest-Nyugati", "Budapest-Keleti", "Budapest-Déli", "Budapest-Kelenföld", "Debrecen", "Szeged", "Miskolc", "Pécs", "Győr", "Nyíregyháza", "Kecskemét", "Székesfehérvár", "Szombathely", "Szolnok", "Cegléd", "Békéscsaba"];

  $hibak = [];

  $journey_from ="";
  $journey_to = "";
  $price = null;
  $distance = null;

  $fromhiba = "";
  $tohiba = "";
  $pricehiba ="";
  $distancehiba ="";
  $paidhiba = "";
  $db = 0;
  if($_GET){
    $valami = false;
      if(!isset($_GET["journey_from"]) || trim($_GET["journey_from"]) === ""){
      $fromhiba = "Kiindulási állomás megadása kötelező!";
      $db+=1;
    }else{

      foreach ($machines as $key => $machine) {
        if($_GET["journey_from"] === $machine){
            $valami = true;
        }
      }
        if(!($valami)){
          $db+=1;
          $fromhiba = "Rossz kiindulási állomás!";
        }
    }
    if($valami){
      $journey_from = $_GET["journey_from"];
    }
    if(!isset($_GET["journey_to"]) || trim($_GET["journey_to"])=== "" ){
      $tohiba = "Érkezési állomás megadása kötelező!";
      $db+=1;
    }else if($_GET["journey_to"]=== $_GET["journey_from"] ){
      $tohiba = "Kiindulási állomás nem egyezhet az érkezési állomással!";
      $db+=1;
    }else{
      $journey_to = $_GET["journey_to"];
    }

    if(!isset($_GET["price"]) || trim($_GET["price"]) === ""){
      $pricehiba ="Jegyár megadása kötelező!";
      $db+=1;
    }else if($_GET["price"] < 0){
      $pricehiba ="A jegyár nem lehet negatív!";
      $db+=1;
    }else if(!filter_var($_GET["price"],FILTER_VALIDATE_INT)){
      $pricehiba ="A jegyár egész szám!";
      $db+=1;
    }else{
      $price = $_GET["price"];
    }
    if(!isset($_GET["distance"]) || trim($_GET["distance"]) === ""){
      $distancehiba ="A megtett távolság megadása kötelező!";
      $db+=1;
    }else if(!(filter_var($_GET["distance"],FILTER_VALIDATE_FLOAT)) || $_GET["distance"] <= 0){
      $distancehiba ="Helytelen távolság!";
      $db+=1;
    }else{
      $distance = $_GET["distance"];
    }
    if(!isset($_GET["paid"])){
      $paidhiba = "Muszáj bejelölni a jelölőmezőt!";
      $db+=1;
      $paid = false;
    }else{
      $paid =  $_GET["paid"];
    }
  }


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
  <title>CO₂ Emission</title>
</head>

<body>
  <h1>CO<sub>2</sub> Emission</h1>

  <form action="index.php" method="get" novalidate>
    <label for="i1">Station of departure:</label> <input type="text" name="journey_from" id="i1" value="<?=$journey_from?>"><span style="color:red"><?=$fromhiba?></span><br>
    <label for="i2">Destination station:</label> <input type="text" name="journey_to" id="i2" value="<?=$journey_to?>"><span style="color:red"><?=$tohiba ?></span> <br>
    <label for="i3">Ticket price (HUF):</label> <input type="text" name="price" id="i3" value="<?=$price?>"><span style="color:red"> <?=$pricehiba ?></span><br>
    <label for="i4">Distance (km):</label> <input type="text" name="distance" id="i4" value="<?=$distance?>"><span style="color:red"> <?=$distancehiba ?></span><br>
    <input type="checkbox" name="paid" id="i5" <?=$paid ? "checked" : "" ?>><label for="i5">Ticket paid</label><span style="color:red"><?=$paidhiba ?></span> <br>
    <button type="submit">Submit</button>
  </form>
<?php if ( $db === 0) : ?>
  <div class="big">Your CO<sub>2</sub> reduction is <span style="color: green"><?=$distance * 0.13 ?></span> kg!</div>    
<?php endif ?>

  
  <h2>Test cases</h2>
  <a href="index.php?journey_from=&journey_to=&price=&distance=">index.php?journey_from=&journey_to=&price=&distance=</a><br>
  <a href="index.php?journey_from=Budafok&journey_to=&price=&distance=">index.php?journey_from=Budafok&journey_to=&price=&distance=</a><br>
  <a href="index.php?journey_from=Debrecen&journey_to=&price=&distance=">index.php?journey_from=Debrecen&journey_to=&price=&distance=</a><br>
  <a href="index.php?journey_from=Debrecen&journey_to=Eger&price=&distance=">index.php?journey_from=Debrecen&journey_to=Eger&price=&distance=</a><br>
  <a href="index.php?journey_from=Debrecen&journey_to=Eger&price=-3000&distance=">index.php?journey_from=Debrecen&journey_to=Eger&price=-200&distance=</a><br>
  <a href="index.php?journey_from=Debrecen&journey_to=Eger&price=3289.99&distance=">index.php?journey_from=Debrecen&journey_to=Eger&price=3289.99&distance=</a><br>
  <a href="index.php?journey_from=Debrecen&journey_to=Eger&price=3290&distance=">index.php?journey_from=Debrecen&journey_to=Eger&price=3290&distance=</a><br>
  <a href="index.php?journey_from=Debrecen&journey_to=Eger&price=3290&distance=long">index.php?journey_from=Debrecen&journey_to=Eger&price=3290&distance=long</a><br>
  <a href="index.php?journey_from=Debrecen&journey_to=Eger&price=3290&distance=-99.5">index.php?journey_from=Debrecen&journey_to=Eger&price=3290&distance=-99.5</a><br>
  <a href="index.php?journey_from=Debrecen&journey_to=Eger&price=3290&distance=210.8">index.php?journey_from=Debrecen&journey_to=Eger&price=3290&distance=210.8</a><br>
  <a href="index.php?journey_from=Debrecen&journey_to=Eger&price=3290&distance=210.8&paid=on">index.php?journey_from=Debrecen&journey_to=Eger&price=3290&distance=210.8&paid=on</a><br>
</body>

</html>