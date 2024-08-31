<!-- code html de la page-->
<h1 class="text-center">suppression d'un appartement</h1>
<form action="/appartement/supprTrait" method='post'>
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
        <td><?php echo $lAppart->getCategorieAppartement()->getLibelle(); ?></td>
        <td><?php echo $lAppart->getRue(); ?></td>
        <td><?php echo $lAppart->getBatiment(); ?></td>
        <td><?php echo $lAppart->getEtage(); ?></td>
        <td><?php echo $lAppart->getSuperficie(); ?></td>
        <td><?php echo $lAppart->getOrientation(); ?></td>
        <td><?php echo $lAppart->getNbPiece(); ?></td>
        <td><?php echo $lAppart->getProprietaire()->getNom(); ?></td>
        <td><?php echo $lAppart->getVille()->getNom(); ?></td>
    </table>
    <!--Valeur à supprimer-->
    <input type="hidden" name="idAppart" value="<?php if ($lAppart != null) echo $lAppart->getId(); ?>" class="row mb-3">
    <input type="hidden" name="rue" value="<?php if ($lAppart != null) echo $lAppart->getRue(); ?>" class="row mb-3">
    <input type="hidden" name="batiment" value="<?php if ($lAppart != null) echo $lAppart->getBatiment(); ?>" class="row mb-3">
    <input type="hidden" name="etage" value="<?php if ($lAppart != null) echo $lAppart->getEtage(); ?>" class="row mb-3">
    <input type="hidden" name="superficie" value="<?php if ($lAppart != null) echo $lAppart->getSuperficie(); ?>" class="row mb-3">
    <input type="hidden" name="orientation" value="<?php if ($lAppart != null) echo $lAppart->getOrientation(); ?>" class="row mb-3">
    <input type="hidden" name="nb_piece" value="<?php if ($lAppart != null) echo $lAppart->getNbPiece(); ?>" class="row mb-3">
    <input type="hidden" name="lstTypeAppart" value="<?php if ($lAppart != null) echo $lAppart->getCategorieAppartement()->getId(); ?>" class="row mb-3">
    <input type="hidden" name="lstProprietaire" value="<?php if ($lAppart != null) echo $lAppart->getProprietaire()->getId(); ?>" class="row mb-3">
    <input type="hidden" name="lstVille" value="<?php if ($lAppart != null) echo $lAppart->getVille()->getInsee(); ?>" class="row mb-3">

    <div class="p-3 mb-4">
        <div class="text-center">
            <button type="submit" name = "supprimer" value="supprimer" class="btn btn-primary">Supprimer</button>
            <button type="yes" class="btn btn-primary">Annuler</button>
        </div>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?>