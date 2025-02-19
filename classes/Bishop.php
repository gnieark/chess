<?php
class Bishop extends Piece{

    public function get_unicode_char(){
        return( $this->color? "♗" : "♝");
    }

    public function get_moves($current): array {
        $x = $current % 8;
        $y = intdiv($current, 8);

        $mvts = array();
        //diagonal NO
        $destX = $x;
        $destY = $y;

        $paths = array();
        while (($destX > 0) && ($destY > 0)){
            $destX--;
            $destY--;
            $nmvt = new Movement();
            $nmvt->set_origin($current)->set_dest( $destY * 8 + $destX);
            foreach ($paths as $path){
                $nmvt->add_cell_to_path($path);
            }
            $paths[] = $destY * 8 + $destX;
            $mvts[] = $nmvt;
        }


        $destX = $x;
        $destY = $y;
        $paths = array();
        while (($destX > 0) && ($destY < 7)){
            $destX --;
            $destY ++;
            $nmvt = new Movement();
            $nmvt->set_origin($current)->set_dest( $destY * 8 + $destX);
            foreach ($paths as $path){
                $nmvt->add_cell_to_path($path);
            }
            $paths[] = $destY * 8 + $destX;
            $mvts[] = $nmvt;
        }

        $destX = $x;
        $destY = $y;
        $paths = array();
        while (($destX < 7) && ($destY > 0)){
            $destX ++;
            $destY --;
            $nmvt = new Movement();
            $nmvt->set_origin($current)->set_dest( $destY * 8 + $destX);
            foreach ($paths as $path){
                $nmvt->add_cell_to_path($path);
            }
            $paths[] = $destY * 8 + $destX;
            $mvts[] = $nmvt;
        }

        $destX = $x;
        $destY = $y;
        $paths = array();
        while (($destX < 7) && ($destY < 7)){
            $destX ++;
            $destY ++;
            $nmvt = new Movement();
            $nmvt->set_origin($current)->set_dest( $destY * 8 + $destX);
            foreach ($paths as $path){
                $nmvt->add_cell_to_path($path);
            }
            $paths[] = $destY * 8 + $destX;
            $mvts[] = $nmvt;
        }

        return $mvts;
    }

}