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
 * Container for the service.
 */
interface IService
{
    /**
     * Gets class name of the service.
     */
    public function getType(): string;

    /**
     * Gets interface name of the service contract.
     */
    public function getContract(): ?string;

    /**
     * Gets the service class constructor parameters.
     */
    public function getParameters(): array;

    /**
     * Gets a value indicating whether the service is transient.
     */
    public function isTransient(): bool;

    /**
     * Gets a value indicating whether the service is managed by the host.
     */
    public function isHosted(): bool;

    /**
     * Sets the service instance.
     */
    public function setInstance(mixed $object): void;

    /**
     * Gets the service instance.
     */
    public function getInstance(): mixed;
}
