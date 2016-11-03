<?PHP

Class SignUpController
{
	public function show()
	{
		$firstname = "";
		$lastname = "";
		$username = "";
		$email = "";
		$error = "";

		if (!empty($_POST)) 
		{
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$confirm = $_POST['confirm'];

			if (strlen($username) < 3)
				$error = "username_length";
			else if (strlen($email) < 4)
				$error = "email_length";
			else if (!(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password)))
				$error = "password_syntax";
			else if ($confirm != $password)
				$error = "confirm";
			else if ($this->_check($firstname, $lastname, $username, $email, $password) == False)
				$error = "mismatch";
		}
		require_once('Views/Pages/signup.php');
	}

	private function _check($firstname, $lastname, $username, $email, $password)
	{
		if (SignUpModel::add($firstname, $lastname, $username, $email, $password) == 1)
			return True;
		else
			return False;
	}

	public function verify()
	{
		$protect = $_GET['protect'];
		
		if (SignUpModel::verify($protect) == 1)
		{
			echo "Your account has been successfully verified, please sign in.";
			header("refresh:2; url='index.php?controller=validate&action=login'");
		}
		else
		{
			echo "There was a problem verifying your account, please sign up again.";
			header("refresh:2; url=index.php?controller=signup&action=show");
		}
	}
}

?>
