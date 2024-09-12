<?php

namespace Glhd\Quartermaster\Tests\Stubs;

use Glhd\Quartermaster\EnumeratesFeatures;

enum UnbackedFeature
{
	use EnumeratesFeatures;
	
	case EnabledFeature;
	case DisabledFeature;
	
	public function resolveEnabledFeature()
	{
		return true;
	}
	
	public function resolveDisabledFeature()
	{
		return false;
	}
}
