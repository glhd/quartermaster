<?php

namespace Glhd\Quartermaster\Tests\Stubs;

use Glhd\Quartermaster\EnumeratesFeatures;

enum FeatureMissingResolvers
{
	use EnumeratesFeatures;
	
	case Foo;
	case Bar;
}
