<!-- 
	Zhuonan Sun, Section AE, HW5
	This site can show the movies in which another actor has appeared with Kevin Bacon,
	and it can also show a list of all movies in which the other actor has appeared
	
	This is the page that includes any common code that is shared between pages
-->


<?php 
// header, including DOCTYPE, head, and first part of body
function head() { 
?>
	<!DOCTYPE html>
	<html>
		<head>
			<title>My Movie Database (MyMDb)</title>
			<meta charset="utf-8" />
			
			<link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" type="image/png" rel="shortcut icon" />
			<script src="https://webster.cs.washington.edu/js/kevinbacon/provided.js" type="text/javascript"></script>

			<link href="bacon.css" type="text/css" rel="stylesheet" />
		</head>

		<body>
			<div id="frame">
				<div id="banner">
					<a href="mymdb.php"><img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" alt="banner logo" /></a>
					My Movie Database
				</div>
				
				<div id="main">
<?php 
} 

// footer, including last part of body with forms and validation
function foot() {
?>
			<!-- form to search for every movie by a given actor -->
				<form action="search-all.php" method="get">
					<fieldset>
						<legend>All movies</legend>
						<div>
							<input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" /> 
							<input name="lastname" type="text" size="12" placeholder="last name" /> 
							<input type="submit" value="go" />
						</div>
					</fieldset>
				</form>

				<!-- form to search for movies where a given actor was with Kevin Bacon -->
				<form action="search-kevin.php" method="get">
					<fieldset>
						<legend>Movies with Kevin Bacon</legend>
						<div>
							<input name="firstname" type="text" size="12" placeholder="first name" /> 
							<input name="lastname" type="text" size="12" placeholder="last name" /> 
							<input type="submit" value="go" />
						</div>
					</fieldset>
				</form>
			</div> <!-- end of #main div -->
	
			<div id="w3c">
				<a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" /></a>
				<a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
			</div>
		</div> <!-- end of #frame div -->
	</body>
</html>
<?php
}

// search the id in the database based on the first and last name of the actor
// return the results found
function getid($db, $firstname, $lastname) {	
	// search id of the actor whose first and last name equal to the condition given
	$query = "SELECT id
			FROM actors
			WHERE last_name = :lastname
				AND first_name LIKE :firstname
			ORDER BY film_count DESC, id
			LIMIT 1;";
	$rows = $db->prepare($query);
	$rows->execute(array(
		':firstname' => $firstname. '%',
		':lastname' => $lastname
	));
	
	return $rows;
}

// search all the movies based on the given id and query
// return the result found
function getmovies($db, $rows, $query) {
	$row = $rows->fetch();
	$id = $row["id"];
	$rows = $db->prepare($query);
	$rows->execute(array(':id'=> $id));
	
	return $rows;
}

// print error message
function error($firstname, $lastname) {
?>
	<h1><?= $firstname . " " . $lastname ?> not found</h1> 
<?php } 

// print the result base on the first and last name of the actor, and all the movies found
// print "Film with ... and Kevin Bacon" if search equals "kevin"
// else print "All films"
function result($firstname, $lastname, $search, $rows) {
	$count = 1;
?>
	<h1>Result for <?= $firstname . " " . $lastname ?></h1>
	<div>
		<table>
			<caption>
			<?php if ($search == "kevin") { ?>
				Films with <?= $firstname . " " . $lastname ?> and Kevin Bacon
			<?php } else { ?>
				All films
			<?php } ?>
			</caption>
			<tr>
				<th>#</th>
				<th>Title</th>
				<th>Year</th>
			</tr>
	<?php foreach($rows as $row) { ?>
			<tr>
				<td><?= $count ?></td>
				<td><?= $row["name"] ?></td>
				<td><?= $row["year"] ?></td>
			</tr>
	<?php 
			$count ++;
		} 
	?>
		</table>
	</div>
<?php
}
?>