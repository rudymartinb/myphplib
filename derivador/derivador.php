<?php
namespace derivador {
    class Derivador {
        private $lista = [];
        function __construct(){
            $this->lista = new derivadorLista();
        }
        public function agregar( string $nombre, callable $funcion ){
            $this->lista->agregar( $nombre,  $funcion );
        }
        
        public function ejecutar( string $cual ){
            if( $this->existe( $cual ) ){
                $funcion = $this->lista->funcion( $cual );
                $funcion();
            }
        }
        public function existe( string $cual ) : bool {
            return $this->lista->existe( $cual );
        }
        
        
    }
}
?>