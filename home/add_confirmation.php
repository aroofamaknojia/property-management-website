<?php
 require "../config/config.php";
  if(!isset($_POST['home-name']) || trim($_POST['home-name'])=='' 
  	|| !isset($_POST['housing-name']) || trim($_POST['housing-name'])=='' 
  	|| !isset($_POST['region-name']) || trim($_POST['region-name']) ==''
  	|| !isset($_POST['state-name']) || trim($_POST['state-name'])==''
  	|| !isset($_POST['parking_idyes']) || trim($_POST['parking_idyes'])=='' 
  	|| !isset($_POST['laundry_idyes']) || trim($_POST['laundry_idyes'])==''
  	|| !isset($_FILES['file-id']['name']) || trim($_FILES['file-id']['name']) == ''){
  	$error = "Missing one or more required fields.";
  }else if($_FILES['file-id']['error'] > 0){
  	//File upload error
  	$error = "File upload error # ". $_FILES['file-id']['error'];
  }else if(($_FILES['file-id']['type'] != "image/jpeg") && ($_FILE['file-id']['type'] != "image/jpg")){
  	$error = "Invalid file type. Please submit file type of jpeg or jpg.";
  }else{
  	require "../config/config.php";
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
  		echo $mysqli->connect_error;
  		exit();
		}
		$file = $_FILES['file-id']['name'];
  	$destination = "uploads/". uniqid().$file;
  	move_uploaded_file($_FILES['file-id']['tmp_name'], $destination);
  	$home_title = $_POST['home-name'];
  	$housing = $_POST['housing-name'];
		$region = $_POST['region-name'];
		$state = $_POST['state-name'];
		$parking = $_POST['parking_idyes'];
		$laundry = $_POST['laundry_idyes'];

		if ( isset($_POST['price']) && trim($_POST['price']) != '' ) {
			$price = $_POST['price'];
		} else {
			$price = "null";
		}

		if ( isset($_POST['sqfeet']) && trim($_POST['sqfeet']) != '' ) {
			$sqfeet = $_POST['sqfeet'];
		} else {
			$sqfeet = "null";
		}

		if ( isset($_POST['beds']) && trim($_POST['beds']) != '' ) {
			$beds = $_POST['beds'];
		} else {
			$beds = "null";
		}
		if ( isset($_POST['baths']) && trim($_POST['baths']) != '' ) {
			$baths = $_POST['baths'];
		} else {
			$baths = "null";
		}

		if ( isset($_POST['dogs_allowed'])) {
			$dogs_allowed = $_POST['dogs_allowed'];
		} else {
			$dogs_allowed = "null";
		}
		if ( isset($_POST['cats_allowed'])) {
			$cats_allowed = $_POST['cats_allowed'];
		} else {
			$cats_allowed = "null";
		}

		if ( isset($_POST['smoking_allowed'])) {
			$smoking_allowed = $_POST['smoking_allowed'];
		} else {
			$smoking_allowed = "null";
		}

		if ( isset($_POST['wheelchair_access'])) {
			$wheelchair_access = $_POST['wheelchair_access'];
		} else {
			$wheelchair_access = "null";
		}

		if ( isset($_POST['electric_charge'])) {
			$electric_charge = $_POST['electric_charge'];
		} else {
			$electric_charge = "null";
		}

		if ( isset($_POST['comes_furnished'])) {
			$comes_furnished = $_POST['comes_furnished'];
		} else {
			$comes_furnished = "null";
		}

		$sql = "INSERT INTO home (price, sqfeet, beds, baths, cats_allowed, dogs_allowed, smoking_allowed, wheelchair_access, electric_charge, comes_furnished, img_url, home_title, parking_id, state_id, laundry_id, housing_id, region_id)
						VALUES ($price, $sqfeet, $beds, $baths, $cats_allowed, $dogs_allowed, $smoking_allowed, $wheelchair_access, $electric_charge, $comes_furnished, '$destination', '$home_title', $parking, $state, $laundry, $housing, $region);";

		// echo "<hr>$sql<hr>";

		$results = $mysqli->query($sql);

		if (!$results) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}


		$mysqli->close();
  }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Homely Add Confirmation</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="main.css">
	<style>
	p{
		text-align: center;
	}
	.container {
		background-color:  white;
		border-radius:  20px;
		padding-bottom:  300px;
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
	<h1>New Listing Details</h1>

				<?php if ( isset($error) && trim($error) != '' ) : ?>

					<div class="text-danger"><p>
						<!-- Show Error Messages Here. -->
						<?php echo $error; ?>
					</p></div>

				<?php else : ?>

					<div class="text-success"><p>
						<span class="font-italic"><?php echo $home_title; ?></span> was successfully added.</p>
					</div>

				<?php endif; ?>
	<div class="row">
<div class="col-md-12 mt-5">
<a class="btn btn-color btn-block" href="search_results.php" role="button">Back to Search Results</a>
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