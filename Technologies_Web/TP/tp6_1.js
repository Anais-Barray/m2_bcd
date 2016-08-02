document.addEventListener('DOMContentLoaded', function() { //execute le code js que quand le document est charge

	var myinterval = setInterval(function(){
	
		var d = new Date();
		var s = d.toLocaleString();
		console.log(s)

		var mondiv = document.getElementById('datediv');
		mondiv.innerHTML = s;
		
	}, 1000); //toutes les secondes, le code modifie le HTMl, pas de rechargement.
	
/*
	var startbutton = document.getElementById('start');
	startbutton.addEventListener('click', function() {
		//TODO
	});
	
	var stopbutton = document.getElementById('stop');
	stopbutton.addEventListener('click', function() {
		clearInterval(myinterval);
	});
	
	var resetbutton = document.getElementById('reset');
	resetbutton.addEventListener('click', function() {
		//TODO
	});
*/

		
});


var timer;

function decremente() {
	var champ = document.getElementById('compteur');
	var time = champ.value;
	console.log(time + ' : ' + typeof time);
	var secondesEntieres = parseInt(time);
	console.log(secondesEntieres + ' : ' + typeof secondesEntieres);
	// decrementation jusqu'a zero
	if (secondesEntieres > 0) {
		secondesEntieres--;
		champ.value = secondesEntieres;
	}
	if (secondesEntieres == 0) {
		// on a atteint zero : affichage du message
		var message = document.getElementById('message');
		message.style.display = 'block';
		// on arrete le timer pour ne pas tourner en boucle
		stop();
	}
}

function start() {
	console.log("start !");
	timer = setInterval(decremente, 1000); // puis une fois par seconde
}

function stop() {
	console.log("stop !");
	clearInterval(timer);
}

function reset() {
	console.log("reset !");
	var message = document.getElementById('message');
	message.style.display = 'none';
	var champcompt = document.getElementById('compteur');

}
