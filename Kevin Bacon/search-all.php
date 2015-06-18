<!-- 
	Zhuonan Sun, Section AE, HW5
	This site can show the movies in which another actor has appeared with Kevin Bacon,
	and it can also show a list of all movies in which the other actor has appeared
	
	This is the page showing search results for all films by a given actor
-->

<?php
	// get first and last names
	$firstname = $_GET['firstname'];
	$lastname = $_GET['lastname'];
	
	// header
	include("common.php");
	head();
	
	// search the id of the actor in database
	$db = new PDO("mysql:dbname=imdb;host=localhost", "szn1992", "9TfGUd9tAGeLy");
	$rows = getid($db, $firstname, $lastname);
	
	// show error message if the id is not found
	// else search all the movies based on the id
	if($rows->rowcount() == 0) {
		error($firstname, $lastname);
	} else {
	
		// search names and years of the movies where the given actor appears
		$query = 'SELECT name, year
				FROM movies
				JOIN roles ON movies.id = movie_id
				WHERE actor_id = :id
				ORDER BY year DESC, name ASC';
		
		$rows = getmovies($db, $rows, $query);
		
		// construct a table of all the movies found
		result($firstname, $lastname, "all", $rows);
	}
	
	// footer
	foot();
?>