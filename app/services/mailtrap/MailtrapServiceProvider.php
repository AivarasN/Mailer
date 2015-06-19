<?php namespace Services\Mailtrap;

use Illuminate\Support\ServiceProvider;

class MailtrapServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Mailtrap', 'Services\Mailtrap\Facades\Mailtrap');
        });

        $this->app['mailtrap'] = $this->app->share(function($app)
        {
            $api_key = $app['config']->get('services.mailtrap.api_key');
            return new Mailtrap($api_key);
        });
    }
}
?>