<?php

// require( "config.php" );
// require_once( $DIST.$CLASS.$DEMO."/cFakeDB.php" );
//~ $BASE = $_SERVER["HOME"]."/projects/myphplib";
//~ $BASETEST = $BASE."/test";

//~ require_once( $BASE."/db/mysql_interface.php" );
//~ require_once( $BASE."/db/mysql_wrapper.php" ); 
//~ require_once( $BASETEST."/credencialessql.php" );

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
 * 
CREATE TABLE  `test`.`relacionada1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `elotroid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_relacionada1_1` (`elotroid`),
  CONSTRAINT `FK_relacionada1_1` FOREIGN KEY (`elotroid`) REFERENCES `relacionada2` (`elotroid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='dependiente';

CREATE TABLE  `test`.`relacionada2` (
  `elotroid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `algo` varchar(10) NOT NULL,
  PRIMARY KEY (`elotroid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='dependiente';


drop table test.relacionada1;
drop table test.relacionada2;


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
	

	public function test_mal_catalogo(){
		// version php 5.6 
		$error_esperado = "mysqli::mysqli(): (HY000/1049): Unknown database 'no_existe'";
		
		// version php 7.2
		$error_esperado = "mysqli::__construct(): (42000/1049): Unknown database 'no_existe'";
		
		
		$db = new mylib\mysql_wrapper( );			
		$servidor = new DemoServidorSQL();
		$servidor->set_catalogo( "no_existe" );
		$error_actual = "";
		$usuario = new DemoUsuarioSQL();

				
		try {
			$db->abrir( $usuario, $servidor );
		} catch ( Exception $e ){
			$error_actual = $e->getMessage();
		}
		$this->assertEquals( $error_esperado, $error_actual, "deberia dar error por no existir el catalogo " );
		
	}



	public function test_error_no_existe_tabla(){
		$db = new mylib\mysql_wrapper();
		
		$servidor = new DemoServidorSQL();
		$usuario = new DemoUsuarioSQL();		

		$db->abrir( $usuario, $servidor );			
		
		$error_actual = "";
		try {
			$db->ejecutar( "SELECT * from test.algo" );	
		} catch( Exception $x ) {
			$error_actual = $x->getMessage();
		}
		$error_esperado = "Table 'test.algo' doesn't exist";
		$this->assertEquals( $error_esperado, $error_actual, "no deberia existir tabla algo " );

        $db->cerrar();
		
	}


	/* 
	 * la idea es generar un error de sql mediante una falla de integridad de SQL
	*/
	public function test_insert_error(){
		$error_esperado = "Cannot add or update a child row: a foreign key constraint fails (`test`.`relacionada1`, CONSTRAINT `FK_relacionada1_1` FOREIGN KEY (`elotroid`) REFERENCES `relacionada2` (`elotroid`))";
		
		$db = new mylib\mysql_wrapper();
		$servidor = new DemoServidorSQL();
		$usuario = new DemoUsuarioSQL();		
		$db->abrir( $usuario, $servidor );			
        
        $db->ejecutar( "start transaction;" );
        
		$query = "insert into test.relacionada1 set elotroid = 0";
		
		$error_actual = "";
		try {
			$db->ejecutar( $query );
		} catch( Exception $e ) {
			$error_actual = $e->getMessage();
		}
		$this->assertEquals( $error_esperado, $error_actual, 
		"cuando se inserta un registro en una dependiente de dos tablas relacionadas, y no tiene el id correcto y debe fallar" );
		$db->ejecutar( "rollback;" );
		
		$db->cerrar();
	}	

	// este test funciona contra una tabla existente en catalogo test
	public function test_insert_falla(){
		$error_esperado = "Column 'algo' cannot be null";
		
		$db = new mylib\mysql_wrapper();
		$servidor = new DemoServidorSQL();
		$usuario = new DemoUsuarioSQL();		
		$db->abrir( $usuario, $servidor );			
		
		$db->ejecutar( "start transaction;" );
		
		$error_actual = "";
		try {
			$db->ejecutar( "insert into test.relacionada2 set algo = null" );
		} catch( Exception $e ) {
			$error_actual = $e->getMessage();
		}
		$this->assertEquals( $error_esperado, $error_actual, "cuando se inserta un registro con null deberia fallar" );
		$db->ejecutar( "rollback;" );
		
		$db->cerrar();
		
	}	


	
	public function test_update_error(){
		$error_esperado = "Cannot add or update a child row: a foreign key constraint fails (`test`.`relacionada1`, CONSTRAINT `FK_relacionada1_1` FOREIGN KEY (`elotroid`) REFERENCES `relacionada2` (`elotroid`))";
		
		$db = new mylib\mysql_wrapper();
		$servidor = new DemoServidorSQL();
		$usuario = new DemoUsuarioSQL();		
		$db->abrir( $usuario, $servidor );
		
		$db->ejecutar( "start transaction;" );
		$db->ejecutar( "insert into test.relacionada2 set algo = 'algo2'" );
		$arr = $db->ejecutar( "select last_insert_id() as id" );
		$db->ejecutar( "insert into test.relacionada1 set elotroid = ".$arr[0]['id'] );

		$error_actual = "";
		try {
			$arr = $db->ejecutar( "update test.relacionada1 set elotroid = 0" );
		} catch( Exception $e ) {
			$error_actual = $e->getMessage();
		}
		$this->assertEquals( $error_esperado, $error_actual, "dos tablas relacionadas, se inserta un registro en una dependiente que no tiene el id correcto, debe fallar" );
		$arr = $db->ejecutar( "rollback;" );
		
		$db->cerrar();
	
	}		
	
	

	
	

}
?>