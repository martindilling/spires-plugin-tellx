<?php
declare(strict_types=1);

namespace AsciiSoup\Spires\TellX;

class ServiceProvider extends \Spires\Core\ServiceProvider
{
    /**
     * (Optional) Define config keys with their default values.
     *
     * @return array
     */
    public function config()
    {
        return [];
    }

    /**
     * (Optional) Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->core->singleton(PDO::class, function() {
            return new PDO(
                "sqlite:" . __DIR__ . "/../resources/tellx.sqlite",
                null,
                null,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        });
    }

    /**
     * (Optional) Boot the service provider.
     * Parameters are resolved through the container.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Plugins provided.
     *
     * @return string[]
     */
    public function plugins()
    {
        return [
            Plugin::class
        ];
    }
}
