<main>
<form method="POST">
    <input name="marque" placeholder="marque" value="<?= $data['moto']->getMarque() ?>"/>
    <input name="modele" placeholder="modele" value="<?= $data['moto']->getModele() ?>"/>
    <input name="annee" type="number" placeholder="annee" />
    <textarea name="description" placeholder="Description de la moto"></textarea>
    <input name="prix" type="number" placeholder="prix" />
    <input name="image_url" type="url" placeholder="URL d'une image" />
    <button name="submit">Envoyer</button>
</form>
</main>