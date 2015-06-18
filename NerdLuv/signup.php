<!--
Zhuonan Sun 7/24/2013 HW4 SECTION AE
This website is a fictional online dating site for desparate single geeks, call "NerdLuv"
This is signup page, providing form where user can type in his or her information 
-->

<?php 
// header
include("common.php");
head();
?>

<form action="signup-submit.php" method="post">
	<fieldset>
		<legend>New User Signup:</legend>
		<div><strong>Name:</strong>  
			<input type="text" name="name" size="16" /> 
		</div>
		
		<div><strong>Gender:</strong>
			<label><input type="radio" name="gender" value="M" /> Male</label>
			<label><input type="radio" name="gender" value="F" checked="checked" /> Female</label>
		</div>
		
		<div><strong>Age:</strong>
			<input type="text" name="age" size="6" />
		</div>
		
		<div><strong>Personality type:</strong>
			<input type="text" name="personality" size="6" />
			(<a href="http://www.humanmetrics.com/cgi-win/JTypes2.asp">Don't know your type?</a>)
		</div>
		
		<div><strong>Favorite OS:</strong>
			<select name="os">
				<option selected="selected">Windows</option>
				<option>Mac OS X</option>
				<option>Linux</option>
			</select>
		</div>
		
		<div><strong>Seeking age:</strong>
			<input type="text" name="min" size="6" placeholder="min"> to
			<input type="text" name="max" size="6" placeholder="max">
		</div>
		
		<div>
			<input type="submit" value="Sign Up">
		</div>
	</fieldset>
</form>

<?php 
// footer
foot(); 
?>