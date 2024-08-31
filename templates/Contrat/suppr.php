<!-- code html de la page-->
<h1 class="text-center">suppression d'un appartement</h1>
<form action="/contrat/supprTrait" method='post'>
<table class="table table-bordered table-lg">
        <thead class="table-light">
            <tr>
                <th class="col">Appartement</th>
                <th class="col">Propriétaire</th>
                <th class="col">Locataire</th>
                <th class="col">Garant</th>
                <th class="col">Début</th>
                <th class="col">Fin</th>
                <th class="col">Montant Loyer CC</th>
            </tr>
        </thead>
        <?php
            echo ("<tr>");
            echo ("<td>" . $lContrat->GetAppartement()->getBatiment() . " " . $lContrat->GetAppartement()->getRue() . ", " . $lContrat->GetAppartement()->getVille()->getNom() . "</td>");
            echo ("<td>" . strtoupper($lContrat->GetAppartement()->getProprietaire()->getNom()) . " " . $lContrat->GetAppartement()->getProprietaire()->getPrenom() . "</td>");
            echo ("<td>" . strtoupper($lContrat->GetLocataire()->getNom()) . " " . $lContrat->GetLocataire()->getPrenom() . "</td>");
            echo ("<td>" . strtoupper($lContrat->GetGarant()->getNom()) . " " .  $lContrat->GetGarant()->getPrenom() . "</td>");
            echo ("<td>" . $lContrat->GetDebut()->format("d/m/Y") . "</td>");
            if ($lContrat->GetFin() != null){
                echo ("<td>" . $lContrat->GetFin()->format("d/m/Y") . "</td>");
            }
            else{
                echo ("<td>" . "</td>");
            }
            echo ("<td>" . ($lContrat->GetMontantLoyerHC() + $lContrat->GetMontantCharge() + $lContrat->GetMontantCaution()) . "</td>");
            echo ("</tr>");
        ?>
    </table>
    <input type="hidden" name="idContrat" value="<?php echo $lContrat->GetId(); ?>" class="row mb-3">
   
    <div class="p-3 mb-4">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Supprimer</button>
        </div>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?>