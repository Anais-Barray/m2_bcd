document.addEventListener('DomContentLoaded',function(){

//####################################################################################################################

	function build_html (msg){
	//TODO
	}
	
//####################################################################################################################

	function refresh(){
	
		var request = new XMLHttpRequest();

		//Quand on a recupere les donnees du webservice (Quand la request est retournee) => la fct est exec.
		request.addEventListener("load", function(data) { //data est le resultat de la requete
			console.log(data);
			var ret = JSON.parse($data.target.responseText); //donnees envoyees par le WS
			var new_html = '';
			for (var i=0; i < ret.msgs.length; i++){
				new_html += built_html(ret.msgs[i]);
			}
			document.querySelector(#messages").innerHTML = new-html;
		
		});
	
	
		request.open("GET", "php/get_latest_msg_new.php");
		request.send(); //en deux parties : d'abord open, puis send.

	

	}
	
	setInterval(refresh, 5000);
	
//####################################################################################################################
	
	
	var form = document.getElementById('msg-form');
	
	form.addEventListener("submit", function(event) {
		//TODO
		
		request.open("POST", "php/add_msg_new.php");
		request.send(new FormData(form)); //envoie des donnees
	
	}

});
