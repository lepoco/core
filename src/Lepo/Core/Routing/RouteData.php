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
 * Contains path information.
 */
class RouteData
{
    private readonly string $route;

    private readonly string $controllerTypeName;

    public function __construct(string $controllerTypeName, string $route)
    {
        $this->controllerTypeName = $controllerTypeName;
        $this->route = $route;
    }

    /**
     * Gets type of the controller.
     */
    public function getControllerTypeName(): mixed
    {
        return $this->controllerTypeName;
    }

    /**
     * Gets path info for the selected route.
     */
    public function getRoute(): string
    {
        return $this->route;
    }
}
