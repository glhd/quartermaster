<?php

namespace Glhd\Quartermaster;

use Glhd\Quartermaster\Support\PendingQuartermasterInteraction;
use Laravel\Pennant\Feature as Pennant;

/** @method bool resolve($scope) */
abstract class Feature
{
	public static function for(mixed $scope): PendingQuartermasterInteraction
	{
		return new PendingQuartermasterInteraction(
			pennant: Pennant::for($scope),
			feature: static::class,
		);
	}
	
	public static function value(): mixed
	{
		return Pennant::value(static::class);
	}
	
	public static function active(): bool
	{
		return Pennant::active(static::class);
	}
	
	public static function inactive(): bool
	{
		return Pennant::inactive(static::class);
	}
	
	public static function when(callable $whenActive, ?callable $whenInactive = null): mixed
	{
		return Pennant::when(static::class, $whenActive, $whenInactive);
	}
	
	public static function unless($whenInactive, $whenActive = null): mixed
	{
		return Pennant::unless(static::class, $whenActive, $whenInactive);
	}
	
	public static function activate(mixed $value = true): void
	{
		Pennant::activate(static::class, $value);
	}
	
	public static function deactivate(): void
	{
		Pennant::deactivate(static::class);
	}
	
	public static function forget(): void
	{
		Pennant::forget(static::class);
	}
}
