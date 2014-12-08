<?php

include 'header.php'; 
		
//Récupération de toutes les éléctions
//
$election_candidate = "SELECT * FROM election_candidate";
$election_candidate_candidats = sql($election_candidate);

//Récupération de tous les candidats
//
$candidates = "SELECT * FROM candidate";
$resultat_candidates = sql($candidates);

//Récupération de toutes les elections
//
$elections = "SELECT * FROM election";
$resultat_elections = sql($elections);

?>

		<p href="" class="produits_labels">Gestion des associations candidats-élections</p>
		<div class="produit_hr"><img src="images/hr.png"/></div>
		
		<form action="admin_candidats_associations.php" method="post">
			<label for="candidate_id">Nom du candidat : </label>
			<select name="candidate_id">
				<?php foreach($resultat_candidates as $candidates){
					echo '<option value="'.$candidates["candidate_id"].'">'.$candidates["candidate_name"].'</option>';
				} ?>
			</select>
			
			<label for="election_id">Label election : </label>
			<select name="election_id">
				<?php foreach($resultat_elections as $elections){
					echo '<option value="'.$elections["election_id"].'">'.$elections["election_label"].'</option>';
				} ?>
			</select>
			
			<input type="submit" value="associer"/>
		</form>
		
		<table class="tab_admin">
		<tr>
			<td class="title">Noms candidats</td>
			<td class="title">ID candidats</td>
			<td class="title">Labels elections</td>
			<td class="title">ID elections</td>
			<td class="title">Supprimer</td>
		</tr>
		<?php
		
		//Ajout de l'association si elle existe
		//
		if($_POST["candidate_id"]){
			
			$stmt = $bdd->prepare("INSERT INTO election_candidate (election_id, candidate_id) VALUES (:election_id, :candidate_id)");
			$stmt->bindParam(':election_id', $election_id);
			$stmt->bindParam(':candidate_id', $candidate_id);
			
			// insertion d'une ligne
			//
			$election_id = htmlspecialchars($_POST['election_id']);
			$candidate_id = htmlspecialchars($_POST['candidate_id']);
			$stmt->execute();
		}
		
		//Suppression si les variables existent
		//
		if($_GET['election_id'] && $_GET['candidate_id']) {

			$sql = "DELETE FROM election_candidate WHERE election_id = :election_id AND candidate_id = :candidate_id ";
			
			$stmt = $bdd->prepare($sql);
			$stmt->bindParam(':election_id', $_GET['election_id']);   
			$stmt->bindParam(':candidate_id', $_GET['candidate_id']);   
			$stmt->execute();
		}
		
		//Afficher les candidats
		//
		foreach($election_candidate_candidats as $election_candidate){
			
			//Récupération des nom et label candidat election
			//
			//Recuperation du candidat
			//
			$candidat_associe = "SELECT * FROM candidate WHERE `candidate_id`='".$election_candidate["candidate_id"]."'";
			$resultat_candidat_associe = sql($candidat_associe);
			
			//Recuperation de l'election
			//
			$election_associe = "SELECT * FROM election WHERE `election_id`='".$election_candidate["election_id"]."'";
			$resultat_election_associe = sql($election_associe);
			
			//Affichage des infos sur l'éléction
			//
			echo '<tr>';
				echo '<td class="cell">'.$resultat_candidat_associe[0]["candidate_name"].'</td>';
				echo '<td class="cell">'.$election_candidate["candidate_id"].'</td>';
				
				echo '<td class="cell">'.$resultat_election_associe[0]["election_label"].'</td>';
				echo '<td class="cell">'.$election_candidate["election_id"].'</td>';
				
				echo '<td class="cell"><a href="admin_candidats_associations.php?election_id='.$election_candidate["election_id"].'&candidate_id='.$election_candidate["candidate_id"].'">Supprimer</a></td>';
			echo '</tr>';
			
		}
		?>
		</table>
		
		
<?php include 'footer.php'; ?>	