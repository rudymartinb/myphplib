<?php
namespace myphplib\session {
    interface session_user_interface {
        function start();
        function status();
        function name( $name );
        function is_registered( $name  );
        function set( $nombre, $valor );
        function get( $nombre );
        function unset();
        function destroy();
    }
    
    class session_user implements session_user_interface  {
        private $status ;
        private $name = "";
        private $valores = [];
        
        
        function start(){
            session_start();
        }
        
        function status(){
            return session_status();
        }
        function name( $name ){
            session_name( $name );
        }
        function is_registered( $name  ){
            return isset( $_SESSION[ $name ] );
        }
        
        function set( $nombre, $valor ){
            global $_SESSION;
            $_SESSION[ $nombre ] = $valor ;
        }
        
        function get( $nombre ){
            global $_SESSION;
            if( array_key_exists( $nombre,  $_SESSION ) )
                return $_SESSION[ $nombre ];
                return "";
        }
        
        function unset(){
            session_unset();
        }
        
        function destroy(){
            session_destroy();
        }
        
    }
    
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