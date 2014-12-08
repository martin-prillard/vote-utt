<?php

include 'header.php'; 
	
//Récupération de toutes les éléctions
//
$elections = "SELECT * FROM election";
$resultat_elections = sql($elections);

?>

		<p href="" class="produits_labels">Ajouter une élection</p>
		<div class="produit_hr"><img src="images/hr.png"/></div>
		
		<?php if($_POST['election_label']) { ?>
		
		<?php
			$stmt = $bdd->prepare("INSERT INTO election (election_label, election_time_start, election_time_end) VALUES (:election_label, :election_time_start, :election_time_end)");
			$stmt->bindParam(':election_label', $election_label);
			$stmt->bindParam(':election_time_start', $election_time_start);
			$stmt->bindParam(':election_time_end', $election_time_end);
			
			// insertion d'une ligne
			//
			$election_label = htmlspecialchars($_POST['election_label']);
			$election_time_start = htmlspecialchars($_POST['election_time_start']);
			$election_time_end = htmlspecialchars($_POST['election_time_end']);
			$stmt->execute();
			echo '<p>Element inséré !</p>';
		?>
		
		<?php } else { ?>
		
		<form action="admin_elections_ajouter.php" method="post">
			<table>
				<tr>
				<td><label for="election_label">Label de l'élection : </label></td>
				<td><input name="election_label" /></td>
				</tr>
				
				<tr>
				<td><label for="election_time_start">Date de début : </label></td>
				<td><input name="election_time_start" /></td>
				</tr>
				
				<tr>
				<td><label for="election_time_end">Date de fin : </label></td>
				<td><input name="election_time_end" /></td>
				</tr>
				
				<tr>
				<td><input type="submit" value="insérer" /></td>
				</tr>
			</table>
		</form>
		<?php } ?>
		
		
<?php include 'footer.php'; ?>	