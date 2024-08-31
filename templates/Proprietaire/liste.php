<!-- code html de la page-->
<h2 class="text-center">Les propriétaires</h2>

<?php
if (count($lesProprios) == 0) {
    echo ("Il n'y a pas de proprietaire");
} else {
?>
    <table class="table table-bordered table-lg">
        <thead class="table-light">
            <tr>
                <th scope="col">Nom Prénom</th>
                <th class="col">téléphone</th>
                <th scope="col">Email</th>
                <th scope="col">Rue</th>
                <th class="col">Nom de la Ville</th>
                <th scope="col">Mode de Gestion</th>
            </tr>
        </thead>
        <?php foreach ($lesProprios as $unProprio) {
            echo ("<tr>");
            echo ("<td>" . $unProprio->getNom() . " ". $unProprio->getPrenom() . "</td>");
            echo ("<td>" . $unProprio->getTelephone() . "</td>");
            echo ("<td>" . $unProprio->getEmail()  . "</td>");
            echo ("<td>" . $unProprio->getRue()  . "</td>"); 
            echo ("<td>" . $unProprio->getLaVille()->getNom() . "</td>");
            echo ("<td>" . $unProprio->getLeModeDeGestion()->getLibelle() . "</td>");
            echo ("</tr>");
        } ?>
    </table>
<?php
}
?>