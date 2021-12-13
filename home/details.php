<?php
require '../config/config.php';
if ( !isset($_GET['home_id']) || trim($_GET['home_id']) == '') {
		$error = "Invalid Home ID.";
	}
	else {
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$home_id = $_GET['home_id'];

		$sql = "SELECT home_title, img_url, housing.housing_name AS housing, region.region_name AS region, state.state_name AS state, laundry.laundry_name AS laundry, parking.parking_name AS parking, price, sqfeet, beds, baths, cats_allowed, dogs_allowed, smoking_allowed, wheelchair_access, electric_charge, comes_furnished
						FROM home
						LEFT JOIN housing
							ON home.housing_id = housing.housing_id
						LEFT JOIN region
							ON home.region_id = region.region_id
						LEFT JOIN state
							ON home.state_id = state.state_id
						LEFT JOIN laundry
							ON home.laundry_id = laundry.laundry_id
						LEFT JOIN parking
							ON home.parking_id = parking.parking_id
						WHERE home_id = $home_id;";

		$results = $mysqli->query($sql);

		if ( !$results ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

		$row = $results->fetch_assoc();

		$mysqli->close();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Homely Search Results Page</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="main.css">
	<style>
	.common_img{
		width:  250px;
		height:  250px;
		object-fit: cover;
		border-radius: 50%;
		margin-left: auto;
		margin-right: auto;
		display: block;

	}
	.container {
		background-color:  white;
		border-radius:  20px;
		padding-bottom:  20px;
	}
	a{
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
			<?php if ( isset($error) && trim($error) != '' ) : ?>

				<div class="text-danger">
					<?php echo $error; ?>
				</div>

			<?php else : ?>
	<div class="container">
		<div class="col-12">
		<h1><?php echo $row['home_title']; ?></h1>
		<img src="<?php echo $row['img_url']; ?>" alt="<?php echo $row['home_title']; ?>" class="common_img">

				<table class="table table-responsive mt-5 offset-md-4">
					<tr>
						<th class="text-right">Housing Type:</th>
						<td><?php echo $row['housing']; ?></td>
					</tr>
					<tr>
						<th class="text-right">Region:</th>
						<td><?php echo $row['region']; ?></td>
					</tr>
					<tr>
						<th class="text-right">State:</th>
						<td><?php echo $row['state']; ?></td>
					</tr>
					<tr>
						<th class="text-right">Price:</th>
						<td><?php echo $row['price']; ?></td>
					</tr>
					<tr>
						<th class="text-right">Square Feet:</th>
						<td><?php echo $row['sqfeet']; ?></td>
					</tr>
					<tr>
						<th class="text-right">Beds:</th>
						<td><?php echo $row['beds']; ?></td>
					</tr>
					<tr>
						<th class="text-right">Baths:</th>
						<td><?php echo $row['baths']; ?></td>
					</tr>
					<tr>
						<th class="text-right">Parking:</th>
						<td><?php echo $row['parking']; ?></td>
					</tr>
					<tr>
						<th class="text-right">Laundry:</th>
						<td><?php echo $row['laundry']; ?></td>
					</tr>
					<tr>
						<th class="text-right">Are cats allowed?:</th>
						<td><?php if ($row['cats_allowed'] == 0){
					echo "No";}else{ echo "Yes"; }?></td>
					</tr>
					<tr>
						<th class="text-right">Are dogs allowed?:</th>
						<td><?php if ($row['dogs_allowed'] == 0){
					echo "No";}else{ echo "Yes"; }?></td>
					</tr>
					<tr>
						<th class="text-right">Is smoking allowed?:</th>
						<td><?php if ($row['smoking_allowed'] == 0){
					echo "No";}else{ echo "Yes"; }?></td>
					</tr>
					<tr>
						<th class="text-right">Is there wheelchair access?:</th>
						<td><?php if ($row['wheelchair_access'] == 0){
					echo "No";}else{ echo "Yes"; }?></td>
					</tr>
					<tr>
						<th class="text-right">Is there electric charging?:</th>
						<td><?php if ($row['electric_charge'] == 0){
					echo "No";}else{ echo "Yes"; }?></td>
					</tr>
					<tr>
						<th class="text-right">Is it furnished?:</th>
						<td><?php if ($row['comes_furnished'] == 0){
					echo "No";}else{ echo "Yes"; }?></td>
					</tr>
				</table>
			</div>
			<a class="btn btn-primary offset-md-5" href="search_results.php" role="button">Back to Search Results</a>
		</div>
		<?php endif; ?>
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