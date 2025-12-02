<?php

namespace App\Providers;

use App\BrandRepository;
use App\BrandRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            if ($user->id == 1) {
                return true;
            }
        });

        Blade::directive('hasPermission', function ($permission) {
        return "<?php if(auth('web')->check() && auth('web')->user()->can($permission)): ?>";
        });

        Blade::directive('endhasPermission', function () {
            return "<?php endif; ?>";
        });

        // Optional: jodi kono permission na thakeo menu dekhate chai
        Blade::if('role', function ($role) {
            return auth('web')->check() && auth('web')->user()->hasRole($role);
        });
    }
}
