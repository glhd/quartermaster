<?php

namespace Glhd\Quartermaster;

use BackedEnum;
use Glhd\Quartermaster\Support\PendingQuartermasterInteraction;
use Illuminate\Support\Str;
use Laravel\Pennant\Feature;
use LogicException;
use UnitEnum;

trait EnumeratesFeatures
{
	public static function register(): void
	{
		$defined = Feature::defined();
		
		foreach (self::cases() as $case) {
			$feature = $case->name();
			
			if (! in_array($feature, $defined)) {
				$resolver = (string) Str::of($case->name)->studly()->prepend('resolve');
				
				if (! method_exists($case, $resolver)) {
					if (! config('quartermaster.require_resolvers', true)) {
						continue;
					}
					
					throw new LogicException(sprintf('The "%s" feature enum is missing a "%s" method.', $feature, $resolver));
				}
				
				Feature::define($feature, $case->$resolver(...));
			}
		}
	}
	
	public function for(mixed $scope): PendingQuartermasterInteraction
	{
		if (! $this instanceof UnitEnum) {
			throw new LogicException('EnumeratesFeatures must be used on an enum.');
		}
		
		return new PendingQuartermasterInteraction(
			pennant: Feature::for($scope),
			enum: $this,
		);
	}
	
	public function define(mixed $resolver = null): static
	{
		Feature::define($this->name(), $resolver);
		
		return $this;
	}
	
	public function active(): bool
	{
		return Feature::active($this->name());
	}
	
	public function inactive(): bool
	{
		return Feature::inactive($this->name());
	}
	
	public function name(): string
	{
		return match (true) {
			$this instanceof BackedEnum && is_string($this->value) => $this->value,
			$this instanceof BackedEnum && is_int($this->value) => $this::class.':'.$this->value,
			default => $this::class.':'.$this->name,
		};
	}
}
