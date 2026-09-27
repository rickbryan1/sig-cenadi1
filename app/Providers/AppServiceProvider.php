namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Ajoutez cette ligne

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Force toutes les URLs générées (formulaires, liens) à utiliser le HTTPS
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
