<?php
	require "../config/config.php";
	if ( !isset($_POST['username_id']) || trim($_POST['username_id']) == '' ){
		$error = "Please fill out username.";
	}else{
		$username = $_POST['username_id'];
	}
	var_dump($username);
?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Homely Login Confirmation</title>
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
           <li class="nav-item">
          <a class="nav-link" href="add_home.php">Add</a>
        </li>
        <li class="nav-item">
           <a class="nav-link" href="login.php">Login</a>
        </li>
      </ul>
    </div>
	</div>
	</nav>
	<h1>Login Details</h1>
				<?php if ( isset($error) && trim($error) != '' ) : ?>

					<div class="text-danger"><p>
						<!-- Show Error Messages Here. -->
						<?php echo $error; ?>
					</p></div>

				<?php else : ?>

					<div class="text-success"><p>
						<span class="font-italic"><?php echo $username; ?></span> has successfully logged in.</p>
					</div>

				<?php endif; ?>
		<div class="row">
<div class="col-md-12 mt-5">
<a class="btn btn-color btn-block" href="home.php" role="button">Go to Home Page</a>
</div>
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