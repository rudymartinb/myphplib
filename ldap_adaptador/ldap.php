<?php
 
namespace ldap_adaptador {
    // define(LDAP_OPT_DIAGNOSTIC_MESSAGE, 0x0032);
    
    class ldap_adaptador implements ldap_interface  {
        private $server ;
        private $bind;
        private $username ;
        private $password ;
        private $connection;
        private $grupos ;
        private $error = '';
        
        // necesitamos esto?
        // ldap_set_option( $this->connection, LDAP_OPT_PROTOCOL_VERSION, 3 );
        // ldap_set_option( $this->connection, LDAP_OPT_REFERRALS, 0 );
        
        function set_server( $server ){
            $port = 389;
            $this->server = $server;
            $this->connection = ldap_connect( $this->server, $port );
        }
        
        /* ldap_bind realiza la conexion y
         * devuelve el identificador propiamente dicho de la conexion
         */
        function conectar( $username, $password ){
            $this->bind = false;
            $this->bind = @ldap_bind( $this->connection, $username."@".$this->server, $password );
            $this->username = $username;
            $this->password = $password; // hace falta esto?
        }
        
        function conectado(){
            return $this->bind;
        }

        function buscar_grupos(){

            $ldap_dn = $this->convertiradn( $this->server );
            $filter = "(samAccountName=".$this->username.")";
            $result = ldap_search( $this->connection, $ldap_dn, $filter, array( "memberof" ) ) ;
            if( ! $result ) 
                return ;
            
            $entries = ldap_get_entries( $this->connection, $result);

            $this->grupos = [];
            foreach ( $entries[0]['memberof'] as $entrie ) {
                $matches = null;
                preg_match_all( "/(CN=)(?<grupo>[a-zA-Z0-9\_]+)[\,]?/", $entrie, $matches  );
                foreach( $matches["grupo"] as $value ){
                    if( $value[0] != "Users" ){
                        $this->grupos[] = $matches["grupo"][0];
                    }
                }
            }
        }
        
        private function convertiradn( $server ){
            $pattern = "|((?<parte>[a-z0-0A-Z]*)[\.]?)|";
            $matches = null;
            preg_match_all($pattern, $server, $matches );
            $dn = "CN=Users";
            foreach( $matches["parte"] as $value  ){
                if( $value != "" )
                    $dn .= ",DC=".$value;
            }
            
            return $dn;
        }
        
        
        function pertenece_grupo( $grupo ) : bool {
            return array_search( $grupo, $this->grupos ) !== false ;
        }
         
        function get_grupos(){
            return $this->grupos;
        }
        
        function cerrar(){
            ldap_close( $this->connection );
        }
        
    }
}
?>