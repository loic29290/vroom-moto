<main>
<div >
    <h2><?= $data['moto']->getModele() ?></h2>
    <p>Marque: <?= $data['moto']->getMarque() ?></p>
    <p>Année: <?= $data['moto']->getAnnee() ?></p>
    <p>Description: <?= $data['moto']->getDescription() ?></p>
    <p>Prix: <?= $data['moto']->getPrix() ?> €</p>
    <img src="<?= $data['moto']->getImage() ?>" />
    
    <!--garder l id de la moto pour la reservation -->
   <a href="index.php?page=reservation&id=<?= $data['moto']->getId() ?>">Réservation</a>
  
  </div>
  
   <?php
if (isset($data['avis'])) {
?>
<?php
    foreach($data['avis'] as $avis) {
?>
<div>
   <p>Auteur: <?= $avis->getAuteurId() ?></p>
   <p>Commentaire: <?= $avis->getCommentaire() ?></p>
   <p>Note: <?= $avis->getNote() ?>"</p>
   <p>Date: </p>
   </div>
   <?php
    }
}
?>
</div>
</main>