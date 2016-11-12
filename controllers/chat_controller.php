<?PHP

require_once("../models/chat_model.php");

$mode = $_POST['mode'];
$id = 0;
$chat = new ChatModel();
$match = $_POST['match'];

if($mode == 'SendAndRetrieveNew')
{
	$name = $_POST['name'];
	$message = $_POST['message'];
	$id = $_POST['id'];

	if ($name != '' && $message != '' && $match != '')
		$chat->postMessage($name, $match, $message);
}
else if ($mode == 'DeleteAndRetrieveNew')
	$chat->deleteMessages();
else if ($mode == 'RetrieveNew')
	$id = $_POST['id'];

if(ob_get_length())
	ob_clean();

//ADD THIS SOMEWHERE IN THIS FILE
//$matches = ChatModel::get_matches($_SESSION['logged_on_user']); //Check that the session key is right.
//print_r($matches); //Gives you an array of matches with userId and username. Use this array to populate the list in the view.

header('Expires: Fri, 22 Jun 1990 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-Type: text/xml');

echo $chat->retrieveNewMessages($id, $match);

?>
