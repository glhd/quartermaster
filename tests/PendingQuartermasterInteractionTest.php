<?php

use Glhd\Quartermaster\Tests\Stubs\FeatureMissingResolvers;
use Glhd\Quartermaster\Tests\Stubs\IntBackedFeature;
use Glhd\Quartermaster\Tests\Stubs\StringBackedFeature;
use Glhd\Quartermaster\Tests\Stubs\UnbackedFeature;
use Glhd\Quartermaster\Tests\TestCase;
use Laravel\Pennant\Feature;
use PHPUnit\Framework\Attributes\DataProvider;

class PendingQuartermasterInteractionTest extends TestCase
{
	#[DataProvider('enumsProvider')]
	/** @param class-string<\Glhd\Quartermaster\EnumeratesFeatures> $enum */
	public function test_pending_interactions(string $enum): void
	{
		$enum::register();
		
		// Test defaults
		
		$this->assertTrue($enum::EnabledFeature->for(1)->value());
		$this->assertFalse($enum::DisabledFeature->for(1)->value());
		
		$this->assertTrue($enum::EnabledFeature->for(1)->active());
		$this->assertFalse($enum::DisabledFeature->for(1)->active());
		
		$this->assertFalse($enum::EnabledFeature->for(1)->inactive());
		$this->assertTrue($enum::DisabledFeature->for(1)->inactive());
		
		// Manually activate/deactivate
		
		$enum::EnabledFeature->for(1)->deactivate();
		$enum::DisabledFeature->for(1)->activate();
		
		$this->assertFalse($enum::EnabledFeature->for(1)->active());
		$this->assertTrue($enum::DisabledFeature->for(1)->active());
		$this->assertTrue($enum::EnabledFeature->for(2)->active());
		$this->assertFalse($enum::DisabledFeature->for(2)->active());
		
		$this->assertTrue($enum::EnabledFeature->for(1)->inactive());
		$this->assertFalse($enum::DisabledFeature->for(1)->inactive());
		$this->assertFalse($enum::EnabledFeature->for(2)->inactive());
		$this->assertTrue($enum::DisabledFeature->for(2)->inactive());
		
		// Revert back to defaults
		
		$enum::EnabledFeature->for(1)->forget();
		$enum::DisabledFeature->for(1)->forget();
		
		$this->assertTrue($enum::EnabledFeature->for(1)->active());
		$this->assertFalse($enum::DisabledFeature->for(1)->active());
		
		$this->assertFalse($enum::EnabledFeature->for(1)->inactive());
		$this->assertTrue($enum::DisabledFeature->for(1)->inactive());
	}
	
	public static function enumsProvider(): array
	{
		return [
			'unbacked' => [UnbackedFeature::class],
			'string backed' => [StringBackedFeature::class],
			'int backed' => [IntBackedFeature::class],
		];
	}
}
