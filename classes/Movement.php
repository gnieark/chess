<?php
class Movement {
    private $origin;
    private $path = array(); // list of cells that must be empty to do the move
    private $dest;

    private $destCanBeAnOpponent = true; //If true the destination cell can contain an oppenent(eaten)
    private $destMustBeAnOpponent = false; //Can move to the dest only to eat opponent

    public function __construct(){
    }
    public function set_origin( int $origin ) :Movement{
        $this->origin = $origin;
        return $this;
    }
    public function get_origin():int{
        return $this->origin;
    }
    public function add_cell_to_path(int $cellId):Movement{
        $this->path[] = $cellId;
        return $this;
    }




}