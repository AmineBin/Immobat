<!-- code html de la page-->
<h1 class="text-center">Modification d'un appartement</h1>
<form action="/appartement/modifTrait" method='post'>
    <div class="row mb-3">
        <label for="rue" class="col-lg-4 col-form-label">Rue</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="rue" value="<?php if (isset($lAppart))  echo $lAppart->getRue();  ?>" id="rue">
        </div>
        <div class="row mb-3">
        <label for="batiment" class="col-lg-4 col-form-label">Batiment</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="batiment" value="<?php if (isset($lAppart))  echo $lAppart->getBatiment();  ?>" id="batiment">
        </div>
        <div class="row mb-3">
        <label for="etage" class="col-lg-4 col-form-label">Etage</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="etage" value="<?php if (isset($lAppart))  echo $lAppart->getEtage();  ?>" id="etage">
        </div>
    <div class="row mb-3">
        <label for="superficie" class="col-lg-4 col-form-label">Superficie</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="superficie" value="<?php if (isset($lAppart))  echo $lAppart->getSuperficie();  ?>" id="superficie">
        </div>
    </div>
    <div class="row mb-3">
        <label for="orientation" class="col-lg-4 col-form-label">Orientation</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="orientation" value="<?php if (isset($lAppart))  echo $lAppart->getOrientation();  ?>" id="orientation">
        </div>
    </div>
    <div class="row mb-3">
        <label for="nb_piece" class="col-lg-4 col-form-label">Nombre de pièces</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="nb_piece" value="<?php if (isset($lAppart))  echo $lAppart->getNbPiece();  ?>" id="nb_piece">
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Type d'appartement</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->

            <select class="form-select form-select-md" name="lstTypeAppart">
                <?php foreach ($lesTypesApparts as $unType) {
                    $id = $unType->getId();
                    $lib = $unType->getLibelle();
                    if (isset($lAppart) && $lAppart->getCategorieAppartement()->getId() == $id)
                        echo ("<option selected value=$id>$lib</option>");
                    else
                        echo ("<option value=$id>$lib</option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Proprietaire</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->

            <select class="form-select form-select-md" name="lstProprietaire">
                <?php foreach ($lesProprietaires as $unProprietaire) {
                    $id = $unProprietaire->getId();
                    $lib = $unProprietaire->getNom();
                    if (isset($unProprio) && $lAppart->getProprietaire()->getId() == $id)
                        echo ("<option selected value=$id>$lib</option>");
                    else
                        echo ("<option value=$id>$lib</option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Ville</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->

            <select class="form-select form-select-md" name="lstVille">
                <?php foreach ($lesVilles as $uneVille) {
                    $id = $uneVille->getInsee();
                    $lib = $uneVille->getNom();
                    if (isset($uneVille) && $lAppart->getVille()->getInsee() == $inseeVille)
                        echo ("<option selected value=$id>$lib</option>");
                    else
                        echo ("<option value=$id>$lib</option>");
                } ?>
            </select>
        </div>
    </div>

    <input type="hidden" name="idAppart" value="<?php if ($lAppart != null) echo $lAppart->getId(); ?>" class="row mb-3">

    <div class="p-3 mb-4">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?>