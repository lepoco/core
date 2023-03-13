<?php

/**
 * This Source Code Form is subject to the terms of the MIT license.
 * Copyright (C) 2023 Leszek Pomianowski and Forward Contributors.
 * All Rights Reserved.
 */

declare(strict_types=1);

namespace Lepo\Core\Routing\Tests;

use Lepo\Core\Routing\RouteCollection;
use Lepo\Core\Routing\RoutingException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class DashboardController
{
}

final class FallbackController
{
}

final class RouteCollectionTest extends TestCase
{
    #[Test]
    #[TestDox('RouteCollection returns valid controllers when asked.')]
    public function addRoute_givenSampleControllers_returnsValidController(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->addRoute(DashboardController::class, "/");

        $receivedRouteData = $routeCollection->match("/");

        $this->assertNotNull($receivedRouteData);
        $this->assertEquals(DashboardController::class, $receivedRouteData->getControllerTypeName());
    }

    #[Test]
    #[TestDox('RouteCollection throws exception when adding same route.')]
    public function addRoute_givenSampleRoutes_throwsExceptionOnDuplicate(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->addRoute(DashboardController::class, "/");

        $this->expectException(RoutingException::class);
        $routeCollection->addRoute(FallbackController::class, "/");
    }

    #[Test]
    #[TestDox('RouteCollection throws exception when adding same controller.')]
    public function addRoute_givenSampleControllers_throwsExceptionOnDuplicate(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->addRoute(DashboardController::class, "/one-dashboard");

        $this->expectException(RoutingException::class);
        $routeCollection->addRoute(DashboardController::class, "/two-dashboard");
    }

    #[Test]
    #[TestDox('RouteCollection returns null when invalid path given.')]
    public function match_givenSampleControllers_returnsNullWhenInvalid(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->addRoute(DashboardController::class, "/dashboard");
        $routeCollection->addRoute(FallbackController::class, "*");

        $receivedRouteData = $routeCollection->match("/404");

        $this->assertNull($receivedRouteData);
    }

    #[Test]
    #[TestDox('RouteCollection, if enabled, returns fallback when invalid path given.')]
    public function match_givenSampleControllers_returnsValidFallbackWhenNeeded(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->addRoute(DashboardController::class, "/dashboard");
        $routeCollection->addRoute(FallbackController::class, "*");

        $receivedRouteData = $routeCollection->match("/404", true);

        $this->assertNotNull($receivedRouteData);
        $this->assertEquals(FallbackController::class, $receivedRouteData->getControllerTypeName());
    }
}
