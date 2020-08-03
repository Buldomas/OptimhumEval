$("#add-question").click(function () {
	// récupére les numéros de champs
	const index = +$("#widgets-counter").val();
	// récupère le prototype des entry
	const tmpl = $("#formation_qFormations")
		.data("prototype")
		.replace(/__name__/g, index);
	// injection du code dans la div
	$("#formation_qFormations").append(tmpl);
	$("#widgets-counter").val(index + 1);
	// je gère le boutton supprimer
	handleDeleteButtons();
});

function handleDeleteButtons() {
	$('button[data-action="delete"]').click(function () {
		const target = this.dataset.target;
		$(target).remove();
	});
}
function updateCounter() {
	const count = +$("#formation_qFormations div.form-group").length;
	$("#widgets-counter").val(count);
}
updateCounter();
handleDeleteButtons();
