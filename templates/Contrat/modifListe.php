<!-- code html de la page-->
<h1 class="text-center">Modification d'un contrat</h1>
<form action="/contrat/modifForm" method='post'>
    <div class=" row mb-3">
        <?php
        if (count($lesContrats) == 0) {
            echo ("Aucun contrat");
        } else {
        ?>
            <label for="lesDem" class="col-lg-4 col-form-label">Choisissez le contrat à modifier</label>
            <div class="col-sm-12">
                <!-- liste déroulante -->
                <select class="form-select form-select-md" onChange="submit();" name="lstContrat">
                    <option selected value=0>Veuillez selectionner un contrat </option>
                    <?php foreach ($lesContrats as $unContrat) {
                        $id = $unContrat->getId();
                        $libelle = strtoupper($unContrat->getLocataire()->getNom()) ;
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