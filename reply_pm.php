<?php
include('config.php');
include('encrypt.php');
include ('decrypt.php');
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
				if(isset($_POST["key"]) and isset($_POST["message"]) and $_POST["key"]!='' and $_POST["message"]!=''){ //add more protection here?
					$key=mysql_real_escape_string($_POST["key"]);
					$newmsg = mysql_real_escape_string($_POST["message"]);
					$header = '--- NEW MESSAGE---';
					$tailer = '--- PREVIOUSLY ETC ETC --- ';
					//echo $totmsg;
					$prevmsg =  decrypt($key,$dn1['message']) ;
					$totmsg= $header.$newmsg.$tailer.$prevmsg;
					//echo $key;
					$encnew = encrypt($key,$totmsg);
					echo $totmsg."\r\n";
					//echo $encnew;
					$resultup = mysql_query('update pm set message= "'.$encnew.'" where id="'.$id.'" ');
					if ($resultup)
						{
						//$form = false;
?>
<div class="message">You have successfully replied to message!<br />
<a href="index.php">Home</a></div>
<?php
					}
					else
					{
						//$form = true;
						$message = 'An error occurred while replying.';
					}
				}
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