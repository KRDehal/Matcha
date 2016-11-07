<?PHP

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once('config/database.php');

$root = $_SERVER['DOCUMENT_ROOT'];

if (!isset($_SESSION["logged_on_user"]))
	$_SESSION["logged_on_user"] = "";

if (isset($_GET['controller']) && isset($_GET['action']))
{
	$controller = $_GET['controller'];
	$action = $_GET['action'];
}
else
{
	$controller = 'pages';
	$action = 'landing';
}

require_once('views/pages/layout.php');
										
?>
