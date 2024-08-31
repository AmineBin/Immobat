<!-- code html de la page-->
<h1 class="text-center">Suppression d'un propriétaire</h1>
<form action="/proprietaire/suppressionForm" method='post'>

<?php
if (count($lesProprios) == 0) {
    echo ("Il n'y a pas de proprietaire");
} else {
?>
    <table class="table table-bordered table-lg">
        <thead class="table-light">
            <tr>
                <th scope="col">Nom Prenom</th>
                <th class="col">Téléphone</th>
                <th scope="col">Ville</th>
               <th scope="col">Rue</th>
            </tr>
        </thead>
        <?php foreach ($lesProprios as $unProprio) { ?>
    <tr>
        <td><?php echo $unProprio->getNom() . ' ' . $unProprio->getPrenom(); ?></td>
        <td><?php echo $unProprio->getTelephone(); ?></td>
        <td><?php echo $unProprio->getLaVille()->getNom(); ?></td>
        <td><?php echo $unProprio->getRue(); ?></td>
        <td>
             <button type="submit" class="btn btn-primary" name="supprimer" value="<?php echo $unProprio->getId(); ?>">
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
