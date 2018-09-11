<?php
// require( "config.php" );
// require_once( $DIST.$CLASS.$DEMO."/cFakeDB.php" );
// 
//~ require_once( "db/mysql_interface.php" );
//~ require_once( "db/mysql_wrapper.php" );
//~ require_once( "db/mysql_mock.php" );
//~ require_once( "credencialessql.php" );
error_reporting(E_ALL);

class mysql_mock_OK_Test extends PHPUnit\Framework\TestCase {
	


	public function test_select_uno_caso_feliz(){
		
		$db = new mylib\mysql_mock();
		
		$servidor = new DemoServidorSQL();
		$usuario = new DemoUsuarioSQL();		
		$db->abrir( $usuario, $servidor );			

		
		$cadena = "sarasa estuvo aqui";
		$query = "SELECT '".$cadena."' as uno";
		
		$devolver = [];
		$devolver[0] = [ "uno" => $cadena ];
		
		$db->esperar( $query, $devolver );
        
		$arr = $db->ejecutar( $query );
		
		$this->assertEquals( $arr[0]['uno'] , $cadena, "al ejecutar un select que devuelve una string deberia devolver la string" );
		$db->cerrar();
		
	}


	

}
?>