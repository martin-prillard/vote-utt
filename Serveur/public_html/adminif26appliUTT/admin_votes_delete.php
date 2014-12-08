<?php

include 'header.php'; 
	
//Récupération de toutes les éléctions
//
$elections = "SELECT * FROM election";
$resultat_elections = sql($elections);

?>

		<p href="" class="produits_labels">Suppression d'un vote</p>
		<div class="produit_hr"><img src="images/hr.png"/></div>
		
		<?php if($_GET['user_id']) { ?>
		
		<?php
			$sql = "DELETE FROM vote WHERE candidate_id =  :candidate_id AND user_id =  :user_id AND election_id =  :election_id";
			$stmt = $bdd->prepare($sql);
			$stmt->bindParam(':candidate_id', $_GET['candidate_id'], PDO::PARAM_INT);   
			$stmt->bindParam(':election_id', $_GET['election_id'], PDO::PARAM_INT);   
			$stmt->bindParam(':user_id', $_GET['user_id'], PDO::PARAM_INT);   
			$stmt->execute();
			echo '<p>Element supprimé !</p>';
		?>
		<?php } ?>
		
		
<?php include 'footer.php'; ?>	