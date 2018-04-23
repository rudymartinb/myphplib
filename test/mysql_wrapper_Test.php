<?php
// require( "config.php" );
// require_once( $DIST.$CLASS.$DEMO."/cFakeDB.php" );
require_once( "db/mysql_wrapper.php" );
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
*/

class mysql_wrapper_Test extends PHPUnit_Framework_TestCase {
	
     
	/*
	 * tiene sentido esto?
	 * si voy a abrir una conexion a una base de datos, 
	 * me importar'ia mas saber si funciono o no
	*/
	public function test_abrirLocal_mal_catalogo(){
		$error_esperado = "mysqli::mysqli(): (HY000/1049): Unknown database 'no_existe'";
		
		
		$db = new mylib\mysql_wrapper( );			
		$host = "127.0.0.1"; 
		$user = "root";
		$pwd = "sunpei42";
		$port = 3306;
		$catalogo = "no_existe";
		try {
			$db->abrir( $host, $user, $pwd, $catalogo, $port );			
		} catch ( Exception $e ){
			$error_actual = $e->getMessage();
		}
		$this->assertEquals( $error_esperado, $error_actual, "deberia dar error por no existir el catalogo " );
		// $db->cerrar();
		
	}

	
	public function test_select_uno(){
		$db = new mylib\mysql_wrapper();
		$host = "127.0.0.1"; 
		$user = "root";
		$pwd = "sunpei42";
		$port = 3306;
		$catalogo = "testing";
		$db->abrir( $host, $user, $pwd, $catalogo, $port );			
        
		$arr = $db->ejecutar( "SELECT 'sarasa estuvo aqui' as uno" );
		
		$this->assertEquals( $arr[0]['uno'] , "sarasa estuvo aqui" );
		$db->cerrar();
		// $db->cerrar();
	}
	
		

	public function test_no_existe_tabla(){
		
		$error_esperado = "Table 'testing.sarasa' doesn't exist";
		
		$db = new mylib\mysql_wrapper();
		// $db->abrirLocal( "testing" );
		$host = "127.0.0.1"; 
		$user = "root";
		$pwd = "sunpei42";
		$port = 3306;
		$catalogo = "testing";
		$db->abrir( $host, $user, $pwd, $catalogo, $port );			
		try {
			$arr = $db->ejecutar( "SELECT * from sarasa" );
		} catch( Exception $x ) {
			$error_actual = $x->getMessage();
		}
		$this->assertEquals( $error_esperado, $error_actual, "no deberia existir tabla sarasa " );

		
        // $db->cerrar();
		
	}
	

	public function test_SelectVacio(){
		$db = new mylib\mysql_wrapper();
		// $db->abrirLocal( "testing" );
        $host = "127.0.0.1"; 
		$user = "root";
		$pwd = "sunpei42";
		$port = 3306;
		$catalogo = "testing";
		$db->abrir( $host, $user, $pwd, $catalogo, $port );			
		$arr = $db->ejecutar( "SELECT * from testing.tabla1 where false" );
		$this->assertEquals( "array", gettype( $arr )  );
		$this->assertEquals( 0, count( $arr )  );
		
		// $db->cerrar();
	}	
	
	public function test_InsertOK(){
		$db = new mylib\mysql_wrapper( );
        $host = "127.0.0.1"; 
		$user = "root";
		$pwd = "sunpei42";
		$port = 3306;
		$catalogo = "testing";
		$db->abrir( $host, $user, $pwd, $catalogo, $port );			
        
		$db->ejecutar( "start transaction;" );
		$db->ejecutar( "delete from testing.tabla1;" );
		$db->ejecutar( "insert into testing.tabla1 set sarasa = 'queseyo'" );
		
		$arr = $db->ejecutar( "SELECT sarasa from testing.tabla1" );
		
		$this->assertEquals( "queseyo", $arr[0]['sarasa'], "valor insertado en el registro" );

		$arr = $db->ejecutar( "rollback;" );
		$db->cerrar();

	}	
	
	/*
CREATE TABLE  `testing`.`relacionada1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `elotroid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_relacionada1_1` (`elotroid`),
  CONSTRAINT `FK_relacionada1_1` FOREIGN KEY (`elotroid`) REFERENCES `relacionada2` (`elotroid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='dependiente';
	*/
	
