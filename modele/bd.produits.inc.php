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
	    $req='select id, description, prix, image, idCategorie from produit where idCategorie ="'.$idCategorie.'"';
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
 * Retourne sous forme d'un tableau associatif tous les produits
 * 
 * @return array $lesLignes un tableau associatif  contenant les produits
*/

	function getLesProduits()
	{
		try 
		{
        $monPdo = connexionPDO();
	    $req='select id, description, prix, image, idCategorie from produit';
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
				$req = "SELECT id, description, prix, image, idCategorie FROM produit WHERE id = '$unIdProduit[0]'";
				$res = $monPdo->query($req);
				$unProduit = $res->fetch(PDO::FETCH_ASSOC);
				$unProduit['qte'] = getQteProduit($unIdProduit);
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
	function creerCommande($nom,$rue,$cp,$ville,$mail, $lesIdProduit )
	{
		try 
		{
        $monPdo = connexionPDO();
		// on récupère le dernier id de commande
		$req = 'select max(id) as maxi from commande';
		$res = $monPdo->query($req);
		$laLigne = $res->fetch();
		$maxi = $laLigne['maxi'] ;// on place le dernier id de commande dans $maxi
		$idCommande = $maxi+1; // on augmente le dernier id de commande de 1 pour avoir le nouvel idCommande
		$date = date('Y/m/d'); // récupération de la date système
		$req = "insert into commande values ('$idCommande','$date','$nom','$rue','$cp','$ville','$mail')";
		$res = $monPdo->exec($req);
		// insertion produits commandés
		foreach($lesIdProduit as $unIdProduit)
		{
			$req = "insert into contenir values ('$idCommande','$unIdProduit')";
			$res = $monPdo->exec($req);
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
	* @param string $description description a mettre à la place de l'ancienne
	* @param float $prix prix a mettre à la place de l'ancien
	* @param string $categoie categorie a mettre à la place de l'ancienne
	* @param string $fichier localisation de l'image a utiliser à la place de l'ancienne
	*
	* @return boolean true si la requète a été exécutée avec succès, false sinon
	*/
	function editProduit($code,$description,$prix,$categorie,$fichier)
	{
		try
		{
			$monPdo = connexionPDO();
			$debutReq = 'update produit set ';
			$finReq = ' where id="'.$code.'";';
			$req=$debutReq;
			$compteur = 0;

			if($description!=''){
				if($compteur){
					$req=$req.', ';
				}
				$compteur++;
				$req=$req.'description="'.$description.'"';
			}

			if($prix!=''){
				if($compteur){
					$req=$req.', ';
				}
				$compteur++;
				$req=$req.'prix='.$prix;
			}

			if($categorie!=''){
				if($compteur){
					$req=$req.', ';
				}
				$compteur++;
				$req=$req.'idCategorie="'.$categorie.'"';
			}

			if($fichier!=''){
				if($compteur){
					$req=$req.', ';
				}
				$compteur++;
				$req=$req.'image="'.$fichier.'"';
			}

			$req = $req.$finReq;
			$res = $monPdo->exec($req);
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
	function ajoutProduit($code,$description,$prix,$categorie,$fichier)
	{
		try
		{
			$monPdo = connexionPDO();
			$req = 'insert into produit (`id`, `description`, `prix`, `image`, `idCategorie`) values ("'.$code.'", "'.$description.'", '.$prix.', "'.$fichier.'", "'.$categorie.'");';
			$res = $monPdo->exec($req);
			return true;
		}
		catch (PDOException $e)
		{
			print "Erreur !: " . $e->getMessage();
			die();
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
?>