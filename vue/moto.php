<main>
<div>
    <h1><?= $data['moto']->getMarque() ?></h1>
    <p><?= $data['moto']->getModele() ?></p>
    <p><?= $data['moto']->getAnnee() ?></p>
    <p><?= $data['moto']->getDescription() ?></p>
    <p><?= $data['moto']->getPrix() ?></p>
    <img src="<?= $data['moto']->getImageUrl() ?>" />
</div>
</main>