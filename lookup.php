<?php

  header('Content-Type: application/json');

  // we get a combination of two GUIDs (a user and an item each have one)

$guid = $_GET['guid'];
$uguid = substr($guid, 0,36);
$iguid = substr($guid,37);

$db = new PDO('mysql:host=localhost;dbname=qdp;charset=utf8', 'root', 'root');

$stmt = $db->prepare("SELECT * FROM Users WHERE guid=? LIMIT 1");
$stmt->execute(array($uguid));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rows as $row) {
  $userid = $row['id'];
}

$stmt = $db->prepare("SELECT * FROM Items WHERE guid=? LIMIT 1");
$stmt->execute(array($iguid));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($rows as $row) {
  $itemuserid = $row['userid'];
}


if ($userid == $itemuserid) {

  echo json_encode($row);

 }


?>
