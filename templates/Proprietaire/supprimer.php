<!-- code html de la page-->
<h1 class="text-center">Suppression d'un propriétaire</h1>
<form action="/proprietaire/suppressionTrait" method='post'>


    <table class="table table-bordered table-lg">
        <thead class="table-light">
            <tr>
                <th scope="col">Nom Prenom</th>
                <th scope="col">Email</th>
                <th class="col">Téléphone</th>
                <th scope="col">Ville</th>
                <th scope="col">Rue</th>
            </tr>
        </thead>

        <td><?php echo $leProprio->getNom() . ' ' . $leProprio->getPrenom(); ?></td>
        <td><?php echo $leProprio->getEmail(); ?></td>
        <td><?php echo $leProprio->getTelephone(); ?></td>
        <td><?php echo $leProprio->getLaVille()->getNom(); ?></td>
        <td><?php echo $leProprio->getRue(); ?></td>
    </table>
    <input type="hidden" name="idProprio" value="<?php if ($leProprio != null) echo $leProprio->getId(); ?>" class="row mb-3">
   
    <div class="p-3 mb-4">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Supprimer</button>
        </div>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?>