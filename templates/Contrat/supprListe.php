<!-- code html de la page-->
<h2 class="text-center">Suppression d'un contrat</h2>
<form action="/contrat/supprForm" method='post'>

<?php
if (count($lesContrats) == 0) {
    echo ("Il n'y a pas de contrat");
} else {
?>
    <table class="table table-bordered table-lg">
        <thead class="table-light">
            <tr>
                <th class="col">Appartement Ekip</th>
                <th class="col">Propriétaire</th>
                <th class="col">Locataire</th>
                <th class="col">Garant</th>
                <th class="col">Début</th>
                <th class="col">Fin</th>
                <th class="col">Montant Loyer CC</th>
            </tr>
        </thead>
        <?php foreach ($lesContrats as $unContrat) {

            echo ("<tr>");
            echo ("<td>" . $unContrat->GetAppartement()->getBatiment() . " " . $unContrat->GetAppartement()->getRue() . ", " . $unContrat->GetAppartement()->getVille()->getNom() . "</td>");
            echo ("<td>" . strtoupper($unContrat->GetAppartement()->getProprietaire()->getNom()) . " " . $unContrat->GetAppartement()->getProprietaire()->getPrenom() . "</td>");
            echo ("<td>" . strtoupper($unContrat->GetLocataire()->getNom()) . " " . $unContrat->GetLocataire()->getPrenom() . "</td>");
            echo ("<td>" . strtoupper($unContrat->GetGarant()->getNom()) . " " .  $unContrat->GetGarant()->getPrenom() . "</td>");
            echo ("<td>" . $unContrat->GetDebut()->format("d/m/Y") . "</td>");
            echo ("<td>" . $unContrat->GetFin()->format("d/m/Y") . "</td>");
            echo ("<td>" . ($unContrat->GetMontantLoyerHC() + $unContrat->GetMontantCharge() + $unContrat->GetMontantCaution()) . "</td>");
            echo ('<td><button type="submit" class="btn btn-primary" name="supprimer" value="' . $unContrat->getId() . '">Supprimer</button></td>');
            echo ("</tr>");
        }?>
             
            <!-- <button type="submit" class="btn btn-primary">Supprimer</button> -->
        </td>
    </tr>
<?php } ?>
    </table>
<?php
if (isset($msg)) echo $msg;
?>