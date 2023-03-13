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
 * Specifies the contract for a collection of route descriptors.
 */
interface IRouteCollection
{
    /**
     * Adds a single route to the collection.
     *
     * @param class-string<T> $controllerTypeName Type (class name) of the controller.
     * @param string $routePath Controller base path, like eg.: "*" or "/api/users"
     */
    public function addRoute(string $controllerTypeName, string $routePath): void;
}
