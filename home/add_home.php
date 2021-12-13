<?php
require "../config/config.php";
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
  echo $mysqli->connect_error;
  exit();
}
$mysqli->set_charset('utf8');
$sql_parking = "SELECT * FROM parking;";

  $results_parking = $mysqli->query( $sql_parking );


  if ( !$results_parking ) {
    echo $mysqli->error;
    $mysqli->close();
    exit();
  }


  $sql_laundry = "SELECT * FROM laundry;";

  $results_laundry = $mysqli->query( $sql_laundry );


  if ( !$results_laundry ) {
    echo $mysqli->error;
    $mysqli->close();
    exit();
  }

  $sql_housing = "SELECT * FROM housing;";

  $results_housing = $mysqli->query( $sql_housing );


  if ( !$results_housing ) {
    echo $mysqli->error;
    $mysqli->close();
    exit();
  }


  $sql_region = "SELECT * FROM region;";

  $results_region = $mysqli->query( $sql_region );


  if ( !$results_region ) {
    echo $mysqli->error;
    $mysqli->close();
    exit();
  }

  $sql_state = "SELECT * FROM state;";
  $results_state = $mysqli->query( $sql_state );
  if( !$results_state ){
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
	<title>Homely Add Home Page</title>
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
	<div class="container">
			<!--H1-->
			<h1>Add a Listing</h1>
		<!-- Form-->
		<form action="add_confirmation.php" method="POST" enctype="multipart/form-data">
			<div class="form-group row">
  <label for="home_name" class="col-sm-3 col-form-label text-sm-right">Home Name: <span class="text-danger">*</span></label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="home_name" name="home-name">
    </div>
</div>
<div class="form-group row">
				<label for="housing" class="col-sm-3 col-form-label text-sm-right">Housing Type: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<select name="housing-name" id="housing" class="form-control">
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
				<label for="region" class="col-sm-3 col-form-label text-sm-right">Region: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<select name="region-name" id="region" class="form-control">
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
				<label for="state" class="col-sm-3 col-form-label text-sm-right">State: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<select name="state-name" id="state" class="form-control">
						<option value="" selected>-- All --</option>
												<?php while ( $row = $results_state->fetch_assoc() ) : ?>
							<option value="<?php echo $row['state_id']; ?>">
								<?php echo $row['state_name']; ?>
							</option>
						<?php endwhile; ?>
			</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="price" class="col-sm-3 col-form-label text-sm-right">Price:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="price" name="price">
				</div>
			</div>
			<div class="form-group row">
				<label for="sqfeet" class="col-sm-3 col-form-label text-sm-right">Square Feet:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="sqfeet" name="sqfeet">
				</div>
			</div>
			<div class="form-group row">
				<label for="beds" class="col-sm-3 col-form-label text-sm-right">Beds:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="beds" name="beds" min="1" max="6">
				</div>
			</div>
			<div class="form-group row">
				<label for="baths" class="col-sm-3 col-form-label text-sm-right">Baths:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="baths" name="baths" step="0.5" min="0.5" max="7.5">
				</div>
			</div>
			<div class="form-group row">
				<label for="parking" class="col-sm-3 col-form-label text-sm-right">Parking: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<select name="parking_idyes" id="parking" class="form-control">
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
				<label for="laundry" class="col-sm-3 col-form-label text-sm-right">Laundry: <span class="text-danger">*</span></label>
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
				<label for="cats_allowedyes" class="col-sm-3 col-form-label text-sm-right">Cat-Friendly:</label>
				<div class="form-check pr-4 pl-5">
			  <input class="form-check-input" type="radio" name="cats_allowed" id="cats_allowedyes" value="1">
			  <label class="form-check-label" for="cats_allowedyes">
			    Yes
			  </label>
			</div>
			<div class="form-check pr-4">
			  <input class="form-check-input" type="radio" name="cats_allowed" id="cats_allowedno" value="0" checked
			  >
			  <label class="form-check-label" for="cats_allowedno">
			    No
			  </label>
			</div>
		</div>
			<div class="form-group row">
				<label for="dogs_allowedyes" class="col-sm-3 col-form-label text-sm-right">Dog-Friendly:</label>
				<div class="form-check pr-4 pl-5">
			  <input class="form-check-input" type="radio" name="dogs_allowed" id="dogs_allowedyes" value="1">
			  <label class="form-check-label" for="dogs_allowedyes">
			    Yes
			  </label>
			</div>
			<div class="form-check pr-4">
			  <input class="form-check-input" type="radio" name="dogs_allowed" id="dogs_allowedno" value="0" checked>
			  <label class="form-check-label" for="dogs_allowedno">
			    No
			  </label>
			</div>
		</div>
			<div class="form-group row">
				<label for="smoking_allowedyes" class="col-sm-3 col-form-label text-sm-right">Smoking Permitted:</label>
				<div class="form-check pr-4 pl-5">
			  <input class="form-check-input" type="radio" name="smoking_allowed" id="smoking_allowedyes" value="1">
			  <label class="form-check-label" for="smoking_allowedyes">
			    Yes
			  </label>
			</div>
			<div class="form-check pr-4">
			  <input class="form-check-input" type="radio" name="smoking_allowed" id="smoking_allowedno" value="0" checked>
			  <label class="form-check-label" for="smoking_allowedno">
			    No
			  </label>
			</div>
		</div>
					<div class="form-group row">
				<label for="wheelchair_accessyes" class="col-sm-3 col-form-label text-sm-right">Wheelchair-Friendly:</label>
				<div class="form-check pr-4 pl-5">
			  <input class="form-check-input" type="radio" name="wheelchair_access" id="wheelchair_accessyes" value="1">
			  <label class="form-check-label" for="wheelchair_accessyes">
			    Yes
			  </label>
			</div>
			<div class="form-check pr-4">
			  <input class="form-check-input" type="radio" name="wheelchair_access" id="wheelchair_accessno" value="0" checked>
			  <label class="form-check-label" for="wheelchair_accessno">
			    No
			  </label>
			</div>
		</div>
			<div class="form-group row">
				<label for="electric_chargeyes" class="col-sm-3 col-form-label text-sm-right">Electric Charging Available:</label>
				<div class="form-check pr-4 pl-5">
			  <input class="form-check-input" type="radio" name="electric_charge" id="electric_chargeyes" value="1">
			  <label class="form-check-label" for="electric_chargeyes">
			    Yes
			  </label>
			</div>
			<div class="form-check pr-4">
			  <input class="form-check-input" type="radio" name="electric_charge" id="electric_chargeno" value="0" checked>
			  <label class="form-check-label" for="electric_chargeno">
			    No
			  </label>
			</div>
		</div>
		<div class="form-group row">
				<label for="comes_furnishedyes" class="col-sm-3 col-form-label text-sm-right">Furnished:</label>
				<div class="form-check pr-4 pl-5">
			  <input class="form-check-input" type="radio" name="comes_furnished" id="comes_furnishedyes" value="1">
			  <label class="form-check-label" for="comes_furnishedyes">
			    Yes
			  </label>
			</div>
			<div class="form-check pr-4">
			  <input class="form-check-input" type="radio" name="comes_furnished" id="comes_furnishedno" value="0" checked>
			  <label class="form-check-label" for="comes_furnishedno">
			    No
			  </label>
			</div>
		</div>
					<div class="form-group row">
				<label for="file_id" class="col-sm-3 col-form-label text-sm-right">Image: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input type="file" class="form-control" id="file_id" name="file-id">
				</div>
			</div>
				<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Add</button>
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