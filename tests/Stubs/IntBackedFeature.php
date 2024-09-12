<?php

namespace Glhd\Quartermaster\Tests\Stubs;

use Glhd\Quartermaster\EnumeratesFeatures;

enum IntBackedFeature: int
{
	use EnumeratesFeatures;
	
	case EnabledFeature = 1337;
	case DisabledFeature = 9876;
	
	public function resolveEnabledFeature()
	{
		return true;
	}
	
	public function resolveDisabledFeature()
	{
		return false;
	}
}
