<?php
	namespace shurjopayv2\ShurjopayLaravelPackage8;
	use Illuminate\Support\ServiceProvider;
	
	class ShurjopayServiceProvider extends ServiceProvider{
		
		public function boot()
		{
			$this->loadRoutesFrom(__DIR__.'/routes/web.php');
			if (is_dir(__DIR__.'/views')) {
				$this->loadViewsFrom(__DIR__.'/views','shurjopay');
			}
		}
		
		public function register()
		{
			//include __DIR__ . '/routes.php';
		}
	}
?>