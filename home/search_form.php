<?php 
	require '../config/config.php';

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$sql_parking = "SELECT * FROM parking;";

	$results_parking = $mysqli->query( $sql_parking );

	// Check for SQL Errors.
	if ( !$results_parking ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}


	$sql_laundry = "SELECT * FROM laundry;";

	$results_laundry = $mysqli->query( $sql_laundry );

	// Check for SQL Errors.
	if ( !$results_laundry ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	$sql_housing = "SELECT * FROM housing;";

	$results_housing = $mysqli->query( $sql_housing );

	// Check for SQL Errors.
	if ( !$results_housing ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}


	$sql_region = "SELECT * FROM region;";

	$results_region = $mysqli->query( $sql_region );

	// Check for SQL Errors.
	if ( !$results_region ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}


$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Homely Search Page</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="main.css">
	<style>
	label{
		font:  12pt Montserrat, sans-serif;
	}
	h1{
		margin-top:  175px;
	}
	.container {
		background-color:  white;
		border-radius:  20px;
		padding-bottom:  20px;
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
          <a class="nav-link active" href="search_form.php">Search</a>
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
	<div class="container">
			<!--H1-->
			<h1>Discover the Endless Living Options</h1>
		<!-- Form-->
		<form action="search_results.php" method="GET">
			
<div class="form-group row">
				<label for="housing" class="col-sm-3 col-form-label text-sm-right">Housing Type:</label>
				<div class="col-sm-9">
					<select name="housing" id="housing" class="form-control">
						<option value="" selected>-- All --</option>
							<?php while ( $row = $results_housing->fetch_assoc() ) : ?>
							<option value="<?php echo $row['housing_id']; ?>">
								<?php echo $row['housing_name']; ?>
							</option>
						<?php endwhile; ?>
			</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="region" class="col-sm-3 col-form-label text-sm-right">Region:</label>
				<div class="col-sm-9">
					<select name="region" id="region" class="form-control">
						<option value="" selected>-- All --</option>
							<?php while ( $row = $results_region->fetch_assoc() ) : ?>
							<option value="<?php echo $row['region_id']; ?>">
								<?php echo $row['region_name']; ?>
							</option>
						<?php endwhile; ?>
			</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="price" class="col-sm-3 col-form-label text-sm-right">Price:</label>
				<div class="input-group col-sm-9">
							<div class="input-group-prepend dropdown">
    <select class="form-control" id="amount" name="amount">
    	<option value="0"selected>Choose...</option>
      <option value="1">Under</option>
      <option value="2">Equal to</option>
      <option value="3">Over</option>
    </select>
  </div>

					<input type="text" class="form-control" id="price" name="price">
		</div>
	</div>
			<div class="form-group row">
				<label for="beds" class="col-sm-3 col-form-label text-sm-right">Beds:</label>
				<div class="col-sm-9">
					<input type="number" class="form-control" id="beds" name="beds" min="1" max="6">
				</div>
			</div>
			<div class="form-group row">
				<label for="baths" class="col-sm-3 col-form-label text-sm-right">Baths:</label>
				<div class="col-sm-9">
					<input type="number" class="form-control" id="baths" name="baths" step="0.5" min="0.5" max="7.5">
				</div>
			</div>
			<div class="form-group row">
				<label for="parking" class="col-sm-3 col-form-label text-sm-right">Parking:</label>
				<div class="col-sm-9">
					<select name="parking_id" id="parking" class="form-control">
						<option value="" selected>-- All --</option>
								<?php while ( $row = $results_parking->fetch_assoc() ) : ?>
							<option value="<?php echo $row['parking_id']; ?>">
								<?php echo $row['parking_name']; ?>
							</option>
						<?php endwhile; ?>
			</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="laundry" class="col-sm-3 col-form-label text-sm-right">Laundry:</label>
				<div class="col-sm-9">
					<select name="laundry_idyes" id="laundry" class="form-control">
						<option value="" selected>-- All --</option>
							<?php while ( $row = $results_laundry->fetch_assoc() ) : ?>
							<option value="<?php echo $row['laundry_id']; ?>">
								<?php echo $row['laundry_name']; ?>
							</option>
						<?php endwhile; ?>
			</select>
				</div>
			</div>
				<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Search</button>
					<button type="reset" class="btn btn-light">Reset</button>
				</div>
			</div>
		</form>
	</div>

<!--Footer-->
	<div class="container-fluid mt-4">
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