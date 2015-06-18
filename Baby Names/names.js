"use strict";
/*
Zhuonan Sun CSE 154 AE, hw8, 8/21/2013
This website is used to display the baby names, their popularity rankings, their meanings,
and celebrities who have the same names as them

This page is java script page, which fetch the data from babynames.php, and control the display 
of the web page
*/

(function() {
// load the page, download names list from babynames.php
// search the information of that name when user clicks "search"
window.addEventListener('load', function() {
	getQuery("list", '', '', fillNames);
	document.getElementById('search').addEventListener('click', search);
});

// clear the information 
// get data from babynames.php, and display meaning, rank, connection with celebrities
// based on what name the user selects
function search() {
	clear();
	var name = document.getElementById('allnames').value;
	if(name != '') {
		var gender = 'm';
		if(!document.getElementById('genderm').checked) {
			gender = 'f';
		}
		document.getElementById('resultsarea').style.display = 'block';
		getQuery("meaning", name, '', fillMeaning);
		getQuery("rank", name, gender, fillRank);
		getQuery("celebs", name, gender, fillCelebs);
	}
}

// get the query and display the information based on the type, name, gender, and function selected
// display error message if there is a browser error
function getQuery(type, name, gender, filldata) {
	var ajax = new XMLHttpRequest();
	ajax.onload = filldata;
	ajax.onerror = ajaxBrowserError;
	var url = 'https://webster.cs.washington.edu/cse154/babynames.php?type=';
	ajax.open('GET', url + type + '&name=' + name + '&gender=' + gender, true);
	ajax.send();
}

// display the celebrities' names and their film counts, who have the same first names
// the user types in, if the status is 200
// else display error message
function fillCelebs() {
	document.getElementById('loadingcelebs').style.display = 'none';
	if(this.status == 200) {
		var celebs = JSON.parse(this.responseText);
		var ul = document.getElementById('celebs');
		for(var i = 0; i < celebs.actors.length; i++) {
			var li = document.createElement('li');
			var actor = celebs.actors[i];
			var count = actor.filmCount;
			li.innerHTML = actor.firstName + ' ' + actor.lastName + ' (' + count + ' films)';
			ul.appendChild(li);
		}
	} else {
		error(this.status);
	}
}

// display the rank of the given name in each year as a graph if the status is 200
// the higher the rank, the taller the bar
// else display error message
function fillRank() {
	document.getElementById('loadinggraph').style.display = "none";
	if(this.status == 200) {
		var ranks = this.responseXML.querySelectorAll("rank");
		var years = document.createElement('tr');
		var bars = document.createElement('tr');
		for(var i = 0; i < ranks.length; i++) {
			var th = document.createElement('th');
			th.innerHTML = parseInt(ranks[i].getAttribute('year'));
			years.appendChild(th);
			
			var td = document.createElement('td');
			var div = document.createElement('div');
			var rank = parseInt(ranks[i].innerHTML);
			div.innerHTML = rank;
			if(rank != 0) {
				div.style.height = "" + Math.floor((1000 - rank) / 4) + "px";
				if(rank <= 10) {
					div.classList.add("red");
				}
			} else {
				div.style.height = "0px";
			}
			td.appendChild(div);
			bars.appendChild(td);
		}
		document.getElementById('graph').appendChild(years);
		document.getElementById('graph').appendChild(bars);
	} else {
		displayLoading('none');
		document.getElementById('norankdata').style.display = "block";
	}
}

// display the meaning of the given name if status is 200
// else display error message
function fillMeaning() {
	document.getElementById('loadingmeaning').style.display = "none";
	if(this.status == 200) {
		var text = this.responseText;
		document.getElementById('meaning').innerHTML = text;
	} else {
		error(this.status);
	}
}

// put all the names as options in the select form if status is 200
// else display error message
function fillNames() {
	document.getElementById('loadingnames').style.display = "none";
	if(this.status == 200) {
		var text = this.responseText;
		var names = text.split('\n');
		var allnames = document.getElementById('allnames');
		for(var i = 0; i < names.length; i++) {
			var name = document.createElement('option');
			name.innerHTML = names[i];
			allnames.appendChild(name);
		}
		document.getElementById('allnames').disabled = false;
	} else {
		error(this.status);
	}
}

// clear the innerHTML of divs that show meaning, graph, celebs, error
// and hide divs of the resultarea and norankdata
// display loadings
function clear() {
	document.getElementById('meaning').innerHTML = '';
	document.getElementById('graph').innerHTML = '';
	document.getElementById('celebs').innerHTML = '';
	document.getElementById('errors').innerHTML = '';
	document.getElementById('resultsarea').style.display = 'none';
	document.getElementById('norankdata').style.display = 'none';
	displayLoading('inline');
}

// display browser error message
function ajaxBrowserError() {
	displayLoading('none');
	document.getElementById('errors').innerHTML = "ERROR, CANNOT CONNECT TO SERVER";
}

// display status error message
function error(status) {
	displayLoading('none');
	var message = "something wrong, THIS IS HTTP " + status + " ERROR";
	document.getElementById('errors').innerHTML = message;
}

// display or hide the loading animation, based on the given parameter
function displayLoading(effect) {
	var loadings = document.querySelectorAll('.loading');
	for(var i = 1; i < loadings.length; i++) {
		loadings[i].style.display = effect;
	}
}
})();