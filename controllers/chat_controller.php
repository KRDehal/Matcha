<?PHP

require_once("../models/chat_model.php");

$mode = $_POST['mode'];
$id = 0;
$chat = new ChatModel();

if($mode == 'SendAndRetrieveNew')
{
	$name = $_POST['name'];
	$message = $_POST['message'];
	$id = $_POST['id'];

	if ($name != '' && $message != '')
		$chat->postMessage($name, $message);
}
else if ($mode == 'DeleteAndRetrieveNew')
	$chat->deleteMessages();
else if ($mode == 'RetrieveNew')
	$id = $_POST['id'];

if(ob_get_length())
	ob_clean();

header('Expires: Fri, 22 Jun 1990 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-Type: text/xml');

echo $chat->retrieveNewMessages($id);

?>
