<?PHP

$DB_HOST = '127.0.0.1';
$DB_NAME = 'db_matcha';
$DB_DSN = 'mysql:host='.$DB_HOST;
$DB_USER = 'root';
$DB_PASSWORD = 'dc06148b';

class Db
{
	private static $instance = NULL;
	private static $conn = NULL;
	
	private function __construct() {}
		
	private function __clone() {}

	public static function getConnect()
	{
		if (self::$conn == NULL)
			self::$conn = new Db();
		return self::$conn;
	}

	public static function getInstance()
	{
		$DB_HOST = '127.0.0.1';
		$DB_NAME = 'db_matcha';
		$DB_DSN = 'mysql:host='.$DB_HOST.';dbname='.$DB_NAME;
		$DB_USER = 'root';
		$DB_PASSWORD = 'dc06148b';
		if (!isset(self::$instance))
		{
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			self::$instance = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $pdo_options);
		}
		return self::$instance;
	}
}

?>
