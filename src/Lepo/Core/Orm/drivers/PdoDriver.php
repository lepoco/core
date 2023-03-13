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

use Lepo\Core\Orm\IContext;

class PdoDriver implements IDriver
{
    public function connect(): bool
    {
        return false;
    }

    public function startTransaction(): bool
    {
        return false;
    }

    public function abortTransaction(): bool
    {
        return false;
    }

    public function finishTransaction(): bool
    {
        return false;
    }

    public function executeQuery(string $query): mixed
    {
        return null;
    }

    public function migrate(IContext $context): bool
    {
        return false;
    }
}
