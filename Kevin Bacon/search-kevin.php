<!-- 
	Zhuonan Sun, Section AE, HW5
	This site can show the movies in which another actor has appeared with Kevin Bacon,
	and it can also show a list of all movies in which the other actor has appeared
	
	This is the page showing search results for all films with the given actor and Kevin Bacon
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
	// else search all the movies both the given actor and Kevin Bacon appeared, based on the id
	if($rows->rowcount() == 0) {
		error($firstname, $lastname);
	} else {
	
		// search names and years of movies where both the given actor and Kevin Bacon appear
		$query = "SELECT name, year
				FROM movies m
				JOIN roles a1 ON m.id = a1.movie_id
				JOIN roles b1 ON m.id = b1.movie_id
				JOIN actors a2 ON a2.id = a1.actor_id
				JOIN actors b2 ON b2.id = b1.actor_id
				WHERE a2.last_name = 'Bacon'
					AND a2.first_name = 'Kevin'
					AND b2.id = :id
				ORDER BY year DESC;";
	
		$rows = getmovies($db, $rows, $query);
		
		// construct a table of all the movies found
		result($firstname, $lastname, "kevin", $rows);
	}
	
	// footer
	foot();
?>
