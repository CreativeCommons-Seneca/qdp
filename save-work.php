<?php

require_once('auth.php');

function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}


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

    if ($_POST['uid'] == $userid) {

      $license = $_POST['license'];

      if ($license == "cavalier") {
	$license = $_POST['licenseuri'];
      }

      $workuri = $_POST['workuri'];

      $workguid = GUID();

      $attr = phpCAS::getAttributes();
      $nickname = $attr['nickname'];

      $stmt = $db->prepare("INSERT INTO Items(userid,attr,guid,uri,license) VALUES(:userid,:attr,:guid,:uri,:license)");
      $stmt->execute(array(':userid' => $userid, ':attr' => $nickname, ':guid' => $workguid, ':uri' => $workuri, ':license' => $license));
      $affected_rows = $stmt->rowCount();

    }


      
 }

?>

<h1>All saved</h1>

<p><a href="works.php">See your licensed works</a></p>
