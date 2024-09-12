<?php

namespace Glhd\Quartermaster\Support;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class QuartermasterServiceProvider extends ServiceProvider
{
	public function boot()
	{
		// require_once __DIR__.'/helpers.php';
		// $this->bootConfig();
		// $this->bootViews();
		// $this->bootBladeComponents();
	}
	
	public function register()
	{
		$this->mergeConfigFrom($this->packageConfigFile(), 'quartermaster');
	}
	
	protected function bootViews() : self
	{
		$this->loadViewsFrom($this->packageViewsDirectory(), 'quartermaster');
		
		$this->publishes([
			$this->packageViewsDirectory() => $this->app->resourcePath('views/vendor/quartermaster'),
		], 'quartermaster-views');
		
		return $this;
	}
	
	protected function bootBladeComponents() : self
	{
		if (version_compare($this->app->version(), '8.0.0', '>=')) {
			Blade::componentNamespace('Glhd\\Quartermaster\\Components', 'quartermaster');
		}
		
		return $this;
	}
	
	protected function bootConfig() : self
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
	
	protected function packageTranslationsDirectory(): string
	{
		return dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'translations';
	}
	
	protected function packageViewsDirectory(): string
	{
		return dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'views';
	}
}
