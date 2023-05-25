<?php
$action = $_REQUEST['action'];
if(isset($_SESSION['mail'])){
	if(isAdmin($_SESSION['mail'])){
		switch($action)
		{
			case 'listeCommandes':
			{
				$cds=getAllCommandes();
				include('vues/v_commandes.php');
				break;
			}
			case 'modifCommande':
			{
				if(isset($_REQUEST['id'])&isset($_REQUEST['mail'])){
					if(isset($_REQUEST['etatCde'])){
						changerEtatCde($_REQUEST['id'], $_REQUEST['mail'], $_REQUEST['etatCde']);
					}
					$infos=getDetailsCommandes($_REQUEST['id'], $_REQUEST['mail']);
					include('vues/v_detailsCommande.php');
				}
				else{
					include('vues/v_accueil.php');					
				}
				break;
			}
			case 'voirResultats':
			{
				$resultats = getChiffredAffaireParMois();
				include('vues/v_montantCde.php');
				break;
			}
			default :
			{
				include('vues/v_accueil.php');
			}
		}
	}
}