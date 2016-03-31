function getSousComp(c){
	var id =c.value;
	console.log(c.value);
	var request = new Request({
		url: 'getSouscompetence.php',
		method: 'get',
		parameters: {'id' : id},
		handleAs   : 'json',
		onSuccess: function(res){
console.log(res);
			var select = $("#sousCompetence");
			select.children().remove();
			$("#sousCompetenceLabel").css("display", "block");
			$(res).each(function(index){
				var option = $("<option>");
				option.val(this.id).text(this.libelle);
				select.append(option);
			});
			select.css("display","block");
		},
		onError: function(error){
			console.log(error);
		}
	});
}

function ajoutCompt(){
	var select = $("#sousCompetence");
	var ajout = $("#comptSelect");
}