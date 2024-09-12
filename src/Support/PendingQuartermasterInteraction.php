<?php

namespace Glhd\Quartermaster\Support;

use Glhd\Quartermaster\EnumeratesFeatures;
use Illuminate\Support\Traits\ForwardsCalls;
use Laravel\Pennant\PendingScopedFeatureInteraction;
use UnitEnum;

/** @mixin PendingScopedFeatureInteraction */
class PendingQuartermasterInteraction
{
	use ForwardsCalls;
	
	/** @param EnumeratesFeatures&UnitEnum $enum */
	public function __construct(
		protected PendingScopedFeatureInteraction $pennant,
		protected string $feature,
	) {
	}
	
	public function value(): mixed
	{
		return $this->pennant->value($this->feature);
	}
	
	public function active(): bool
	{
		return $this->pennant->active($this->feature);
	}
	
	public function inactive(): bool
	{
		return $this->pennant->inactive($this->feature);
	}
	
	public function when(callable $whenActive, ?callable $whenInactive = null): mixed
	{
		return $this->pennant->when($this->feature, $whenActive, $whenInactive);
	}
	
	public function unless($whenInactive, $whenActive = null): mixed
	{
		return $this->pennant->unless($this->feature, $whenActive, $whenInactive);
	}
	
	public function activate(mixed $value = true): static
	{
		$this->pennant->activate($this->feature, $value);
		
		return $this;
	}
	
	public function deactivate(): static
	{
		$this->pennant->deactivate($this->feature);
		
		return $this;
	}
	
	public function forget(): static
	{
		$this->pennant->forget($this->feature);
		
		return $this;
	}
	
	public function __call(string $name, array $arguments)
	{
		return $this->forwardDecoratedCallTo($this->pennant, $name, $arguments);
	}
}
