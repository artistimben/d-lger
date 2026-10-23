<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::setLocale('tr');
        Paginator::defaultView('pagination.default');
        Blade::directive('tl', function ($expression) {
            return "<?php echo \\App\\Support\\Money::format($expression); ?>";
        });
    }
}
