<?php

namespace Glhd\Quartermaster\Support;

use Illuminate\Support\ServiceProvider;

class QuartermasterServiceProvider extends ServiceProvider
{
	public function boot(): void
	{
		$this->bootConfig();
	}
	
	public function register(): void
	{
		$this->mergeConfigFrom($this->packageConfigFile(), 'quartermaster');
	}
	
	protected function bootConfig(): static
	{
		$this->publishes([
			$this->packageConfigFile() => $this->app->configPath('quartermaster.php'),
		], 'quartermaster-config');
		
		return $this;
	}
	
	protected function packageConfigFile(): string
	{
		return dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'quartermaster.php';
	}
}
