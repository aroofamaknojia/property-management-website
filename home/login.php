<?php
	require "../config/config.php";
	if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) {
		header('Location: home.php');
	} else {

		if ( isset($_POST['username_id']) && isset($_POST['password_id']) ) {
			// The form was submitted.
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, MEMBERSHIP_DB);
			if ($mysqli->connect_errno){
				echo $mysqli->connect_error;
				exit();
			}
			$username = $_POST['username_id'];
			$password = $_POST['password_id'];

			$password = hash('sha256', $password);

			$sql ="SELECT * FROM user WHERE username = '$username' AND password = '$password';";

			$results = $mysqli->query($sql);

			if(!$results){
				echo $mysqli->error;
				$mysqli->close();
				exit();
			}

			$mysqli->close();
			if($results->num_rows == 1){

				// Valid credentials.

				$_SESSION['logged_in'] = true;
				$_SESSION['username'] = $_POST['username_id'];
				header('Location: home.php');
	


			} else {
				// Invalid credentials.

				$error = "Invalid credentials.";

			}

		}

	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Homely Login Page</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="main.css">
	<style>
	h1{
		margin-top:  175px;
	}
	.container {
		background-color:  white;
		border-radius:  20px;
		padding-bottom:  20px;
	}
	#center{
		margin-top:  50px;
		text-align: center;
	}
</style>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light nav-background fixed-top">
		<div class="container-fluid">
		<img id="logo" src="img/homely.png" alt="logo">
    	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      	<span class="navbar-toggler-icon"></span>
    	</button>
    	<div class="collapse navbar-collapse" id="navbarNav">
      	<ul class="navbar-nav mr-auto">
        <li class="nav-item first-tab">
          <a class="nav-link" aria-current="page" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="search_form.php">Search</a>
        </li>
     	<?php if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) : ?>
         <li class="nav-item">
          <a class="nav-link" href="add_home.php">Add</a>
        </li>
        		<?php endif; ?>
        <li class="nav-item">
          <a class="nav-link active" href="login.php">Login</a>
        </li>
      </ul>
    </div>
	</div>
	</nav>
		<div class="container">
	<h1>Login to Your Account</h1>
		<form action="login.php" method="POST">
			<div class="form-group row">
				<label for="username" class="col-sm-3 col-form-label text-sm-right">Username:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="username" name="username_id">
				</div>
			</div>
			<div class="form-group row">
				<label for="password" class="col-sm-3 col-form-label text-sm-right">Password:</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password" name="password_id">
				</div>
			</div>
					<?php if ( isset($error) && trim($error) != '' ) : ?>
					<div class="text-danger offset-sm-3"><?php echo $error; ?></div>
				<?php endif; ?>
							<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Login</button>
					<button type="reset"  class="btn btn-light">Reset</button>
				</div>
			</div>
			</form>
			<p id="center">Don't have an account? Sign up <a href="signup.php">here</a>!</p>
		</div>
	<div class="container-fluid mt-4 fixed-bottom">
<div class="row">
	<div class="col-md-12 nav-background">
	<footer>
		<p class="p-3 text-muted">The Ultimate Database for the Top Home Listings</p>
		</footer>
	</div>
</div>
</div>
</body>
</html>