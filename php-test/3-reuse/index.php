<?php 
  $ads = json_decode(file_get_contents("./ads.json"), true);

  $tempAd = [];
  if(isset($_POST['submit'])){
    $id = uniqid();
    $tempAd['title'] = $_POST['title'];
    $tempAd['description'] = $_POST['description'];
    $tempAd['email'] = $_POST['email'];
    $tempAd['url'] = $_POST['url'];
    $tempAd['created_at'] = date("Y.m.d G:i:s");
    $tempAd['status'] = "active";
    $tempAd['id'] = $id;

    $ads[$id] = $tempAd;
    
    file_put_contents("./ads.json", json_encode($ads));
    header('location: ./index.php');
    exit();
  }

  function filtered($id){
    global $ads;
    if(isset($_GET['filter-text'])){
      $ads[$id]['title'];
      return str_contains($ads[$id]['title'], $_GET['filter-text']) || str_contains($ads[$id]['description'], $_GET['filter-text']);
    }
    return true;
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reuse advertisments</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <h1>Reuse advertisments</h1>
  <form action="?" method="post">
    <fieldset>
      <legend><strong>NEW AD</strong></legend>
      Title: <br>
      <input type="text" name="title" required> <br>
      Description: <br>
      <textarea name="description"cols="30" rows="3" required></textarea> <br>
      Contact email: <br>
      <input type="email" name="email" required> <br>
      Image URL: <br>
      <input type="url" name="url"> <br>
      <button type="submit" name="submit">Add</button>
    </fieldset>
  </form>
  <h2>Active ads</h2>
  <form action="" method="get">
    <fieldset>
      <legend>Filter</legend>
      Filter text: <br>
      <input type="text" name="filter-text"> <br>
      <button type="submit">Search</button>
    </fieldset>
  </form>
  <div id="ads">
    <?php foreach ($ads as $ad): ?>
      <?php if($ad['status'] == "active" && filtered($ad['id'])):?>
        <div class="item">
          <img src="https://www.prospectpizzabk.com/wp-content/uploads/2020/11/Placeholder-1.png">
          <div>
            <h3><a href="./details.php?id=<?= $ad['id'] ?>"><?= $ad['title'] ?></a></h3>
            <p><?= $ad['description'] ?></p>
            <p><small><?= $ad['created_at'] ?></small></p>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
</body>
</html>