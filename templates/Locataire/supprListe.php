<!-- code html de la page-->
<h2 class="text-center">Suppression d'un locataire</h2>
<form action="/locataire/supprForm" method='post'>

<?php
if (count($lesLocataires) == 0) {
    echo ("Il n'y a pas de locataire");
} else {
?>
    <table class="table table-bordered table-lg">
        <thead class="table-light">
            <tr>
            <th class="col">Nom</th>
                <th class="col">Prénom</th>
                <th class="col">Email</th>
                <th class="col">Téléphone</th>
                <th class="col">Rue</th>
                <th class="col">Ville</th>
                <th class="col">Impression</th>
                <th class="col">Catégorie socio-professionnelle</th>
            </tr>
        </thead>
        <?php foreach ($lesLocataires as $unLocataire) {?>
        <tr>
            
            <td><?php echo $unLocataire->getNom() ?></td>
            <td><?php echo $unLocataire->getPrenom() ?></td>
            <td><?php echo $unLocataire->getEmail() ?></td>
            <td><?php echo $unLocataire->getTelephone() ?></td>
            <td><?php echo $unLocataire->getRue()  ?></td>
            <td><?php echo $unLocataire->getVille()->getNom() ?></td>
            <td><?php echo $unLocataire->getImpression()->getLibelle() ?></td>
            <td><?php echo $unLocataire->getCategorieSocioprofessionnelle()->getLibelle() ?></td>
            <td>
                <button type="submit" class="btn btn-primary" name="supprimer" value="<?php echo $unLocataire->getId(); ?>">
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