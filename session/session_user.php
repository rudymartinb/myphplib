<?php
namespace myphplib\session {
    interface session_user_interface {
        function start();
        function status();
        function name( $name );
        function is_registered( $name  );
        function data_set( $nombre, $valor );
        function data_get( $nombre );
        function data_unset( string $clave );
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
        
        function data_set( $nombre, $valor ){
            global $_SESSION;
            $_SESSION[ $nombre ] = $valor ;
        }
        
        function data_get( $nombre ){
            global $_SESSION;
            if( array_key_exists( $nombre,  $_SESSION ) )
                return $_SESSION[ $nombre ];
                return "";
        }
        function data_unset( string $clave ){
            global $_SESSION;
            if( array_key_exists( $clave, $_SESSION ) )
                unset( $_SESSION[ $clave ] ) ;
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