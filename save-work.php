<?php

/* qdp

   Copyright (C) 2015 Creative Commons

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

require_once('auth.php');
require_once('database.php');
require_once('guid.php');

if (! $casuid) {
    die("User not logged in. How did that happen?");
}

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

    $stmt = $db->prepare("INSERT INTO Items(userid,attr,guid,uri,license) " .
                         "VALUES(:userid,:attr,:guid,:uri,:license)");
    $stmt->execute(array(':userid' => $userid, ':attr' => $nickname,
                         ':guid' => $workguid, ':uri' => $workuri,
                         ':license' => $license));
    $affected_rows = $stmt->rowCount();
}

?>
<h1>All saved</h1>

<p><a href="works.php">See your licensed works</a></p>
