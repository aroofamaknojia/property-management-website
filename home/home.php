<?php 
require "../config/config.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Homely Home Page</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="main.css">
	<style>

	.caption p {
		text-align: center;
		font:  12pt Montserrat, sans-serif;
		margin-top:  10px;
	}
	.btn-color{
		background-color: #A1CCA5;
		font:  12pt Montserrat, sans-serif;
		text-decoration: none;
		color: black;
		width:  200px;
		margin-top:  75px;
	}
	.thumbnail img{
		width:100%;
	}
	.before a {
		margin-left: auto;
		margin-right: auto;
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
          <a class="nav-link active" aria-current="page" href="home.php">Home</a>
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
        			<?php if(!isset($_SESSION['logged_in'])) :?>
					<a class="nav-link" href="login.php">Login</a>
			<?php else :?>

			<a class="nav-link" href="logout.php">Logout</a>
			<?php endif; ?>
        </li>
      </ul>
    </div>
	</div>
	</nav>
	<h1>Discover Home Listings Across America</h1>
	<div class="row">
		 <div class="col-md-4">
    <div class="thumbnail">
        <img src="img/home1.jpeg" alt="Home with Pool">
        <div class="caption">
          <p>Coachella Valley Villa</p>
        </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="thumbnail">
        <img src="img/home2.jpeg" alt="Decor Inside Home">
        <div class="caption">
          <p>Malibu Beach Home</p>
        </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="thumbnail">
        <img src="img/home3.jpeg" alt="Pool Deck Outside Home">
        <div class="caption">
          <p>Big Bear Cabin</p>
    </div>
  </div>
</div>
</div>
<div class="container">
<div class="row">
<div class="col-md-12 before">
<a class="btn btn-color btn-block" href="search_form.php" role="button">Search</a>
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