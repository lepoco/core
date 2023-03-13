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
 * Defines a mechanism for retrieving a route.
 */
interface IRouteProvider
{
    /**
     * Gets a single route if it exists.
     *
     * @param string $routePath Controller base path, like eg.: "*" or "/api/users"
     */
    public function getRoute(string $routePath): ?RouteData;

    /**
     * Gets the RouteData that matches the given path info.
     *
     * @param string $pathInfo Current path, lik eg.: "/dashboard/account/password/"
     * @param string $fallback If nothing matches, it will return any RouteData with path "*".
     */
    public function match(string $pathInfo, bool $fallback = false): ?RouteData;
}
