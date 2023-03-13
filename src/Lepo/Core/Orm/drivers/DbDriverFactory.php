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

namespace Lepo\Core\Orm\Drivers;

use Lepo\Core\Orm\DbException;

/**
 * Crates driver
 */
class DbDriverFactory
{
    public static function getDriver(DbDriver $driver, DbDriverConfiguration $configuration): IDriver
    {
        if ($driver === DbDriver::Pdo) {
            return new PdoDriver($configuration);
        }

        throw new DbException("Unable to create a driver");
    }
}
