<main>
    <div>
    <form method="POST" enctype="multipart/form-data">
        <input name="marque" placeholder="marque" value="<?= $data['moto']->getMarque() ?>" />
        <input name="modele" placeholder="modele" value="<?= $data['moto']->getModele() ?>" />
        <select name="categorie">
            <option value="">Toutes les catégories</option>
            <option value="Sportive">Sportive</option>
            <option value="Roadster">Roadster</option>
            <option value="Trail">Trail</option>
            <option value="Routiere">Routiére</option>
            <option value="Cross">Cross</option>
            <option value="Scooter">Scooter</option>
        </select>
        <input name="annee" type="number" placeholder="annee" />
        <select name="bridee">
            <option value="">Bridage</option>
            <option value="oui">oui</option>
            <option value="non">non</option>
        </select>
        <textarea name="description" placeholder="Description de la moto"></textarea>
        <input name="prix" type="number" placeholder="prix" />
        <input type="file" name="file" id="imageFile">
        <button name="submit">Envoyer</button>
    </form>
    </div>
</main>