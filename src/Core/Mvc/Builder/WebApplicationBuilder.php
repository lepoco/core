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

namespace Lepo\Core\Mvc\Builder;

use Lepo\Core\Mvc\HttpRequest;
use Lepo\Core\Mvc\IConfiguration;
use Lepo\Core\Mvc\WebApplication;
use Lepo\Core\Mvc\WebApplicationServiceCollection;
use Lepo\Core\Routing\RouteCollection;
use Lepo\Core\Routing\RouteData;

/**
 * Builder pattern for the WebApplication.
 */
class WebApplicationBuilder
{
    protected readonly WebApplicationServiceCollection $serviceCollection;

    protected readonly RouteCollection $routesCollection;

    protected WebApplication $builtApplication;

    public function __construct(?IConfiguration $options = null)
    {
        $this->serviceCollection = new WebApplicationServiceCollection();
        $this->routesCollection = new RouteCollection();
        $this->builtApplication = new WebApplication(
            HttpRequest::build(),
            $this->serviceCollection,
            $this->routesCollection
        );

        if ($options !== null) {
            $this->serviceCollection->add(IConfiguration::class, $options);
        }
    }

    public function build(): WebApplication
    {
        return $this->builtApplication;
    }

    public function configureServices(callable $callback): self
    {
        $callback($this->serviceCollection);

        return $this;
    }

    public function configureRoutes(callable $callback): self
    {
        $callback($this->routesCollection);

        /**
         * @var RouteData $singleRoute
         */
        foreach ($this->routesCollection->getRoutes() as $singleRoute) {
            $this->serviceCollection->addTransient($singleRoute->getControllerTypeName());
        }

        return $this;
    }
}
