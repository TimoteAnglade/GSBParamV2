<?php
/**
 * Supprime le panier
 *
 * Supprime le tableau associatif $_SESSION['produits']
 */
function supprimerPanier()
{
	if(isset($_SESSION['mail'])){
		$mail=$_SESSION['mail'];
		$mail=getMail($mail);
		$monPdo= connexionPDO();
		$req = "DELETE FROM panier WHERE mail='$mail';";	
		$res = $monPdo->exec($req);
	}
}
/**
 * Ajoute un produit au panier
 *
 * Teste si l'identifiant du produit est déjà dans la variable session 
 * ajoute l'identifiant à la variable de type session dans le cas où
 * où l'identifiant du produit n'a pas été trouvé
 
 * @param string $idProduit identifiant de produit
 * @return boolean $ok vrai si le produit n'était pas dans la variable, faux sinon 
*/
function ajouterAuPanier($idProduit, $idCont, $qte)
{
	$ok=false;
	if(isset($_SESSION['mail']))
	{
		$mail=getMail();
		$monPdo= connexionPDO();
		$req = "SELECT count(*) FROM panier WHERE mail=:mail AND id=:idProduit AND id_contenance=:cont;";
		$req = $monPdo->prepare($req);
		$req->execute(['mail'=>$mail, 'idProduit'=>$idProduit, 'cont'=>$idCont]);
		$count = $req->fetch()[0];
		if($count){
			$req = "UPDATE panier SET qte=qte+:qte WHERE mail=:mail AND id=:idProduit AND id_contenance=:cont;";
		$req = $monPdo->prepare($req);
		$req->execute(['mail'=>$mail, 'idProduit'=>$idProduit, 'cont'=>$idCont, 'qte'=>$qte]);
		}
		else{
			$req = "INSERT INTO panier (id, id_contenance, mail, qte) VALUES (:id, :idCont, :mail, :qte);";
			$req = $monPdo->prepare($req);
			$req->execute(['mail'=>$mail, 'id'=>$idProduit, 'idCont'=>$idCont, 'qte'=>$qte]);
		}
		$ok=true;
	}
	return $ok;
}
/**
 * Retourne les produits du panier
 *
 * Retourne le tableau des identifiants de produit
 
 * @return array $_SESSION['produits'] le tableau des id produits du panier 
*/
function getLesIdProduitsDuPanier()
{
	$ids=[];
	if(isset($_SESSION['mail'])){
		$mail=getMail();
		$monPdo= connexionPDO();
		$req = "SELECT id, id_contenance, qte FROM panier WHERE mail='$mail';";
		$res = $monPdo->query($req);
		$ids = $res->fetchAll(PDO::FETCH_ASSOC);		
	}
	return $ids;

}
/**
 * Retourne le nombre de produits du panier
 *
 * Teste si la variable de session existe
 * et retourne le nombre d'éléments de la variable session
 
 * @return int $n
*/
function nbProduitsDuPanier()
{
	$n = 0;
	if(isset($_SESSION['mail'])){
		$mail=getMail();
		$monPdo= connexionPDO();
		$req = "SELECT count(*) as c FROM panier WHERE mail=:mail;";
		$req = $monPdo->prepare($req);
		$req->execute(['mail'=>$mail]);
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$n = $res['c'];
	}
	return $n;
}
/**
 * Retire un de produits du panier
 *
 * Recherche l'index de l'idProduit dans la variable session
 * et détruit la valeur à ce rang
 
 * @param string $idProduit identifiant de produit
 
*/
function retirerDuPanier($idProduit, $idCont)
{
	$mail=getMail();
	$monPdo= connexionPDO();
	$req = "SELECT qte FROM panier WHERE mail='$mail' AND id='$idProduit';";
	$res = $monPdo->query($req);http://localhost/gsbparam/images/logo_2.jpg
	$count = $res->fetch()[0];
	if($count>1){
		$req = "UPDATE panier SET qte=qte-1 WHERE mail='$mail' AND id='$idProduit';";	
   		$res = $monPdo->exec($req);
	}
	elseif ($count==1) {
		$req = "DELETE FROM panier WHERE mail='$mail' AND id='$idProduit';";
   		$res = $monPdo->exec($req);
	}
	$req = "SELECT count(*) FROM panier WHERE mail='$mail';";
	$res = $monPdo->query($req);
	$count = $res->fetch()[0];
	if(!$count){
		supprimerPanier();
		header("Location:index.php?uc=gererPanier&action=voirPanier");
	}
	$ok=true;
	return $ok;
}

