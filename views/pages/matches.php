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
	$html .= "<input id='match' name='match' type=\"radio\" value=\"$match[1]\">$match[1]</input>";
}

echo $html;

?>

<input type="text" style="display: none;" id="messageBox" maxlength="2000" size="50" onkeydown="handleKey(event)"/>
<input type="text" id="userName" style="display: none;" name="chat" value="<?php echo $userName;?>">
<input type="button" name="chat" value="Chat" onclick="loadMessages();">