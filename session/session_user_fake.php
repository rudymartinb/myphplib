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
        
        function set( $nombre, $valor ){
            $this->valores[ $nombre ] = $valor ;
        }
        
        function get( $nombre ){
            if( array_key_exists( $nombre, $this->valores ) )
                return $this->valores[ $nombre ];
                return "";
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