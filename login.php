<?php

require_once('auth.php');
require_once('head.php');


phpCAS::forceAuthentication();

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

    $db = new PDO('mysql:host=localhost;dbname=qdp;charset=utf8', 'root', 'root');

    $stmt = $db->prepare("INSERT INTO Users(email,guid) VALUES(:email,:guid)");
    $stmt->execute(array(':email' => $casuid, ':guid' => $guid));
    $affected_rows = $stmt->rowCount();
    
?>

<h1>Welcome <?php echo $nickname;?></h1>

<p>We have your email address as: <?php echo $casuid; ?> &mdash; if this is wrong, please contact Creative Commons.</p>

<p><a class="btn btn-success" href="chooser.php"><span class="glyphicon glyphicon-plus"></span> Get a CC license for your work</a></p>

<p><a class="btn btn-primary" href="works.php"><span class="glyphicon glyphicon-list"></span> See your previously licensed works</a></li>

<?php

} else {

echo "We couldn't authenticate your CCID. Please try again or contact Creative Commons for support.";

}

?>
