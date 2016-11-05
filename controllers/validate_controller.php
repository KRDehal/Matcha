<?PHP

Class ValidateController
{		
	public function login()
	{
		$error = "";
		
		if (!empty($_POST))
		{
			$login = $_POST['login'];
			$hash = hash("whirlpool", "wethinkcode".$_POST['password']);
			$id = ValidateModel::check($login, $hash);
			if ($id != 0)
			{
				$_SESSION["logged_on_user"] = $id;
				header('Location: index.php?controller=pages&action=home');
			}
			$error = "incorrect";
		}
		require_once('views/pages/login.php');
	}

	public function logout()
	{
		$_SESSION['logged_on_user'] = "";
		header('Location: index.php');
	}
}

?>
