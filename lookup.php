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

require_once('database.php');

header('Content-Type: application/json');

// we get a combination of two GUIDs (a user and an item each have one)

$guid = $_GET['guid'];
$uguid = substr($guid, 0,36);
$iguid = substr($guid,37);

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
