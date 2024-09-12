<?php

namespace Glhd\Quartermaster\Tests;

use Glhd\Quartermaster\Support\QuartermasterServiceProvider;
use Illuminate\Container\Container;
use Laravel\Pennant\PennantServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use PHPUnit\Framework\Attributes\Before;

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
