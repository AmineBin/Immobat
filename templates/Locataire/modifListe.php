<!-- code html de la page-->
<h1 class="text-center">Modification d'un locataire</h1>
<form action="/locataire/modifForm" method='post'>
    <div class=" row mb-3">
        <?php
        if (count($lesLocataires) == 0) {
            echo ("Aucun locataire");
        } else {
        ?>
            <label for="lesDem" class="col-lg-4 col-form-label">Choisissez le locataire à modifier</label>
            <div class="col-sm-12">
                <!-- liste déroulante -->
                <select class="form-select form-select-md" onChange="submit();" name="lstLocataire">
                    <option value=0 >Veuillez sélectionner un locataire</option>
                    <?php foreach ($lesLocataires as $unLocataire) {
                        $id = $unLocataire->getId();
                        $libelle = $unLocataire->getVille()->getNom() . ' , Nom : ' . $unLocataire->getNom();
                        if (isset($_POST['lstLocataire']) == true && $_POST['listLocataire'] == $id)
                            echo ("<option selected value=$id>$libelle</option>");
                        else
                            echo ("<option value=$id>$libelle</option>");
                    } ?>
                </select>

            </div>
        <?php
        }
        ?>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?>