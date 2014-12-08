<?php

include 'header.php'; 
	
//Récupération de toutes les éléctions
//
$elections = "SELECT * FROM election";
$resultat_elections = sql($elections);

?>

		<p href="" class="produits_labels">Suppression d'une élection</p>
		<div class="produit_hr"><img src="images/hr.png"/></div>
		
		<?php if($_GET['election_id']) { ?>
		
		<?php
			$sql = "DELETE FROM election WHERE election_id =  :election_id";
			$stmt = $bdd->prepare($sql);
			$stmt->bindParam(':election_id', $_GET['election_id'], PDO::PARAM_INT);   
			$stmt->execute();
			echo '<p>Element supprimé !</p>';
		?>
		<?php } ?>
		
		
<?php include 'footer.php'; ?>	