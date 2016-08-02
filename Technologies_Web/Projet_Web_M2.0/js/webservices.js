//////////////////////////////////////////////////////////////////
////////////////////////// WEBSERVICES ////////////////////////// 
////////////////////////////////////////////////////////////////

// On attend que la page soit chargee
document.addEventListener('DOMContentLoaded', function () {
	rechercheliste();

    //AFFICHER
    var bouton_afficher = document.getElementById('Afficher');
    if (bouton_afficher != null) {
        bouton_afficher.addEventListener("click", function() {
            document.getElementById('motif').value = '';
			rechercheliste()});
    }  
    
    //RECHERCHER
    var bouton_recherche = document.getElementById('Recherche');
    if (bouton_recherche != null) {
        bouton_recherche.addEventListener("click", function() {rechercheliste()});
    }
    
    // AJOUTER
    var bouton_ajout = document.getElementById('ajout');
    if (bouton_ajout != null) {
        bouton_ajout.addEventListener("click", function() {
            // On prepare une requête AJAX
            var requeteAjout = new XMLHttpRequest();
            var formAjout = document.getElementById('formulaireAjout');
            document.getElementById('motif').value = ''
            requeteAjout.addEventListener('load', function(data) {rechercheliste()});
            requeteAjout.open("POST", "php/add.php");
			requeteAjout.send(new FormData(formAjout));

            //~ toggle_visibility('formulaireAjout');
            toggle_visibility('formulaireRecherche');
        });
    }
    
    //LOGIN
    var bouton_login = document.getElementById('login');
    if (bouton_login != null) {
        bouton_login.addEventListener("click", function() {
			var currentLocation = window.location.pathname;
            // On prepare une requête AJAX
            var request_login = new XMLHttpRequest();
            var form_login = document.getElementById('loginform');
            request_login.addEventListener('load', function(data) {
				//console.log(JSON.parse(data.target.responseText))
				var donnees = JSON.parse(data.target.responseText);
				console.log(donnees);
				if (donnees.status == "success"){
					window.location = currentLocation;
				} else {
					p_error = document.getElementById('notif_error');
					p_error.innerHTML = donnees.message;
					p_error.style.display = "block";
				}
            });
            // On envoie la requête avec la methode POST (car on transmet des donnees)
            request_login.open("POST", "php/login.php");
            request_login.send(new FormData(form_login));
        });
    }    
        
    //LOGOUT
    var bouton_logout = document.getElementById('logout');
    if (bouton_logout != null) {
        bouton_logout.addEventListener("click", function() {
			var currentLocation = window.location.pathname;
            //console.log(pageCourante);
            // On prepare une requête AJAX
            var request_logout = new XMLHttpRequest();
            var form_logout = document.getElementById('logoutform');
            request_logout.addEventListener('load', function() {
                window.location = currentLocation;
            });
            // On envoie la requête avec la methode GET
            request_logout.open("POST", "php/logout.php");
            request_logout.send(new FormData());
        });
    }    

})

////////////////////////////////////////////////////////////////
////////////////////////// FUNCTIONS ////////////////////////// 
//////////////////////////////////////////////////////////////

function toggle_visibility(id) {
    var e = document.getElementById(id);
    if(e.style.display == 'block')
        e.style.display = 'none';
    else
        e.style.display = 'block';
}


function rechercheliste () {
    // On prepare une requête AJAX
    var request = new XMLHttpRequest();
    // On definit ce qu'elle fera lorsqu'elle aura reçu une reponse : 
    // parse le Json et l'affiche
    var formRech = document.getElementById('formulaireRecherche');
    request.addEventListener('load', function(data) {afficherListe(data)});
    
    // ... et ce qu'elle fera en cas d'erreur
    request.addEventListener('error', function(data) {
        // On affiche une erreur
        console.log('error', data);
    });

    // On envoie la requête avec la methode POST (car on transmet des donnees)
    request.open("POST", "php/search.php");
    request.send(new FormData(formRech));
}



