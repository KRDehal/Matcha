<?PHP
	header("Content-Type: text/html");
?>

<HTML>
<HEAD>
	<TITLE>Matcha</TITLE>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</HEAD>
<BODY>
<HEADER>
	<?PHP
		if (!isset($_SESSION["logged_on_user"]) || $_SESSION["logged_on_user"] == "")
		{
			$_SESSION["logged_on_user"] = "";
	?>		
			<a href="index.php?controller=signup&action=show">Sign Up</a>
			<a href="index.php?controller=validate&action=login">Sign In</a>
	<?PHP
		}
		else
		{
	?>
			<a href="index.php?controller=pages&action=home">Home</a>
			<a href="index.php?controller=pages&action=chat">Chat</a>
			<a href="index.php?controller=validate&action=logout">Sign Out</a>
	<?PHP
		}
	?>
</HEADER>

<?PHP require_once('routes.php'); ?>

<FOOTER>
<HR />
	<P>&#169 The Matcha Team 2016</P>
</FOOTER>
</BODY>
</HTML>
