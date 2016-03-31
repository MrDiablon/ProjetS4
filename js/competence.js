function getSousComp(c){
	var id =c.value;
//console.log(c.value);
	var request = new Request({
		url: 'getSouscompetence.php',
		method: 'get',
		parameters: {'id' : id},
		handleAs   : 'json',
		onSuccess: function(res){
//console.log(res);
			var select = $("#sousCompetence");
			select.children().remove();
			$("#sousCompetenceLabel").css("display", "block");
			$(res).each(function(index){
				var option = $("<option>");
				option.val(this.id).text(this.libelle);
				select.append(option);
			});
			select.css("display","block");
			var btnAjout = $("#btnAjoutCompetence");
			btnAjout.css("display","block");
		},
		onError: function(error){
			//console.log(error);
		}
	});
}

function ajoutCompt(){
	var select = $("#sousCompetence option:selected");
	var ajout = $("#comptSelect");
	var option = $("<option>");
//console.log(select.val(),select.text());
	option.val(select.val()).text(select.text());
	ajout.append(option);
console.log(ajout);
}