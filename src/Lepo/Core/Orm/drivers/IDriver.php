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

interface IDriver
{
    public function connect(): bool;
    public function startTransaction(): bool;
    public function abortTransaction(): bool;
    public function finishTransaction(): bool;
    public function executeQuery(string $query): mixed;
    public function migrate(IContext $context): bool;
}
