<?PHP

Class SignUpModel
{
	public static function add($firstname, $lastname, $username, $email, $password)
	{
		$db = Db::getConnect()->getInstance();
		$query_match = $db->prepare("SELECT id FROM users WHERE (username = :username OR email = :email) AND protect != '1';");
		$query_match->execute(array('username' => $username, 'email' => $email));
		$ret = $query_match->fetch();

		if (!empty($ret))
			return 0;
		else
		{
			$hash = hash("whirlpool", "dkrusche".$password);
			$gen = rand(0, 9999999);
			$protect = hash('whirlpool', "dkrusche".$gen);
			$query_insert = $db->prepare("INSERT INTO users (firstName, lastName,  username, email, password, protect) VALUES (:firstname, :lastname, :username, :email, :password, :protect);");
			$query_insert->execute(array('firstname' => $firstname, 'lastname' => $lastname, 'username' => $username, 'email' => $email, 'password' => $hash, 'protect' => $protect));
			
			$from = "From: noreply@matcha.co.za"."\r\n";
			$subject = "Account Verification";
			$url = "http://localhost:8080/Matcha/index.php?controller=signup&action=verify&protect=".$protect;
			$message = "Hi there,\n\nYou have succesfully created an account, please click on the following link to verify:\n".$url;
			mail($email, $subject, $message, $from);
			return 1;
		}
	}

	public static function verify($protect)
	{
		$db = Db::getConnect()->getInstance();
		$query_match = $db->prepare("SELECT id FROM users WHERE protect = :protect;");
		$query_match->execute(array('protect' => $protect));
		$ret = $query_match->fetch();

		if (empty($ret))
			return 0;
		else
		{
			$query_insert = $db->prepare("UPDATE users SET protect = '1' WHERE protect = :protect;");
			$query_insert->execute(array('protect' => $protect));
			return 1;
		}
	}
}

?>
