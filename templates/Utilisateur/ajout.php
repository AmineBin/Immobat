<!-- code html de la page-->
<h1 class="text-center">Ajout d'un utilisateur</h1>
<form action="/utilisateur/ajoutTrait" method='post'>
    <div class="row mb-3">
        <label for="nom" class="col-lg-4 col-form-label">Nom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="nom" value="<?php if (isset($leUtil))  echo $leUtil->getNom(); ?>" id="nom">
        </div>
    </div>
    <div class="row mb-3">
        <label for="prenom" class="col-lg-4 col-form-label">Prénom</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="prenom" value="<?php if (isset($leUtil))  echo $leUtil->getPrenom(); ?>" id="prenom">
        </div>
    </div>
    <div class="row mb-3">
        <label for="typeFrais" class="col-lg-4 col-form-label">Profil</label>
        <div class="col-sm-12">
            <!-- liste déroulante -->
            <select class="form-select form-select-md" name="lstProfil">
                <?php foreach ($profils as $unProfil) {
                    $id = $unProfil->getId();
                    $lib = $unProfil->getLibelle();
                    if (isset($lProfil) && $lProfil->getLesProfils()->getId() == $id)
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