"use strict";
/* Zhuonan Sun CSE154 AE HW6 8/8/2013
This program constructs a webpage which can perform 
different types of animations. You can also change the size of the image
and the speed of the animation.
This is the javascript page, which controls the function of the webpage
*/

// load the window, change the behavior of the animation based on user's choice
(function() {
var images = null; // images set captured from ANIMATION
var count = 0; // counter used to count the step of animation
var timer = null; // timer used to run the animation
var time = 250; // initial time interval of animation, 250 ms
window.addEventListener('load', function() {
	document.getElementById("stop").disabled = true;
	document.getElementById('start').onclick = start;
	document.getElementById('stop').onclick = stop;
	document.getElementById("animation").onchange = put;
	document.getElementById("size").onchange = sizechange;
	document.getElementById("turbo").onclick = speedchange;
	document.getElementById("normal").onclick = speedchange;
	document.getElementById("slo-mo").onclick = speedchange;
});

// when start button pressed, enable stop button and disable start button
// capture the images in textarea
// set up the timer and run the animation
function start() {
	disable();
	images = document.getElementById("mytextarea").value.split("=====\n");
	timer = setInterval(run, time);	
}

// put images from ANIMATIONS in textarea 
function put() {
	var which = this.value;
	document.getElementById("mytextarea").value = ANIMATIONS[which];
}

// change the size of images in textarea
function sizechange() {
	document.getElementById("mytextarea").style.fontSize = this.value;
}

// get time interval based on what speed the user selects
// if start is disabled, clear and reset the timer and run the animation
function speedchange() {
	time = this.value;
	if(document.getElementById("start").disabled) {
		clearInterval(timer);
		timer = setInterval(run, time);
	}
}

// run the animation indefinitely if there are images existing
function run() {
	if(images) {
		document.getElementById("mytextarea").value = images[count];
		count++;
		if(count == images.length) {
			count = 0;
		}
	}
}

// stop the animation, the text that was in the box
// prior to the start of animation will be returned to the box
function stop() {
	disable();
	clearInterval(timer);
	count = 0;
	document.getElementById("mytextarea").value = images.join("=====\n");
}

// if stop button is disabled 
// disable start button and animation droplist, and enable stop button
// otherwise enable start button and animation droplist, and disable stop button 
function disable() {
	if(document.getElementById("stop").disabled) {
		document.getElementById("start").disabled = true;
		document.getElementById("stop").disabled = false;
		document.getElementById("animation").disabled = true;
	} else {
		document.getElementById("stop").disabled = true;
		document.getElementById("start").disabled = false;
		document.getElementById("animation").disabled = false;
	}
}
})();