<?php
namespace Acme\Tests;

//use Acme\Http\Response;
//use Acme\Http\Request;
use Acme\Validation\Validator;
use Kunststube\CSRFP\SignatureGenerator;
use dotenv;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
	protected $request;
	protected $response;
	protected $validator;
	
	
	public function testGetIsValidReturnTrue()
	{
		$validator = new validator($this->request, $this->response);
		$validator->setIsValid(true);
		$this->assertTrue($validator->getIsValid());
	}

	protected function setUp()
	{
		$signer = $this->getMockBuilder('Kunststube\CSRFP\SignatureGenerator')
					   ->setConstructorArgs(['abc123'])
					   ->getMock();
		$this->request = $this->getMockBuilder('Acme\Http\Request')
							  ->getMock();
		$this->response = $this->getMockBuilder('Acme\Http\Response')
					   		   ->setConstructorArgs([$this->request,$signer])
					           ->getMock();
	}

	public function testGetIsValidReturnFalse()
	{
		$validator = new validator($this->request, $this->response);
		$validator->setIsValid(false);
		$this->assertFalse($validator->getIsValid());
	}

	public function testCheckForMinStringLengthWithValidData()
    {
       $req = $this->getMockBuilder('Acme\Http\Request')
       		       ->getMock();
       $req->expects($this->once())
       	   ->method('input')
       	   ->will($this->returnValue('yellow'));
       $validator = new validator($req,$this->response);
       $errors = $validator->check(['mintype' => 'min:3']);
       $this->assertCount(0, $errors);
    }

    public function testCheckForMinStringLengthWithInvalidData()
    {
       $req = $this->getMockBuilder('Acme\Http\Request')
       		       ->getMock();
       $req->expects($this->once())
       	   ->method('input')
       	   ->will($this->returnValue('x'));
       $validator = new validator($req,$this->response);
       $errors = $validator->check(['mintype' => 'min:3']);
       $this->assertCount(1, $errors);
    }

    public function testCheckForEmailWithValidData()
    {
   	   $req = $this->getMockBuilder('Acme\Http\Request')
       		       ->getMock();
       $req->expects($this->once())
       	   ->method('input')
       	   ->will($this->returnValue('john@here.com'));
       $validator = new validator($req,$this->response);
       $errors = $validator->check(['mintype' => 'email']);
       $this->assertCount(0, $errors);
    }

    
    public function testCheckForEmailWithInvalidData()
    {
       $req = $this->getMockBuilder('Acme\Http\Request')
       		       ->getMock();
       $req->expects($this->once())
       	   ->method('input')
       	   ->will($this->returnValue('johnhere.com'));
       $validator = new validator($req,$this->response);
       $errors = $validator->check(['mintype' => 'email']);
       $this->assertCount(1, $errors);
    }

    /*
    public function testValidateWithInvalidData()
    {
    	$req = $this->getMockBuilder('Acme\Http\Request')
       		       ->getMock();
        $req->expects($this->once())
       	   ->method('input')
       	   ->will($this->returnValue('john@here.com'));
        $validator = new validator($req,$this->response);
    	$this->testdata = ['check_field' => 'x'];
    	$this->setUpRequestResponse();
    	$this->validator->validate(['check_field' => 'email'], '/register');
    }*/
}
