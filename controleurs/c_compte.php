<?php
$action = $_REQUEST['action'];
switch($action)
{
	case "connexion" :
	{
		if(isset($_SESSION['mail'])) {
			include("vues/v_accueil.html");
		}
		else{
			$mail='';$password='';
			include("vues/v_formCon.php");
		}
		break;
	}
	case "confirmationConnexion" :
	{
		$mail=$_REQUEST['mail'];$password=$_REQUEST['password'];
		if(connection($mail, $password)){
			header("Location:?uc=compte&action=apresConnexion");
		}
		else {
			$msgErreurs = ['Mauvais mail/mot de passe.'];
			include("vues/v_erreurs.php");
			include("vues/v_formCon.php");
		}
		break;
	}
	case "apresConnexion" :
	{
		$message = "Connexion réussie !";
		include("vues/v_message.php");
		break;
	}
	case "inscription" :
	{
		if(isset($_SESSION['mail'])) {
			include("vues/v_accueil.html");
		}
		else{
			$password1='';$password2='';$nom='';$prenom='';$rue='';$ville='';$cp='';$mail='';
			include("vues/v_formInc.php");
		}
		break;
	}
	case "confirmationInscription" :
	{
		$mail=$_REQUEST['mail'];
		$password1=$_REQUEST['password1'];
		$password2=$_REQUEST['password2'];
		$nom=$_REQUEST['nom'];
		$prenom=$_REQUEST['prenom'];
		$rue=$_REQUEST['rue'];
		$ville =$_REQUEST['ville'];
		$cp=$_REQUEST['cp'];
		$msgErreurs = getErreursSaisieInscription($mail,$password1,$password2,$nom,$prenom,$rue,$ville,$cp);
		if (count($msgErreurs)!=0)
		{
			include ("vues/v_erreurs.php");
			include ("vues/v_formInc.php");
		}
		else
		{
			if(inscription($mail,$password1,$nom,$prenom,$rue,$ville,$cp)){
				$message = "Inscription effectuée";
				include ("vues/v_message.php");
				include ("vues/v_accueil.html");
			}
			else{
				$msgErreurs[] = "Ce mail est déjà utilisé.";
				include ("vues/v_erreurs.php");
				include ("vues/v_formInc.php");
			}
		}
		break;
	}
	case "deconnexion" :
	{
		unset($_SESSION['mail']);
		header("Location:?uc=compte&action=apresDeconnexion");
		break;
	}
	case "apresDeconnexion" :
	{
		$message = "Déconnexion réussie !";
		include("vues/v_message.php");	
		include("vues/v_accueil.html");
		break;
	}
	case "redigerAvis":{
		
	}
}