<?php
namespace ldap {
    
    interface ldap_conectar_interface {
        function conectar( $username, $password );
    }
    
    interface ldap_interface extends ldap_conectar_interface {
    }
    
}
?>