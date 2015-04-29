<?php
include('config.php')
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Messenger</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Messenger" /></a>
	    </div>
        <div class="content">

Hi<?php if(isset($_SESSION['username'])){echo ' '.htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8');} ?>!<br />
Welcome to Messenger.<br />
<?php
//Logged in?
if(isset($_SESSION['username']))
{
$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));

$nb_new_pm = $nb_new_pm['nb_new_pm'];

?>
<a href="edit_infos.php">Edit my profile</a><br />
<a href="list_pm.php">My messages (<?php echo $nb_new_pm; ?> unread)</a><br />
<a href="connection.php">Logout</a>
<?php
}
else
{
?>
<a href="sign_up.php">Sign up</a><br />
<a href="connection.php">Log in</a>
<?php
}
?>
		</div>
		<div class="foot"><a href="<?php echo $url_home; ?>">HOME</a></div>
	</body>
</html>