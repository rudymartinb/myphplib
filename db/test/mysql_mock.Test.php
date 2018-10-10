<?php
error_reporting(E_ALL);

class mysql_mock_OK_Test extends PHPUnit\Framework\TestCase {
	public function test_select_uno_caso_feliz(){
		
	    $db = myphplib\mysql_query_mock::Builder()->build();
		
		$cadena = "sarasa estuvo aqui";
		$query = "SELECT '".$cadena."' as uno";
		
		$devolver = [];
		$devolver[0] = [ "uno" => $cadena ];
		
		$db->esperar( $query, function() use( $devolver ) { return $devolver; } );
        
		$arr = $db->ejecutar( $query );
		
		$this->assertEquals( $arr[0]['uno'] , $cadena, "al ejecutar un select que devuelve una string deberia devolver la string" );
		
	}

	public function test_SelectVacio(){
		// $db = new mylib\mysql_query_mock(); 
		$db = myphplib\mysql_query_mock::Builder()->build();
		$query = "SELECT * from (select 1 as uno) as queseyo where false";
		$devolver = [];
		$db->esperar( $query, function() use( $devolver ) { return $devolver; } );
		$arr = $db->ejecutar( $query );

		$this->assertEquals( 0, count( $arr ), "al ejecutar un select que devuelve una consulta vacia deberia devolver un array vacio"    );
		
	}

	

}
?>