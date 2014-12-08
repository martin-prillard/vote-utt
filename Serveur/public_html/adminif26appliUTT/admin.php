<?php

include 'header.php'; 
	
//Récupération de toutes les catégories
//
$achats = "SELECT * FROM projet_vente_achats";
$resultat_achats = sql($achats);

?>

<p href="" class="produits_labels">Administration VOTE UTT</p>
<div class="produit_hr"><img src="images/hr.png"/></div>

<p>Auteurs : Martin Prillard & Vincent Courtade. Touts droits réservés</p>
		
<?php 
include 'footer.php';
?>	