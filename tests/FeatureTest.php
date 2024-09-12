<?php

use Glhd\Quartermaster\Tests\Stubs\ClassFeature;
use Glhd\Quartermaster\Tests\Stubs\TestScope;
use Glhd\Quartermaster\Tests\TestCase;
use Laravel\Pennant\Feature;

class FeatureTest extends TestCase
{
	public function test_pending_interactions(): void
	{
		$default = new TestScope(['id' => 1, 'resolve' => 'default']);
		$always = new TestScope(['id' => 2, 'resolve' => true]);
		$never = new TestScope(['id' => 3, 'resolve' => false]);
		
		Feature::resolveScopeUsing(fn() => $default);
		
		// Test default scope
		
		$this->assertEquals('default', ClassFeature::value());
		$this->assertTrue(ClassFeature::active());
		$this->assertFalse(ClassFeature::inactive());
		
		// Test specific scope
		
		$this->assertTrue(ClassFeature::for($always)->value());
		$this->assertTrue(ClassFeature::for($always)->active());
		$this->assertFalse(ClassFeature::for($always)->inactive());
		$this->assertFalse(ClassFeature::for($never)->value());
		$this->assertFalse(ClassFeature::for($never)->active());
		$this->assertTrue(ClassFeature::for($never)->inactive());
		
		// Manually activate/deactivate
		
		ClassFeature::deactivate();
		
		$this->assertFalse(ClassFeature::value());
		$this->assertFalse(ClassFeature::active());
		$this->assertTrue(ClassFeature::inactive());
		$this->assertFalse(ClassFeature::for($default)->value());
		$this->assertFalse(ClassFeature::for($default)->active());
		$this->assertTrue(ClassFeature::for($default)->inactive());
		$this->assertTrue(ClassFeature::for($always)->value());
		$this->assertTrue(ClassFeature::for($always)->active());
		$this->assertFalse(ClassFeature::for($always)->inactive());
		
		ClassFeature::activate('custom');
		
		$this->assertEquals('custom', ClassFeature::value());
		$this->assertTrue(ClassFeature::active());
		$this->assertFalse(ClassFeature::inactive());
		$this->assertEquals('custom', ClassFeature::for($default)->value());
		$this->assertTrue(ClassFeature::for($default)->active());
		$this->assertFalse(ClassFeature::for($default)->inactive());
		$this->assertFalse(ClassFeature::for($never)->value());
		$this->assertFalse(ClassFeature::for($never)->active());
		$this->assertTrue(ClassFeature::for($never)->inactive());
		
		// Forget
		
		ClassFeature::forget();
		
		$this->assertEquals('default', ClassFeature::value());
		$this->assertTrue(ClassFeature::active());
		$this->assertFalse(ClassFeature::inactive());
	}
}