	/* 
	 * la idea es generar un error de sql mediante una falla de integridad de SQL
	*/
	public function test_insert_error(){
		$error_esperado = "Cannot add or update a child row: a foreign key constraint fails (`testing`.`relacionada1`, CONSTRAINT `FK_relacionada1_1` FOREIGN KEY (`elotroid`) REFERENCES `relacionada2` (`elotroid`))";
		
		$db = new mylib\mysql_wrapper();
		$host = "127.0.0.1"; 
		$user = "root";
		$pwd = "sunpei42";
		$port = 3306;
		$catalogo = "testing";
		$db->abrir( $host, $user, $pwd, $catalogo, $port );			
        
		$query = "insert into relacionada1 set elotroid = 0";
		
		try {
			$arr = $db->ejecutar( $query );
		} catch( Exception $e ) {
			$error_actual = $e->getMessage();
		}
		$this->assertEquals( $error_esperado, $error_actual, "cuando se inserta un registro en una dependiente de dos tablas relacionadas, y no tiene el id correcto y debe fallar" );

		$db->cerrar();
	}	

	
	public function test_insert_falla(){
		$error_esperado = "Column 'sarasa' cannot be null";
		
		$db = new mylib\mysql_wrapper(  );
		$host = "127.0.0.1"; 
		$user = "root";
		$pwd = "sunpei42";
		$port = 3306;
		$catalogo = "testing";
		$db->abrir( $host, $user, $pwd, $catalogo, $port );			
		
		try {
			$arr = $db->ejecutar( "insert into tabla1 set sarasa = null" );
		} catch( Exception $e ) {
			$error_actual = $e->getMessage();
		}
		$this->assertEquals( $error_esperado, $error_actual, "cuando se inserta un registro con null deberia fallar" );

		$db->cerrar();
	}	
	
	public function test_update_ok(){
		$db = new mylib\mysql_wrapper( );
		$host = "127.0.0.1"; 
		$user = "root";
		$pwd = "sunpei42";
		$port = 3306;
		$catalogo = "testing";
		$db->abrir( $host, $user, $pwd, $catalogo, $port );			
		
		$db->ejecutar( "start transaction;" );
		$db->ejecutar( "delete from tabla1;" );
		$db->ejecutar( "insert into tabla1 set sarasa = 'otra'" );
		$db->ejecutar( "update tabla1 set sarasa = 'queseyo'" );
		
		$arr = $db->ejecutar( "SELECT sarasa from tabla1" );
		
		$this->assertEquals( "queseyo", $arr[0]['sarasa'], "valor actualizado en el unico registro" );

		$arr = $db->ejecutar( "rollback;" );
		$db->cerrar();

	}
	
	public function test_update_error(){
		$error_esperado = "Cannot add or update a child row: a foreign key constraint fails (`testing`.`relacionada1`, CONSTRAINT `FK_relacionada1_1` FOREIGN KEY (`elotroid`) REFERENCES `relacionada2` (`elotroid`))";
		
		$db = new mylib\mysql_wrapper();
		$host = "127.0.0.1"; 
		$user = "root";
		$pwd = "sunpei42";
		$port = 3306;
		$catalogo = "testing";
		$db->abrir( $host, $user, $pwd, $catalogo, $port );			
		
		$db->ejecutar( "insert into relacionada2 set algo = 'algo2'" );
		$arr = $db->ejecutar( "select last_insert_id() as id" );
		$db->ejecutar( "insert into relacionada1 set elotroid = ".$arr[0]['id'] );

		try {
			$arr = $db->ejecutar( "update relacionada1 set elotroid = 0" );
		} catch( Exception $e ) {
			$error_actual = $e->getMessage();
		}
		$this->assertEquals( $error_esperado, $error_actual, "dos tablas relacionadas, se inserta un registro en una dependiente que no tiene el id correcto, debe fallar" );

		$db->cerrar();
	}	

	/* si convertimos la static en public static podemos probar esto
	 * */
	function test_Mismo_Obj(){
		$db = new mylib\mysql_wrapper( );

		$host = "127.0.0.1"; 
		$user = "root";
		$pwd = "sunpei42";
		$port = 3306;
		$catalogo = "testing";
		$db->abrir( $host, $user, $pwd, $catalogo, $port );			
				
		$db2 = new mylib\mysql_wrapper(  );

		$host = "127.0.0.1"; 
		$user = "root";
		$pwd = "sunpei42";
		$port = 3306;
		$catalogo = "testing";
		$db2->abrir( $host, $user, $pwd, $catalogo, $port );					
		
		$this->assertTrue( $db->esIgual( $db2 ) );
	}

	

}
?>