function modifierQtePanier($id, $idCont, $qte){
	$mail=getMail();
	try{
	if($qte>=1){
		$monPdo= connexionPDO();
		$req = "UPDATE panier SET qte=:qte WHERE mail=:mail AND id=:id AND id_contenance=:cont;";	
   	$req = $monPdo->prepare($req);
   	$req->execute(['id'=>$id, 'cont'=> $idCont, 'mail'=>$mail, 'qte'=>$qte]);
   	return true;
	}
	else{
		$monPdo= connexionPDO();
		$req = "DELETE FROM panier WHERE mail=:mail AND id=:id AND id_contenance=:cont;";	
   	$req = $monPdo->prepare($req);
   	$req->execute(['id'=>$id, 'cont'=> $idCont, 'mail'=>$mail]);		
   	return true;
	}
	}
	catch (PDOException $e) 
	{
			print("ERREUR SQL : ".$e);
      	return false;
      	die();
	}
}

/**
 * teste si une chaîne a un format de code postal
 *
 * Teste le nombre de caractères de la chaîne et le type entier (composé de chiffres)
 
 * @param string $codePostal  la chaîne testée
 * @return boolean $ok vrai ou faux
*/
function estUnCp($codePostal)
{
   
   return strlen($codePostal)== 5 && estEntier($codePostal);
}
/**
 * teste si une chaîne est un entier
 *
 * Teste si la chaîne ne contient que des chiffres
 
 * @param string $valeur la chaîne testée
 * @return boolean $ok vrai ou faux
*/

