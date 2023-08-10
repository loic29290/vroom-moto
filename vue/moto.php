<main>
<div >
    <h2><?= $data['moto']->getModele() ?></h2>
    <p>Marque: <?= $data['moto']->getMarque() ?></p>
    <p>Année: <?= $data['moto']->getAnnee() ?></p>
    <p>Description: <?= $data['moto']->getDescription() ?></p>
    <p>Prix: <?= $data['moto']->getPrix() ?> €</p>
    <img src="<?= $data['moto']->getImageUrl() ?>" />
     <form method="POST">
          <label for="debut">Début:</label>
        <input type="date" id="debut" name="debut" required><br>

         <label for="fin">Fin:</label>
        <input type="date" id="fin" name="fin" required><br>

    <button name="submit" name="reserver" >Réserver moto</button>
      </form>
    
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