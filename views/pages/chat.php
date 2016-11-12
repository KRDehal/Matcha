<?PHP

$query = "SELECT users.id, users.username FROM user_matches LEFT JOIN users ON user_matches.matchedId=users.id WHERE user_matches.userId=:userId;";
$db = Db::getConnect()->getInstance();
$query_find = $db->prepare($query);
$query_find->execute(array('userId' => $_SESSION["logged_on_user"]));
$matches = $query_find->fetchAll();

$userName = $_SESSION["userName"];
$html = "";

foreach ($matches as $match)
{
	$html .= "<input id='match' name='match' type=\"radio\" value=\"$match[1]\" onclick=\"loadMessages();\">$match[1]</input>";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<HEAD>
	<TITLE>Matcha</TITLE>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="css/chat.css">
	<SCRIPT type="text/javascript" src="js/chat.js"></SCRIPT>
</HEAD>
<BODY onload="init();">
<HEADER>
	<?PHP
		if (!isset($_SESSION["logged_on_user"]) || $_SESSION["logged_on_user"] == "")
		{
			$_SESSION["logged_on_user"] = "";
	?>		
			<a href="index.php?controller=signup&action=show">Sign Up</a>
			<a href="index.php?controller=validate&action=login">Sign In</a>
	<?PHP
		}
		else
		{
	?>
			<a href="index.php?controller=pages&action=home">Home</a>
			<a href="index.php?controller=pages&action=chat">Chat</a>
			<a href="index.php?controller=validate&action=logout">Sign Out</a>
	<?PHP
		}
	?>
</HEADER>
<NOSCRIPT>
	Your browser does not support JavaScript!!
</NOSCRIPT>
<?PHP
	echo $html;
?>
<!--<input type="button" name="chat" value="Chat" onclick="sendMessage();">-->
<br/>
<TABLE id="content" align="center">
	<TR>
		<TD>
			<div id="scroll">
			</div>
		</TD>
	</TR>
</TABLE>
<div align="center">

	<input type="text" value="<?PHP echo $userName ?>" id="userName" style="display: none;" />
	<input type="text" id="messageBox" maxlength="2000" size="50" onkeydown="handleKey(event)"/>
	<input type="button" value="Send" onclick="sendMessage();" />
	<input type="button" value="Delete All" onclick="deleteMessages();" />
</div>
</BODY>
</HTML>