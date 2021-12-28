<?php

namespace Programic\DistanceMatrix;

use Illuminate\Support\ServiceProvider;

class DistanceMatrixServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DistanceMatrix::class, function ($app) {
            return new DistanceMatrix();
        });

        $this->app->alias(DistanceMatrix::class, 'distanceMatrix');
    }
}
