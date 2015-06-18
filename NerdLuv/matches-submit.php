<!--
Zhuonan Sun 7/24/2013 HW4 SECTION AE
This website is a fictional online dating site for desparate single geeks, call "NerdLuv"
This is matches-submit page, validating the user's name and find matches for him or her.  
-->

<?php 
// retrieve user's name from matches page and all information from singles.txt
$username = $_GET["name"];
$text = file("singles.txt");

// header
include("common.php");
head();

// print error message if user name is invalid or user name does not exist in singles.txt
// otherwise retrieve the user's information and find matches based on that
if(!check_name($username) || search_name($text, $username) == "") {
	invalid();
} else {
?>
	<p><strong>Matches for <?= $username ?></strong></p>
	<?php 
	list($name, $gender, $age, $personality, $os, $min, $max) = search_name($text, $username);
	
	// find matches, if there is, then print them out
	foreach ($text as $line) {
		list($name2, $gender2, $age2, $personality2, $os2, $min2, $max2) = explode(",", $line);
		if($gender != $gender2 && $os == $os2 
		&& $age <= $max2 && $age >= $min2 && $age2 <= $max && $age2 >= $min 
		&& similar_text($personality, $personality2) > 0) {
?>
			<div class="match">
				<p>
				<img src="http://webster.cs.washington.edu/images/nerdluv/user.jpg" alt="user" />
				<?= $name2 ?>
				</p>
				
				<ul>
					<li><strong>gender:</strong> <?= $gender2 ?> </li>
					<li><strong>age:</strong> <?= $age2 ?> </li>
					<li><strong>type:</strong> <?= $personality2 ?> </li>
					<li><strong>OS:</strong> <?= $os2 ?> </li>
				</ul>
			</div>
<?php		
		}
	}
} 

// footer
foot(); 
?>