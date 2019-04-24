<?php

declare(strict_types=1);

namespace VOSTPT\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    protected $namespace = 'VOSTPT\Http\Controllers';

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        parent::boot();

        $this->modelBinder();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        //
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        $this->app['router']->group(['middleware' => 'api'], function () {
            require base_path('routes/api/acronyms.php');
            require base_path('routes/api/auth.php');
            require base_path('routes/api/counties.php');
            require base_path('routes/api/districts.php');
            require base_path('routes/api/events.php');
            require base_path('routes/api/occurrences.php');
            require base_path('routes/api/parishes.php');
            require base_path('routes/api/users.php');
        });
    }

    /**
     * Model binder.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return void
     */
    protected function modelBinder(): void
    {
        $models = [
            'Acronym'          => \VOSTPT\Repositories\Contracts\AcronymRepository::class,
            'County'           => \VOSTPT\Repositories\Contracts\CountyRepository::class,
            'District'         => \VOSTPT\Repositories\Contracts\DistrictRepository::class,
            'Event'            => \VOSTPT\Repositories\Contracts\EventRepository::class,
            'Occurrence'       => \VOSTPT\Repositories\Contracts\OccurrenceRepository::class,
            'Parish'           => \VOSTPT\Repositories\Contracts\ParishRepository::class,
            'ProCivOccurrence' => \VOSTPT\Repositories\Contracts\ProCivOccurrenceRepository::class,
            'User'             => \VOSTPT\Repositories\Contracts\UserRepository::class,
        ];

        foreach ($models as $name => $repositoryContract) {
            $this->app['router']->bind($name, function (string $id) use ($name, $repositoryContract) {
                $repository = $this->app->make($repositoryContract);

                if (! $model = $repository->findById((int) $id)) {
                    throw new NotFoundHttpException(\sprintf('%s Not Found', $name));
                }

                return $model;
            });
        }
    }
}
