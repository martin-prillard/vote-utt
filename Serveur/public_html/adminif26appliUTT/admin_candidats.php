<?php

include 'header.php'; 
	
//Récupération de tous les candidats
//
$candidats = "SELECT * FROM candidate";
$resultat_candidats = sql($candidats);

?>

<p href="" class="produits_labels">Gestion des candidats</p>
<div class="produit_hr"><img src="images/hr.png"/></div>
<a class="link_add" href="admin_candidats_ajouter.php">Ajouter un candidat</a><br /><br />
<a class="link_add" href="admin_candidats_associations.php">Gérer les associations candidats-élections</a><br /><br />
<table class="tab_admin">
	<tr>
		<td class="title">Noms candidats</td>
		<td class="title">Descriptions candidats</td>
		<td class="title">Photos candidats</td>
		<td class="title">Modifier</td>
		<td class="title">Supprimer</td>
	</tr>
	<?php
	//Afficher les candidats
	//
	foreach($resultat_candidats as $candidat){
		
		//Affichage des infos sur les candidats
		//
		echo '<tr>';
			echo '<td class="cell">'.$candidat["candidate_name"].'</td>';
			echo '<td class="cell">'.$candidat["candidate_desc"].'</td>';
			echo '<td class="cell"><img width="100" height="100" src="../candidats/'.$candidat["candidate_url_picture"].'"/></td>';
			echo '<td class="cell"><a href="admin_candidats_modifier.php?candidate_id='.$candidat["candidate_id"].'">Modifier</a></td>';
			echo '<td class="cell"><a href="admin_candidats_delete.php?candidate_id='.$candidat["candidate_id"].'">Supprimer</a></td>';
		echo '</tr>';
		
	}
	?>
</table>
			
<?php include 'footer.php'; ?>	