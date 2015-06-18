<!--
Zhuonan Sun 7/24/2013 HW4 SECTION AE
This website is a fictional online dating site for desparate single geeks, call "NerdLuv"
This is common.php, which contains all the functions 

header, including DOCTYPE, and logo 
-->
<?php function head() { ?>
	<!DOCTYPE html>
	<html>		
		<head>
			<title>NerdLuv</title>
			
			<meta charset="utf-8" />
			
			<!-- instructor-provided CSS and JavaScript links; do not modify -->
			<link href="https://webster.cs.washington.edu/images/nerdluv/heart.gif" type="image/gif" rel="shortcut icon" />
			<link href="https://webster.cs.washington.edu/css/nerdluv.css" type="text/css" rel="stylesheet" />
			
			<script src="http://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js" type="text/javascript"></script>
			<script src="https://webster.cs.washington.edu/js/nerdluv/provided.js" type="text/javascript"></script>
		</head>

		<body>
			<div id="bannerarea">
				<img src="https://webster.cs.washington.edu/images/nerdluv/nerdluv.png" alt="banner logo" /> <br />
				where meek geeks meet
			</div>
<?php } 

// footer, which contains notes and validations 
function foot() { ?>
		<div>
			<p>
				This page is for single nerds to meet and date each other!  Type in your personal information and wait for the nerdly luv to begin!  Thank you for using our site.
			</p>
			
			<p>
				Results and page (C) Copyright NerdLuv Inc.
			</p>
			
			<ul>
				<li>
					<a href="home.php">
						<img src="https://webster.cs.washington.edu/images/nerdluv/back.gif" alt="icon" />
						Back to front page
					</a>
				</li>
			</ul>
		</div>

		<div id="w3c">
			<a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML" /></a>
			<a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
		</div>
	</body>
</html>
<?php } 

// print "invalid data" message
function invalid() {
?>
	<p><strong>Error! Invalid data.</strong></p>
	<p>We're sorry. You submitted invalid user information. Please go back and try again.</p>
<?php 
}

// check if age, min and max are valid
function check_ages($age, $min, $max) {
	$regex = "/^[1-9]?\d?$/";
	return preg_match($regex, $age) && preg_match($regex, $min) && preg_match($regex, $max) 
	&& $max >= $min;
}

// check if name typed in is valid
function check_name($name) {
	return preg_match("/\S+/", $name);
}

// search the person from the file base on the give name.
// info[0] is the user name
// if name is found, return the array containing the person's information
// otherwise return "";
function search_name($text, $name) {
	foreach ($text as $line) { 
		$info = explode(",", $line);
		if($name == $info[0]) {
			return explode(",", $line);
		}
	}
	return "";
}
?>