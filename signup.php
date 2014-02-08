<html>
<head>
<title>Mismatch - Log In</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<?php

	require_once ('appvars.php');
	require_once ('connectvars.php');
	
	//connect to the DB
	
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	if(isset($_POST['submit'])){
		//grap the profile data from the POST
		
		$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
		$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
		$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
	
	if (!empty($username) && !empty($password1) && !empty($password2) &&
			($password1 == $password2)){
		
		//make sure somewone isn't already regestered under username
		
		$query = "SELECT * from mismatch_user WHERE username='$username'";
		
		$data = mysqli_query($dbc, $query);
		
		if(mysqli_num_rows($data) == 0){
			//the username is unique so insert into the table
			$query ="INSERT INTO mismatch_user (username, password, join_date) 
				VALUES " . "('$username', sha('$password1'), now())";
			
					
			mysqli_query($dbc, $query);
			
			//confirm success with the user
			
			echo '<p> Your new account has been successfully created. you\'re now ready to log in and ' . '<a href="editprofile.php">edit your profile</a></p>';
			
			mysqli_close($dbc);
			
			exit();
		}
		
		else {
			//an account already exists for this username so display an error message
			
			echo '<p class="error">A user already exists with that user name, or you did not use the same password twice. <br /><br /> You must enter all of the sign-up data, including the desired pasword twice.</p>';
			
			$username = "";
		}
	}
	
	mysqli_close($dbc);
	}
	?>
	
	<p> Please enter your username and desired password to sign up to Mismatch.</p>
	
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<fieldset>
			<legend>Registration Info</legend>
			
			<label for="username">Username: </label>
			<input type="text" id="username" name="username"
			value="<?php if(!empty($username)) echo $username; ?>" /> <br />
			
			<label for="password1">Password: </label>
			<input type="password" id="password1" name="password1"  /> <br />
			
			<label for="password2">Password (retype): </label>
			<input type="password" id="password2" name="password2"  /> <br />
		</fieldset>
	
	<input type="submit" value="Sign Up" name="submit" />
		
	</form>
	
	
	</html>