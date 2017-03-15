<?php

namespace App\Providers;

use App\Events\UsuarioCadastrado;
use App\Listeners\EmailDeCadastro;
use App\Listeners\RegraDeAcesso;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UsuarioCadastrado::class => [
            EmailDeCadastro::class,
            RegraDeAcesso::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
