<?php
$action = $_REQUEST['action'];
if(isset($_SESSION['login'])){
if(isAdmin($_SESSION['login'])){
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
		include('vues/v_formEdit.php');
		break;
	case 'confirmerEdition' :
		$target_file='';
		if($_FILES["fileToUpload"]["size"] > 0){
			$target_dir = "images/UPLOADED_";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			  if($check !== false) {
			    $uploadOk = 1;
			  } else {
				$msgErreurs[]="File is not an image.";
				include('vues/v_erreurs.php');
			    $uploadOk = 0;
			  }
			}

			// Check if file already exists
			if (file_exists($target_file)) {
			  //echo "Sorry, file already exists.";
			  $uploadOk = 0;
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
			  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
			  } else {
				$msgErreurs[]="Sorry, there was an error uploading your file.";
				include('vues/v_erreurs.php');
			  }
			}
		}
		$code=$_REQUEST['produit'];
		$prix=$_REQUEST['prix'];
		$description=$_REQUEST['description'];
		$categorie=$_REQUEST['categorie'];
		if(editProduit($code,$description,$prix,$categorie,$target_file)){
			$message="Le produit a été modifié.";
			include('vues/v_message.php');
		}
		$lesProduits=getLesProduits();
		include('vues/v_produitsEdit.php');
		break;
	case 'ajoutProduit' :
		include('vues/v_formAjout.php');
		break;
	case 'confirmerAjout' :
		$target_file='';
		if($_FILES["fileToUpload"]["size"] > 0){
			$target_dir = "images/UPLOADED_";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			  if($check !== false) {
			    $uploadOk = 1;
			  } else {
				$msgErreurs[]="File is not an image.";
			    $uploadOk = 0;
			  }
			}

			if ($_FILES["fileToUpload"]["size"]>=1048576*2){
				$msgErreurs[]="File is too big.";
			    $uploadOk = 0;
			}

			// Check if file already exists
			if (file_exists($target_file)) {
			  //echo "Sorry, file already exists.";
			  $uploadOk = 0;
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$msgErreurs[]="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			  $uploadOk = 0;
			}

			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0 | $_FILES['fileToUpload']['error']) {
				$msgErreurs[]="Sorry, your file was not uploaded.";
				include('vues/v_erreurs.php');
			// if everything is ok, try to upload file
			} else {
			  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
			  } else {
				$msgErreurs[]="Sorry, there was an error uploading your file.";
				include('vues/v_erreurs.php');
			  }
			}
		}
		$code=$_REQUEST['code'];
		$prix=$_REQUEST['prix'];
		$description=$_REQUEST['description'];
		$categorie=$_REQUEST['categorie'];
		if(ajoutProduit($code,$description,$prix,$categorie,$target_file)){
			$message="Le produit a été ajouté.";
			include('vues/v_message.php');
		$lesProduits=getLesProduits();
		include('vues/v_produitsEdit.php');
		}
		else {
			$msgErreurs[]="Impossible d'ajouter ce produit.";
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
			include('vues/v_message.php');
		}
		$lesProduits=getLesProduits();
		include('vues/v_produitsEdit.php');
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