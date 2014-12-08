<?php

include 'header.php'; 
	
//Récupération de toutes les éléctions
//
$candidates = "SELECT * FROM candidate";
$resultat_candidates = sql($candidates);

?>

		<p href="" class="produits_labels">Modifier une élection</p>
		<div class="produit_hr"><img src="images/hr.png"/></div>
		
		<?php if($_POST['candidate_name']) { ?>
		
		<?php
			$stmt = $bdd->prepare("UPDATE candidate SET candidate_name = :candidate_name, candidate_desc = :candidate_desc, candidate_url_picture = :candidate_url_picture 
								   WHERE candidate_id = :candidate_id");
			$stmt->bindParam(':candidate_name', $candidate_name);
			$stmt->bindParam(':candidate_desc', $candidate_desc);
			$stmt->bindParam(':candidate_url_picture', $candidate_url_picture);
			$stmt->bindParam(':candidate_id', $candidate_id);
			
			// insertion d'une ligne
			//
			$candidate_name = htmlspecialchars($_POST['candidate_name']);
			$candidate_desc = htmlspecialchars($_POST['candidate_desc']);
			$candidate_url_picture = htmlspecialchars($_POST['candidate_url_picture']);
			$candidate_id = htmlspecialchars($_POST['candidate_id']);
			$stmt->execute();
			echo '<p>Element modifié !</p>';
		?>
		
		<?php } elseif($_GET['candidate_id']) { ?>
		<?php
		//Récupération de toutes les éléctions
		//
		$candidate_mod = "SELECT * FROM candidate WHERE candidate_id=".$_GET['candidate_id']."";
		$resultat_candidate_mod = sql($candidate_mod);
		?>
		
		<form action="admin_candidats_modifier.php" method="post">
			<table>
				<tr>
				<td><label for="candidate_name">Nom du candidat : </label></td>
				<td><input name="candidate_name" value="<? echo $resultat_candidate_mod[0]["candidate_name"]; ?>" /></td>
				</tr>
				
				<tr>
				<td><label for="candidate_desc">Description du candidat : </label></td>
				<td><input name="candidate_desc" value="<? echo $resultat_candidate_mod[0]["candidate_desc"]; ?>" /></td>
				</tr>
				
				<tr>				
				<td><label for="candidate_url_picture">Image de candidat : </label></td>
				<td><input name="candidate_url_picture" value="<? echo $resultat_candidate_mod[0]["candidate_url_picture"]; ?>" /></td>
				</tr>
				
				<tr>
				<td><input name="candidate_id" type="hidden" value="<? echo $_GET["candidate_id"]; ?>" /><input type="submit" value="modifier" /></td>
				</tr>
			</table>
		</form>
		<?php } ?>
		
		
<?php include 'footer.php'; ?>	