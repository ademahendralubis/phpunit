<?php
namespace Acme\Tests;

use Acme\Http\Response;
use Acme\Http\Request;
use Acme\Validation\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
	
	public function testGetIsValidReturnTrue()
	{
		$request = new Request([]);
		$response = new Response($request);
		$validator = new Validator($request, $response);

		$validator->setIsValid(true);
		$this->assertTrue($validator->getIsValid());
	}

	public function testGetIsValidReturnFalse()
	{
		$request = new Request([]);
		$response = new Response($request);
		$validator = new Validator($request, $response);

		$validator->setIsValid(false);
		$this->assertFalse($validator->getIsValid());
	}
}
