<main>

<div>
    
<h2>Recherche de Motos</h2>

<form method="GET" action="">
    <input type="text" name="search" placeholder="Rechercher par nom">
    <select name="category">
        <option value="">Toutes les catégories</option>
        <option value="0">Sportive</option>
            <option value="1">Roadster</option>
            <option value="2">Trail</option>
            <option value="3">Routiére</option>
            <option value="4">Cross</option>
            <option value="5">Scooter</option>
    </select>
    <input type="submit" value="Rechercher">
</form>
</div>

<?php

foreach($data['motos'] as $moto) {
?>
    <div>
        <h2><a href="index.php?page=moto&id=<?= $moto->getId() ?>"><?= $moto->getModele() ?></a></h2>
        <img src="<?= $moto->getImage() ?>" />
    </div>
<?php
}
?>
</main>