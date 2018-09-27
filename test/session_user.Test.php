<?php
// require_once( "src/class/session/session_data_fake.php" );
// use myphplib\session\session_user_interface;
use myphplib\session\session_user;
// use myphplib\session\session_user_mock;


class session_user_test extends PHPUnit\Framework\TestCase {
	
//     function crear() : session_user_interface {
//         $session_user = new session_user();
//         return $session_user;
//     }
    /**
     * @runInSeparateProcess
     */
	function test_session_start(){
	    $session_user = new session_user();
		$session_user->start();
		$this->assertEquals( PHP_SESSION_ACTIVE, $session_user->status(), "PHP_SESSION_ACTIVE" );
		$session_user->unset();
		$session_user->destroy();
	}

// 	/** 
// 	 * @runInSeparateProcess
// 	 */
// 	function test_session_name_ok(){
// 	    $session_user = $this->crear(); 
// 		$session_user->name( "sarasa" );
// 		$session_user->start();
// 		$this->assertEquals( true, $session_user->is_registered( "sarasa" ), "is_registered" );
// 		$session_user->unset();
// 		$session_user->destroy();
// 	}

	/**
	 * @runInSeparateProcess
	 */
	function test_session_name_fail(){
	    $session_user = new session_user();
		$session_user->start();
		$this->assertEquals( false, $session_user->is_registered( "sarasaxyz" ), "is_registered" );
		$session_user->unset();
		$session_user->destroy();
	}
	/**
	 * @runInSeparateProcess
	 */
	function test_set_get(){
	    $session_user = new session_user();
	    $session_user->start();
		$session_user->set( "sarasa", "palomon" );
		$this->assertEquals( "palomon", $session_user->get( "sarasa" ), "get" );
		$session_user->unset();
		$session_user->destroy();
	}
	/**
	 * @runInSeparateProcess
	 */
	function test_unset(){
	    // $session_user = $this->crear();
	    $session_user = new session_user();
	    $session_user->start();
		$session_user->set( "sarasa", "palomon" );
		$session_user->unset();
		$this->assertEquals( "", $session_user->get( "sarasa" ), "get" );
		$session_user->destroy();
	}
	/**
	 * @runInSeparateProcess
	 */
	function test_destroy(){
	    $session_user = new session_user();
	    $session_user->start();
		$session_user->set( "sarasa", "palomon" );
		$session_user->unset();
		$session_user->destroy();
		$this->assertEquals( "", $session_user->get( "sarasa" ), "get" );
	}
	
}

?>