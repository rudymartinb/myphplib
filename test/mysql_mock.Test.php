<?php
// use function mylib\build;

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
		
		$db = mylib\mysql_query_mock::Builder()->build();
		
		$cadena = "sarasa estuvo aqui";
		$query = "SELECT '".$cadena."' as uno";
		
		$devolver = [];
		$devolver[0] = [ "uno" => $cadena ];
		
		$db->esperar( $query, function() use( $devolver ) { return $devolver; } );
        
		$arr = $db->ejecutar( $query );
		
		$this->assertEquals( $arr[0]['uno'] , $cadena, "al ejecutar un select que devuelve una string deberia devolver la string" );
		
	}

// 	public function test_SelectVacio(){
// 		$db = new mylib\mysql_query_mock();
		

// 		$query = "SELECT * from (select 1 as uno) as queseyo where false";
		
// 		$devolver = [];
		
// 		$db->esperar( $query, function() use( $devolver ) { return $devolver; } );
		
// 		$arr = $db->ejecutar( $query );

// 		$this->assertEquals( 0, count( $arr ), "al ejecutar un select que devuelve una consulta vacia deberia devolver un array vacio"    );
		
// 	}

	

}
?>