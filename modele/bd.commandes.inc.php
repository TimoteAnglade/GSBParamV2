<?php
include_once 'bd.inc.php';

function getAllCommandes()
{
	try 
		{
        $monPdo = connexionPDO();
		$req = 'select id, mail, dateCommande, etatCde from commande';
		$res = $monPdo->query($req);
		$lesLignes = $res->fetchAll(PDO::FETCH_ASSOC);
		return $lesLignes;
		} 
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
	}
}

function getDetailsCommandes($id, $mail){
	try 
	{
        $monPdo = connexionPDO();
		$req = 'select id, mail, dateCommande, etatCde, sum(con.qte) as qte, count(id_contenance) as nbProduits from commande inner join contenir con on con.id_commande=id and con.mail_commande=mail where mail=:mail and id=:id';
		$req = $monPdo->prepare($req);
		$req->execute(['id' => $id, 'mail'=>$mail]);
		$lesLignes = $req->fetch(PDO::FETCH_ASSOC);
		$req = "select p.id, image, c.id_contenance, round(prix,2) as prix, c.qte, reduction, round((prix*reduction),2) as prixReduit, p.qte as qteC, stock, unit_intitule, IFNULL(NULLIF(unit_pluriel,''), unit_intitule) as 'unit_pluriel' from contenir c inner join produitcontenance p on id_produit=p.id and p.id_contenance=c.id_contenance inner join unites u on u.id_unit=p.id_unit inner join produit prod on prod.id=p.id where c.mail_commande=:mail and c.id_commande=:id;";
		$req = $monPdo->prepare($req);
		$req->execute(['id' => $id, 'mail'=>$mail]);
		$lesLignes['contenir'] = $req->fetchAll(PDO::FETCH_ASSOC);
		return $lesLignes;
	} 
	catch (PDOException $e) 
	{
        print "Erreur !: " . $e->getMessage();
        die();
	}
}

function changerEtatCde($id, $mail, $etat){
	if($etat=="T"|$etat=="P"|$etat=="A"|$etat=="C")
	try 
	{
        $monPdo = connexionPDO();
		$req = 'update commande set etatCde=:etat where id=:id and mail=:mail';
		$req = $monPdo->prepare($req);
		$req->execute(['id' => $id, 'mail'=>$mail, 'etat'=>$etat]);
	} 
	catch (PDOException $e) 
	{
        print "Erreur !: " . $e->getMessage();
        die();
	}

}

function getAllMarques(){
	try
	{
		$monPdo = connexionPDO();
		$req = "SELECT id_marque, nom_marque FROM marque";
		$req = $monPdo->prepare($req);
		$req->execute();
		$res = $req->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	} 
	catch (PDOException $e) 
	{
        print "Erreur !: " . $e->getMessage();
        die();
	}
}
?>