<main>
<form method="POST">
    <input name="marque" placeholder="marque" value="<?= $data['moto']->getMarque() ?>"/>
    <input name="modele" placeholder="modele" value="<?= $data['moto']->getModele() ?>"/>
     <select name="Categorie">
          <option value="">Toutes les catégories</option>
            <option value="Sportive">Sportive</option>
            <option value="Roadster">Roadster</option>
            <option value="Trail">Trail</option>
            <option value="Routiére">Routiére</option>
            <option value="Cross">Cross</option>
            <option value="Scooter">Scooter</option>
        </select>
    <input name="annee" type="number" placeholder="annee" />
    <textarea name="description" placeholder="Description de la moto"></textarea>
    <input name="prix" type="number" placeholder="prix" />
    <input name="image_url" type="url" placeholder="URL d'une image" />
    <button name="submit">Envoyer</button>
</form>
</main>