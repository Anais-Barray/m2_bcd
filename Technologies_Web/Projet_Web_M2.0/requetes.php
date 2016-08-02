<?php
	include("html/head.html");
?>

<!--PAGE D'AFFICHAGE DYNAMIQUE ET REQUETES DE RECHERCHE, D'AJOUT ET SUPPRESSION DANS LA BDD-->
	<button type="button" name="Afficher" id="Afficher" class="btn btn-sm btn-primary">
		Afficher la liste
	</button>   
	
	<button type="button" name="Ajouter" id="Ajouter" class="btn btn-sm btn-primary" onclick="toggle_visibility('formulaireAjout');toggle_visibility('formulaireRecherche');">
		Ajouter un lieu
	</button>

   <form id="formulaireAjout" class="tog formulaireAjout">
	   <ul class="ul_formAj">
        <li><label for = "nom" class="control-label" >Nom :</label>
        <input type="text" id="nom" name="nom" value='Gibert joseph'></li>
        <li><label for = "type" class="control-label">Type :</label>
        <input type="text" id="type" name="type" value='BD-livres-Mangas'> </li>
        <li><label for = "latitude" class="control-label">Latitude :</label>
        <input type="text" id="latitude" name="latitude" value='43.609653'></li>
        <li><label for = "longitude" class="control-label">Longitude :</label>
        <input type="text" id="longitude" name="longitude" value='3.876125'></li>
        <li><label for = "horaires" class="control-label">Horaires :</label>
        <input type="text" id="horaires" name="horaires" value='19h'>      </li>
        <li><label for = "date_recensement" class="control-label">Date de recensement :</label>
        <input type="text" id="date_recensement" name="date_recensement" value='2015-12-09'> </li>
        <li><label for = "photo" class="control-label">Photo :</label>
        <input type="url" id="photo" name="photo" value='http://toutelaculture.com/wp-content/uploads/2013/10/publi_gibert_004.jpg'> </li>
        <li><label for = "nom_participant" class="control-label">Nom participant :</label>
        <input type="text" id="nom_participant" name="nom_participant" value='Chouet'></li>
        <li><label for = "prenom_participant" class="control-label">Prenom participant :</label>
        <input type="text" id="prenom_participant" name="prenom_participant" value='Mathias'> </li>
        <li><label for = "commentaire :" class="control-label">Commentaires :</label>
        <textarea rows="3" id="commentaire" class="commentaire" name="commentaire" value='Livres et BD Occasions'>Lieu convivial</textarea></li>
		<li><button type="button" name="ajout" id="ajout" class="btn btn-sm btn-primary btn-ajout">Ajouter !</button></li>
	   </ul>
    </form> 
		
	<form id='formulaireRecherche'  style="display:block">
		<label for = 'motif'>Entrez le terme recherché :</label>
		<input type="text" id="motif" name="motif">
		<button type="button" name="Recherche" id="Recherche" class="btn btn-sm btn-primary">Chercher !</button>
	</form>
	
	<!-- On prépare le div pour insérer le tableau : -->
	<div id='div_liste' class='div_liste' style="display:block">
	</div>
	
<?php
	include("html/foot.html");
?>

