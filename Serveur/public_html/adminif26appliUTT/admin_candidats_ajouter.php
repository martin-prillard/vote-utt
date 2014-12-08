<?php

include 'header.php'; 
	
//Récupération de toutes les éléctions
//
$candidates = "SELECT * FROM candidate";
$resultat_candidates = sql($candidates);

?>

<p href="" class="produits_labels">Ajouter un candidat</p>
<div class="produit_hr"><img src="images/hr.png"/></div>

<?php if($_POST['candidate_name']) { ?>

<?php
	//Requête préparée anti injection SQL
	//
	$stmt = $bdd->prepare("INSERT INTO candidate (candidate_name, candidate_desc, candidate_url_picture) VALUES (:candidate_name, :candidate_desc, :candidate_url_picture)");
	$stmt->bindParam(':candidate_name', $candidate_name);
	$stmt->bindParam(':candidate_desc', $candidate_desc);
	$stmt->bindParam(':candidate_url_picture', $candidate_url_picture);
	
	// insertion d'un candidat dans la base de donnée
	//
	$candidate_name = htmlspecialchars($_POST['candidate_name']);
	$candidate_desc = htmlspecialchars($_POST['candidate_desc']);
	$candidate_url_picture = $_FILES['candidate_url_picture']['name']."";
	$stmt->execute();
	
	$nom = "../candidats/".$_FILES['candidate_url_picture']['name']."";
	$resultat = move_uploaded_file($_FILES['candidate_url_picture']['tmp_name'],$nom);
	if ($resultat) echo "Transfert réussi";

	echo '<p>Element inséré !</p>';
?>

<?php } else { ?>

<form action="admin_candidats_ajouter.php" method="post" enctype="multipart/form-data">
	<table>
		<tr>
			<td><label for="candidate_name">Nom du candidat : </label></td>
			<td><input name="candidate_name" /></td>
		</tr>
		
		<tr>
			<td><label for="candidate_desc">Description du candidat : </label></td>
			<td><textarea width="800" height="400" name="candidate_desc" ></textarea></td>
		</tr>
		
		<tr>
			<td><label for="candidate_url_picture">Image du candidat : </label></td>
			<td><input type="file" name="candidate_url_picture" /></td>
		</tr>
		
		<tr>
			<td><input type="submit" value="insérer" /></td>
		</tr>
	</table>
</form>

<?php } ?>
		
<?php include 'footer.php'; ?>	