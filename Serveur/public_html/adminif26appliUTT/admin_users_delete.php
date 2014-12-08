<?php

include 'header.php'; 
?>

		<p href="" class="produits_labels">Suppression d'un user</p>
		<div class="produit_hr"><img src="images/hr.png"/></div>
		
		<?php if($_GET['user_id']) { ?>
		
		<?php
			$sql = "DELETE FROM user WHERE user_id =  :user_id";
			$stmt = $bdd->prepare($sql);
			$stmt->bindParam(':user_id', $_GET['user_id'], PDO::PARAM_INT);   
			$stmt->execute();
			echo '<p>Element supprimé !</p>';
		?>
		<?php } ?>
		
		
<?php include 'footer.php'; ?>	