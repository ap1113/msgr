<?php
include('config.php');
include('encrypt.php');
//msgr copy!!
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>New Message</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Messenger" /></a>
	    </div>
<?php
//User logged in?
if(isset($_SESSION['username']))
{
$form = true;
$otitle = '';
$orecip = '';
$okey = '';
$omessage = '';
if(isset($_POST['title'], $_POST['recip'],$_POST['message'], $_POST['key']))
{
	$otitle = $_POST['title'];
	$orecip = $_POST['recip'];
	$okey =$_POST['key'];
	$omessage = $_POST['message'];
	if(get_magic_quotes_gpc())
	{
		$otitle = stripslashes($otitle);
		$orecip = stripslashes($orecip);
		$okey = stripslashes($okey);
		$omessage = stripslashes($omessage);
	}
	if($_POST['title']!='' and $_POST['recip']!='' and $_POST['message']!='' and $_POST['key']!='')
	{
		$title = mysql_real_escape_string($otitle);
		$recip = mysql_real_escape_string($orecip);
		$key = mysql_real_escape_string($okey);
		
		$cyphertext = encrypt($key, $omessage);		
		echo($cyphertext);
		
		$message = mysql_real_escape_string(nl2br(htmlentities($cyphertext, ENT_QUOTES, 'UTF-8')));
		$dn1 = mysql_fetch_array(mysql_query('select count(id) as recip, id as recipid, (select count(*) from pm) as npm from users where email="'.$recip.'"'));
		
		if($dn1['recip']==1)
		{
			if($dn1['recipid']!=$_SESSION['userid'])
			{
				$id = $dn1['npm']+1;
				if(mysql_query('insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$id.'", "1", "'.$title.'", "'.$_SESSION['userid'].'", "'.$dn1['recipid'].'", "'.$cyphertext.'", "'.time().'", "yes", "no")'))
				{
?>
<div class="message">The message has been sent!<br />
<a href="list_pm.php">My messages</a></div>
<?php
					$form = false;
				}
				else
				{
					$error = 'An error occurred while sending the message';
				}
			}
			else
			{
				$error = 'You cannot send a message to yourself.';
			}
		}
		else
		{
			if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['recip'])){
				$dn2 = mysql_num_rows(mysql_query('select id from users'));
				$id2 = $dn2+1;
				$username = 'Anon'. $id2;
				$password = '123456';
				$avatar = '';
				mysql_query('insert into users(id, username, password, email, avatar, signup_date) values ('.$id2.', "'.$username.'", "'.$password.'", "'.$recip.'", "'.$avatar.'", "'.time().'")');	
				
				$id = $dn1['npm']+1;
				if(mysql_query('insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$id.'", "1", "'.$title.'", "'.$_SESSION['userid'].'", "'.$id2.'", "'.$message.'", "'.time().'", "yes", "no")'))
				{
?>
<div class="message">The message has been sent!<br />
<a href="list_pm.php">My messages</a></div>
<?php
					$form = false;
				}
				else
				{
					$error = 'An error occurred while sending the message';
				}
			}
			else {$error = 'Not a valid email format.';}
		}
	}
	else
	{
		$error = 'A field is empty. Please fill all of the fields.';
	}
}
elseif(isset($_GET['recip']))
{
	$orecip = $_GET['recip'];
}
if($form)
{
if(isset($error))
{
	echo '<div class="message">'.$error.'</div>';
}

?>
<div class="content">
	<h1>New Message</h1>
    <form action="new_pm.php" method="post">
		Please fill the form with all fields to send a message. <br />
        <label for="title">Title</label><input type="text" value="<?php echo htmlentities($otitle, ENT_QUOTES, 'UTF-8'); ?>" id="title" name="title" /><br />
        <label for="recip">Recipient<span class="small">(Email)</span></label><input type="text" value="<?php echo htmlentities($orecip, ENT_QUOTES, 'UTF-8'); ?>" id="recip" name="recip" /><br />
		<label for="key">Key<span class="small">(24 bytes)</span></label><input type="text" value="<?php echo htmlentities($okey, ENT_QUOTES, 'UTF-8'); ?>" id="key" name="key" /><br />
		<label for="message">Message</label><textarea cols="40" rows="5" id="message" name="message"><?php echo htmlentities($omessage, ENT_QUOTES, 'UTF-8'); ?></textarea><br />
        <input type="submit" value="Send" />
    </form>
</div>
<?php
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