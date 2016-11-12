<?PHP

function call($controller, $action)
{
	require_once('controllers/'.$controller.'_controller.php');
	switch ($controller)
	{
		case 'pages':
			$controller = new PagesController();
			break;
		case 'signup':
			require_once('models/signup_model.php');
			$controller = new SignUpController();
			break;
		case 'validate':
			require_once('models/validate_model.php');
			$controller = new ValidateController();
			break;
		case 'reset':
			require_once('models/reset_model.php');
			$controller = new ResetController();
			break;
	}

	$controller->{ $action }();
}

$controllers = array('pages' => ['home', 'landing', 'matches', 'chat', 'error'],
					'signup' => ['show', 'verify'],
					'validate' => ['login', 'logout'],
					'reset' => ['fpass', 'verify', 'npass']);

if (array_key_exists($controller, $controllers))
{
	if (in_array($action, $controllers[$controller]))
		call($controller, $action);
	else
		call('pages', 'error');
}
else
	call('pages', 'error');

?>
