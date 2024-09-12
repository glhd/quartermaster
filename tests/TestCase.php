<?php

namespace Glhd\Quartermaster\Tests;

use Glhd\Quartermaster\Support\QuartermasterServiceProvider;
use Laravel\Pennant\PennantServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
	protected function getPackageProviders($app)
	{
		return [
			QuartermasterServiceProvider::class,
			PennantServiceProvider::class,
		];
	}
	
	protected function getPackageAliases($app)
	{
		return [];
	}
	
	protected function getApplicationTimezone($app)
	{
		return 'America/New_York';
	}
}
