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
 * Specifies the contract for a collection of service descriptors.
 */
interface IServiceCollection
{
    /**
     * Add an IHostedService registration for the given type.
     */
    public function addHostedService(string $serviceTypeName): void;

    /**
     * Adds a scoped service of the type specified in $serviceTypeOrContractName.
     */
    public function addScoped(string $serviceTypeOrContractName, ?string $serviceTypeName = null): void;

    /**
     * Adds a singleton service of the type specified in $serviceTypeOrContractName.
     */
    public function addTransient(string $serviceTypeOrContractName, ?string $serviceTypeName = null): void;
}
