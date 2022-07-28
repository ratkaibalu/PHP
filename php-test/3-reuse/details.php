<?php 
  $ads = json_decode(file_get_contents("./ads.json"), true);

  if(isset($_POST['submit'])){
    $ads[$_GET['id']]['status'] = "inactive";
    $ads[$_GET['id']]['email2'] = $_POST['email2'];
    file_put_contents("./ads.json", json_encode($ads));
    header("Location: ./index.php");
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
  <h2>Details page</h2>
  <div class="item">
    <img src="https://www.prospectpizzabk.com/wp-content/uploads/2020/11/Placeholder-1.png">
    <div>
      <h3><?= $ads[$_GET['id']]['title'] ?></h3>
      <p><?= $ads[$_GET['id']]['description'] ?></p>
      <p><a href="mailto:<?= $ads[$_GET['id']]['description']?>"><?= $ads[$_GET['id']]['email']?></a></p>
      <p><small><?= $ads[$_GET['id']]['created_at'] ?></small></p>
    </div>
  </div>
  <form action="" method="post">
    Email: <br>
    <input type="email" name="email2" required> <br>
    <button type="submit" name="submit">I want to reuse it!</button>
  </form>
</body>
</html>