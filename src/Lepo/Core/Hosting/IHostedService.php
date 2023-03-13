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

namespace Lepo\Core\Hosting;

/**
 * Defines methods for objects that are managed by the host.
 */
interface IHostedService
{
    /**
     * Triggered when the application host is ready to start the service.
     */
    public function start(): void;

    /**
     * Triggered when the application host is performing a graceful shutdown.
     */
    public function stop(): void;
}