<?php

namespace Glhd\Quartermaster\Tests\Stubs;

use Glhd\Quartermaster\EnumeratesFeatures;

enum StringBackedFeature: string
{
	use EnumeratesFeatures;
	
	case EnabledFeature = 'enabled';
	case DisabledFeature = 'disabled';
	
	public function resolveEnabledFeature()
	{
		return true;
	}
	
	public function resolveDisabledFeature()
	{
		return false;
	}
}
