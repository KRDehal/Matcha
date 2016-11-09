<h1>Matcha</h1>

	<?PHP
        $errorMessage = "";
        if ($error == 'incorrect')
            $errorMessage = "Incorrect Username/password";
    ?>

    <p id="error"> <?PHP echo $errorMessage ?> </p>

<form action="index.php?controller=validate&action=login" method="POST">
	<input type="text" placeholder="Username" name="login">
	<input type="password" placeholder="Password" name="password">

	<input type="submit" value="Sign In">
</form>

<a href="index.php?controller=reset&action=fpass">Forgot password?</a>
