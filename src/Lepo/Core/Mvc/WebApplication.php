<?php

/**
 * This Source Code Form is subject to the terms of the GNU GPL-3.0.
 * If a copy of the GPL was not distributed with this file,
 * You can obtain one at https://www.gnu.org/licenses/gpl-3.0.en.html.
 * Copyright (C) 2023 Leszek Pomianowski and Forward Contributors.
 * All Rights Reserved.
 *
 * Based on .NET ASP.NET Core
 * Copyright (c) .NET Foundation. All rights reserved.
 * Licensed under the Apache License, Version 2.0 or MIT.
 */

declare(strict_types=1);

namespace Lepo\Core\Mvc;

use Lepo\Core\DependencyInjection\IServiceProvider;
use Lepo\Core\Hosting\IHost;
use Lepo\Core\Hosting\IHostedService;
use Lepo\Core\Mvc\Builder\WebApplicationBuilder;
use Lepo\Core\Routing\RouteCollection;

class WebApplication implements IHost
{
    protected readonly HttpRequest $request;

    protected readonly WebApplicationServiceCollection $serviceCollection;

    protected readonly RouteCollection $routeCollection;

    public function __construct(
        HttpRequest $request,
        WebApplicationServiceCollection $serviceCollection,
        RouteCollection $routeCollection
    ) {
        $this->request = $request;
        $this->serviceCollection = $serviceCollection;
        $this->routeCollection = $routeCollection;
    }

    public static function createBuilder(?IConfiguration $options = null): WebApplicationBuilder
    {
        return new WebApplicationBuilder($options);
    }

    public function getServiceProvider(): IServiceProvider
    {
        return $this->serviceCollection;
    }

    public function start(): void
    {
        /**
         * @var IHostedService $hostedService
         */
        foreach ($this->serviceCollection->getHostedServices() as $hostedService) {
            $hostedService->start();
        }

        $pathInfo = $this->request->getPathInfo();
        $currentRouteData = $this->routeCollection->match($pathInfo, true);

        if ($currentRouteData !== null) {
            /** @var ControllerBase $controller */
            $controller = $this->serviceCollection->getService($currentRouteData->getControllerTypeName());
            $controller->initialize($this->request, $currentRouteData);
        }

        $this->stop();
    }

    public function stop(): void
    {
        /**
         * @var IHostedService $hostedService
         */
        foreach ($this->serviceCollection->getHostedServices() as $hostedService) {
            $hostedService->stop();
        }
    }
}
