<?php

include 'header.php'; 
	
//Récupération de toutes les éléctions
//
$elections = "SELECT * FROM election";
$resultat_elections = sql($elections);

?>

		<p href="" class="produits_labels">Modifier une élection</p>
		<div class="produit_hr"><img src="images/hr.png"/></div>
		
		<?php if($_POST['election_label']) { ?>
		
		<?php
			$stmt = $bdd->prepare("UPDATE election SET election_label = :election_label, election_time_start = :election_time_start, election_time_end = :election_time_end 
								   WHERE election_id = :election_id");
			$stmt->bindParam(':election_label', $election_label);
			$stmt->bindParam(':election_time_start', $election_time_start);
			$stmt->bindParam(':election_time_end', $election_time_end);
			$stmt->bindParam(':election_id', $election_id);
			
			// insertion d'une ligne
			//
			$election_label = htmlspecialchars($_POST['election_label']);
			$election_time_start = htmlspecialchars($_POST['election_time_start']);
			$election_time_end = htmlspecialchars($_POST['election_time_end']);
			$election_id = htmlspecialchars($_POST['election_id']);
			$stmt->execute();
			echo '<p>Element modifié !</p>';
		?>
		
		<?php } elseif($_GET['election_id']) { ?>
		<?php
		//Récupération de toutes les éléctions
		//
		$election_mod = "SELECT * FROM election WHERE election_id=".$_GET['election_id']."";
		$resultat_election_mod = sql($election_mod);
		?>
		
		<form action="admin_elections_modifier.php" method="post">
			<table>
				<tr>
				<td><label for="election_label">Label de l'élection : </label></td>
				<td><input name="election_label" value="<? echo $resultat_election_mod[0]["election_label"]; ?>" /></td>
				</tr>
				
				<tr>
				<td><label for="election_time_start">Date de début : </label></td>
				<td><input name="election_time_start" value="<? echo $resultat_election_mod[0]["election_time_start"]; ?>" /></td>
				</tr>
				
				<tr>
				<td><label for="election_time_end">Date de fin : </label></td>
				<td><input name="election_time_end" value="<? echo $resultat_election_mod[0]["election_time_end"]; ?>" /></td>
				</tr>
				
				<tr>
				<td><input name="election_id" type="hidden" value="<? echo $_GET["election_id"]; ?>" /><input type="submit" value="modifier" /></td>
				</tr>
			</table>
		</form>
		<?php } ?>
		
		
<?php include 'footer.php'; ?>	