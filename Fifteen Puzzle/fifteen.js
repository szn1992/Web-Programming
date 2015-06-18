"use strict";
/*
Zhuonan Sun CSE 154AE HW7 8/16/2013
This webpage is a simple classic game consisting of 4*4 grid of numbered squares with 
one square missing. Its "shuffle" button can construct more challenging game for the user
This is the JavaScript page, which controls the functions of the game
*/

(function() {
var emptyX = 300; // x coordinate of upper left corner of the empty square
var emptyY = 300; // y coordinate of upper left corner of the empty square

// load the window, build the initial pattern of the puzzle
// shuffle the puzzle if 'shuffle' button is clicked
window.addEventListener("load", function() {
	buildPuzzle();
	document.getElementById('shufflebutton').addEventListener('click', shuffle);
});

// build the puzzle of 15 squares with numbers and a pikachu background
// react if the user click the square, or move the mouse
function buildPuzzle() {
	var x = 0;
	var y = 0;
	for(var i = 1; i < 16; i++) {
		var rect = document.createElement('div');
		rect.innerHTML = i;
		rect.classList.add('rect');
		rect.addEventListener("click", moveRect);
		rect.addEventListener('mouseover', mouseMove);
		rect.addEventListener('mouseout', mouseMove);
		rect.style.top = y + 'px';
		rect.style.left = x + 'px';
		rect.style.backgroundPosition = "-" + x + "px -" + y + "px";
		rect.id = x + "-" + y;
		x += 100;
		if(x == 400) {
			x = 0;
			y += 100;
		}
		document.getElementById('puzzlearea').appendChild(rect);
	}
}

// move the square if it is one top, bottom, left, or right of the empty square
function moveRect() {
	var x = parseInt(this.style.left);
	var y = parseInt(this.style.top);
	if((x == emptyX && (y == emptyY + 100 || y == emptyY - 100))
	||(y == emptyY && (x == emptyX + 100 || x == emptyX - 100))) {
		moveHelper(x, y);
	}
}	

// border and text color turn red and mouse cursor change into "hand" shape 
// if the mouse hovers over a square that can be moved
// return to normal state if the mouse move out of that square
function mouseMove() {
	var x = parseInt(this.style.left);
	var y = parseInt(this.style.top);
	if((x == emptyX && (y == emptyY + 100 || y == emptyY - 100)) 
	|| (y == emptyY && (x == emptyX + 100 || x == emptyX - 100))) {
		this.classList.toggle('special');
	} 
}

// shuffle the squares in the puzzle area using the algorithm:
// about ~1000 times:
// neighbors = an empty array.
// if there exists a piece directly up from the empty square: add it to the neighbors array
// (repeat for the pieces down, left, and right of the empty square.)
// randomly choose a neighbor n from neighbors
// move n to the location of the empty square
// xy[0] is the x coordinate of the randomly selected square, xy[1] is the y coordinate
function shuffle() {
	for(var i = 0; i < 1000; i++) {
		var neighbors = [];
		if(emptyY > 0) {
			neighbors.push(emptyX + "-" + (emptyY - 100));
		}
		if(emptyY < 300) {
			neighbors.push(emptyX + "-" + (emptyY + 100));
		}
		if(emptyX > 0) {
			neighbors.push(emptyX - 100 + "-" + emptyY);
		}
		if(emptyX < 300) {
			neighbors.push(emptyX + 100 + "-" + emptyY);
		}
		var rand = Math.floor(Math.random() * neighbors.length);
		var xy = neighbors[rand].split("-");
		moveHelper(parseInt(xy[0]), parseInt(xy[1]));
	}
}

// helper function for moving the movable square to the empty square
function moveHelper(x, y) {
	var rect = document.getElementById(x + "-" + y)
	rect.id = emptyX + "-" + emptyY;
	rect.style.top = emptyY + "px";
	rect.style.left = emptyX + "px"; 
	emptyY = y;
	emptyX = x;
}
})();