<?php

namespace laspi94\CsgoServerApi\Tests\Feature;

use laspi94\CsgoServerApi\Classes\Command;
use laspi94\CsgoServerApi\Classes\Server;
use laspi94\CsgoServerApi\Classes\Summaries\ByCommandSummary;
use laspi94\CsgoServerApi\Facades\CsgoApi;
use laspi94\CsgoServerApi\Tests\Base;
use Ixudra\Curl\Builder;
use Ixudra\Curl\Facades\Curl;
use Mockery;

class DirectTest extends Base
{
	public function test_direct_method()
	{
		$this->execute_facade_method('direct');
	}

	public function test_to_method()
	{
		$this->execute_facade_method('to');
	}

	protected function execute_facade_method($method)
	{
		$builder = Mockery::mock(Builder::class)->makePartial();

		$builder->shouldReceive('get')->once()->andReturn(['error' => false, 'response' => 'response-1']);
		$builder->shouldReceive('get')->once()->andReturn(['error' => false, 'response' => 'response-2']);

		Curl::shouldReceive('to')->twice()->andReturn($builder);

		$response = CsgoApi::$method(ByCommandSummary::class)->addCommand([
			new Command('stats', 1500, false),
			new Command('status', 1500, false),
		])->addServer(
			new Server('177.54.150.15:27001')
		)->send();

		$expected = [
			"stats"  => [
				"177.54.150.15:27001" => "response-1",
			],
			"status" => [
				"177.54.150.15:27001" => "response-2",
			],
		];

		$this->assertEquals($expected, $response);
	}
}