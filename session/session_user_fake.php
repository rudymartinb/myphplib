<?php
namespace myphplib\session {
    
    class session_user_fake implements session_user_interface  {
        private $status = PHP_SESSION_NONE;
        private $name = "";
        private $valores = [];
        
        function start(){
            $this->status = PHP_SESSION_ACTIVE;
        }
        function status(){
            return $this->status;
        }
        function name( $name ){
            $this->name = $name;
        }
        function is_registered( $name  ){
            return $this->name == $name;
        }
        
        function data_set( $nombre, $valor ){
            $this->valores[ $nombre ] = $valor ;
        }
        
        function data_get( $nombre ) {
            if( array_key_exists( $nombre, $this->valores ) )
                return $this->valores[ $nombre ];
            return "";
        }
        
        function data_unset( string $clave ){
            if( array_key_exists( $clave, $this->valores ) )
                unset( $this->valores[ $clave ] );
        }
        
        function unset(){
            $this->valores = [];
        }
        
        function destroy(){
            $this->status = PHP_SESSION_NONE;
            $this->valores = [];
        }
        
    }
}
?>