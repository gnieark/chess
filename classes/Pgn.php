<?php
class Pgn{

    private $moves = array();
    public function __construct(string $pgnstring){
        $this->parsePgnString($pgnstring);
    }
    private function parsePgnString(string $pgnstring): array{
        $mvts = array(); // Tableau contenant les objets Movement

        // Supprimer les lignes de métadonnées (entre crochets) et les lignes vides
        $pgnstring = preg_replace('/^\[.*\]\s*/m', '', $pgnstring);
        $pgnstring = trim(preg_replace('/^\s*$/m', '', $pgnstring));
    
        // Nettoyer la chaîne PGN (retirer les annotations, les échecs et les mats)
        $clean_pgn = preg_replace('/\$\d+/', '', $pgnstring); // Retirer les NAG
        $clean_pgn = preg_replace('/[+#]/', '', $clean_pgn);     // Retirer les échecs et mats
        $clean_pgn = trim(preg_replace('/\s+/', ' ', $clean_pgn)); // Nettoyer les espaces superflus
    
        // Extraire uniquement les mouvements (ignorer les numéros de coups)
        preg_match_all('/\d+\.\s*([a-h1-8NBRQKxO-]+)\s*([a-h1-8NBRQKxO-]+)\s*/', $clean_pgn, $matches);
        //print_r($matches);

        for($i = 0; $i < count( $matches[1] ); $i++ ){
            $origiStr = substr($matches[1][$i], -2);
            $destStr = substr($matches[2][$i], -2);
            echo $origiStr." ".$destStr."\n";
        }

        return $mvts;
    }


}