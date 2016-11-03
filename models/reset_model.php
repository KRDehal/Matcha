<?PHP

Class ResetModel
{
	public static function mail($email)
	{
		$db = Db::getConnect()->getInstance();
		$protect = "1";
		$query_match = $db->prepare("SELECT id FROM users WHERE email = :email AND protect = :protect;");
		$query_match->bindParam(":email", $email);
		$query_match->bindParam(":protect", $protect);
		$query_match->execute();
		$ret = $query_match->fetch();

		if (empty($ret))
			return 0;
		else
		{
			$gen = rand(0, 9999999);
			$reset = hash('whirlpool', "wethinkcode".$gen);
			$query_update = $db->prepare("UPDATE users SET reset = :reset WHERE email = :email;");
			$query_update->bindParam(":reset", $reset);
			$query_update->bindParam(":email", $email);
			$query_update->execute();
			
			$from = "From: noreply@matcha.co.za"."\r\n";
			$subject = "Matcha: Password Reset";
			$url = "http://localhost:8080/Matcha/index.php?controller=reset&action=verify&reset=".$reset;
			$message = "Hi there,\n\nPlease click on the following link to reset your password:\n".$url."\n\nRegards,\n\nThe Matcha Team";
			mail($email, $subject, $message, $from);
			echo "<script>alert('Account located, please check your email for a reset link.');</script>";
			return 1;
		}
	}

	public static function verify($reset)
	{
		$db = Db::getConnect()->getInstance();
		$query_match = $db->prepare("SELECT id FROM users WHERE reset = :reset;");
		$query_match->bindParam(":reset", $reset);
		$query_match->execute();
		$ret = $query_match->fetch();

		if (empty($ret))
			return 0;
		else
		{
			$query_update = $db->prepare("UPDATE users SET reset = '1' WHERE reset = :reset;");
			$query_update->bindParam(":reset", $reset);
			$query_update->execute();
			return 1;
		}
	}

	public static function check($login)
	{
		$db = Db::getConnect()->getInstance();
		$query_match = $db->prepare('SELECT id FROM users WHERE (username = :login OR email = :login) AND reset = "1";');
		$query_match->bindParam(":login", $login);
		$query_match->execute();
		$ret = $query_match->fetch();
		if (empty($ret))
			return 0;
		else
			return $ret["id"];
	}
}

?>
