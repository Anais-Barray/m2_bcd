// on définit une fonction qui place l'heure courante dans la balise ayant l'id "heure"
function afficherHeure() {
	var emplacement = document.getElementById('heure');
	var d = new Date();
	//alert(d.toLocaleString());
	// Attention au nom de la propriété : innerHTML (les majuscules sont importantes !)
	emplacement.innerHTML = d.toLocaleString();
}
// on l'appelle une première fois au chargement de la page
afficherHeure();
// on l'appelle ensuite une fois par seconde
setInterval(afficherHeure, 1000);
