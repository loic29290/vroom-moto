<main>
<div >
    <h2><?= $data['moto']->getModele() ?></h2>
    <p>Marque: <?= $data['moto']->getMarque() ?></p>
    <p>Année: <?= $data['moto']->getAnnee() ?></p>
    <p>Description: <?= $data['moto']->getDescription() ?></p>
    <p>Prix: <?= $data['moto']->getPrix() ?> €</p>
    <img src="<?= $data['moto']->getImageUrl() ?>" />
    
    <!--garder l id de la moto pour la reservation -->
   <a href="index.php?page=reservation&id=<?= $data['moto']->getId() ?>">Réservation</a>
     <!--garder l id de la moto pour l'avis -->
   <a href="index.php?page=avis&id=<?= $data['moto']->getId() ?>">Avis</a>
   
</div>
</main>