function estEntier($valeur) 
{
	return preg_match("/[^0-9]/", $valeur) == 0;
}
/**
 * Teste si une chaîne a le format d'un mail
 *
 * Utilise les expressions régulières
 
 * @param string $mail la chaîne testée
 * @return boolean $ok vrai ou faux
*/
function estUnMail($mail)
{
	return  preg_match ('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $mail);
}
/**
 * Retourne un tableau d'erreurs de saisie pour une commande
 *
 * @param string $nom  chaîne testée
 * @param  string $rue chaîne
 * @param string $ville chaîne
 * @param string $cp chaîne
 * @param string $mail  chaîne 
 * @return array $lesErreurs un tableau de chaînes d'erreurs
*/
function getErreursSaisieCommande($nom,$rue,$ville,$cp,$mail)
{
	$lesErreurs = array();
	if($nom=="")
	{
		$lesErreurs[]="Il faut saisir le champ nom";
	}
	if($rue=="")
	{
	$lesErreurs[]="Il faut saisir le champ rue";
	}
	if($ville=="")
	{
		$lesErreurs[]="Il faut saisir le champ ville";
	}
	if($cp=="")
	{
		$lesErreurs[]="Il faut saisir le champ Code postal";
	}
	else
	{
		if(!estUnCp($cp))
		{
			$lesErreurs[]= "erreur de code postal";
		}
	}
	if($mail=="")
	{
		$lesErreurs[]="Il faut saisir le champ mail";
	}
	else
	{
		if(!estUnMail($mail))
		{
			$lesErreurs[]= "erreur de mail";
		}
	}
	return $lesErreurs;
}

/**
 * Retourne un tableau d'erreurs de saisie pour une inscription
 *
 * @param string $mail  chaîne testée
 * @param string $password1  chaîne testée
 * @param string $password2  chaîne testée
 * @param string $nom  chaîne testée
 * @param string $rue chaîne
 * @param string $ville chaîne
 * @param string $cp chaîne
 * @param string $mail  chaîne 
 * @return array $lesErreurs un tableau de chaînes d'erreurs
*/
function getErreursSaisieInscription($mail,$password1,$password2,$nom,$prenom,$rue,$ville,$cp)
{
	if($mail=="")
	{
		$lesErreurs[]="Il faut saisir le champ Mail";
	}
	else
	{
		if(!estUnMail($mail))
		{
			$lesErreurs[]= "erreur de mail";
		}
	}
	$lesErreurs = array();
	if($password1=="")
	{
		$lesErreurs[]="Il faut saisir le champ Mot de Passe";
	}
	if($password2=="")
	{
		$lesErreurs[]="Il faut saisir le champ Confirmation du mot de passe";
	}
	if($password1!=$password2)
	{
		$lesErreurs[]="Les deux mots de passes ne sont pas identiques";
	}
	if($nom=="")
	{
		$lesErreurs[]="Il faut saisir le champ nom";
	}
	if($prenom=="")
	{
		$lesErreurs[]="Il faut saisir le champ prénom";
	}
	if($rue=="")
	{
	$lesErreurs[]="Il faut saisir le champ Rue";
	}
	if($ville=="")
	{
		$lesErreurs[]="Il faut saisir le champ Ville";
	}
	if($cp=="")
	{
		$lesErreurs[]="Il faut saisir le champ Code postal";
	}
	else
	{
		if(!estUnCp($cp))
		{
			$lesErreurs[]= "erreur de code postal";
		}
	}
	return $lesErreurs;
}

function inscription($mail,$password,$nom,$prenom,$rue,$ville,$cp){
	try 
	{
	$hashedPass=password_hash($password, PASSWORD_DEFAULT);
     $monPdo = connexionPDO();
	$req = "INSERT INTO compte (`mail`,`pass`,`nom`,`prenom`,`adresseRue`,`ville`, `cp`) VALUES ('$mail','$hashedPass','$nom','$prenom','$rue','$ville','$cp')";
	$res = $monPdo->exec($req);
	return true;
	}
	catch (PDOException $e) 
	{
		print("ERREUR SQL : ".$e);
   	return false;
   	die();
	}
}

function connection($mail, $password){
	try
	{	
		$valide=false;
		$monPdo= connexionPDO();
 		$req = "SELECT pass FROM compte WHERE mail='$mail'";
    	$res = $monPdo->query($req);
    	$hashedPass=$res->fetch();
    	var_dump($hashedPass);
    	if($hashedPass){
    		if(password_verify($password, $hashedPass[0])){
    			$_SESSION['mail']=$mail;
    			$valide=true;
    		}
    	}
    	return $valide;
	}
	catch(PDOException $e)
	{
		print("ERREUR SQL : ".$e);
		return false;
	}
}

function getAttributsUtilisateur($mail){
	try
	{	
		$valide=false;
		$monPdo= connexionPDO();
 		$req = "SELECT mail, nom, prenom, mail, rue, code_postal, ville FROM compte WHERE mail='$mail'";
    	$res = $monPdo->query($req);
    	$attributs=$res->fetchAll();
    	return $attributs[0];
	}
	catch(PDOException $e)
	{
		return false;
	}
}

function getQteProduit($idProduit){
	$qte = 0;
	if(isset($_SESSION['mail'])){
			$mel=getMail();
			$monPdo= connexionPDO();
			$req = "SELECT qte FROM panier p WHERE mail='$mel' AND id='$idProduit[0]'";
		   	$res = $monPdo->query($req);
		   	$qte=$res->fetch()[0];
	}
	else{
		foreach ($_SESSION['panier'] as $unProduit) {
			if($unProduit[0]==$idProduit){
				$qte=$unProduit[1];
			}
		}
	}
	return $qte;
}

function getMail(){
	return $_SESSION['mail'];
}

function isAdmin(){
	if(isset($_SESSION['mail']))
	{
		$monPdo= connexionPDO();
		$mail=$_SESSION['mail'];
		$req = "SELECT admin FROM compte WHERE mail=:mail";
		$req = $monPdo->prepare($req);
		$req->execute(['mail'=>$mail]);
	   $admin = $req->fetch()[0]==1;
	}
	else{
		$admin=false;
	}
	return $admin;
}
?>
