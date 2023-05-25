function changePrix(valeur, objet) {
	document.getElementById("prix").innerHTML=objet[valeur+"prix"];
	if(objet[valeur+"stock"]==0){
		document.getElementById("stock2").innerHTML='Hors stock';
	}
	else{
		document.getElementById("stock2").innerHTML='<em><span id="stock"></span> encore en stock</em>';
		document.getElementById("stock").innerHTML=objet[valeur+"stock"];
	}
	document.getElementById("stockHid").innerHTML=objet[valeur+"stock"];
}

function checkQteAjout(cde, stock)
{
	cdeT = parseInt(cde);
	stockT = parseInt(stock);
	return cdeT<=stockT;
}
