<?php

/**
 * This Source Code Form is subject to the terms of the MIT license.
 * Copyright (C) 2023 Leszek Pomianowski and Forward Contributors.
 * All Rights Reserved.
 *
 * Based on .NET ASP.NET Core or .NET Core source code.
 * Copyright (c) .NET Foundation and/or Microsoft. All rights reserved.
 * Licensed under the Apache License, Version 2.0 or MIT.
 */

declare(strict_types=1);

namespace Lepo\Core\Routing;

/**
 * Specifies the contract for a collection of service descriptors.
 */
class RouteCollection implements IRouteCollection, IRouteProvider
{
    protected array $routes = [];

    /**
     * @inheritdoc
     */
    public function addRoute(
        string $controllerTypeName,
        string $routePath
    ): void {
        if ($this->hasController($controllerTypeName)) {
            throw new RoutingException("{$controllerTypeName} is already registered as route controller.");
        }

        if ($this->hasRoute($routePath)) {
            throw new RoutingException("{$routePath} is already registered as route path.");
        }

        $this->routes[] = new RouteData($controllerTypeName, $routePath);
    }

    /**
     * @inheritdoc
     */
    public function getRoute(string $routePath): ?RouteData
    {
        /**
         * @var RouteData $singleRoute
         */
        foreach ($this->routes as $singleRoute) {
            if ($singleRoute->getRoute() === $routePath) {
                return $singleRoute;
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function match(string $pathInfo, bool $fallback = false): ?RouteData
    {
        /**
         * @var RouteData $singleRoute
         */
        foreach ($this->routes as $singleRoute) {
            if ($this->isRouteMatched($pathInfo, $singleRoute)) {
                return $singleRoute;
            }
        }

        if (!$fallback) {
            return null;
        }

        /**
         * @var RouteData $singleRoute
         */
        foreach ($this->routes as $singleRoute) {
            if ($singleRoute->getRoute() === '*' || $singleRoute->getRoute() === '(.*)') {
                return $singleRoute;
            }
        }

        return null;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    protected function hasRoute(string $routePath): bool
    {
        /**
         * @var RouteData $singleRoute
         */
        foreach ($this->routes as $singleRoute) {
            if ($singleRoute->getRoute() === $routePath) {
                return true;
            }
        }

        return false;
    }

    protected function hasController(string $controllerTypeName): bool
    {
        /**
         * @var RouteData $singleRoute
         */
        foreach ($this->routes as $singleRoute) {
            if ($singleRoute->getControllerTypeName() === $controllerTypeName) {
                return true;
            }
        }

        return false;
    }

    protected function isRouteMatched(string $currentPath, RouteData $routeEntry): bool
    {
        $pattern =
            "@^"
            . preg_replace('/:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', $routeEntry->getRoute())
            . "$@D";

        $params = [];

        // check if the current request params the expression
        // TODO: Fix warning
        $match = @preg_match($pattern, $currentPath, $params);

        return ($match === 1);
    }
}
