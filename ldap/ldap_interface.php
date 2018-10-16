<?php
namespace ldap {
    
    interface ldap_conectar_interface {
        function conectar( $username, $password );
        function conectado();
        function cerrar();
    }
    
    interface ldap_interface extends ldap_conectar_interface {
        function set_server( $server );
        function buscar_grupos();
        function pertenece_grupo( $grupo ) : bool ;
        function get_grupos();
    }
    
}
?>