<!-- code html de la page-->
<h1 class="text-center">Modification d'un locataire 667</h1>
<form action="/locataire/modifTrait" method='post'>
    <div class="row mb-3">
        <label for="nom" class="col-lg-4 col-form-label">Nom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="nom" value="<?php if (isset($leLoca))  echo $leLoca->getNom();  ?>" id="nom">
        </div>
    </div>
    <div class="row mb-3">
        <label for="prenom" class="col-lg-4 col-form-label">Prénom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="prenom" value="<?php if (isset($leLoca))  echo $leLoca->getPrenom();  ?>" id="prenom">
        </div>
    </div>
    <div class="row mb-3">
        <label for="email" class="col-lg-4 col-form-label">Email</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="email" value="<?php if (isset($leLoca))  echo $leLoca->getEmail();  ?>" id="email">
        </div>
    </div>
    <div class="row mb-3">
        <label for="telephone" class="col-lg-4 col-form-label">Téléphone</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="telephone" value="<?php if (isset($leLoca))  echo $leLoca->getTelephone();  ?>" id="telephone">
        </div>
    </div>
    <div class="row mb-3">
        <label for="rue" class="col-lg-4 col-form-label">Rue</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="rue" value="<?php if (isset($leLoca))  echo $leLoca->getRue();  ?>" id="rue">
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Ville</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->

            <select class="form-select form-select-md" name="lstVille">
                <?php foreach ($lesVilles as $uneVille) {
                    $id = $uneVille->getInsee();
                    $nom = $uneVille->getNom();
                    $codP = $uneVille->getCodePostal();
                    if (isset($leLoca) && $leLoca->getVille()->getInsee() == $id)
                        echo ("<option selected value=$id>$nom $codP</option>");
                    else
                        echo ("<option value=$id>$nom $codP</option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Impression</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->

            <select class="form-select form-select-md" name="lstImpression">
                <?php foreach ($lesImpressions as $uneImpression) {
                    $id = $uneImpression->getId();
                    $lib = $uneImpression->getLibelle();
                    if (isset($leLoca) && $leLoca->getImpression()->getId() == $id)
                        echo ("<option selected value=$id>$lib</option>");
                    else
                        echo ("<option value=$id>$lib</option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Catégorie socio-professionnelle</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->

            <select class="form-select form-select-md" name="lstCategorieSocioprofessionnelle">
                <?php foreach ($lesCategorieSocioprofessionnelles as $uneCategorieSocioprofessionnelle) {
                    $id = $uneCategorieSocioprofessionnelle->getId();
                    $lib = $uneCategorieSocioprofessionnelle->getLibelle();
                    if (isset($leLoca) && $leLoca->getCategorieSocioprofessionnelle()->getId() == $id)
                        echo ("<option selected value=$id>$lib</option>");
                    else
                        echo ("<option value=$id>$lib</option>");
                } ?>
            </select>
        </div>
    </div>

    <input type="hidden" name="idLocataire" value="<?php if ($leLoca != null) echo $leLoca->getId(); ?>" class="row mb-3">

    <div class="p-3 mb-4">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?>