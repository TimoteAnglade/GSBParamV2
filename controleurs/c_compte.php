<?php
$action = $_REQUEST['action'];
switch($action)
{
	case "connexion" :
	{
		if(isset($_SESSION['login'])) {
			include("vues/v_accueil.html");
		}
		else{
			$login='';$password='';
			include("vues/v_formCon.php");
		}
		break;
	}
	case "confirmationConnexion" :
	{
		$login=$_REQUEST['login'];$password=$_REQUEST['password'];
		if(connection($login, $password)){
			header("Location:?uc=compte&action=apresConnexion");
		}
		else {
			$msgErreurs = ['Mauvais mail/login/mot de passe.'];
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
		if(isset($_SESSION['login'])) {
			include("vues/v_accueil.html");
		}
		else{
			$login='';$password1='';$password2='';$nom='';$rue='';$ville='';$cp='';$mail='';
			include("vues/v_formInc.php");
		}
		break;
	}
	case "confirmationInscription" :
	{
		$login=$_REQUEST['login'];$password1=$_REQUEST['password1'];$password2=$_REQUEST['password2'];$nom=$_REQUEST['nom'];$rue=$_REQUEST['rue'];$ville =$_REQUEST['ville'];$cp=$_REQUEST['cp'];$mail=$_REQUEST['mail'];
		$msgErreurs = getErreursSaisieInscription($login,$password1,$password2,$nom,$rue,$ville,$cp,$mail);
		if (count($msgErreurs)!=0)
		{
			include ("vues/v_erreurs.php");
			include ("vues/v_formInc.php");
		}
		else
		{
			if(inscription($login,$password1,$nom,$rue,$ville,$cp,$mail)){
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
		unset($_SESSION['login']);
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
}