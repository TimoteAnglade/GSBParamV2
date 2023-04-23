<?php
/**
 * @file fonctions.inc.php
 * @author Marielle Jouin <jouin.marielle@gmail.com>
 * @version    2.0
 * @date juin 2021
 * @details contient les fonctions qui ne font pas accès aux données de la BD

 * regroupe les fonctions pour gérer le panier, et les erreurs de saisie dans le formulaire de commande

 * @package  GsbParam\util
*/
/**
 * Initialise le panier
 *
 * Crée un tableau associatif $_SESSION['produits']en session dans le cas
 * où il n'existe pas déjà
*/
function initPanier()
{
	if(!isset($_SESSION['panier']))
	{
		$_SESSION['panier']= array();
	}
}
/**
 * Supprime le panier
 *
 * Supprime le tableau associatif $_SESSION['produits']
 */
function supprimerPanier()
{
	unset($_SESSION['panier']);
	if(isset($_SESSION['login'])){
		$login=$_SESSION['login'];
		$mail=getMail($login);
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
function ajouterAuPanier($idProduit)
{
	if(isset($_SESSION['login']))
	{
		$mail=getMail();
		$monPdo= connexionPDO();
		$req = "SELECT count(*) FROM panier WHERE mail='$mail' AND id='$idProduit';";
		$res = $monPdo->query($req);
		$count = $res->fetch()[0];
		if($count){
			$req = "UPDATE panier SET qte=qte+1 WHERE mail='$mail' AND id='$idProduit';";	
	   		$res = $monPdo->exec($req);
		}
		else{
			$req = "INSERT INTO panier (mail, id, qte) VALUES ('$mail','$idProduit',1);";
	   		$res = $monPdo->exec($req);
		}
		$ok=true;
	}
	else
	{
	$ok = true;
	$present = -1;
	$i=0;
	foreach ($_SESSION['panier'] as $produit) {
		if($produit[0]==$idProduit) {
			$present=$i;
		}
		$i++;
	}
	if($present+1)
	{
		$_SESSION['panier'][$present][1]++;
	}
	else
	{
		$_SESSION['panier'][]= [$idProduit,1]; // l'indice n'est pas précisé : il sera automatiquement celui qui suit le dernier occupé
	}
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
	if(isset($_SESSION['login'])){
		$mail=getMail();
		$monPdo= connexionPDO();
		$req = "SELECT id FROM panier WHERE mail='$mail';";
		$res = $monPdo->query($req);
		$ids = $res->fetchAll();		
	}
	else{
		foreach ($_SESSION['panier'] as $produit) {
		$ids[]=$produit[0];
		}	
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
	if(isset($_SESSION['login'])){
		$mail=getMail();
		$monPdo= connexionPDO();
		$req = "SELECT count(*) FROM panier WHERE mail='$mail';";
		$res = $monPdo->query($req);
		$n = $res->fetch()[0];
	}
	else{
		$n = 0;
		if(isset($_SESSION['panier']))
		{
			$n = count($_SESSION['panier']);
		}	
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
function retirerDuPanier($idProduit)
{
	if(isset($_SESSION['login'])){
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
	}
	else{
		$i=0;
		foreach ($_SESSION['panier'] as $unProduit) {
			if($unProduit[0]==$idProduit){
				unset($_SESSION['panier'][$i]);
			}
			$i++;
		}		
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
 * @param string $login  chaîne testée
 * @param string $password1  chaîne testée
 * @param string $password2  chaîne testée
 * @param string $nom  chaîne testée
 * @param string $rue chaîne
 * @param string $ville chaîne
 * @param string $cp chaîne
 * @param string $mail  chaîne 
 * @return array $lesErreurs un tableau de chaînes d'erreurs
*/
function getErreursSaisieInscription($login,$password1,$password2,$nom,$rue,$ville,$cp,$mail)
{
	$lesErreurs = array();
	if($login=="")
	{
		$lesErreurs[]="Il faut saisir le champ Login";
	}
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
	return $lesErreurs;
}

	function inscription($login,$password,$nom,$rue,$ville,$cp,$mail){
		try 
		{
		$hashedPass=password_hash($password, PASSWORD_DEFAULT);
        $monPdo = connexionPDO();
		$req = "INSERT INTO login (`login`,`pass`,`nom_prenom`,`mail`,`rue`,`code_postal`,`ville`) VALUES ('$login','$hashedPass','$nom','$mail','$rue','$cp','$ville')";
		$res = $monPdo->exec($req);
		return true;
		}
		catch (PDOException $e) 
		{
        return false;
        die();
		}
	}

	function connection($login, $password){
		try
		{	
			$valide=false;
			$monPdo= connexionPDO();
			$type= 'log';
			$pattern="/[a-z.]+[@]+[a-z]+[.]+[a-z]+/";
    		if(preg_match($pattern, $login)) {
    			$type= 'mail';
    			$req = "SELECT pass FROM login WHERE mail='$login'";
    		}
    		else {
    			$req = "SELECT pass FROM login WHERE login='$login'";
	    	}
	    	$res = $monPdo->query($req);
	    	$hashedPass=$res->fetch();
	    	if($hashedPass){
	    		if(password_verify($password, $hashedPass[0])){
	    			if($type=='mail'){
	    				$req= "SELECT login FROM login WHERE mail='$login'";
	    				$res= $monPdo->query($req);
	    				$log= $res->fetch();
	    				$_SESSION['login']=$log;
	    			}
	    			else{
	    				$_SESSION['login']=$login;		
	    			}
	    		$valide=true;
	    		}
	    	}
	    	return $valide;
		}
		catch(PDOException $e)
		{
			return false;
		}
	}

	function getAttributsUtilisateur($login){
		try
		{	
			$valide=false;
			$monPdo= connexionPDO();
    		$req = "SELECT nom_prenom, mail, rue, code_postal, ville FROM login WHERE login='$login'";
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
		if(isset($_SESSION['login'])){
				$mel=getMail($_SESSION['login']);
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
		if(isset($_SESSION['login']))
		{
			$monPdo= connexionPDO();
			$log=$_SESSION['login'];
			$req = "SELECT mail FROM login WHERE login='$log'";
		   	$res = $monPdo->query($req);
		   	$mail = $res->fetch()[0];
		}
		else{
			$mail="";
		}
		return $mail;
	}

	function isAdmin(){
		if(isset($_SESSION['login']))
		{
			$monPdo= connexionPDO();
			$log=$_SESSION['login'];
			$req = "SELECT admin FROM login WHERE login='$log'";
		   	$res = $monPdo->query($req);
		   	$admin = $res->fetch()[0]==1;
		}
		else{
			$admin=false;
		}
		return $admin;
	}
?>
