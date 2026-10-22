<?php

namespace App\Providers;

use Base\Events\CompanyOptInRegistered;
use Base\Listeners\SendOptInRequest;
use Base\Models\Company\Company;
use Base\Models\CompanyDocument\CompanyDocument;
use Base\Models\CompanyOptIn\CompanyOptIn;
use Base\Models\CompanyPosition\CompanyPosition;
use Base\Models\CompanySupplier\CompanySupplier;
use Base\Models\User\User;
use Base\Policies\CompanyDocumentPolicy;
use Base\Policies\CompanyLegalRepresentativePolicy;
use Base\Policies\CompanyOptInPolicy;
use Base\Policies\CompanyPolicy;
use Base\Policies\CompanyPositionPolicy;
use Base\Policies\CompanySupplierPolicy;
use Base\Policies\UserPolicy;
use Base\SearchCnpj\Cnpja\CnpjaService;
use Base\SearchCnpj\SearchCnpjServiceInterface;
use Base\SMS\SmsServiceInterface;
use Base\SMS\Twilio\TwilioSmsService;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register(): void
    {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureCommands();
        $this->configureUrlScheme();
        $this->configureModels();
        $this->configureDates();
        $this->configureAuthThrottle();
        $this->configureFactoriesNameSpace();
    }

    /**
     * Configure the application's commands.
     */
    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction()
        );
    }

    /**
     * Configure the application's URL scheme.
     */
    private function configureUrlScheme(): void
    {
        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }
    }

    /**
     * Configure the application's models.
     */
    private function configureModels(): void
    {
        //Model::unguard();

        //Model::shouldBeStrict();
    }

    /**
     * Configure the application's dates.
     */
    private function configureDates(): void
    {
        Date::use(CarbonImmutable::class);
    }

    /**
     * Configure the application's factories namespace.
     */
    private function configureFactoriesNameSpace(): void
    {
        Factory::guessFactoryNamesUsing(function (string $model_name) {
            $namespace  = 'Database\\Factories\\';
            $model_name = Str::afterLast($model_name, '\\');

            return $namespace . $model_name . 'Factory';
        });
    }

    /**
     * Configure the application's attemps-auth throttle.
     */
    private function configureAuthThrottle(): void
    {
        RateLimiter::for('attemps-auth', function (Request $request) {
            $email = Str::lower((string) $request->input('email'));

            return Limit::perMinute(5)
                ->by($email.'|'.$request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => __('auth.throttle', [
                            'seconds' => $headers['Retry-After'],
                        ]),
                        'retry_after' => (int) $headers['Retry-After'],
                    ], 429, $headers);
                });
        });
    }
}
