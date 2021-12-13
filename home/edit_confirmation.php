<?php 
	require '../config/config.php';
	if ( !isset($_POST['home-name']) || trim($_POST['home-name']) == ''
		|| !isset($_POST['housing-name']) || trim($_POST['housing-name']) == ''
		|| !isset($_POST['region-name']) || trim($_POST['region-name']) == ''
		|| !isset($_POST['state-name']) || trim($_POST['state-name']) == ''
		|| !isset($_POST['laundry_idyes']) || trim($_POST['laundry_idyes']) == ''
		|| !isset($_POST['parking_idyes']) || trim($_POST['parking_idyes']) == ''
		|| !isset($_POST['home_id']) || trim($_POST['home_id']) == ''
	) {
		$error = "Please fill out all required fields.";
	}else{
				$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');
$home_title = $_POST['home-name'];
var_dump($home_title);
$housing = $_POST['housing-name'];
var_dump($housing);
$region = $_POST['region-name'];
var_dump($region);
$state = $_POST['state-name'];
var_dump($state);
$laundry = $_POST['laundry_idyes'];
var_dump($laundry);
$parking = $_POST['parking_idyes'];
var_dump($parking);
$home_id = $_POST['home_id'];
var_dump($home_id);

		if ( isset($_POST['price']) && trim($_POST['price']) != '') {
			$price = $_POST['price'];
		} else {
			$price = "null";
		}
				if ( isset($_POST['sqfeet']) && trim($_POST['sqfeet']) != '') {
			$sqfeet = $_POST['sqfeet'];
		} else {
			$sqfeet = "null";
		}

		if ( isset($_POST['beds']) && trim($_POST['beds']) != '') {
			$beds = $_POST['beds'];
		} else {
			$beds = "null";
		}
		if ( isset($_POST['baths']) && trim($_POST['baths']) != '') {
			$baths = $_POST['baths'];
		} else {
			$baths = "null";
		}

		if ( isset($_POST['cats_allowed'])) {
			$cats_allowed = $_POST['cats_allowed'];
		} else {
			$cats_allowed = "null";
		}
		var_dump($cats_allowed);

		if ( isset($_POST['dogs_allowed'])) {
			$dogs_allowed = $_POST['dogs_allowed'];
		} else {
			$dogs_allowed = "null";
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
$sql = "UPDATE home
						SET home_title = '$home_title',
						price = $price,
						sqfeet = $sqfeet,
						beds = $beds,
						baths = $baths, 
						cats_allowed = $cats_allowed,
						dogs_allowed = $dogs_allowed,
						smoking_allowed = $smoking_allowed, 
						wheelchair_access = $wheelchair_access,
						electric_charge = $electric_charge,
						comes_furnished = $comes_furnished,
						parking_id = $parking,
						state_id = $state,
						laundry_id = $laundry, 
						housing_id = $housing,
						region_id = $region
						WHERE home_id = $home_id;";

		$results = $mysqli->query($sql);

		if ( !$results ) {
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
	<title>Homely Edit Confirmation</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="main.css">
	<style>
	p{
		text-align: center;
	}
	.container {
		background-color:  white;
		border-radius:  20px;
		padding-bottom:  400px;
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
	<div class="container-fluid">
	<h1>Edit Details</h1>
	
				<?php if ( isset($error) && trim($error) != '' ) : ?>

					<div class="text-danger"><p>
						<!-- Show Error Messages Here. -->
						<?php echo $error; ?>
					</p></div>

				<?php else : ?>

					<div class="text-success"><p>
						<span class="font-italic"><?php echo $home_title; ?></span> was successfully edited.</p>
					</div>

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