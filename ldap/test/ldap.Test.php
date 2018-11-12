<?php
/*
 * historias a resolver sobre la seguridad de usuarios
 * 
 * 1) como usuario no autenticado proporciono usuario/clave validos para autenticarme en el sistema
 * (implicitamente comprobamos que el servidor existe)
 * 2) como usuario no autenticado proporciono usuario/clave no validos para que el sistema me rebote
 * 3) como usuario autenticado necesito pertenecer a un grupo de usuarios valido para poder continuar 
 * 4) como usuario autenticado necesito que al no pertenecer a un grupo de usuarios valido el sistema me rebote
 
*/

use ldap\ldap;

class ldap_test extends PHPUnit\Framework\TestCase {
    
    public function mysetup( string $username, string $password ) : ldap {
        $ldap = new ldap();
        $ldap->set_server( 'dep.local' );
        $ldap->conectar( $username, $password );
        return $ldap;
    }

    /* microtest para corroborar el pattern usado en convertiradn()
     */
    public function test_server_a_dn(){
        $pattern = "|((?<parte>[a-z0-0A-Z]*)[\.]?)|";
        $matches = null;
        preg_match_all($pattern, "dep.local", $matches );
        $this->assertEquals( "dep", $matches["parte"][0] );
        $this->assertEquals( "local", $matches["parte"][1] );
    }

    
	public function test_caso1_conectar(){
        $username = '1armador';
		$password = '1armador1';
		$ldap = $this->mysetup( $username, $password );
		$this->assertTrue( $ldap->conectado() );
		$ldap->cerrar();
	}
	
	
	public function test_pertenece_grupo_OK(){
		$username = 'mantener';
		$password = 'tenmantenman';
		
		$ldap = $this->mysetup( $username, $password );
		
		$ldap->buscar_grupos( );
		$grupo = "Soporte";
		$this->assertTrue( $ldap->pertenece_grupo($grupo) );
		$ldap->cerrar();
	}

	public function test_pertenece_grupo_FAIL(){
	    $username = 'mantener';
	    $password = 'tenmantenman';
	    
	    $ldap = $this->mysetup( $username, $password );
	    $ldap->buscar_grupos( );
	    $this->assertFalse( $ldap->pertenece_grupo("AR") );
	    $ldap->cerrar();
	}
	
	public function test_caso2(){
		$username = '1armador';
		$password = '1armador1X';
		
		$ldap = $this->mysetup( $username, $password );
		
		$this->assertFalse( $ldap->conectado() );
		
	}
	
	public function test_buscar(){
	    $username = 'mantener';
	    $password = 'tenmantenman';
	    
	    $ldap = $this->mysetup( $username, $password );
	    $ldap->buscar_grupos( );
	    $grupos = $ldap->get_grupos();

	    $this->assertTrue( count( $grupos ) > 0 );
	    
	}

	
}
?>