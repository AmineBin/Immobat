<h1 class="text-center">Modification d'un propriétaire</h1>
<form action="/proprietaire/modifForm" method='post'>
    <div class=" row mb-3">
        <?php
        if (count($lesProprios) == 0) {
            echo ("Aucun propriétaire");
        } else {
        ?>
            <label for="lesDem" class="col-lg-4 col-form-label">Choisissez le proptiétaire à modifier</label>
            <div class="center">
            <div class="col-sm-12">
                <select class="form-select form-select-md" onChange="submit();" name="lstProprietaire">
                <option value=0>Veuillez choisir un propriétaire</option>
                    <!-- liste déroulante -->
                    <?php foreach ($lesProprios as $unProprio) {
                        $id = $unProprio->getId();
                        $nomPrenom = $unProprio->getPrenom()." ".$unProprio->getNom();
                        $ville = $unProprio->getLaVille()->getNom();
                        if (isset($_POST['lstProprietaire']) == true && $_POST['lstProprietaire'] == $id)
                            echo ("<option selected value='$id'>$nomPrenom de $ville</option>");
                        else
                            echo ("<option value='$id'>$nomPrenom de $ville</option>");
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
