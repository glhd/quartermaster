<?php

use Glhd\Quartermaster\Tests\Stubs\FeatureMissingResolvers;
use Glhd\Quartermaster\Tests\Stubs\IntBackedFeature;
use Glhd\Quartermaster\Tests\Stubs\StringBackedFeature;
use Glhd\Quartermaster\Tests\Stubs\UnbackedFeature;
use Glhd\Quartermaster\Tests\TestCase;
use Laravel\Pennant\Feature;

class EnumeratesFeaturesTest extends TestCase
{
	public function test_register_throws_when_missing_a_resolver(): void
	{
		$this->expectException(LogicException::class);
		
		FeatureMissingResolvers::register();
	}
	
	public function test_register_does_not_throw_if_require_resolvers_is_disabled(): void
	{
		config()->set('quartermaster.require_resolvers', false);
		
		FeatureMissingResolvers::register();
		
		$this->assertEmpty(Feature::defined());
	}
	
	public function test_defining_a_feature_prevents_quartermaster_exception(): void
	{
		FeatureMissingResolvers::Foo->define(fn() => true);
		FeatureMissingResolvers::Bar->define(fn() => true);
		
		FeatureMissingResolvers::register();
		
		$this->assertEquals(
			expected: [FeatureMissingResolvers::Foo->name(), FeatureMissingResolvers::Bar->name()], 
			actual: Feature::defined()
		);
	}
	
	public function test_unbacked_enums(): void
	{
		UnbackedFeature::register();
		
		$this->assertTrue(UnbackedFeature::EnabledFeature->active());
		$this->assertFalse(UnbackedFeature::EnabledFeature->inactive());
		
		$this->assertFalse(UnbackedFeature::DisabledFeature->active());
		$this->assertTrue(UnbackedFeature::DisabledFeature->inactive());
	}
	
	public function test_string_backed_enums(): void
	{
		StringBackedFeature::register();
		
		$this->assertTrue(StringBackedFeature::EnabledFeature->active());
		$this->assertFalse(StringBackedFeature::EnabledFeature->inactive());
		
		$this->assertFalse(StringBackedFeature::DisabledFeature->active());
		$this->assertTrue(StringBackedFeature::DisabledFeature->inactive());
	}
	
	public function test_int_backed_enums(): void
	{
		IntBackedFeature::register();
		
		$this->assertTrue(IntBackedFeature::EnabledFeature->active());
		$this->assertFalse(IntBackedFeature::EnabledFeature->inactive());
		
		$this->assertFalse(IntBackedFeature::DisabledFeature->active());
		$this->assertTrue(IntBackedFeature::DisabledFeature->inactive());
	}
}
