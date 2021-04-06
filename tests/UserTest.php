
<?php


class UserTest extends \PHPUnit\Framework\TestCase {

	
	public function login(){
		$user = new \api\objects\user;
		$user->login('TOMMMY','TOMMY@test.com','1234567');
		$this->assertEquals($user->login(), 'TOMMMY','TOMMY@test.com','1234567');
	}


	public function signup(){

		$user = new \api\objects\user;
		$user->signup('TOMMMY','TOMMY@test.com','1234567');
		$this->assertEquals($user->signup(), 'TOMMMY','TOMMY@test.com','1234567');
	}
	
}
?>