<?php
namespace derivador{ 
    class derivadorLista {
        private $lista = []; 
        function __construct( ){
        }
        
        
        function agregar( string $url, callable $funcion ){
            $this->lista[] = [ "url" => $url, "funcion" => $funcion ];
             
        }
        function existe( string $url ) : bool {
            foreach( $this->lista as $value ){
                if( $value["url"] == $url )
                    return true;
                
            }
            return false;
        }
        
        function funcion( string $url ) : callable {
            foreach( $this->lista as $value ){
                if( $value["url"] == $url )
                    return $value["funcion"];
            }
            return "";
        }
        
    }
}
?>