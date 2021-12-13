<?php
	require '../config/config.php';

	if ( !isset($_GET['home_id']) || trim($_GET['home_id']) == '' || !isset($_GET['home_title']) || trim($_GET['home_title']) == '') {
		$error = "Invalid Home ID.";
	}	else {

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$home_id = $_GET['home_id'];

		$sql = "DELETE
						FROM home
						WHERE home_id = $home_id;";

		$results = $mysqli->query($sql);

		if ( !$results ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		// $row = $results->fetch_assoc();

		$mysqli->close();
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Homely Delete Confirmation</title>
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
	<h1>Delete Details</h1>
	<?php echo $home_id;?>
	<div class="container">
				<?php if (isset($error) && trim($error) != '') : ?>
			
				<div class="text-danger"><p>
					<?php echo $error; ?>
				</p></div>

			<?php else : ?>

				<div class="text-success"><p><span class="font-italic"><?php echo $_GET['home_title']; ?></span> was successfully deleted.</p></div>

			<?php endif; ?>
		<div class="row">
<div class="col-md-12 mt-5">
<a class="btn btn-color btn-block" href="search_results.php" role="button">Back to Results</a>
</div>
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