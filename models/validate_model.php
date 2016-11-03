<?PHP

Class ValidateModel
{
	public static function check($login, $hash)
	{
		$db = Db::getConnect()->getInstance();
		$query = $db->prepare('SELECT id FROM users WHERE (username = :login OR email = :login) AND password = :hash AND protect = "1";');
		$query->execute(array('login' => $login, 'hash' => $hash));
		$ret = $query->fetch();
		if (empty($ret))
			return 0;
		else
			return $ret["id"];
	}
}

?>
