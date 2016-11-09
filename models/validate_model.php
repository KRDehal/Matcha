<?PHP

Class ValidateModel
{
	public static function check($login, $hash)
	{
		$db = Db::getConnect()->getInstance();
		$protect = "1";
		$query_match = $db->prepare('SELECT id FROM users WHERE username = :login AND password = :hash AND protect = :protect;');
		$query_match->bindParam(":login", $login);
		$query_match->bindParam(":hash", $hash);
		$query_match->bindParam(":protect", $protect);
		$query_match->execute();
		$ret = $query_match->fetch();
		if (empty($ret))
			return 0;
		else
			return $ret["id"];
	}
}

?>
