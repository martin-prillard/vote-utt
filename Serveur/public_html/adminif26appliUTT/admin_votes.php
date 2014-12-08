<?php

include 'header.php'; 
	
//Récupération de toutes les votes
//
$votes = "SELECT * FROM vote";
$resultat_votes = sql($votes);
?>

		<p href="" class="produits_labels">Gestion des votes</p>
		<div class="produit_hr"><img src="images/hr.png"/></div>
		
		<table class="tab_admin">
		<tr>
			<td class="title">Email users</td>
			<td class="title">Candidat</td>
			<td class="title">Election</td>
			<td class="title">Date du vote</td>
			<td class="title">Supprimer</td>
		</tr>
		<?php
		//Afficher les users
		//
		foreach($resultat_votes as $vote){
			
			//Recuperation de l'user
			//
			$user_associe = "SELECT * FROM user WHERE `user_id`='".$vote["user_id"]."'";
			$resultat_user_associe = sql($user_associe);
			
			//Recuperation du candidat
			//
			$candidat_associe = "SELECT * FROM candidate WHERE `candidate_id`='".$vote["candidate_id"]."'";
			$resultat_candidat_associe = sql($candidat_associe);
			
			//Recuperation de l'election
			//
			$election_associe = "SELECT * FROM election WHERE `election_id`='".$vote["election_id"]."'";
			$resultat_election_associe = sql($election_associe);
			
			//Affichage des infos sur les votes
			//
			echo '<tr>';
				echo '<td class="cell">'.$resultat_user_associe[0]["user_email"].'</td>';
				echo '<td class="cell">'.$resultat_candidat_associe[0]["candidate_name"].'</td>';
				echo '<td class="cell">'.$resultat_election_associe[0]["election_label"].'</td>';
				echo '<td class="cell">'.$vote["vote_time_voted"].'</td>';
				echo '<td class="cell"><a href="admin_votes_delete.php?user_id='.$vote["user_id"].'&election_id='.$vote["election_id"].'&candidate_id='.$vote["candidate_id"].'">Supprimer</a></td>';
			echo '</tr>';
			
		}
		?>
		</table>
		
		
<?php include 'footer.php'; ?>	