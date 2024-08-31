<h1 class="text-center">Filtrage des appartements</h1>
<form action="/appartement/liste" method='post'>
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

    <input type="hidden" name="idAppart" value="<?php if ($lAppart != null) echo $lAppart->getId(); ?>" class="row mb-3">

    <div class="p-3 mb-4">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Voir les appartements</button>
        </div>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?>