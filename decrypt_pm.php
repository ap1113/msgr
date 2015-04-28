<?php
include('config.php');
include('decrypt.php');
//msgr file.
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Read Message</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Messenger" /></a>
	    </div>
<?php
if(isset($_SESSION['username']))
{
if(isset($_GET['id']))
{
$id = intval($_GET['id']);
//Grab message from db
$req1 = mysql_query('select message, user1, user2 from pm where id="'.$id.'" and id2="1"');
$dn1 = mysql_fetch_array($req1);
if(mysql_num_rows($req1)==1)
{
if($dn1['user1']==$_SESSION['userid'] or $dn1['user2']==$_SESSION['userid'])
{//Work inside protected zone here
	if(isset($_POST["key"]) and $_POST["key"]!=''){ //add more protection here?
	$key=mysql_real_escape_string($_POST["key"]);
	$msg = mysql_real_escape_string($dn1['message']);
	$plain = decrypt($key,$msg);
	echo $plain;
	
	?>

	<div class="message">Your message has been decrypted.<br />
	<a href="index.php?id=<?php echo $id; ?>">Home</a></div>

	<h3>Reply</h3>
<div class="center">
    <form action="reply_pm.php?id=<?php echo $id; ?>" method="post">
		Key<label for="key"><span class="small">(24 bytes)</span></label><input type="text" id="key" name="key" /><br />
    	<label for="message" class="center">Message</label><br />
        <textarea cols="40" rows="5" name="message" id="message"></textarea><br />
        <input type="submit" value="Send" />
    </form>
</div>
	
	<?php
	}
	else{
		?>
		<div class="message">Hellz nopez!!.<br />
		<a href="index.php?id=<?php echo $id; ?>">Home</a></div>
		<?php
	}

	
	//Up to here
}
else
{
	echo '<div class="message">You do not have the rights to access this page.</div>';
}
}
else
{
	echo '<div class="message">This discussion does not exist.</div>';
}
}
else
{
	echo '<div class="message">The discussion ID is not defined.</div>';
}
}
else
{
	echo '<div class="message">You must be logged in to access this page.</div>';
}
?>
		<div class="foot"><a href="list_pm.php">My Messages</a> </div>
	</body>
</html>