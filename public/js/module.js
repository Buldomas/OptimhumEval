$("#add-question").click(function () {
	// récupére les numéros de champs
	const index = +$("#widgets-counter").val();
	// récupère le prototype des entry
	const tmpl = $("#module_qModules")
		.data("prototype")
		.replace(/__name__/g, index);

	// injection du code dans la div
	$("#module_qModules").append(tmpl);
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
	const count = +$("#module_qModules div.form-group").length;
	$("#widgets-counter").val(count);
}
updateCounter();
handleDeleteButtons();
