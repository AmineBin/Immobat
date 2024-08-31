<!-- code html de la page-->
<h1 class="text-center">Suppression d'un locataire</h1>
<form action="/locataire/supprTrait" method='post'>
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
            <td><?php echo $leLoca->getNom() ?></td>
            <td><?php echo $leLoca->getPrenom() ?></td>
            <td><?php echo $leLoca->getEmail() ?></td>
            <td><?php echo $leLoca->getTelephone() ?></td>
            <td><?php echo $leLoca->getRue()  ?></td>
            <td><?php echo $leLoca->getVille()->getNom() ?></td>
            <td><?php echo $leLoca->getImpression()->getLibelle() ?></td>
            <td><?php echo $leLoca->getCategorieSocioprofessionnelle()->getLibelle() ?></td>
    </table>
    <input type="hidden" name="idLocataire" value="<?php if ($leLoca != null) echo $leLoca->getId(); ?>" class="row mb-3">
    <input type="hidden" name="nom" value="<?php if ($leLoca != null) echo $leLoca->getNom(); ?>" class="row mb-3">
    <input type="hidden" name="prenom" value="<?php if ($leLoca != null) echo $leLoca->getPrenom(); ?>" class="row mb-3">
    <input type="hidden" name="email" value="<?php if ($leLoca != null) echo $leLoca->getEmail(); ?>" class="row mb-3">
    <input type="hidden" name="telephone" value="<?php if ($leLoca != null) echo $leLoca->getTelephone(); ?>" class="row mb-3">
    <input type="hidden" name="rue" value="<?php if ($leLoca != null) echo $leLoca->getRue(); ?>" class="row mb-3">
    <input type="hidden" name="lstVille" value="<?php if ($leLoca != null) echo $leLoca->getVille()->getInsee(); ?>" class="row mb-3">
    <input type="hidden" name="lstImpression" value="<?php if ($leLoca != null) echo $leLoca->getImpression()->getId(); ?>" class="row mb-3">
    <input type="hidden" name="lstCategorieSocioprofessionnelle" value="<?php if ($leLoca != null) echo $leLoca->getCategorieSocioprofessionnelle()->getId(); ?>" class="row mb-3">

    <div class="p-3 mb-4">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Supprimer</button>
        </div>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?>