function afficherListe(data) {
    var donnees = JSON.parse(data.target.responseText);
    console.log(data);
    var motif=document.getElementById("motif").value;
    //donnees est un tableau de tableaux associatifs
    // on initialise le tableau : 
    var tableau = '<table class="table table-responsive bordered-table table-striped table-petit">';
    tableau +=    '<thead>' ;
    tableau +=    '<tr>' ;
    
    //on met les entetes dans thead :
    var j=0;
    for (var entete in donnees[0]) {
        tableau += '<th class="capit"><div class="col-' + j + '"><center>' + entete.replace("_", " ") + '</center></div></th>';
        j = j + 1;

    }
    tableau +=    '</tr></thead>' ;
    // on passe au tbody avec les valeurs de donnees : comme pour afficher.php :
    tableau +=    '<tbody>' ;
    
    //pour chaque enregistrement dans la base de donnees on fait une ligne de tableau :
    for (var i = 0; i < donnees.length; i++) {
        tableau +=    '<tr>' ;
        // on teste si c'est la colonne photo alors on affiche la photo et non l'adresse
        j=0;
        for (var entree in donnees[i]) {
            if (entree == 'photo') {
                tableau += '<td><img src="' + donnees[i][entree] + '" width="150px"/></td>';
            } else {
                var texte=donnees[i][entree];
                // on recherche le motif
                var pos = texte.search(new RegExp(motif, "i"));
                // Si on le trouve, on l'entoure de spans avec la classe rouge
                if (pos > -1) {
                    var newTexte=texte.slice(0, pos) + '<span class="rouge">' + texte.slice(pos, pos + motif.length) + '</span>' +  texte.slice(pos + motif.length, texte.length);
                    tableau += '<td class="capit"><div class="col-' + j + '">' + newTexte + '</div></td>';
                } else {
                    tableau += '<td class="capit"><div class="col-' + j + '">' + texte + '</div></td>';
                }
            }
            j = j + 1;
        }
        //<input type="image" src="submit.gif" alt="Submit" width="48" height="48">
        tableau += '<td><input type="image" src="images/Supprimer.png" alt="Supprimer" name="supprimer" id="supprimer"'+ donnees[i]['id']+'" data-id="'+ donnees[i]['id'] +'"></td>';
        tableau +=    '</tr>' ;
    }
    // On pose le code html genere dans le div prepare dans requetes.php
    document.getElementById('div_liste').innerHTML = tableau;
    
    // Si le code de retour est "erreur du serveur"
    if (data.target.status == 500) {
        // popup erreur 
        alert("Probleme lors de la recherche");
    } 
    
    supprimerElement();
}


function supprimerElement() {
    var listeBoutonSupprimer = document.getElementsByName('supprimer');
    if (listeBoutonSupprimer != null) {
		var arrayLength = listeBoutonSupprimer.length;
		for (var i = 0; i < arrayLength; i++) {
			bouton = listeBoutonSupprimer[i];
			dataId = bouton.getAttribute("data-id");
			console.log(dataId);
			bouton.addEventListener("click", function() {
                //console.log("click ");
	            var requeteSuppression = new XMLHttpRequest();
	            requeteSuppression.addEventListener('load', function(data) {rechercheliste()});
	            requeteSuppression.open("POST", "php/remove.php");
	            requeteSuppression.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	            var logState=document.getElementsByClassName("logform");
                console.log("login " + logState[0].id);
                if (logState[0].id != 'logoutform') {
                    alert ("Il faut être connecté(e) pour supprimer un lieu");
                } else { 
					var x = confirmDelete();
					if (x) {requeteSuppression.send("dataId="+dataId);}
				}
			});
		}
    }
}

function confirmDelete(){
  var x = confirm("Êtes vous sûr(e) de vouloir supprimer ce lieu ?");
  if (x)
      return true;
  else
    return false;
}

