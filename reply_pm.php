<?php
include('config.php');
include('encrypt2.php');
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
		$req1 = mysql_query('select message, invec, user1, user2 from pm where id="'.$id.'" and id2="1"');
		$dn1 = mysql_fetch_array($req1);
		if(mysql_num_rows($req1)==1)
		{
			if($dn1['user1']==$_SESSION['userid'] or $dn1['user2']==$_SESSION['userid'])
			{//Work inside protected zone here
				if($_POST["key"]!=null){ //add more protection here?
					$key=$_POST["key"];
					$newmsg = $_POST["message"];
					$header = '--- NEW MESSAGE---';
					$tailer = '--- PREVIOUSLY ETC ETC --- ';
					$totmsg= $header.$newmsg.$tailer;
					//echo $totmsg;
					$iv=$dn1['invec'];
					$prevmsg =  $dn1['message'] ;
					//echo $key;
					$encnew = encrypt2($key,$iv,$totmsg);
					$thread = $encnew;// . $prevmsg;
					echo $thread;
					$resultup = mysql_query('update pm set message= "'.$thread.'" where id="'.$id.'" ');
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