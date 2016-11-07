<?PHP
class PagesController
{
	public function home()
	{	
		require_once('views/pages/home.php');
	}
	public function landing()
	{
		require_once('views/pages/landing.php');
	}
	public function error()
	{
		require_once('views/pages/error.php');
	}
}
?>
