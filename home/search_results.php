<?php
	require '../config/config.php';
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

	$sql = "SELECT home_title, housing.housing_name AS housing, region.region_name AS region, state.state_name AS state, price, sqfeet, beds, baths, img_url, home_id
					FROM home
					LEFT JOIN housing
						ON home.housing_id = housing.housing_id
					LEFT JOIN region
						ON home.region_id = region.region_id
					LEFT JOIN state
						ON home.state_id = state.state_id
					LEFT JOIN parking 
						ON home.parking_id = parking.parking_id
					LEFT JOIN laundry
						ON home.laundry_id = laundry.laundry_id
					WHERE 1 = 1";

		if ( isset($_GET['housing']) && trim($_GET['housing']) != '' ) {
		$housing = $_GET['housing'];
		$sql = $sql . " AND home.housing_id = $housing";
	}

		if ( isset($_GET['region']) && trim($_GET['region']) != '' ) {
		$region = $_GET['region'];
		$sql = $sql . " AND region.region_id = $region";
	}

			if ( isset($_GET['parking']) && trim($_GET['parking']) != '' ) {
		$parking = $_GET['parking'];
		$sql = $sql . " AND parking.parking_id = $parking";
	}
				if ( isset($_GET['laundry']) && trim($_GET['laundry']) != '' ) {
		$laundry = $_GET['laundry'];
		$sql = $sql . " AND laundry.laundry_id = $laundry";
	}
				if ( isset($_GET['beds']) && trim($_GET['beds']) != '' ) {
		$beds = $_GET['beds'];
		$sql = $sql . " AND beds = $beds";
	}

		if ( isset($_GET['baths']) && trim($_GET['baths']) != '' ) {
		$baths = $_GET['baths'];
		$sql = $sql . " AND baths = $baths";
	}
	if ( isset($_GET['price']) && trim($_GET['price']) != '' ) {
		$price = $_GET['price'];
		if(isset($_GET['amount']) && trim($_GET['amount']) != ''){
			if($_GET['amount'] == 0){
				$sql = $sql . " AND price = $price";
			}
			if($_GET['amount'] == 1){
				$sql = $sql . " AND price < $price";
			}
			else if($_GET['amount'] == 2){
				$sql = $sql . " AND price = $price";
			}
			else if($_GET['amount'] == 3){
				$sql = $sql . " AND price > $price";
			}
		}
		
	}

		$sql = $sql . ";";

		$results = $mysqli->query($sql);


		if ( !$results ) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}

	$total_results = $results->num_rows;
	$results_per_page = 10;

	$last_page = ceil($total_results / $results_per_page);
	if ( isset($_GET['page']) && trim($_GET['page']) != '' ) {
		$current_page = $_GET['page'];
	} else {
		$current_page = 1;
	}

	if ($current_page < 1 || $current_page > $last_page) {
		$current_page = 1;
	}

	$start_index = ($current_page - 1) * $results_per_page;
		$sql = rtrim($sql, ';');

		$sql = $sql . " LIMIT $start_index, $results_per_page";

			$results = $mysqli->query($sql);

	if ( !$results ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	// Close MySQL Connection
	$mysqli->close();


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
		width:  100px;
		height:  100px;
		object-fit: cover;
		float:  left;
		border-radius: 50%;

	}
	.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
  background-color: #94BDF2;
}
th{
	width:  150px;
	background-color: #8FB996;
}
td{
	width:  150px;
}
#pagination{
	margin-left:  0px;
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
			<h1>Listings Search Results</h1>
			<div class="row mb-4 mt-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col-10">

				<?php if ( $total_results == 0 ) : ?>

					Search returned 0 results.

				<?php else : ?>

					Showing 
					<?php echo $start_index + 1; ?>
					-
					<?php echo $start_index + $results->num_rows; ?>
					of 
					<?php echo $total_results; ?> 
					result(s).

				<?php endif; ?>

			</div>
			<div class="col-3" id="pagination">
			<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item <?php if ($current_page <= 1) { echo 'disabled'; } ?>">
      <a class="page-link" href="<?php
								$_GET['page'] = $current_page - 1;
								echo $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET);
							?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <?php for($i = 1; $i <= $last_page; $i++) : ?>
    <li class="page-item <?php if($page == $i) {echo 'active'; } ?>"><a class="page-link" href="<?php $_GET['page'] = $i; echo $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET);?>"><?= $i; ?></a></li>
    <?php endfor; ?>
    <li class="page-item <?php if ($current_page >= $last_page) { echo 'disabled'; } ?>">
      <a class="page-link" href="<?php
								$_GET['page'] = $current_page + 1;
								echo $_SERVER['PHP_SELF'] . '?' . http_build_query($_GET);
							?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>
</div>
	</div>
	<div class="col-12 table-responsive">
				<table class="table table-hover table-responsive mt-4 table-striped">
					<thead>
						<tr>
							<th></th>
							<th>Name</th>
							<th>Housing Type</th>
							<th>Region</th>
							<th>State</th>
							<th>Price</th>
							<th>Square Feet</th>
							<th>Beds</th>
							<th>Baths</th>
								<?php if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) : ?>
							<th></th>
							<th></th>
								<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php while ( $row = $results->fetch_assoc() ) : ?>
						<tr>
							<td>
								<img src="<?php echo $row['img_url']; ?>" alt="<?php echo $row['home_title']; ?>" class="common_img">
							</td>
							<td>
								<a href="details.php?home_id=<?php echo $row['home_id']; ?>"><?php echo $row['home_title']; ?></a>
							</td>
							<td>
								<?php echo $row['housing']; ?>
							</td>
							<td>
								<?php echo $row['region']; ?>
							</td>
								
							<td>
								<?php echo $row['state']; ?>
							</td>
							<td>
									<?php echo $row['price']; ?>
							</td>
							<td>
								<?php echo $row['sqfeet']; ?>
							</td>
							<td>
								<?php echo $row['beds']; ?>
							</td>
							<td>
								<?php echo $row['baths']; ?>
							</td>
								<?php if ( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ) : ?>
							<td>
								<a href="edit_form.php?home_id=<?php echo $row['home_id']; ?>" class="btn btn-outline-warning" data-toggle="modal" data-target="#exampleModalCenter"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg> Edit</a>
							</td>
							<td>
								<a href="delete_confirmation.php?home_id=<?php echo $row['home_id']; ?>&home_title=<?php echo $row['home_title']; ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete \'<?php echo $row['home_title']; ?>\'?');"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
</svg> Delete</a>
							</td>
						<?php endif; ?>
						</tr>
							<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
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