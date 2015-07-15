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

require_once('head.php');
require_once('auth.php');
require_once('database.php');

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

echo "<table class='table table-striped'><thead><tr><th>ID</th><th>GUID</th>" .
       "<th>Attr.</th><th>URI</th><th>License</th></tr></thead>";

echo "<tbody>";

foreach($rows as $row) {
    $itemguid = $guid . "-" . $row['guid'];
    echo "<tr>";
    echo "<td>" . $row['id'] ."</td>";
    echo "<td>" . "<a href='lookup.php?guid=$itemguid'>" . $row['guid'] .
        "</a></td>";
    echo "<td>" . $row['attr'] ."</td>";
    echo "<td>" . "<a href='" . $row['uri'] . "' target=_blank>" .
        $row['uri'] . "</td>";
    echo "<td>" . "<a href='" . $row['license'] . "' target=_blank>" .
        $row['license'] . "</td>";
    echo "</tr>";
}

echo "</tbody></table>";

require_once('base.php');
