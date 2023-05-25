<?php

/** 
 * Mission 3 : architecture MVC GsbParam
 
 * @file bd.produits.inc.php
 * @author Marielle Jouin <jouin.marielle@gmail.com>
 * @version    2.0
 * @date juin 2021
 * @details contient les fonctions d'accès BD à la table produits
 */
include_once 'bd.inc.php';

	/**
	 * Retourne toutes les catégories sous forme d'un tableau associatif
	 *
	 * @return array $lesLignes le tableau associatif des catégories 
	*/
	function getLesCategories()
	{
		try 
		{
        $monPdo = connexionPDO();
		$req = 'select id, libelle from categorie';
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
	/**
	 * Retourne toutes les informations d'une catégorie passée en paramètre
	 *
	 * @param string $idCategorie l'id de la catégorie
	 * @return array $laLigne le tableau associatif des informations de la catégorie 
	*/
	function getLesInfosCategorie($idCategorie)
	{
		try 
		{
        $monPdo = connexionPDO();
		$req = 'SELECT id, libelle FROM categorie WHERE id="'.$idCategorie.'"';
		$res = $monPdo->query($req);
		$laLigne = $res->fetch(PDO::FETCH_ASSOC);
		return $laLigne;
		} 
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}
/**
 * Retourne sous forme d'un tableau associatif tous les produits de la
 * catégorie passée en argument
 * 
 * @param string $idCategorie  l'id de la catégorie dont on veut les produits
 * @return array $lesLignes un tableau associatif  contenant les produits de la categ passée en paramètre
*/

	function getLesProduitsDeCategorie($idCategorie)
	{
		try 
		{
        $monPdo = connexionPDO();
	    $req='select p.id, libelle, m.nom_marque as marque, description, min(pc.prix) as prix, image, id_categorie, sum(stock) as stock from produit p inner join produitcontenance pc on pc.id=p.id inner join marque m on m.id_marque=p.id_marque where id_categorie =:cat group by p.id';
		$req = $monPdo->prepare($req);
		$req->execute(['cat'=>$idCategorie]);
		$lesLignes = $req->fetchAll(PDO::FETCH_ASSOC);
		return $lesLignes; 
		} 
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}
/**
 * Retourne sous forme d'un tableau associatif tous les produits
 * 
 * @return array $lesLignes un tableau associatif  contenant les produits
*/

	function getLesProduits()
	{
		try 
		{
        $monPdo = connexionPDO();
	    $req='select p.id, libelle, nom_marque as marque, description, min(pc.prix) as prix, image, id_categorie, sum(stock) as stock from produit p inner join produitcontenance pc on pc.id=p.id inner join marque m on m.id_marque = p.id_marque group by p.id';
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
/**
 * Retourne les produits concernés par le tableau des idProduits passée en argument
 *
 * @param array $desIdProduit tableau d'idProduits
 * @return array $lesProduits un tableau associatif contenant les infos des produits dont les id ont été passé en paramètre
*/
	function getLesProduitsDuTableau($desIdProduit)
	{
		try 
		{
        $monPdo = connexionPDO();
		$nbProduits = count($desIdProduit);
		$lesProduits=array();
		if($nbProduits != 0)
		{
			foreach($desIdProduit as $unIdProduit)
			{

				$req = 'select p.id, libelle, id_contenance, pc.qte as qteC, unit_intitule, unit_pluriel, nom_marque as marque, description, pc.prix, image, id_categorie, stock, (stock>='.$unIdProduit['qte'].') as assez from produit p inner join produitcontenance pc on pc.id=p.id inner join marque m on m.id_marque = p.id_marque inner join unites u on pc.id_unit=u.id_unit where p.id="'.$unIdProduit['id'].'" AND id_contenance="'.$unIdProduit['id_contenance'].'";';
				$res = $monPdo->query($req);
				$unProduit = $res->fetch(PDO::FETCH_ASSOC);
				$unProduit['qte'] = $unIdProduit['qte'];
				$unProduit['reductionMax'] = getBestPromo($unIdProduit['id'], $unIdProduit['id_contenance']);
				$lesProduits[] = $unProduit;
			}
		}
		return $lesProduits;
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}
	/**
	 * Crée une commande 
	 *
	 * Crée une commande à partir des arguments validés passés en paramètre, l'identifiant est
	 * construit à partir du maximum existant ; crée les lignes de commandes dans la table contenir à partir du
	 * tableau d'idProduit passé en paramètre
	 * @param string $nom nom du client
	 * @param string $rue rue du client
	 * @param string $cp cp du client
	 * @param string $ville ville du client
	 * @param string $mail mail du client
	 * @param array $lesIdProduit tableau associatif contenant les id des produits commandés
	 
	*/
	function creerCommande($lesIdProduit)
	{
		try 
		{
		$mail = getMail();
        $monPdo = connexionPDO();
		// on récupère le dernier id de commande
		$req = 'select max(id) as maxi from commande where mail=:mail';
		$req = $monPdo->prepare($req);
		$req->execute(['mail'=>$mail]);
		$laLigne = $req->fetch();
		$maxi = $laLigne['maxi'] ;// on place le dernier id de commande dans $maxi
		$idCommande = $maxi+1; // on augmente le dernier id de commande de 1 pour avoir le nouvel idCommande
		$date = date('Y-m-d'); // récupération de la date système
		$req = "insert into commande (MAIL, ID, DATECOMMANDE) values (:mail, :id, :date)";
		$req = $monPdo->prepare($req);
		$req->execute(['mail'=>$mail, 'id'=>$idCommande, 'date'=>$date]);
		//insertion produits commandés
		foreach($lesIdProduit as $unIdProduit)
		{
			$req = "insert into contenir (id_produit, id_contenance, mail_commande, id_commande, qte, reduction) values (:idp, :idc, :mail, :idco, :qte, :reduc)";
			$req = $monPdo->prepare($req);
			$req->execute(['idp'=>$unIdProduit['id'], 'idc'=>$unIdProduit['id_contenance'], 'mail'=>$mail, 'idco'=>$idCommande, 'qte'=>$unIdProduit['qte'], 'reduc'=>$unIdProduit['reductionMax']]);
		}
		return true;
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        return false;
        die();
		}
	}
	/**
	 * Retourne les produits concernés par le tableau des idProduits passée en argument
	 *
	 * @param int $mois un numéro de mois entre 1 et 12
	 * @param int $an une année
	 * @return array $lesCommandes un tableau associatif contenant les infos des commandes du mois passé en paramètre
	*/
	function getLesCommandesDuMois($mois, $an)
	{
		try 
		{
        $monPdo = connexionPDO();
		$req = 'select id, dateCommande, nomPrenomClient, adresseRueClient, cpClient, villeClient, mailClient from commande where YEAR(dateCommande)= '.$an.' AND MONTH(dateCommande)='.$mois;
		$res = $monPdo->query($req);
		$lesCommandes = $res->fetchAll(PDO::FETCH_ASSOC);
		return $lesCommandes;
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}

	/**
	* Edite le produit $code avec un ou une des caractéristiques fournies après
	* Les paramètres contenant '' seront ignorés
	*
	* @param string $code code du produit concerné
	* @param string $libelle libelle a mettre à la place de l'ancien
	* @param string $description description a mettre à la place de l'ancienne
	* @param fichier $fichier image a mettre à la place de l'ancien
	* @param string $categoie categorie a mettre à la place de l'ancienne
	* @param int $marque marque a mettre la place de l'ancienne
	*
	* @return boolean true si la requète a été exécutée avec succès, false sinon
		if(ajoutProduit($id,$libelle,$description,$target_file,$categorie, $marque)){
	*/
	function editProduit($code, $libelle, $description, $fichier, $categorie, $marque)

	{
		try
		{
			$prepare = [];
			$donnees = getDetailsProduit($code);
			$monPdo = connexionPDO();
			$debutReq = 'update produit set ';
			$finReq = ' where id=:code;';
			$prepare['code']=$code;
			$req=$debutReq;
			$compteur = 0;
			if(!empty($libelle)){
				if($compteur){
					$req=$req.", ";
				}
				$req=$req."libelle=:libelle";
				$prepare['libelle']=$libelle;
				$compteur++;
			}
			if(!empty($description)){
				if($compteur){
					$req=$req.", ";
				}
				$req=$req."description=:description";
				$prepare['description']=$description;
				$compteur++;
			}
			if(!empty($fichier)){
				if($compteur){
					$req=$req.", ";
				}
				$req=$req."image=:fichier";
				$prepare['fichier']=$fichier;
				$compteur++;
			}
			if(!empty($categorie)){
				if($compteur){
					$req=$req.", ";
				}
				$req=$req."id_categorie=:categorie";
				$prepare['categorie']=$categorie;
				$compteur++;
			}
			if(!empty($marque)){
				if($compteur){
					$req=$req.", ";
				}
				$req=$req."id_marque=:marque";
				$prepare['marque']=$marque;
				$compteur++;
			}
			$req = $req.$finReq;
			$req = $monPdo->prepare($req);
			$req->execute($prepare);
			return true;
		}
		catch (PDOException $e)
		{
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}

	/**
	* Retourne la catégorie du produit demandé
	*
	* @param string $produit code du produit dont on veut la catégorie
	*
	* @return string le code de la catégorie du produit demandé
	*/
	function getCatProduit($produit)
	{
		try 
		{
        $monPdo = connexionPDO();
        $req = 'select idCategorie from produit where id="'.$produit.'";';
		$res = $monPdo->query($req);
		$lesCommandes = $res->fetchAll(PDO::FETCH_ASSOC);
		return $lesCommandes[0]['idCategorie'];
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}

	/**
	* Ajoute un produit ayant pour caractéristiques celles fournies en paramètre
	*
	* @param string $code code du nouveau produit
	* @param string $description description du nouveau produit
	* @param float $prix prix du nouveau produit
	* @param string $categoie categorie du nouveau produit
	* @param string $fichier localisation de l'image a utiliser pour le nouveau produit
	*
	* @return boolean true si la requète a été exécutée avec succès, false sinon
	*/
	function ajoutProduit($id,$libelle,$description,$image,$id_cat, $id_marque, $qte, $unite, $prix, $stock=50)
	{
		try
		{
			$monPdo = connexionPDO();
			$req = 'insert into produit (`id`, `libelle`, `description`, `image`, `dateMiseEnRayon`, `id_categorie`, `id_marque`) values (:id, :lib, :desc, :img, CURDATE(), :cat, :marq);';
			$req = $monPdo->prepare($req);
			$req->execute(['id'=>$id, 'lib'=>$libelle, 'desc'=>$description, 'img'=>$image, 'id'=>$id, 'cat'=>$id_cat, 'marq'=>$id_marque]);
			return ajoutContenance($id, 1, 1, $qte, $unite, $prix, $stock);
		}
		catch (PDOException $e)
		{
			return false;
		}
	}	

	/**
	* Supprime le produit demandé en paramètre
	*
	* @param string $code code du produit demandé
	*
	* @return boolean true si la requète a été exécutée avec succès, false sinon
	*/
	function supprimerProduit($code)
	{
		try
		{
			$monPdo = connexionPDO();
			$req = 'delete from produitcontenance where id="'.$code.'";';
			$res = $monPdo->exec($req);
			$req = 'delete from produit where id="'.$code.'";';
			$res = $monPdo->exec($req);
			return true;
		}
		catch (PDOException $e)
		{
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}	

	function getDetailsProduit($id){
		$monPdo= connexionPDO();
		$req="SELECT p.id, nom_marque as marque, libelle, description, image, dateMiseEnRayon, id_categorie, min(prix) as prix from produit p inner join produitcontenance pc on pc.id=p.id inner join marque m on m.id_marque = p.id_marque WHERE p.id=:id;";
		$req = $monPdo->prepare($req);
		$req->execute(['id'=>$id]);
		$res = $req->fetch(PDO::FETCH_ASSOC);
		return $res;
	}

	function getContenances($id){
		$monPdo= connexionPDO();
		$req="SELECT pc.id, id_contenance, prix, qte, stock, isBase, id_categorie, unit_intitule, unit_pluriel from produit p inner join produitcontenance pc on pc.id = p.id inner join unites u on pc.id_unit=u.id_unit WHERE p.id=:id;";
		$req = $monPdo->prepare($req);
		$req->execute(['id'=>$id]);
		$res = $req->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}

	function getIdReco($id){
		$monPdo= connexionPDO();
		$req = "SELECT id_produit FROM recommande WHERE id=:id";
		$req = $monPdo->prepare($req);
		$req->execute(['id'=>$id]);
		return $req->fetchAll(PDO::FETCH_ASSOC);
	}

	function getNouveautes($qte){
		try 
		{
        $monPdo= connexionPDO();
		$req="SELECT p.id, nom_marque as marque, libelle, description, image, dateMiseEnRayon, id_categorie, min(prix) as prix from produit p inner join produitcontenance pc on pc.id=p.id inner join marque m on m.id_marque = p.id_marque GROUP BY p.id ORDER BY dateMiseEnRayon DESC LIMIT ".$qte." ;";
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

	function getPromotions(){
		try 
		{
        $monPdo= connexionPDO();
		$req="SELECT pro.id_reduc, pro.reduction as reduc, p.id, nom_marque as marque, libelle, description, image, dateMiseEnRayon, id_categorie, min(prix) as prix, SUM(pc.stock) as stock from produit p inner join produitcontenance pc on pc.id=p.id inner join marque m on m.id_marque = p.id_marque inner join sur s on s.id=p.id inner join promotion pro on pro.id_reduc=s.id_reduc GROUP BY pc.id, pc.id_contenance HAVING SUM(pc.stock)>1";
		$req = $monPdo->prepare($req);
		$req->execute();
		$res = $req->fetchAll(PDO::FETCH_ASSOC);
		$result = [];
		foreach($res as $item){
			$result[$item['id_reduc']][] = $item;
		}
		return $result;
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}

	function getBestPromo($id, $id2){
		try
		{
		$monPdo= connexionPDO();
		$req="SELECT IFNULL(min(reduction), 1) as promo FROM produitcontenance p inner join sur s on p.id_contenance=s.id_contenance and p.id=s.id inner join promotion pro on pro.id_reduc=s.id_reduc where p.id=:id and p.id_contenance=:id2;";
		$req = $monPdo->prepare($req);
		$req->execute(['id'=>$id, 'id2'=>$id2]);
		$res = $req->fetch(PDO::FETCH_ASSOC);
		return $res['promo'];
		}
		catch (PDOException $e){
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}

	function getBestPrix($id){
		try
		{
		$monPdo= connexionPDO();
		$req="SELECT min(prix) prix FROM (SELECT prix*ifnull(min(pro.reduction),1) as prix from produitcontenance p left join sur s on s.id=p.id and s.id_contenance=p.id_contenance left join promotion pro on pro.id_reduc=s.id_reduc where p.id = :id group by p.id_contenance) t;";
		$req = $monPdo->prepare($req);
		$req->execute(['id'=>$id]);
		$res = $req->fetch(PDO::FETCH_ASSOC);
		return round($res['prix'],2);
		}
		catch (PDOException $e){
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}

	function getImage($id){
		try
		{
		$monPdo= connexionPDO();
		$req="SELECT image from produit where id=:id";
		$req = $monPdo->prepare($req);
		$req->execute(['id'=>$id]);
		$res = $req->fetch(PDO::FETCH_ASSOC);
		return $res['promo'];
		}
		catch (PDOException $e){
			print "Erreur !: " . $e->getMessage();
			die();
		}
	}

	function ajoutContenance($id, $idC, $isBase, $qte, $unite, $prix, $stock){
		try
		{
			$monPdo = connexionPDO();
			$req = 'insert into produitcontenance (`id`, `id_contenance`, `prix`, `qte`, `isBase`, `id_unit`, `stock`) values (:id, :idC, :prix, :qte, :isBase, :unite, :stock);';
			$req = $monPdo->prepare($req);
			$req->execute(['id'=>$id, 'idC'=>$idC, 'isBase'=>$isBase, 'qte'=>$qte, 'id'=>$id, 'unite'=>$unite, 'prix'=>$prix, 'stock'=>$stock]);
			return true;
		}
		catch (PDOException $e)
		{
			return false;
		}
	}

	function editContenance($id, $idC, $isBase, $qte, $unite, $prix, $stock){
		try
		{
			$monPdo = connexionPDO();
			$req = 'update produitcontenance set prix=:prix, qte=:qte, isBase=:isBase, id_unit=:unite, stock=:stock where id=:id and id_contenance=:idC';
			$req = $monPdo->prepare($req);
			$req->execute(['id'=>$id, 'idC'=>$idC, 'isBase'=>$isBase, 'qte'=>$qte, 'id'=>$id, 'unite'=>$unite, 'prix'=>$prix, 'stock'=>$stock]);
			return true;
		}
		catch (PDOException $e)
		{
			var_dump($e);
			return false;
		}
	}

	function getAllContenances(){
		$monPdo= connexionPDO();
		$req="SELECT pc.id, libelle, id_contenance, prix, qte, stock, isBase, id_categorie, unit_intitule, unit_pluriel from produit p inner join produitcontenance pc on pc.id = p.id inner join unites u on pc.id_unit=u.id_unit;";
		$req = $monPdo->prepare($req);
		$req->execute();
		$res = $req->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}

	function modifStock($id, $idC, $stock){
		try
		{
			$monPdo = connexionPDO();
			$req = 'UPDATE produitcontenance SET stock=:stock WHERE id=:id AND id_contenance=:idC';
			$req = $monPdo->prepare($req);
			$req->execute(['id'=>$id, 'idC'=>$idC, 'stock'=>$stock]);
			return true;
		}
		catch (PDOException $e)
		{
			print "ERREUR SQL : ".$e;
			return false;
		}
	}

	function getContenance($id, $idC){
		$monPdo= connexionPDO();
		$req="SELECT pc.id, id_contenance, prix, qte, stock, isBase, id_categorie, pc.id_unit, unit_intitule, unit_pluriel from produit p inner join produitcontenance pc on pc.id = p.id inner join unites u on pc.id_unit=u.id_unit WHERE p.id=:id AND id_contenance=:idC;";
		$req = $monPdo->prepare($req);
		$req->execute(['id'=>$id, 'idC'=>$idC]);
		$res = $req->fetch(PDO::FETCH_ASSOC);
		return $res;
	}

	function existContenance($id, $idC){
		$monPdo= connexionPDO();
		$req="SELECT count(id_contenance) as 'is' from produitcontenance where id=:id AND id_contenance=:idC;";
		$req = $monPdo->prepare($req);
		$req->execute(['id'=>$id, 'idC'=>$idC]);
		$res = $req->fetch(PDO::FETCH_ASSOC);
		return $res['is'];
	}
?>