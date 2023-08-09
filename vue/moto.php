<main>
<div >
    <h2><?= $data['moto']->getMarque() ?></h2>
    <p><?= $data['moto']->getModele() ?></p>
    <p><?= $data['moto']->getAnnee() ?></p>
    <p><?= $data['moto']->getDescription() ?></p>
    <p><?= $data['moto']->getPrix() ?></p>
    <img src="<?= $data['moto']->getImageUrl() ?>" />
     <form method="POST">
    <button name="reserverMoto" name="reserver" >Réserver moto</button>
      </form>
    
</div>


    <form method="POST">
        <textarea name="avis" placeholder="Avis"></textarea>
        <p>Note</p>
        <select name="rating">
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