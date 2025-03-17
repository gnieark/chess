<?php
require("./classes/Pgn.php");
$p = new Pgn( file_get_contents("./tests/pgns/Htlynn_vs_gnieark_2025.02.18.pgn") );