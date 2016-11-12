<?PHP

Class PagesController
{
	public function home()
	{	
		require_once('views/pages/home.php');
	}
	public function landing()
	{
		require_once('views/pages/landing.php');
	}
	public function matches()
	{
		require_once('views/pages/matches.php');
	}
	public function chat()
	{
		require_once('views/pages/chat.php');
	}
	public function error()
	{
		require_once('views/pages/error.php');
	}
}

?>
