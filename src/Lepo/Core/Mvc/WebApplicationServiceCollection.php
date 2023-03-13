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

namespace Lepo\Core\Mvc;

use Lepo\Core\DependencyInjection\Service;
use Lepo\Core\DependencyInjection\ServiceCollection;

/**
 * Service collection for the web application.
 */
class WebApplicationServiceCollection extends ServiceCollection
{
    /**
     * Adds service by its object.
     */
    public function add(string $serviceContractName, mixed $serviceObject): void
    {
        $this->services[] =
            Service::fromObject($serviceContractName, $serviceObject);
    }

    /**
     * Gets a collection of hosted services.
     */
    public function getHostedServices(): array
    {
        $servicesInstances = [];

        /**
         * @var Service $singleService
         */
        foreach ($this->services as $singleService) {
            if ($singleService->isHosted()) {
                $servicesInstances[] = $singleService;
            }
        }

        return $servicesInstances;
    }
}
