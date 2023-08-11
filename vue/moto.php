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
    
</div>


    <form method="POST">
        <textarea name="commentaire" placeholder="Avis"></textarea>
        <p>Note</p>
        <select name="note">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <button name="envoyerAvis" name="avis" value="" >Envoyer</button>
        </form>
    
    




</main>