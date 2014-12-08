<?php

include 'header.php'; 
	
//Récupération de toutes les éléctions
//
$elections = "SELECT * FROM election";
$resultat_elections = sql($elections);

?>

		<p href="" class="produits_labels">Suppression d'un candidat</p>
		<div class="produit_hr"><img src="images/hr.png"/></div>
		
		<?php if($_GET['candidate_id']) { ?>
		
		<?php
			$sql = "DELETE FROM candidate WHERE candidate_id =  :candidate_id";
			$stmt = $bdd->prepare($sql);
			$stmt->bindParam(':candidate_id', $_GET['candidate_id'], PDO::PARAM_INT);   
			$stmt->execute();
			echo '<p>Element supprimé !</p>';
		?>
		<?php } ?>
		
		
<?php include 'footer.php'; ?>	