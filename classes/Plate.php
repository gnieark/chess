<?php

class Plate {


    //array containing plate cells indexed as:
    /** 
    * 56  57  58  59  60  61  62  63  
    * 48  49  50  51  52  53  54  55  
    * 40  41  42  43  44  45  46  47  
    * 32  33  34  35  36  37  38  39  
    * 24  25  26  27  28  29  30  31  
    * 16  17  18  19  20  21  22  23  
    * 8   9  10  11  12  13  14  15  
    * 0   1   2   3   4   5   6   7  
     */
    private array $board;

    private $rook0moved = false;
    private $rook7moved = false;
    private $rook56moved = false;
    private $rook63moved = false;
    private $king4moved = false;
    private $king59moved = false;


    private function is_array_of_cells_empty($cells) :bool{
        foreach( $cells as $cell ){
            if( !is_null($this->board($cell)) ){
                return false;
            }
        }
        return true;
    }
    private function is_cell_threat_by_opponent(bool $opponentcolor,int $cell):bool{
        for($i=0; $i < 64; $i++ ){
            if( !is_null($this->getPiece($i)) &&  $this->getPiece($i)->getColor() == $opponentcolor){
                $moves = $this->listAvailableMoves($i,false);
                foreach($moves as $move){
                    if( $move->get_dest() == $cell ){
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function is_white_little_castling_available():bool{
        if($rook7moved || $king4moved ){
            return false;
        }

        if(!$this->is_array_of_cells_empty( array(5,6) ) ){
            return false;
        }
        if ($this->isCheck( true )){
            return false;
        }
        //cells that mustnot be targetted
        foreach( array(5,6) as $cell){
            if($this->is_cell_threat_by_opponent(false,$cell)  ){
                return false;
            }
        }
        return true; 
    }

    public function __construct( $InitializeWithPieces = true  ) {
        $this->initializeBoard( $InitializeWithPieces );
    }

    public function getCellIndexByCoords(int $x,int $y) :int{
        return $x + $y *8;
    }
    public function getCellIndexByPNGNotation(string $str) : int{
        $x = ord(strtolower($str[0])) - ord('a'); 
        $y = (int)$str[1];
        return $this->getCellIndexByCoords($x, $y);
    }

    private function initializeBoard(bool $withPieces): void {
        $this->board = [];
        for( $i = 0; $i<64; $i++){
            $this->board[$i] = null;
        }
        if( $withPieces ){
            $this->initializeBoardWithPieces();
        }
    }
    
    public function initializeBoardWithPieces(): void {


        for( $i = 8; $i < 16; $i++ ){
            $this->placePiece(new Pawn(true), $i);
        }
        for( $i = 48; $i < 56; $i++){
            $this->placePiece(new Pawn(false), $i);
        }
        $this->placePiece(new Rook(true), 0);
        $this->placePiece(new Rook(true), 7);
        $this->placePiece(new Rook(false), 56);
        $this->placePiece(new Rook(false), 63);
        $this->placePiece(new Knight(true), 1);
        $this->placePiece(new Knight(true), 6);
        $this->placePiece(new Knight(false), 57);
        $this->placePiece(new Knight(false), 62);
        $this->placePiece(new Bishop(true), 2);
        $this->placePiece(new Bishop(true), 5);
        $this->placePiece(new Bishop(false), 58);
        $this->placePiece(new Bishop(false), 61);
        $this->placePiece(new Queen(true), 3);
        $this->placePiece(new Queen(false), 60);
        $this->placePiece(new King(true), 4);
        $this->placePiece(new King(false), 59);

    }

    public function placePiece(Piece $piece, int $cellIndex): Plate {
        if( $cellIndex < 0 || $cellIndex > 63 ){
            throw new \UnexpectedValueException(
                "cellIndex must be in [0-63]"
            );
        }
        $this->board[$cellIndex] = $piece;
        return $this;
    }

    public function getPiece(int $cellIndex ): ?Piece {
            return $this->board[$cellIndex];
    }

    private function movePiece(int $indexOrigi, $indexDest) : Plate{
        $this->board[$indexDest] = $this->board[$indexOrigi];
        $this->board[$indexOrigi] = null;
        return $this;
    }

    public function applyMovement(Movement $movement, bool $checkIfAllowed=true ): Plate {
        if($checkIfAllowed ){
            if(is_null( $this->getPiece( $movement->get_origin() ) )  ){
                return false;
            }
            $disallowed = true;
            foreach($this->listAvailableMoves( $movement->get_origin() ) as $availableMove){
                //only compare dest and origin, not path and others parameters
                if( $availableMove->get_dest() == $movement->get_dest() 
                    && $availableMove->get_origin() == $movement->get_origin() 
                ){
                    $disallowed = false;
                    break;
                }

            }
            if($disallowed){
                return false;
            }
        }
        return $this->movePiece($movement->get_origin(), $movement->get_dest());
    }

    public function listAvailableMoves(int $origin, bool $checkcheck = true): array {

        $moves = $this->getPiece($origin)->get_moves($origin);
        $allowedMoves = array();
        

        foreach( $moves as $move ){
            //test path
            foreach( $move->get_path() as $pathcell ){
                if( !is_null($this->getPiece($pathcell)) ){
                    continue 2;
                }
            }

            //test dest cell
            $dest = $this->getPiece( $move->get_dest() );
            if(is_null($dest)){
                if($move->does_destMustBeAnOpponent()){
                    continue;
                }
            }elseif( $dest->isWhite() == $this->getPiece($origin)->isWhite() ){
                //same color
                continue;
            }else{
                //dest is opponent
                if(!$move->does_destCanBeAnOpponent()){
                    continue;
                }
            }

            //test if after move it's check.
            if($checkcheck){
                $testPlate = clone $this;           
                if( $testPlate
                        ->applyMovement( $move, false )
                        ->isCheck( $this->getPiece($origin)->isWhite() ) ){
                    continue;
                }
            }

            $allowedMoves[] = $move;

        }
        return $allowedMoves ;
        
    }

    public function isCheck(bool $color) : bool {
        for($i=0; $i < 64; $i++ ){
            if( !is_null($this->getPiece($i)) &&  $this->getPiece($i)->getColor() == !$color){
                foreach( $this->listAvailableMoves($i, false)  as $move ){
                    if( is_a( $this->getPiece( $move->get_dest() ), "King") 
                        &&  $this->getPiece( $move->get_dest() )->getColor() == $color){
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function __toString(){
        $str="|";
        for( $i= 7; $i > -1; $i-- ){
            for( $j = 0; $j < 8; $j++){
                $str.= is_null( $this->getPiece($i * 8 + $j) ) ? " " : $this->getPiece($i * 8 + $j)->get_unicode_char();
                $str.="|";
            }
            $str.="\n|";
        }
        return $str;
       
    }

    

}
