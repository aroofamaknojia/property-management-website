<?php 

require '../config/config.php';

if (!isset($_POST['name']) || trim($_POST['name'] == '')|| !isset($_POST['email']) || trim($_POST['email'] == '')
	|| !isset($_POST['username']) || trim($_POST['username'] == '')
	|| !isset($_POST['password']) || trim($_POST['password'] == '') ) {
	$error = "Please fill out all required fields.";
}else{
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, MEMBERSHIP_DB);
	if($mysqli->connect_errno){
		echo $mysqli->connect_error;
		exit();
	}

$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$name = $mysqli->escape_string($name);
$username = $mysqli->escape_string($username);
$email = $mysqli->escape_string($email);
$password = hash('sha256', $password);


$sql_registered = "SELECT * FROM user WHERE username = '$username' OR email = '$email';";
$results_registered = $mysqli->query($sql_registered);

if(!$results_registered){
	echo $mysqli->error;
	$mysqli->close();
	exit();
}

if($results_registered->num_rows > 0){
// Username or email already taken
	$error = "Username or email already registered.";

}else{
// Username or email both available

$sql = "INSERT INTO user(name, username, email, password)
		VALUES ('$name', '$username', '$email', '$password');";

$results = $mysqli->query($sql);
if (!$results){
	echo $mysqli->error;
	$mysqli->close();
	exit();
}
}
$mysqli->close();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Homely Signup Confirmation</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="main.css">
	<style>
	p{
		text-align: center;
	}
</style>
</head>
<body>
	<!--Nav-->
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
          	<?php if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) : ?>
          <a class="nav-link" href="logout.php">Logout</a>
           <?php else : ?>
           <a class="nav-link" href="login.php">Login</a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
	</div>
	</nav>
	<h1>Signup Details</h1>
		<?php if ( isset($error) && trim($error) != '' ) : ?>
					<div class="text-danger"><p><?php echo $error; ?></p></div>
				<?php else : ?>
					<div class="text-success"><p><?php echo $username; ?> was successfully registered.</p></div>
				<?php endif; ?>
			<p><a href="signup.php" role="button" class="btn btn-primary">Back to Form</a></p>
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