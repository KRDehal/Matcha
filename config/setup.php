<?PHP

require_once('database.php');

try {
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	echo "Connected to database successfully\n";
} catch (PDOException $e) {
	die("Connection failed: ".$e->getMessage());
}

$pdo_db_create = "CREATE DATABASE IF NOT EXISTS ".$DB_NAME;

$pdo_table_create = "CREATE TABLE IF NOT EXISTS users(
					id INT AUTO_INCREMENT NOT NULL,
					firstName VARCHAR(64) NOT NULL,
					lastName VARCHAR(64) NOT NULL,
        			email VARCHAR(250) NOT NULL,
        			username VARCHAR(250) NOT NULL,
        			password VARCHAR(512) NOT NULL,
        			protect VARCHAR(512) NOT NULL,
        			reset VARCHAR(512) NOT NULL,
        			PRIMARY KEY (id)
        			);";

$conn->query($pdo_db_create);
$conn->query("USE $DB_NAME");
$conn->query($pdo_table_create);

$pdo_table_create = "CREATE TABLE IF NOT EXISTS user_info(
					id INT AUTO_INCREMENT NOT NULL,
					userId INT NOT NULL,
					gender INT DEFAULT '0' NOT NULL,
					preferance INT DEFAULT '0' NOT NULL,
					biography TEXT NOT NULL,
					birthDate DATE NOT NULL,
					interests TEXT NOT NULL,
					PRIMARY KEY (id)
					);";

$conn->query($pdo_db_create);
$conn->query("USE $DB_NAME");
$conn->query($pdo_table_create);

$pdo_table_create = "CREATE TABLE IF NOT EXISTS user_pictures(
					id INT AUTO_INCREMENT NOT NULL,
					userId INT NOT NULL,
					image VARCHAR(64) NOT NULL,
					profilePic INT DEFAULT '0',
					PRIMARY KEY (id)
					);";

$conn->query($pdo_db_create);
$conn->query("USE $DB_NAME");
$conn->query($pdo_table_create);

$pdo_table_create = "CREATE TABLE IF NOT EXISTS user_connections(
					id INT AUTO_INCREMENT NOT NULL,
					userId INT NOT NULL,
					longitude DECIMAL(3,6) NOT NULL,
					latitude DECIMAL(3,6) NOT NULL,
					lastOnline DATETIME DEFAULT(GETDATE()) NOT NULL,
					PRIMARY KEY (id)
					);";

$conn->query($pdo_db_create);
$conn->query("USE $DB_NAME");
$conn->query($pdo_table_create);

$pdo_table_create = "CREATE TABLE IF NOT EXISTS likes(
					id INT AUTO_INCREMENT NOT NULL,
					userId INT NOT NULL,
					likedId INT NOT NULL,
					PRIMARY KEY (id)
					);";

$conn->query($pdo_db_create);
$conn->query("USE $DB_NAME");
$conn->query($pdo_table_create);

echo "Tables successfully created";

?>
