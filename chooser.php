<?php

require_once('auth.php');
require_once('head.php');

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
      
 }

?>

<h1>Okay, let's get you a license</h1>

<p>We know your name, so let's just cut to the chase.</p>

<form action="save-work.php" method="post">
  <div class="well">
    <div class="form-group">
      <select name="license" required>

	<option value="">Choose a license</option>
	
	<optgroup label="Free culture licenses">
	  <option value="https://creativecommons.org/licenses/by/4.0/">CC-BY 4.0 (good for educational works)</option>
	  <option value="https://creativecommons.org/licenses/by-sa/4.0/">CC-BY-SA 4.0 (perfect for Wikipedia!)</option>
	</optgroup>

	<optgroup label="Other CC licenses">
	  
	  <option value="https://creativecommons.org/licenses/by-nd/4.0/">CC-BY-ND 4.0 (no changes here)</option>
	  <option value="https://creativecommons.org/licenses/by-nc/4.0/">CC-BY-NC 4.0 (non-commercial)</option>
	  <option value="https://creativecommons.org/licenses/by-nc-sa/4.0/">CC-BY-NC-SA 4.0 (NC share-alike)</option>
	  <option value="https://creativecommons.org/licenses/by-nc-nd/4.0/">CC-BY-NC-ND 4.0 (Look but don't touch)</option>
	</optgroup>

	<optgroup label="Other licenses">
	  <option value="cavalier">I'm cavalier, I will enter a license URI manually</option>
	</optgroup>								      
	
      </select>
      <p class="form-help">Yes, we'd need to make this more interactive.</p>
    </div>

    <div class="form-group">

      <label>License URI: <input name="licenseuri" maxlength="120" size="40" type="url"></label>

      <p class="form-help">Note this field won't be saved unless you choose the cavalier option above.</p>
      
    </div>

  </div>

  <div class="form-group">

    <label>Work URI: <input type="url" required name="workuri" maxlength="2000" size="40" /></label>
    <p class="form-help">We'd probably offer some kind of upload to Internet Archive process here.</p>

  </div>

  <div class="form-controls">

    <input type="submit" class="btn btn-success btn-lg" value="Get your license" />
    
  </div>

  <input type="hidden" name="uid" value="<?php echo $userid; ?>" />
  <input type="hidden" name="guid" value="<?php echo $guid; ?>" />

</form>

<?php require_once('base.php'); ?>
