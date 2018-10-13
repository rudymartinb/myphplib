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
    

}
?>