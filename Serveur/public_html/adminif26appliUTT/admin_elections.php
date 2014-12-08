<?php

include 'header.php'; 
	
//Récupération de toutes les éléctions
//
$elections = "SELECT * FROM election";
$resultat_elections = sql($elections);

?>

		<p href="" class="produits_labels">Gestion des éléctions</p>
		<div class="produit_hr"><img src="images/hr.png"/></div>
		<a class="link_add" href="admin_elections_ajouter.php">Ajouter une élection</a><br /><br />
		<table class="tab_admin">
		<tr>
			<td class="title">Label éléctions</td>
			<td class="title">Début elections</td>
			<td class="title">Fin éléctions</td>
			<td class="title">Modifier</td>
			<td class="title">Supprimer</td>
		</tr>
		<?php
		//Afficher les éléctions
		//
		foreach($resultat_elections as $election){
			
			//Affichage des infos sur l'éléction
			//
			echo '<tr>';
				echo '<td class="cell">'.$election["election_label"].'</td>';
				echo '<td class="cell">'.$election["election_time_start"].'</td>';
				echo '<td class="cell">'.$election["election_time_end"].'</td>';
				echo '<td class="cell"><a href="admin_elections_modifier.php?election_id='.$election["election_id"].'">Modifier</a></td>';
				echo '<td class="cell"><a href="admin_elections_delete.php?election_id='.$election["election_id"].'">Supprimer</a></td>';
			echo '</tr>';
			
		}
		?>
		</table>
		
		
<?php include 'footer.php'; ?>	