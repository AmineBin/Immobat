<!-- code html de la page-->
<h1 class="text-center">Suppression d'un propriétaire</h1>
<form action="/proprietaire/suppressionTrait" method='post'>
<div class="row mb-3">
        <label for="nom" class="col-lg-4 col-form-label">nom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="nom" readonly value="<?php if (isset($leProprio))  echo $leProprio->getNom();  ?>" id="nom">
        </div>
    </div>
    <div class="row mb-3">
        <label for="prenom" class="col-lg-4 col-form-label">Prénom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="prenom" readonly value="<?php if (isset($leProprio))  echo $leProprio->getPrenom();  ?>" id="prenom">
        </div>
    </div>
    <div class="row mb-3">
        <label for="email" class="col-lg-4 col-form-label">Email</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="email" readonly value="<?php if (isset($leProprio))  echo $leProprio->getEmail();  ?>" id="email">
        </div>
    </div>
    <div class="row mb-3">
        <label for="telephone" class="col-lg-4 col-form-label">Telephone</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="telephone" readonly value="<?php if (isset($leProprio))  echo $leProprio->getTelephone();  ?>" id="telephone">
        </div>
    </div>
    <div class="row mb-3">
        <label for="rue" class="col-lg-4 col-form-label">Rue</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="rue" readonly value="<?php if (isset($leProprio))  echo $leProprio->getRue();  ?>" id="rue">
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">La Ville</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstVille" disabled>
                 <?php foreach ($lesVilles as $uneVille) {
                    $insee = $uneVille->getInsee();
                    $nom = $uneVille->getNom();
                    //$selected = (isset($_POST['lstVille']) && $_POST['lstVille'] == $insee) ? "selected" : "";
                    if (isset($leProprio) && $leProprio->getLaVille()->getInsee() == $insee)
                        echo ("<option selected value=$insee>$nom </option>");
                    else
                        echo ("<option value=$insee>$nom</option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Le Mode de Gestion</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstModeGestion" disabled>
                <?php foreach ($lesModes as $unMode) {
                    $id = $unMode->getId();
                    $lib = $unMode->getLibelle();
                    //$selected = (isset($_POST['lstModeGestion']) && $_POST['lstModeGestion'] == $id) ? "selected" : "";
                    if (isset($leProprio) && $leProprio->getLeModeDeGestion()->getId() == $id)
                        echo ("<option selected value=$id>$lib</option>");
                    else
                        echo ("<option value=$id>$lib</option>");
                } ?>
            </select>
        </div>
    </div>

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