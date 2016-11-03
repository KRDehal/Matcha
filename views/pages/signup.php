<h1>Sign up for your free Matcha account!</h1>
<h4>Use Matcha and all its features for free, forever!!!</h4>

    <?PHP
        $errorMessage = "";
        if ($error == 'username_length')
            $errorMessage = "Username must be at least 3 characters";
        else if ($error == "email_length")
            $errorMessage = "Please enter a valid email address";
        else if ($error == "password_syntax")
            $errorMessage = "Password must be at least 8 characters; and must include at least one lower case letter, one upper case later and one number";
        else if ($error == "confirm")
            $errorMessage = "Passwords do not match";
        else if ($error == "mismatch")
            $errorMessage = "Email/Username already exists";
    ?>

     <p id="error"> <?PHP echo $errorMessage ?> </p>

<form action="index.php?controller=signup&action=show" method="POST">
    <input type="text" placeholder="First Name" name="firstname" value="<?PHP echo $firstname?>">
    <input type="text" placeholder="Last Name" name="lastname" value="<?PHP echo $lastname?>">
	<input type="text" placeholder="Enter a username" name="username" value="<?PHP echo $username?>">
	<input type="text" placeholder="Enter your email address" name="email" value="<?PHP echo $email?>">
	<input type="password" placeholder="Set a password" name="password">
	<input type="password" placeholder="Confirm your password" name="confirm">

	<input type="submit" value="Create account">
</form>
