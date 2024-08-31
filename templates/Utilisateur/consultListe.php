<!-- code html de la page-->
<h2 class="text-center">Les utilisateurs</h2>

<?php
if (count($lesUtilisateurs) == 0) {
    echo ("Il n'y a pas d'utilisateur");
} else {
?>
    <table class="table table-bordered table-lg">
        <thead class="table-light">
            <tr>
                <th scope="col">Nom</th>
                <th class="col">Prénom</th>
                <th scope="col">Fonction</th>
            </tr>
        </thead>
        <?php foreach ($lesUtilisateurs as $unUtilisateur) {
            echo ("<tr>");
            echo ("<td>" . $unUtilisateur->getNom() . "</td>");
            echo ("<td>" . $unUtilisateur->getPrenom() . "</td>");
            echo ("<td>" . $unUtilisateur->getProfil()->getLibelle()  . "</td>");
            echo ("</tr>");
        } ?>
    </table>
<?php
}
?>