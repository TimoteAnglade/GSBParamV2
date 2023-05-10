<?php

function addAvis($mail, $id, $texte, $note){
	if($note>=0&&$note<=5&&canAvis($mail, $id)){
		try{
		$monPdo = connexionPDO();
		$req = "insert into avis (mail, id, note, contenu_avis) VALUES (:mail, :id, :note, :ctn);";
		$req = $monPdo->prepare($req);
		$req->execute(['mail'=>$mail, 'id'=>$id, 'note'=>$note, 'ctn'=>$texte]);
		return true;
		}
		catch(PDOException $e){
			print("ERREUR SQL : ".$e);
			return false;
		}
	}
	return false;
}


function canAvis($mail, $id){
	$monPdo = connexionPDO();
	$req = "SELECT count(*) as x FROM contenir WHERE mail_commande = :mail AND id_produit=:idProduit";
	$req = $monPdo->prepare($req);
	$req->execute(['mail'=>$mail, 'idProduit'=>$id]);
	$res=$req->fetch()['x'];
	$result=$res>=1;
	$req = "SELECT count(*) as x FROM avis WHERE mail = :mail AND id=:idProduit";
	$req = $monPdo->prepare($req);
	$req->execute(['mail'=>$mail, 'idProduit'=>$id]);
	$result=$result==1&&!($req->fetch()['x']>=1);
	return $result;
}

function getMoy($id){
	$monPdo = connexionPDO();
	$req = "SELECT AVG(note) as x FROM avis WHERE id=:idProduit";
	$req = $monPdo->prepare($req);
	$req->execute(['idProduit'=>$id]);
	$res=$req->fetch();
	$result=round($res['x']);
	return $result;
}

function getNbAvis($id){
	$monPdo = connexionPDO();
	$req = "SELECT count(note) as x FROM avis WHERE id=:idProduit";
	$req = $monPdo->prepare($req);
	$req->execute(['idProduit'=>$id]);
	$res=$req->fetch()['x'];
	return $res;
}

function getDataAvis($id){
	$monPdo = connexionPDO();
	$req = "SELECT prenom, nom, contenu_avis as contenu, note FROM avis a inner join compte c on c.mail = a.mail WHERE id=:idProduit";
	$req = $monPdo->prepare($req);
	$req->execute(['idProduit'=>$id]);
	$res=$req->fetchAll(PDO::FETCH_ASSOC);
	return $res;
}
?>