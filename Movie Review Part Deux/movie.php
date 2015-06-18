<!-- 
	ZHUONAN SUN CSE154 AE 
	7/18/2013 HW3
	This web page can show different movies' reviews, which includes general overview, the overall rate, 
	and reviews from other publications.
-->

<?php
// reading files based on the movie name
$movie = $_GET["film"];
list($moviename, $year, $rate) =  file("$movie/info.txt", FILE_IGNORE_NEW_LINES);
$overviews = file("$movie/overview.txt", FILE_IGNORE_NEW_LINES);

if ($rate >= 60) { 
	$quality = "fresh";
} else {
	$quality = "rotten";
}

$reviews = glob("$movie/review*.txt");
$number = count($reviews);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Rancid Tomatoes</title>

		<meta charset="utf-8" />
		<link href="movie.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		<?php banner(); ?>
		
		<h1><?= $moviename ?> (<?= $year ?>)</h1>
		
		<div id="main">
			<?php rate($quality, $rate); ?>
		
			<img src="<?= $movie ?>/overview.png" alt="general overview" /> 
			
			<div id="overview">
				<!-- display the overview -->
				<?php foreach ($overviews as $overview) { ?>
				<?php list($term, $definition) = explode(":", $overview); ?>
				<dl>
					<dt><?= $term ?></dt>
					<dd><?= $definition ?></dd>
				</dl>
				<?php } ?>
			</div>
			
			<div id="reviews">
				<div class="column">
				<?php reviews(0, round($number / 2), $reviews); ?>	
				</div>
				<div class="column">
				<?php reviews(round($number / 2), $number, $reviews); ?>		
				</div>
			</div>
			
			<p>(1-<?= $number ?>) of <?= $number ?></p>
			
			<?php rate($quality, $rate); ?>
		</div>	
		
		<a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" /></a><br />
		<a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
		
		<?php banner(); ?>
	</body>
</html>

<!-- display banner of Rancid Tomatoes -->
<?php function banner() { ?>
	<div class="banner">
		<img src="https://webster.cs.washington.edu/images/rancidbanner.png" alt="Rancid Tomatoes" />
	</div>

<?php } 

// display general rate of the movie, over 60% it displays a picture of fresh tomato, otherwise a picture of rotten tomato
function rate($quality, $rate) { ?>
	<div class="rotten">
		<img src="https://webster.cs.washington.edu/images/<?= $quality ?>large.png" alt="<?= $quality ?>" /><?= $rate ?>%
	</div>
<?php } 

// read the reviews of the movie, and display them 
function reviews($start, $end, $reviews) {
	for($i = $start; $i < $end; $i ++) {
	$filename = $reviews[$i];	
	list($comment, $quali, $reviewer, $company) = file("$filename", FILE_IGNORE_NEW_LINES);
?>
	<p class="review">
		<img src="https://webster.cs.washington.edu/images/<?= strtolower($quali) ?>.gif" alt="<?= $quali ?>" />
		<q><?= $comment ?></q>
	</p>
	<p class="reviewer">
		<img class="icon" src="https://webster.cs.washington.edu/images/critic.gif" alt="Critic" />
		<?= $reviewer ?> <br />
		<span><?= $company ?></span>
	</p>
	<?php }
} 
?>