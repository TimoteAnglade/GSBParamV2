function changePrix(valeur, objet) {
	document.getElementById("prix").innerHTML=objet[valeur+"prix"];
	document.getElementById("stock").innerHTML=objet[valeur+"stock"];
}