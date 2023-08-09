<main>
<h1>Liste des motos</h1>
<?php

foreach($data['motos'] as $moto) {
?>
    <div>
        <h2><a href="index.php?page=moto&id=<?= $moto->getId() ?>"><?= $moto->getModele() ?></a></h2>
        <img src="<?= $moto->getImageUrl() ?>" />
    </div>
<?php
}
?>
</main>