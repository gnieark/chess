<?php
class Knight extends Piece {

    public function get_unicode_char(){
        return( $this->color? "♘" : "♞");
    }

    public function get_moves($current): array {

        $moves = [
            [-2, -1], [-2, 1], [2, -1], [2, 1],
            [-1, -2], [-1, 2], [1, -2], [1, 2]
        ];
        
        $x = $current % 8;
        $y = intdiv($current, 8);
        $destinations = [];
        $mvts = array();
        foreach ($moves as [$dx, $dy]) {
            $newX = $x + $dx;
            $newY = $y + $dy;
            
            if ($newX >= 0 && $newX < 8 && $newY >= 0 && $newY < 8) {
                $mvt = new Movement();
                $mvt-> set_origin($current)->set_dest( $newY * 8 + $newX);
                $mvts[] = $mvt; 
            }
        }
        
        return $mvts;
    }
       
}