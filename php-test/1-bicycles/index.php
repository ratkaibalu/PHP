<?php
include_once('data.php');
function contains($station_id, $station_ids){
  for($i = 0; $i < count($station_ids); $i++){
    if($station_ids[$i] == $station_id){
      return true;
    }
  }
  return false;
}

function elso_allomas($dist){
  $year = 0;
  global $locations;
  global $stations;
  foreach($locations as $location){
    if($location['district'] == $dist){
      if($stations[$location['station_id']]['year'] > $year){
        $year = $stations[$location['station_id']]['year'];
      }
    }
  }

  return $year;
}

$earliest = 100000;

foreach($stations as $station){
  if($station['year'] < $earliest){
    $earliest = $station['year'];
  }
}

?>
<!DOCTYPE html>
<html lang="en">
  
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rentable Bicycles</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/elte-fi/www-assets@19.10.16/styles/mdss.min.css">
</head>

<body>
  <h1>Rentable Bicycles</h1>
  <table>
    <thead>
      <th>District</th>
      <th>Stations</th>
      <th>Opened</th>
      <th>🏆</th>
      <th>Avg docks</th>
    </thead>
    <tbody>
      <?php for($i = 1; $i < 15; $i++) : ?>
        <tr>
          <td>Budapest <?= $i ?></td>
          <?php
            $station_ids = [];
            foreach($locations as $location){
              if($location['district'] == $i){
                if(!contains($location['station_id'], $station_ids)){
                  $station_ids[] = $location['station_id'];
                }
              }
            }
            if(count($station_ids) > 0){
              echo '<td>' . count($station_ids) . '</td>';
            }
          ?>
          <td><?= elso_allomas($i) ?></td>
          <td>
          <?php 
          if(elso_allomas($i) == $earliest){
            echo "🏆";
          }
          ?>
          </td>
          <td>
            <?php
              $all = 0;
              $count = 0;
              foreach($locations as $location){
                if($location['district'] == $i){
                  $all += $stations[$location['station_id']]['docks'];
                  $count++;
                }
              }
              echo round($all / $count, 2);
            ?>
          </td>
        </tr>
      <?php endfor ?>
    </tbody>
  </table>
</body>
</html>