<!--
Zhuonan Sun 7/24/2013 HW4 SECTION AE
This website is a fictional online dating site for desparate single geeks, call "NerdLuv"
This is signup-submit page, validating the user's information.  
-->

<?php 
// retrieve user information from signup page and singles.txt 
$name = $_POST["name"];
$age = $_POST["age"];
$gender = $_POST["gender"];
$personality = $_POST["personality"];
$os = $_POST["os"];
$min = $_POST["min"];
$max = $_POST["max"];
$text = file("singles.txt");

// header
include("common.php");
head();

// validate user's information
// print error message if the information is invalid or the user name already exists in singles.txt
// otherwise put the new user information in singles.txt, and print welcome message
if(!check_name($name) || !preg_match("/^[IE][NS][FT][JP]$/", $personality) 
|| !check_ages($age, $min, $max) || !preg_match("/^[MF]$/", $gender) 
|| !preg_match("/^Windows$|^Mac OS X$|^Linux$/", $os) || search_name($text, $name) != "") {
	invalid();
} else { 
	$text = implode(",", $_POST) . "\n" ;
	file_put_contents("singles.txt", $text, FILE_APPEND);
?>
	<p><strong>Thank you!</strong></p>
	<p>Welcome to NerdLuv, <?= $name ?>!</p>
	<p>
		Now
		<a href="matches.php">
			log in to see your matches!
		</a>
	</p>
<?php 
}

// footer
foot(); 
?>