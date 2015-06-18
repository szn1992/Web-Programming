<!--
Zhuonan Sun 7/24/2013 HW4 SECTION AE
This website is a fictional online dating site for desparate single geeks, call "NerdLuv"
This is matches page, where user can type in his or her name to find matches.  
-->

<?php 
// header
include("common.php");
head();
?>

<form action="matches-submit.php" method="get">
	<fieldset>
		<legend>Returning User:</legend>
		<div>
			<strong>Name:</strong>
			<input type="text" name="name" size="16" />
		</div>
		
		<div>
			<input type="submit" value="View My Matches" />
		</div>
	</fieldset>
</form>

<?php 
// footer
foot(); 
?>