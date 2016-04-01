function crypterMdp(f){

	if(f.mdp.value.length){
		f.mdp.value = SHA1(f.mdp.value);
		f.mdp2.value = "";
	}
	/*var mdp = $("#mdp");
	mdp.val(SHA1(mdp.val()));
	$("#mdp2").val("")
console.log(mdp.val());*/
}

function verifPass(){
//console.log(document.getElementById("mdp2").value);
	var mpd = document.getElementById("mdp");
	var mpd2 = document.getElementById("mdp2");
	var regex = new RegExp("^[A-Za-z0-9]{6,25}$");
//console.log(regex.test(mpd.value),regex.test(mdp2.value));
	if(regex.test(mpd.value) || regex.test(mdp2.value)){
//console.log(regex.test(mpd.value),regex.test(mdp2.value));
		$("#mdp").removeAttr("data-toggle", "tooltip").removeAttr("data-placement","right")
				 .removeAttr("title","").css("borderColor" , "white");
		$("#mdp2").removeAttr("data-toggle", "tooltip").removeAttr("data-placement","right")
				 .removeAttr("title","").css("borderColor" , "white");
		if(mpd.value == mpd2.value){
			mpd2.style.borderColor = "green";
			mpd.style.borderColor = "green";
		}else{
			mpd2.style.borderColor = "red";
			mpd.style.borderColor = "red";
		}
	}else{
//console.log($("input#mpd").value());

			$("#mdp").attr("data-toggle", "tooltip").attr("data-placement","right")
				 .attr("title","Le mots de passe doit être compris entre 6 et 25 caracteres et peut avoirs des chiffres").tooltip().css({"borderColor" : "red"});
			$("#mdp2").attr("data-toggle", "tooltip").attr("data-placement","right")
				 .attr("title","Le mots de passe doit être compris entre 6 et 25 caracteres et peut avoirs des chiffres").tooltip().css({"borderColor" : "red"});
		
	}
}

function getVille(c){
	var id = c.value;
	var request = new Request({
		url: "getVilleList.php",
		method: 'get',
		parameters: {'id' : id},
		handleAs   : 'json',
		onSuccess: function(res){
			var select = $("#ville_id");
			select.children().remove();
			$('#villeLabel').css("display", "block");
			$(res).each(function(index){
//console.log(select);
				var option = $("<option>")
				option.val(this.id).text(this.ville);
				select.append(option);
			})
			select.css("display", "block");
		}
	});
}

function afficheMessage(message,redir){
	alert(message);
	if(redir){
		window.location.replace("index.php");
	}
}