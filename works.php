<?php

require_once('head.php');
require_once('auth.php');

if ($auth) {

  $casuid = phpCAS::getUser();

    $db = new PDO('mysql:host=localhost;dbname=qdp;charset=utf8', 'root', 'root');

    $stmt = $db->prepare("SELECT * FROM Users WHERE email=? LIMIT 1");
    $stmt->execute(array($casuid));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
    foreach($rows as $row) {
      $guid = $row['guid'];
      $userid = $row['id'];
    }

    $stmt = $db->prepare("SELECT * FROM Items WHERE userid=?");
    $stmt->execute(array($userid));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table class='table table-striped'><thead><tr><th>ID</th><th>GUID</th><th>Attr.</th><th>URI</th><th>License</th></tr></thead>";

    echo "<tbody>";
    
    foreach($rows as $row) {

      $itemguid = $guid . "-" . $row['guid'];

      
      echo "<tr>";
      echo "<td>" . $row['id'] ."</td>";
      echo "<td>" . "<a href='lookup.php?guid=$itemguid'>" . $row['guid'] ."</a></td>";
      echo "<td>" . $row['attr'] ."</td>";
      echo "<td>" . "<a href='" . $row['uri'] . "' target=_blank>" . $row['uri'] . "</td>";
      echo "<td>" . "<a href='" . $row['license'] . "' target=_blank>" . $row['license'] . "</td>";
      echo "</tr>";
    }

    echo "</tbody></table>";

 }

require_once('base.php');

?>


