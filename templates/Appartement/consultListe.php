<!-- code html de la page-->
<h2 class="text-center">Les appartements</h2>

<?php
if (count($lesApparts) == 0) {
    echo ("Il n'y a pas d'appartements");
} else {
?>
    <table class="table table-bordered table-lg">
        <thead class="table-light">
            <tr>
                <th scope="col">Type d'appartement</th>
                <th scope="col">rue</th>
                <th scope="col">batiment</th>
                <th scope="col">etage</th>
                <th class="col">superficie</th>
                <th scope="col">orientation</th>
                <th scope="col">nombre de pièces</th>
                <th scope="col">propriétaire</th>
                <th scope="col">ville</th>
            </tr>
        </thead>
        <?php foreach ($lesApparts as $unAppart) {
            echo ("<tr>");
            echo ("<td>" . $unAppart->getCategorieAppartement()->getLibelle() . "</td>");
            echo ("<td>" . $unAppart->getRue() . "</td>");
            echo ("<td>" . $unAppart->getBatiment() . "</td>");
            echo ("<td>" . $unAppart->getEtage() . "</td>");
            echo ("<td>" . $unAppart->getSuperficie() . "</td>");
            echo ("<td>" . $unAppart->getOrientation()  . "</td>");
            echo ("<td>" . $unAppart->getNbPiece() . "</td>");
            echo ("<td>" . $unAppart->getProprietaire()->getNom() . "</td>");
            echo ("<td>" . $unAppart->getVille()->getNom() . "</td>");
            echo ("</tr>");
        } ?>
    </table>
<?php
}
?>