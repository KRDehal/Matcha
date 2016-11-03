<?PHP

Class ResetController
{		
	public function fpass()
	{
		$email = "";
		$error = "";

		if (!empty($_POST)) 
		{
			$email = $_POST['email'];

			if ($this->_check($email) == False)
				$error = "mismatch";
		}
		require_once('views/pages/fpass.php');
	}

	private function _check($email)
	{
		if (ResetModel::mail($email) == 1)
			return True;
		else
			return False;
	}

	public function verify()
	{
		$reset = $_GET['reset'];

		if (ResetModel::verify($reset) == 1)
		{
			echo "Hmmm...maybe let's try something you can remember this time :/";
			header("refresh:2; url='index.php?controller=reset&action=npass'");
		}
		else
		{
			echo "It seems that there may have been a problem, kindly re-verify your email address.";
			header("refresh:2; url=index.php?controller=reset&action=fpass");
		}
	}

	public function npass()
	{
		$error = "";
		
		if (!empty($_POST))
		{
			$login = $_POST['login'];
			$password = $_POST['password'];
			$confirm = $_POST['confirm'];

			if (!(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8}$/', $password)))
					$error = "password_syntax";
			else if ($confirm != $password)
					$error = "confirm";

			$id = ResetModel::check($login);
			if ($id != 0)
			{
				$hash = hash("whirlpool", "dkrusche".$password);
				$db = Db::getConnect()->getInstance();
				$query_update = $db->prepare("UPDATE users SET password = :hash WHERE id = :id;");
				$query_update->bindParam(":hash", $hash);
				$query_update->bindParam(":id", $id);
				$query_update->execute();
				echo "<script>alert('Your password has been reset successfully, please sign in.');</script>";
				header("refresh:1; url='index.php?controller=validate&action=login'");
			}
			else
				$error = "incorrect";
		}
		require_once('views/pages/npass.php');
	}
}

?>
