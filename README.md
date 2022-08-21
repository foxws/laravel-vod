# A Laravel extension for video on demand (VOD)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/foxws/laravel-vod.svg?style=flat-square)](https://packagist.org/packages/foxws/laravel-vod)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/foxws/laravel-vod/run-tests?label=tests)](https://github.com/foxws/laravel-vod/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/foxws/laravel-vod/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/foxws/laravel-vod/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/foxws/laravel-vod.svg?style=flat-square)](https://packagist.org/packages/foxws/laravel-vod)

A Laravel package for [nginx-vod-module](https://github.com/kaltura/nginx-vod-module).

## Installation

You can install the package via composer:

```bash
composer require foxws/laravel-vod
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-vod-config"
```

This is the contents of the published config file:

```php
return [
    /*
    |--------------------------------------------------------------------------
    | VOD
    |--------------------------------------------------------------------------
    |
    | This configures the vod parameters.
    |
    */

    'url' => env('VOD_URL'),

    /*
    |--------------------------------------------------------------------------
    | Secure Token
    |--------------------------------------------------------------------------
    |
    | This configures the secure token parameters.
    |
    */

    'key' => env('VOD_TOKEN_KEY'),

    'iv' => env('VOD_TOKEN_IV'),
];
```

## Usage

Create a service provider, e.g. `VodServiceProvider`, and [register](https://laravel.com/docs/9.x/providers#registering-providers) the provider:

```php
use Foxws\Vod\Facades\Vod;
use Foxws\Vod\Streamers\Streamer\DashStreamer;
use Illuminate\Support\ServiceProvider;

class VodServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Vod::streamers([
            DashStreamer::new()
                ->name('dash')
                ->label('ngx-dash-vod')
                ->route('api.vod.manifest'),
        ]);
    }
}
```

Create a custom controller, in this example we use Spatie's [laravel-medialibrary](https://github.com/spatie/laravel-medialibrary):
```php
use Foxws\Vod\Mappings\Mapping\ClipMapping;
use Foxws\Vod\Mappings\Mapping\SequenceMapping;
use Foxws\Vod\Mappings\Mapping\SequencesMapping;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ManifestController extends Controller
{
    public function __invoke(Request $request, string $streamer, Model $model): JsonResponse
    {
        $sequences = array_merge(
            $this->getVideoSequence($model)->toArray(),
            $this->getCaptionSequence($model)->toArray(),
        );

        $format = SequencesMapping::new()
            ->id($model->getRouteKey())
            ->sequences($sequences)
            ->toArray();

        return response()->json(
            $format
        );
    }
    
    protected function getVideoSequence(Model $model): Collection
    {
        return $model->getMedia('videos')->map(fn (Media $media) => SequenceMapping::new()
            ->id($media->getRouteKey())
            ->label($media->getRouteKey())
            ->clips(ClipMapping::new()
                ->type('source')
                ->path($media->getPath())
                ->toArray()
            )
        );
    }

    protected function getCaptionSequence(Model $model): Collection
    {
        return $model->getMedia('captions')->map(fn (Media $media, int $index) => SequenceMapping::new()
            ->id($media->getRouteKey())
            ->label($media->getRouteKey())
            ->language($media->getCustomProperty('locale', 'eng'))
            ->clips(ClipMapping::new()
                ->type('source')
                ->path($media->getPath())
                ->toArray()
            )
        );
    }
}
```

Register the routes, in this example as API:

```php
use Foxws\Vod\Http\Controllers\VodStreamController;

Route::name('vod.')->prefix('vod')->group(function () {
    Route::get('/manifest/{streamer}/{post}', VodManifestController::class)->middleware('auth:sanctum')->name('manifest');
    Route::get('/stream/{streamer}/{post}', VodStreamController::class)->middleware('auth:sanctum')->name('stream');
});
```

Create a model attribute, e.g. for `Post` and the stream name `dash`:
```php
public function stream(): Attribute
{
    return Attribute::make(
        get: fn () => route('api.vod.stream', ['dash', $this]),
    );
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/foxws/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [foxws](https://github.com/foxws)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
