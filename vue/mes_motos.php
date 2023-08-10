<main>
<h1>Mes motos/ Réservations</h1>
<?php

foreach($data['motos'] as $moto) {
?>
    <div>
        <form method="POST">
        <h2><a href="index.php?page=moto&id=<?= $moto->getId() ?>"><?= $moto->getModele() ?></a></h2>
        <button name="supprimerMoto" name="supprimer" value="<?= $moto->getId() ?>" >Supprimer moto</button>
        </form>
    </div>
<?php
}
?>
</main>