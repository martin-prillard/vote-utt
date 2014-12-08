<?php

include 'header.php'; 
	
//Récupération de tous les utilisateurs
//
$users = "SELECT * FROM user";
$resultat_users = sql($users);

?>

		<p href="" class="produits_labels">Gestion des utlisateurs</p>
		<div class="produit_hr"><img src="images/hr.png"/></div>
		<a class="link_add" href="admin_users_ajouter.php">Ajouter un utilisateur</a><br /><br />
		<table class="tab_admin">
		<tr>
			<td class="title">Email users</td>
			<td class="title">Date d'inscription</td>
			<td class="title">Admin</td>
			<td class="title">Supprimer</td>
		</tr>
		<?php
		//Afficher les users
		//
		foreach($resultat_users as $user){
			
			//Affichage des infos sur l'éléction
			//
			echo '<tr>';
				echo '<td class="cell">'.$user["user_email"].'</td>';
				echo '<td class="cell">'.$user["user_time_sign_up"].'</td>';
				echo '<td class="cell">'.$user["user_admin"].'</td>';
				echo '<td class="cell"><a href="admin_users_delete.php?user_id='.$user["user_id"].'">Supprimer</a></td>';
			echo '</tr>';
			
		}
		?>
		</table>
		
		
<?php include 'footer.php'; ?>	