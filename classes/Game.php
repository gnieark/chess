<?php
class Game{
    private bool $currentPlayer = true; //true white,  false blacks
    private Plate $plate;

    public function __construct(){
        $this->plate = new Plate(); // Initialize plate
    }

    public function set_plate(Plate $plate): Game {
        $this->plate = $plate;
        return $this;
    }
    public function get_plate() : Plate {
        return $this->plate;
    }
    private function next_turn(): Game{
        $this->currentPlayer = !$this->currentPlayer;
        return $this;
    }
    public function start() : Game {
        $this->currentPlayer = true;
        $this->plate->initializeBoardWithPieces();
        return $this;
    }
    public function get_current_player_txt(){
        if($this->$currentPlayer){
            return "white";
        }
        return "black";
    }


}