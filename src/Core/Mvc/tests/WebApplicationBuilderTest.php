<?php

/**
 * This Source Code Form is subject to the terms of the MIT license.
 * Copyright (C) 2023 Leszek Pomianowski and Forward Contributors.
 * All Rights Reserved.
 */

declare(strict_types=1);

namespace Lepo\Core\Mvc\Tests;

use Lepo\Core\DependencyInjection\IServiceCollection;
use Lepo\Core\Hosting\IHost;
use Lepo\Core\Mvc\ApiController;
use Lepo\Core\Mvc\BaseController;
use Lepo\Core\Mvc\WebApplication;
use Lepo\Core\Mvc\Produces;
use Lepo\Core\Mvc\Route;
use Lepo\Core\Mvc\Verb;
use Lepo\Core\Routing\IRouteCollection;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

interface IWeatherService
{
    public function getTemperature(): int;

    public function setTemperature(int $temperature): void;
}

class WeatherService implements IWeatherService
{
    private int $temperature = 12;

    public function getTemperature(): int
    {
        return $this->temperature;
    }

    public function setTemperature(int $temperature): void
    {
        $this->temperature = $temperature;
    }
}

#[ApiController]
#[Produces('application/json')]
class WeatherApiController extends BaseController
{
    private readonly IWeatherService $weather;

    public function __construct(IWeatherService $weather)
    {
        $this->weather = $weather;
    }

    #[Route("/", Verb::Get)]
    public function root(): int
    {
        return $this->weather->getTemperature();
    }
}

final class WebApplicationBuilderTest extends TestCase
{
    #[Test]
    #[TestDox('WebApplication can be created using the WebApplicationBuilder.')]
    public function addRoute_givenSampleControllers_returnsValidController(): void
    {
        $host = WebApplication::createBuilder()
            ->configureServices(function (IServiceCollection &$services) {
                $services->addScoped(IWeatherService::class, WeatherService::class);
            })
            ->configureRoutes(function (IRouteCollection &$routes) {
                $routes->addRoute(WeatherApiController::class, "/api", false);
            })
            ->build();

        $this->assertNotNull($host);
        $this->assertInstanceOf(IHost::class, $host);
    }
}
