<!-- code html de la page-->
<h2 class="text-center">Suppression d'un appartement</h2>
<form action="/appartement/supprForm" method='post'>

<?php
if (count($lesApparts) == 0) {
    echo ("Il n'y a pas d'appartements");
} else {
?>
    <table class="table table-bordered table-lg">
        <thead class="table-light">
            <tr>
                <th scope="col">Type d'appartement</th>
                <th scope="col">rue</th>
                <th scope="col">batiment</th>
                <th scope="col">etage</th>
                <th class="col">superficie</th>
                <th scope="col">orientation</th>
                <th scope="col">nombre de pièces</th>
                <th scope="col">propriétaire</th>
                <th scope="col">ville</th>
            </tr>
        </thead>
        <?php foreach ($lesApparts as $unAppart) {?>
        <tr>
            <td><?php echo $unAppart->getCategorieAppartement()->getLibelle() ?></td>
            <td><?php echo $unAppart->getRue() ?></td>
            <td><?php echo $unAppart->getBatiment() ?></td>
            <td><?php echo $unAppart->getEtage() ?></td>
            <td><?php echo $unAppart->getSuperficie() ?></td>
            <td><?php echo $unAppart->getOrientation()  ?></td>
            <td><?php echo $unAppart->getNbPiece() ?></td>
            <td><?php echo $unAppart->getProprietaire()->getNom() ?></td>
            <td><?php echo $unAppart->getVille()->getNom() ?></td>
            <td>
             <button type="submit" class="btn btn-primary" name="supprimer" value="<?php echo $unAppart->getId(); ?>">
                Supprimer
            </button>
            <!-- <button type="submit" class="btn btn-primary">Supprimer</button> -->
        </td>
    </tr>
<?php } ?>
    </table>
<?php
if (isset($msg)) echo $msg;

}
?>