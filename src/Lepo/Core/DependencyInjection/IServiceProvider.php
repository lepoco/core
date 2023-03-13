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

namespace Lepo\Core\DependencyInjection;

/**
 * Defines a mechanism for retrieving a service object.
 */
interface IServiceProvider
{
    /**
     * Gets the service object of the specified type.
     */
    public function getService(string $serviceTypeOrContractName): mixed;
}
