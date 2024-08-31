<!-- code html de la page-->
<h1 class="text-center">Ajout d'un locataire</h1>
<form action="/locataire/ajoutTrait" method='post'>
    <div class="row mb-3">
        <label for="nom" class="col-lg-4 col-form-label">Nom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="nom" value="<?php if (isset($leLoca))  echo $leLoca->getNom(); ?>" id="nom">
        </div>
    </div>
    <div class="row mb-3">
        <label for="prenom" class="col-lg-4 col-form-label">Prénom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="prenom" value="<?php if (isset($leLoca))  echo $leLoca->getPrenom(); ?>" id="prenom">
        </div>
    </div>
    
    <div class="row mb-3">
        <label for="email" class="col-lg-4 col-form-label">Email</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="email" value="<?php if (isset($leLoca))  echo $leLoca->getEmail(); ?>" id="email">
        </div>
    </div>
    
    <div class="row mb-3">
        <label for="telephone" class="col-lg-4 col-form-label">Téléphone</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="telephone" value="<?php if (isset($leLoca))  echo $leLoca->getTelephone(); ?>" id="telephone">
        </div>
    </div>
    <div class="row mb-3">
        <label for="rue" class="col-lg-4 col-form-label">Rue</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="rue" value="<?php if (isset($leLoca))  echo $leLoca->getRue(); ?>" id="rue">
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Ville</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstVille">
                <?php foreach ($villes as $uneVille) {
                    $id = $uneVille->getInsee();
                    $codPos = $uneVille->getCodePostal();
                    $nom = $uneVille->getNom();
                    if (isset($lVille) && $lVille->getLesVilles()->getInsee() == $id)
                        echo ("<option selected value=$insee>$nom . $codPos</option>");
                    else
                        echo ("<option value=$id>$nom . $codPos</option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Impression</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstImpression">
                <?php foreach ($impressions as $uneImpression) {
                    $id = $uneImpression->getId();
                    $lib = $uneImpression->getLibelle();
                    if (isset($lImpression) && $lImpression->getLesImpressions()->getId() == $id)
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
                <?php foreach ($CategorieSocioprofessionnelles as $uneCategorieSocioprofessionnelle) {
                    $id = $uneCategorieSocioprofessionnelle->getId();
                    $lib = $uneCategorieSocioprofessionnelle->getLibelle();
                    if (isset($lCategorieSocioprofessionnelle) && $lCategorieSocioprofessionnelle->getLesCategorieSocioprofessionnelles()->getId() == $id)
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