<h1 class="text-center">Ajout d'un contrat</h1>
<form action="/contrat/ajoutTrait" method='post'>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Locataire</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstLocataire">
                <?php foreach ($LesLocataires as $unLocataire) {
                    $id = $unLocataire->getId();
                    $nom = strtoupper($unLocataire->getNom());
                    $prenom = $unLocataire->getPrenom();
                    if (isset($lContrat) && $lContrat->getLocataire()->getId() == $id)
                        echo ("<option selected value=$id>$nom $prenom</option>");
                    else
                        echo ("<option value=$id>$nom $prenom</option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Appartement</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstAppart">
                <?php foreach ($lesApparts as $unAppart) {
                    $id = $unAppart->GetId();
                    $detail = $unAppart->getBatiment() . " " . $unAppart->getRue() . ", " . $unAppart->getVille()->getNom();
                    if (isset($lContrat) && $lContrat->GetAppart()->GetId() == $id)
                        echo ("<option selected value=$id>$detail</option>");
                    else
                        echo ("<option value=$id>$detail</option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Garant</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstGarant">
                <?php foreach ($LesGarants as $unGarant) {
                    $id = $unGarant->getId();
                    $nom = strtoupper($unGarant->getNom());
                    $prenom = $unGarant->getPrenom();
                    if (isset($lContrat) && $lContrat->getGarant()->getId() == $id)
                        echo ("<option selected value=$id>$nom $prenom</option>");
                    else
                        echo ("<option value=$id>$nom $prenom</option>");
                } ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="debut" class="col-lg-4 col-form-label">Début</label>
        <div class="col-sm-12">
            <input type="date" class="form-control" name="debut" value="<?php if (isset($lContrat))  echo $lContrat->GetDebut();  ?>" id="debut">
        </div>
    </div>
    <div class="row mb-3">
        <label for="fin" class="col-lg-4 col-form-label">Fin</label>
        <div class="col-sm-12">
            <input type="date" class="form-control" name="fin" value="<?php if (isset($lContrat))  echo $lContrat->GetFin();  ?>" id="fin">
        </div>
    </div>
    <div class="row mb-3">
        <label for="montant loyer" class="col-lg-4 col-form-label">Montant Loyer</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="montantLoyer" value="<?php if (isset($lContrat))  echo $lContrat->GetMontantLoyerHC();  ?>" id="montantLoyer">
        </div>
    </div>
    <div class="row mb-3">
        <label for="montant charge" class="col-lg-4 col-form-label">Montant Charge</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="montantCharge" value="<?php if (isset($lContrat))  echo $lContrat->GetMontantCharge();  ?>" id="montantCharge">
        </div>
    </div>
    <div class="row mb-3">
        <label for="montant caution" class="col-lg-4 col-form-label">Montant Caution</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="montantCaution" value="<?php if (isset($lContrat))  echo $lContrat->GetMontantCaution();  ?>" id="montantCaution">
        </div>
    </div>
    <div class="row mb-3">
        <label for="salaire" class="col-lg-4 col-form-label">Salaire locataire</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="salaire" value="<?php if (isset($lContrat))  echo $lContrat->GetSalaireLocataire();  ?>" id="salaire">
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