<?php
error_reporting(-1);

echo($fichier + "<br/>");

define('BASE', 'jpeg/');
 
function renommerFichier($repertoire, $nomFichier) {
	$nouvNom = ereg_replace('[éèë]', 'e', $nomFichier);
	$nouvNom = ereg_replace('[àä]', 'a', $nouvNom);
	$nouvNom = ereg_replace('[ùü]', 'u', $nouvNom);
	rename($repertoire . $nomFichier, $repertoire . $nouvNom);
}
 
function parcourirArborescence($repertoire) {
    if (!ereg('/$', $repertoire)) {
        $repertoire .= '/';
    }
    if (@ $dh = opendir($repertoire)) {
        while (($fichier = readdir($dh)) != FALSE) {
            if ($fichier == '.') {
                continue; // Skip it
            }
            if ($fichier == '..') {
                continue; // Skip it
            }
            if (is_dir($repertoire . $fichier)) {
                parcourirArborescence($repertoire . $fichier); // Récursivité
            } elseif (ereg('[éèëàäùü]', $fichier)) {
				renommerFichier($repertoire, $fichier);
				echo($fichier + "<br/>");
            }
        }
        @ closedir($dh);
    }
}
 
parcourirArborescence(BASE);
?>