<?php
// require( "config.php" );
// require_once( $DIST.$CLASS.$DEMO."/cFakeDB.php" );
// 
//~ require_once( "db/mysql_interface.php" );
//~ require_once( "db/mysql_wrapper.php" );
//~ require_once( "credencialessql.php" );
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



class mysql_wrapper_OK_Test extends PHPUnit\Framework\TestCase {
	private $host = "192.168.111.3";
	private $user = "root";
	private $pwd = "";
	private $port = 3306;
	private $catalogo = "";	

	public function test_test(){
	    
	    $db = new myphplib\mysql_wrapper();
	    
	    $servidor = new DemoServidorSQL();
	    $this->assertTrue( $db->probar( $servidor ), "al probar la conexion deberia funcionar" );
	    
	    
	}

	/*
	 * tiene sentido esto?
	 * si voy a abrir una conexion a una base de datos, 
	 * me importar'ia mas saber si funciono o no
	*/
	


	public function test_select_uno_caso_feliz(){
		
	    $db = new myphplib\mysql_wrapper();
		
		$servidor = new DemoServidorSQL();
		$usuario = new DemoUsuarioSQL();		
		$db->abrir( $usuario, $servidor );			

		
		$cadena = "sarasa estuvo aqui";
        
		$arr = $db->ejecutar( "SELECT '".$cadena."' as uno" );
		
		$this->assertEquals( $arr[0]['uno'] , $cadena, "al ejecutar un select que devuelve una string deberia devolver la string" );
		
		// $valor= $db->ejecutar( "SELECT last_insert_id() as idalumno" );
		// var_dump( $valor );
		
		
		$db->cerrar();
		
	}

	public function test_SelectVacio(){
	    $db = new myphplib\mysql_wrapper();
		
		$servidor = new DemoServidorSQL();
		$usuario = new DemoUsuarioSQL();		

		$db->abrir( $usuario, $servidor );			
		$arr = $db->ejecutar( "SELECT * from (select 1 as uno) as queseyo where false" );

		$this->assertEquals( 0, count( $arr ), "al ejecutar un select que devuelve una consulta vacia deberia devolver un array vacio"    );
		
		$db->cerrar();
	}
	
	
	public function test_InsertOK(){
	    $db = new myphplib\mysql_wrapper();
		
		$servidor = new DemoServidorSQL();
		$usuario = new DemoUsuarioSQL();		

		$db->abrir( $usuario, $servidor );			
        
		$db->ejecutar( "start transaction;" );
		$db->ejecutar( "delete from test.relacionada2;" );
		$db->ejecutar( "insert into test.relacionada2 set algo = 'queseyo'" );
		
		$arr = $db->ejecutar( "SELECT algo from test.relacionada2" );
		
		$this->assertEquals( "queseyo", $arr[0]['algo'], "valor insertado en el registro" );

		$arr = $db->ejecutar( "rollback;" );
		
		$db->cerrar();
	}	

	

	public function test_update_ok(){
	    $db = new myphplib\mysql_wrapper();
		$servidor = new DemoServidorSQL();
		$usuario = new DemoUsuarioSQL();		
		$db->abrir( $usuario, $servidor );			
				
		$db->ejecutar( "start transaction;" );
		$db->ejecutar( "delete from test.relacionada2;" );
		$db->ejecutar( "insert into test.relacionada2 set algo = 'otra'" );
		$db->ejecutar( "update test.relacionada2 set algo = 'queseyo'" );
		
		$arr = $db->ejecutar( "SELECT algo from test.relacionada2" );
		
		$this->assertEquals( "queseyo", $arr[0]['algo'], "valor actualizado en el unico registro" );

		$arr = $db->ejecutar( "rollback;" );
		$db->cerrar();
	}
	
	
	
	/* si convertimos la static en public static podemos probar esto
	 * */
	function test_Mismo_Obj(){
	    $db = new myphplib\mysql_wrapper( );

		$servidor = new DemoServidorSQL();
		$usuario = new DemoUsuarioSQL();		
		$db->abrir( $usuario, $servidor );
						
		$db2 = new myphplib\mysql_wrapper(  );
		
		$servidor = new DemoServidorSQL();
		$usuario = new DemoUsuarioSQL();		
		$db2->abrir( $usuario, $servidor );
		
		// por ahora false
		$this->assertFalse( $db->esIgual( $db2 ) );

		$db->cerrar();		
		$db2->cerrar();
	}
	
	

}
?>