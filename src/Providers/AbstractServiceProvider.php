<?php

namespace Maduser\Laravel\Support\Providers;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Maduser\Laravel\Support\Helpers\CSV;
use Maduser\Laravel\Support\Resource\Resources;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Finder\Finder;

/**
 * Class AbstractServiceProvider
 *
 * @package Maduser\Laravel\Support\Providers
 */
abstract class AbstractServiceProvider extends ServiceProvider
{
    /**
     * @var
     */
    protected $namespace;

    /**
     * @var
     */
    protected $directory;

    /**
     * @var
     */
    protected $configPrefix;

    /**
     * @var
     */
    protected $viewPrefix;

    /**
     * @var
     */
    protected $viewPriority;

    /**
     * AbstractServiceProvider constructor.
     *
     * @param $app
     *
     * @throws ReflectionException
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $reflection = new ReflectionClass(get_class($this));
        $this->defineNamespace($reflection);
        $this->defineDirectory($reflection);
        $this->defineConfigPrefix();
        $this->defineViewPrefix();
    }

    /**
     *
     */
    public function register()
    {
        $this->registerConfigs();
    }

    /**
     * @throws Exception
     */
    public function boot()
    {
        $this->registerApiRoutes();
        $this->registerWebRoutes();
        $this->registerViews();
        $this->registerMigrations();
        $this->registerCommands();
    }

    /**
     * @param string|null $name
     *
     * @return string
     */
    protected function directory(string $name = null)
    {
        return $this->directory . $name;
    }

    /**
     * Defines the view namespace
     *
     * @return string
     */
    public function viewNamespace(): string
    {
        return basename($this->directory());
    }

    /**
     * Declares the available artisan commands classes
     *
     * @return array
     */
    public function artisan(): array
    {
        return [];
    }

    /**
     * @param string|null $directory
     */
    protected function registerConfigs(string $directory = null)
    {
        $directory = $directory ?? $this->directory('config');

        if (! File::isDirectory($directory)) return;

        foreach (Finder::create()->in($directory)->name('*.php') as $file) {
            $path = $file->getRealPath();
            $this->mergeConfigFrom($path, $this->configPrefix($path));
        }
    }

    /**
     * @param string|null $file
     */
    public function registerApiRoutes(string $file = null)
    {
        $file = $file ?? $this->directory('routes/api.php');
        File::exists($file) && $this->mapApiRoutes($file);
    }

    /**
     * @param string|null $file
     */
    public function registerWebRoutes(string $file = null)
    {
        $file = $file ?? $this->directory('routes/web.php');
        File::exists($file) && $this->mapWebRoutes($file);
    }

    /**
     * @param string|null $directory
     */
    public function registerViews(string $directory = null)
    {
        $directory = $directory ?? $this->directory('resources/views');
        if (File::isDirectory($directory)) {

            /** @var Factory $viewFactory */
            $viewFactory = $this->app['view'];
            $viewFactory->addLocation($directory);

//            $this->loadViewsFrom($directory, $this->viewPrefix());
//            $hints = config('maduser.support.view.hints');
//            $hints[$this->viewPrefix()] = ['priority' => $this->viewPriority()];
//            config(['maduser.support.view.hints' => $hints]);
        }
    }

    /**
     * @param string|null $directory
     */
    public function registerMigrations(string $directory = null)
    {
        $directory = $directory ?? $this->directory('database/migrations');
        File::isDirectory($directory) && $this->loadMigrationsFrom($directory);
    }

    /**
     * Registers the commands defined in artisan()
     */
    public function registerCommands()
    {
        if ($this->app->runningInConsole() && count($this->artisan())) {
            $this->commands($this->artisan());
        }
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes(string $file)
    {
        Route::middleware('web')->group($file);
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes(string $file)
    {
        Route::middleware('api')->group($file);
    }

    /**
     * @param string $namespace
     *
     * @return string
     */
    protected function parentNamespace(string $namespace): string
    {
        $e = explode('\\', $namespace);
        unset($e[count($e) - 1]);
        return implode('\\', $e);
    }

    /**
     * @param ReflectionClass $reflection
     */
    protected function defineNamespace(ReflectionClass $reflection): void
    {
        $namespace = $reflection->getNamespaceName();
        $this->namespace = $this->parentNamespace($namespace);
    }

    /**
     * @param ReflectionClass $reflection
     */
    protected function defineDirectory(ReflectionClass $reflection): void
    {
        $dir = dirname($reflection->getFileName());
        $this->directory = rtrim(realpath($dir . '/../../'), '/') . '/';
    }

    /**
     * @return void
     */
    protected function defineConfigPrefix(): void
    {
        $this->configPrefix =
            $this->configPrefix ?? Str::studly(basename($this->directory()));
    }

    /**
     * @return void
     */
    protected function defineViewPrefix(): void
    {
        $this->viewPrefix =
            $this->viewPrefix ?? Str::studly(basename($this->directory()));
    }

    /**
     * @param $realPath
     *
     * @return string
     */
    protected function configPrefix($realPath): string
    {
        return $this->configPrefix . '.' . basename($realPath, '.php');
    }

    /**
     * @return string
     */
    protected function viewPrefix(): string
    {
        return $this->viewPrefix;
    }

    protected function viewPriority(): int
    {
        return (int) $this->viewPriority;
    }
}
