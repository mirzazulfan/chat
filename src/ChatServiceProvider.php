<?php

namespace Musonza\Chat;

// use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Musonza\Chat\Conversations\Policies\ConversationPolicy;
use Musonza\Chat\Conversations\Conversation;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ChatServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $policies = [
        Conversation::class => ConversationPolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();

        /*
        |--------------------------------------------------------------------------
        | Publish the Config file from the Package to the App directory
        |--------------------------------------------------------------------------
         */
        $this->configPublisher();

        $this->registerAssets();

        $this->loadRoutesFrom(__DIR__.'/routes/front.php');
    }

    public function register()
    {
        $this->registerChat();
    }

    private function registerChat()
    {
        $this->app->bind('chat', function () {
            return $this->app->make(\Musonza\Chat\Chat::class);
        });
    }

    public function configPublisher()
    {
        $this->publishes([
            $this->packagePath('config') => config_path(),
        ], 'config');

        $this->publishes([
            $this->packagePath('database/migrations') => database_path('/migrations'),
        ], 'database');
    }

    public function registerAssets()
    {

    }

    private function packagePath($path)
    {
        return __DIR__ . "/../../$path";
    }
}
