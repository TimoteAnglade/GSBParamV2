<?php
$action = $_REQUEST['action'];
if(isset($_SESSION['mail'])){
if(isAdmin($_SESSION['mail'])){
switch($action)
{
	case 'listeProduits':
		$lesCategories = getLesCategories();
		include("vues/v_categoriesEdit.php");
		$lesProduits=getLesProduits();
		include("vues/v_produitsEdit.php");
		break;

	case 'listeProduitsCategorie':
		$lesCategories = getLesCategories();
		include("vues/v_categoriesEdit.php");
		if(isset($_REQUEST['categorie']))
		{
  			$categorie = $_REQUEST['categorie'];	
		}
		else
		{
			$categorie="CH";
		}
		$lesProduits = getLesProduitsDeCategorie($categorie);
		include("vues/v_produitsEdit.php");
		break;
	case 'editerProduit' :
		$id=$_REQUEST['produit'];
		$produit=getDetailsProduit($id);
		$conts=getContenances($id);
		$marques = getAllMarques();
		$prixC = "{";
		foreach($conts as $cont){
			$prix1 = round($cont['prix'],2);
			$prix2 = getBestPromo($cont['id'],$cont["id_contenance"])*$cont['prix'];
			if($prix1!=$prix2){
				$prix3="<NOBR><strike><i>".$prix1." €</i></strike> <strong>".$prix2." €</strong></NOBR>";
			}
			else{
				$prix3="<NOBR><strong>".$prix1." €</strong></NOBR>";
			}

			$prixC = $prixC."'".$cont['id_contenance']."prix' : '".$prix3."', ";
			$prixC = $prixC."'".$cont['id_contenance']."stock' : '".$cont['stock']."', ";
		}
		$prixC = $prixC.'}';
		include('vues/v_formEdit.php');
		break;
	case 'confirmerEdition' :
		$target_file='';
		if($_FILES["image"]["size"] > 0){
			$target_dir = "images/UPLOADED_";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			// Check if image file is a actual image or fake image
			if(true) {
			  $check = getimagesize($_FILES["image"]["tmp_name"]);
			  if($check !== false) {
			    $uploadOk = 1;
			  } else {
				$msgErreurs[]="File is not an image.";
				include('vues/v_erreurs.php');
			    $uploadOk = 0;
			  }
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$msgErreurs[]="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				include('vues/v_erreurs.php');
			  $uploadOk = 0;
			}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				$msgErreurs[]="Sorry, your file was not uploaded.";
				include('vues/v_erreurs.php');
			// if everything is ok, try to upload file
			} else {
			  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
			    //echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
			  } else {
				$msgErreurs[]="Sorry, there was an error uploading your file.";
				include('vues/v_erreurs.php');
			  }
			}
		}
		$id=$_REQUEST['id'];
		$libelle=$_REQUEST['nom'];
		$description=$_REQUEST['description'];
		$categorie=$_REQUEST['type'];
		$marque=$_REQUEST['marque'];
		if(editProduit($id,$libelle,$description,$target_file,$categorie,$marque)){
			$message="Le produit a été modifié.";
			include('vues/v_message.php');
		}
		$lesProduits=getLesProduits();
		include('vues/v_produitsEdit.php');
		break;
	case 'ajoutProduit' :
		$unites = getAllUnites();
		$marques = getAllMarques();
		include('vues/v_formAjout.php');
		break;
	case 'confirmerAjout' :
		$valide=isset($_REQUEST['id'])&&isset($_REQUEST['nom'])&&isset($_REQUEST['description'])&&isset($_REQUEST['type'])&&isset($_REQUEST['marque'])&&isset($_FILES['image'])&&isset($_REQUEST['qte'])&&isset($_REQUEST['unite'])&&isset($_REQUEST['prix']);
		if($valide){
			$valide = !empty($_REQUEST['id'])&&!empty($_REQUEST['nom'])&&!empty($_REQUEST['description'])&&!empty($_REQUEST['type'])&&!empty($_REQUEST['marque'])&&$_FILES["image"]["size"]>0&&!empty($_REQUEST['qte'])&&!empty($_REQUEST['unite'])&&!empty($_REQUEST['prix']);
		}
		if($valide){
			$target_file='';
			if($_FILES["image"]["size"] > 0){
				$target_dir = "images/UPLOADED_";
				$target_file = $target_dir . basename($_FILES["image"]["name"]);
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

				// Check if image file is a actual image or fake image
				if(true) {
				  $check = getimagesize($_FILES["image"]["tmp_name"]);
				  if($check !== false) {
				    $uploadOk = 1;
				  } else {
					$msgErreurs[]="File is not an image.";
				    $uploadOk = 0;
				  }
				}

				if ($_FILES["image"]["size"]>=1048576*2){
					$msgErreurs[]="File is too big.";
				    $uploadOk = 0;
				}

				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
					$msgErreurs[]="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				  $uploadOk = 0;
				}

				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0 | $_FILES['image']['error']) {
					$msgErreurs[]="Sorry, your file was not uploaded.";
					include('vues/v_erreurs.php');
				// if everything is ok, try to upload file
				} else {
				  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
				    //echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
				  } else {
					$msgErreurs[]="Sorry, there was an error uploading your file.";
					include('vues/v_erreurs.php');
				  }
				}
			}
			$id=$_REQUEST['id'];
			$libelle=$_REQUEST['nom'];
			$description=$_REQUEST['description'];
			$categorie=$_REQUEST['type'];
			$marque=$_REQUEST['marque'];
			$qte=$_REQUEST['qte'];
			$unite=$_REQUEST['unite'];
			$prix=$_REQUEST['prix'];
			$stock=$_REQUEST['stock'];
			if(ajoutProduit($id,$libelle,$description,$target_file,$categorie, $marque, $qte, $unite, $prix, $stock)){
				$message="Le produit a été ajouté.";
				include('vues/v_message.php');
				$lesProduits=getLesProduits();
				include('vues/v_produitsEdit.php');
			}
			else {
				$unites = getAllUnites();
				$marques = getAllMarques();
				$msgErreurs[]="Impossible d'ajouter ce produit.";
				include('vues/v_erreurs.php');
				include('vues/v_formAjout.php');
			}
		}
		else{
			$unites = getAllUnites();
			$marques = getAllMarques();
			$msgErreurs[]="Un ou des champs ne sont pas valides";
			include('vues/v_erreurs.php');
			include('vues/v_formAjout.php');			
		}
		break;
	case 'supprimerProduit' :
		$id=$_REQUEST['produit'];
		include('vues/v_confirmerDelete.php');
		break;
	case 'confirmerSuppression' :
		$produit=$_REQUEST['produit'];
		if(supprimerProduit($produit)){
			$message='Le produit a bien été supprimé.';
		}
		else{
			$message='Le produit n\'a pas été supprimé';
		}
		include('vues/v_message.php');
		$lesProduits=getLesProduits();
		include('vues/v_produitsEdit.php');
	case 'stocks':
	{
		$infos=getAllContenances();
		include('vues/v_gererStock.php');
	}
	case 'modifStock':
		if(isset($_REQUEST['id'])&&isset($_REQUEST['idC'])&&isset($_REQUEST['stock'])){
			if(!empty($_REQUEST['id'])&&!empty($_REQUEST['idC'])&&!empty($_REQUEST['stock'])){
				if(modifStock($_REQUEST['id'], $_REQUEST['idC'], $_REQUEST['stock'])){
				}
				else{
				}
			}
		}
		$infos=getAllContenances();
		include('vues/v_gererStock.php');
		break;
	}
}
else{
	header("Location:index.php");
}
}
else{
	header("Location:index.php");
}
?>