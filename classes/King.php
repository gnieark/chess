<?php
class King extends Piece {
    public function get_unicode_char(){
        return( $this->color? "♔" : "♚");
    }

    public function get_moves($current): array {
        $mvts = array();

        $down = ($current > 7);
        $up = ($current < 56);
        $left = (fmod( $current , 8 ) > 0 );
        $right = (fmod( $current , 8 ) < 7 );


        if($down){
            //down a line
            $mvt = new Movement();
            $mvt-> set_origin($current)->set_dest( $current - 8);
            $mvts[] = $mvt; 
        }
        if($left){
            $mvt = new Movement();
            $mvt-> set_origin($current)->set_dest( $current - 1);
            $mvts[] = $mvt; 
        }
        if($right){
            $mvt = new Movement();
            $mvt-> set_origin($current)->set_dest( $current + 1);
            $mvts[] = $mvt; 
        }
        if($up) {
            $mvt = new Movement();
            $mvt-> set_origin($current)->set_dest( $current + 8);
            $mvts[] = $mvt; 
        }
        if($down && $left){
            $mvt = new Movement();
            $mvt-> set_origin($current)->set_dest( $current - 9);
            $mvts[] = $mvt; 
        }
        if($down && $right){
            $mvt = new Movement();
            $mvt-> set_origin($current)->set_dest( $current - 7);
            $mvts[] = $mvt; 
        }
        if($up && $left){
            $mvt = new Movement();
            $mvt-> set_origin($current)->set_dest( $current + 7);
            $mvts[] = $mvt; 
        }
        if($up && $right){
            $mvt = new Movement();
            $mvt-> set_origin($current)->set_dest( $current + 9);
            $mvts[] = $mvt; 
        }

        return $mvts;
    }

}