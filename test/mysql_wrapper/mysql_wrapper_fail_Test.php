<?php


error_reporting(E_ALL);

/*
 * algun dia voy a tener q parar de armar wrappers de mysql
 * 
 * que pretendo con la clase de objeto
 * 
 * 1) no tener que lidiar con rutinas internas de mysql
 * 2) delegar totalmente el tratamiento de errores (is this wise?)
 * 3) no tener q andar pasando un  objeto conexion_a_db a todos lados
 * 4) hacer una coinsulta y recibir todos los datos como array
 * 5) hacer una subclase como testdouble  (IMPORTANTE ?!)
 * 
 * ver test/SQL.TXT 
 * 
*/

class mysql_wrapper_fail_Test extends PHPUnit\Framework\TestCase {
	private $host = "192.168.111.3";
	private $user = "root";
	private $pwd = "";
	private $port = 3306;
	private $catalogo = "";	
     
	/* 
	 * tiene sentido esto?
	 * si voy a abrir una conexion a una base de datos, 
	 * me importar'ia mas saber si funciono o no
	*/

	function dbsetup( $query  ) { 
	    return $this->dbsetupfun( function( $db ) use( $query ) { $db->ejecutar( $query ); } ) ;
	}

	function dbsetupfun( $query  ) {
	    $db = new myphplib\mysql_wrapper();
	    
	    $servidor = new DemoServidorSQL();
	    $usuario = new DemoUsuarioSQL();
	    
	    $db->abrir( $usuario, $servidor );
	    
	    $error_actual = "";
	    $query( $db );
	    $error_actual = $db->get_error();
	    
	    $db->cerrar();
	    return $error_actual;
	}
	
	public function test_mal_catalogo(){
		// ultimo cambio despues de sacar el try
		$error_esperado = "Unknown database 'no_existe'";
		
		$db = new myphplib\mysql_wrapper( );			
		$servidor = new DemoServidorSQL();
		$servidor->set_catalogo( "no_existe" );
		$usuario = new DemoUsuarioSQL();
		$db->abrir( $usuario, $servidor );
				
		$error_actual = $db->get_error();
		$this->assertEquals( $error_esperado, $error_actual, "deberia dar error por no existir el catalogo " );
		
	}

	public function test_error_no_existe_tabla(){
	    $query = "SELECT * from test.algo" ;
        $error_actual = $this->dbsetup( $query );
        $error_esperado = "Table 'test.algo' doesn't exist";
        $this->assertEquals( $error_esperado, $error_actual, "no deberia existir tabla algo " );
	}

	public function test_insert_error(){
		$error_esperado = "Cannot add or update a child row: a foreign key constraint fails (`test`.`relacionada1`, CONSTRAINT `FK_relacionada1_1` FOREIGN KEY (`elotroid`) REFERENCES `relacionada2` (`elotroid`))";
		$query = "insert into test.relacionada1 set elotroid = 0";

		$error_actual = $this->dbsetup( $query );
		
		$this->assertEquals( $error_esperado, $error_actual, "cuando se inserta un registro en una dependiente de dos tablas relacionadas, y no tiene el id correcto y debe fallar" );

	}	

	// este test funciona contra una tabla existente en catalogo test
	public function test_insert_falla(){
		$error_esperado = "Column 'algo' cannot be null";

		$query = "insert into test.relacionada2 set algo = null";
		$error_actual = $this->dbsetup( $query );
		
		$this->assertEquals( $error_esperado, $error_actual, "cuando se inserta un registro con null deberia fallar" );
		
	}	

	public function test_update_error(){
		$error_esperado = "Cannot add or update a child row: a foreign key constraint fails (`test`.`relacionada1`, CONSTRAINT `FK_relacionada1_1` FOREIGN KEY (`elotroid`) REFERENCES `relacionada2` (`elotroid`))";
		
		$funcion = function( $db ){ 
		    $db->ejecutar( "start transaction;" );
		    $db->ejecutar( "insert into test.relacionada2 set algo = 'algo2'" );
		    $arr = $db->ejecutar( "select last_insert_id() as id" );
		    $db->ejecutar( "insert into test.relacionada1 set elotroid = ".$arr[0]['id'] );
		    $db->ejecutar( "update test.relacionada1 set elotroid = 0" );
		};
		
		$error_actual = $this->dbsetupfun( $funcion );
		$this->assertEquals( $error_esperado, $error_actual, "dos tablas relacionadas, se inserta un registro en una dependiente que no tiene el id correcto, debe fallar" );
	}		

}
?>