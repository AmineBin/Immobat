<h1 class="text-center">Ajout d'un propriétaire</h1>
<form action="/proprietaire/ajoutTrait" method='post'>
    <div class="row mb-3">
        <label for="nom" class="col-lg-4 col-form-label">Nom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="nom" value="<?php if (isset($leProprio))  echo $leProprio->getNom();  ?>" id="nom">
        </div>
    </div>
    <div class="row mb-3">
        <label for="prenom" class="col-lg-4 col-form-label">Prénom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="prenom" value="<?php if (isset($leProprio))  echo $leProprio->getPrenom();  ?>" id="prenom">
        </div>
    </div>
    <div class="row mb-3">
        <label for="email" class="col-lg-4 col-form-label">Email</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="email" value="<?php if (isset($leProprio))  echo $leProprio->getEmail();  ?>" id="email">
        </div>
    </div>
    <div class="row mb-3">
        <label for="telephone" class="col-lg-4 col-form-label">Téléphone</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="telephone" value="<?php if (isset($leProprio))  echo $leProprio->getTelephone();  ?>" id="telephone">
        </div>
    </div>
    <div class="row mb-3">
        <label for="rue" class="col-lg-4 col-form-label">Rue</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="rue" value="<?php if (isset($leProprio))  echo $leProprio->getRue();  ?>" id="rue">
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Ville</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstVille">
                <?php foreach ($lesVilles as $uneVille) {
                    $insee = $uneVille->getInsee();
                    $nom = $uneVille->getNom();
                    if (isset($leProprio) && $leProprio->getLaVille()->getInsee() == $insee)
                        echo ("<option selected value=$insee>$nom $insee</option>");
                    else
                        echo ("<option value=$insee>$nom $insee</option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Mode de gestion</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstModeGestion">
                <?php foreach ($lesModes as $unMode) {
                    $id = $unMode->getId();
                    $lib = $unMode->getLibelle();
                    if (isset($leProprio) && $leProprio->getLeModeDeGestion()->getId() == $id)
                        echo ("<option selected value=$id>$lib</option>");
                    else
                        echo ("<option value=$id>$lib</option>");
                } ?>
            </select>
        </div>
    </div>

    <div class="p-3 mb-4">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?>