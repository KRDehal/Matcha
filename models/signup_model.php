<?PHP

Class SignUpModel
{
	public static function add($firstname, $lastname, $username, $email, $password)
	{
		$db = Db::getConnect()->getInstance();
		$query_match = $db->prepare("SELECT id FROM users WHERE username = :username OR email = :email;");
		$query_match->bindParam(":username", $username);
		$query_match->bindParam(":email", $email);
		$query_match->execute();
		$ret = $query_match->fetch();

		if (!empty($ret))
			return 0;
		else
		{
			$hash = hash("whirlpool", "wethinkcode".$password);
			$gen = rand(0, 9999999);
			$protect = hash('whirlpool', "wethinkcode".$gen);
			$query_insert = $db->prepare("INSERT INTO users (firstName, lastName,  username, email, password, protect) VALUES (:firstname, :lastname, :username, :email, :password, :protect);");
			$query_insert->bindParam(":firstname", $firstname);
			$query_insert->bindParam(":lastname", $lastname);
			$query_insert->bindParam(":username", $username);
			$query_insert->bindParam(":email", $email);
			$query_insert->bindParam(":password", $hash);
			$query_insert->bindParam(":protect", $protect);
			$query_insert->execute();
			
			$from = "From: noreply@matcha.co.za"."\r\n";
			$subject = "Matcha: Account Verification";
			$url = "http://localhost:8080/Matcha/index.php?controller=signup&action=verify&protect=".$protect;
			$message = "Hi there,\n\nYou have succesfully created an account, please click on the following link to verify: ".$url."\n\nRegards,\n\nThe Matcha Team";
			mail($email, $subject, $message, $from);
			echo "<script>alert('Account succesfully created, please check your email for varification purposes.');</script>";
			return 1;
		}
	}

	public static function verify($protect)
	{
		$db = Db::getConnect()->getInstance();
		$query_match = $db->prepare("SELECT id FROM users WHERE protect = :protect;");
		$query_match->bindParam(":protect", $protect);
		$query_match->execute();
		$ret = $query_match->fetch();

		if (empty($ret))
			return 0;
		else
		{
			$query_update = $db->prepare("UPDATE users SET protect = '1' WHERE protect = :protect;");
			$query_update->bindParam(":protect", $protect);
			$query_update->execute();
			return 1;
		}
	}
}

?>
