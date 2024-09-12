<?php

namespace Glhd\Quartermaster\Tests\Stubs;

use Glhd\Quartermaster\Feature;

class ClassFeature extends Feature
{
	public function resolve(TestScope $scope)
	{
		return $scope->resolve;
	}
}
