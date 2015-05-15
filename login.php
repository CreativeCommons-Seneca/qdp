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

// We don't include auth.php, as if we're not logged in it redirects *here*
// and this would cause an infinite loop.
require_once('database.php');
require_once('guid.php');
require_once('cas.php');

if (! phpCAS::isAuthenticated()) {
    phpCAS::forceAuthentication();
} else {
    if(! phpCAS::checkAuthentication()){
        die("User not logged in. How did that happen?");
    }
    $casuid = phpCAS::getUser();
    //$smarty->assign('userid',phpCAS::getUser());

    $attr = phpCAS::getAttributes();

    $nickname = $attr['nickname'];

    //$smarty->assign('handle', $nickname);

    //$user = new User($casuid);

    //$userid = $user->id;
    //$makerid = $user->makerid;

    //$smarty->assign('makerid', $makerid);

    //echo $casuid;
    //echo $nickname;

    $guid = GUID();

    $stmt = $db->prepare("INSERT INTO Users(email,guid) VALUES(:email,:guid)");
    $stmt->execute(array(':email' => $casuid, ':guid' => $guid));
    $affected_rows = $stmt->rowCount();

    require_once('head.php');
}
?>
<h1>Welcome <?php echo $nickname;?></h1>

<p>We have your email address as: <?php echo $casuid; ?> &mdash; if this is wrong, please contact Creative Commons.</p>

<p><a class="btn btn-success" href="chooser.php"><span class="glyphicon glyphicon-plus"></span> Get a CC license for your work</a></p>

<p><a class="btn btn-primary" href="works.php"><span class="glyphicon glyphicon-list"></span> See your previously licensed works</a></li>
