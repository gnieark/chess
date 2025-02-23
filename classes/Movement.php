<?php
class Movement {
    private $origin;
    private $path = array(); // list of cells that must be empty to do the move
    private $dest;

    private $destCanBeAnOpponent = true; //If true the destination cell can contain an oppenent(eaten)
    private $destMustBeAnOpponent = false; //Can move to the dest only to eat opponent

    public function __construct(int $origin = null, int $dest = null){

        if(!is_null($origin)){
            $this->set_origin($origin);
        }
        if(!is_null($dest)){
            $this->set_dest($dest);
        }

    }
    public function set_origin( int $origin ) :Movement{
        $this->origin = $origin;
        return $this;
    }
    public function get_origin():int{
        return $this->origin;
    }
    public function set_dest(int $dest) : Movement{
        $this->dest = $dest;
        return $this;
    }
    public function get_dest():int{
        return $this->dest;
    }
    public function set_destCanBeAnOpponent (bool $destCanBeAnOpponent ): Movement {
        $this->destCanBeAnOpponent = $destCanBeAnOpponent;
        return $this; 
    }
    public function does_destCanBeAnOpponent():bool{
        return $this->destCanBeAnOpponent;
    }
    public function set_destMustBeAnOpponent(bool $destMustBeAnOpponent): Movement{
        $this->destMustBeAnOpponent = $destMustBeAnOpponent;
        return $this;
    }
    public function does_destMustBeAnOpponent() : bool {
        return $this->destMustBeAnOpponent;
    }
    public function add_cell_to_path(int $cellId):Movement{
        $this->path[] = $cellId;
        return $this;
    }
    public function get_path():array{
        return $this->path;
    }
}