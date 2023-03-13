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

namespace Lepo\Core\Orm;

/**
 * Represents database column.
 */
class DbColumn
{
    public string $columnName;

    public string $propertyName;

    public string $propertyTypeName;

    public DbType $type;

    public mixed $valueOne;

    public mixed $valueTwo;

    public mixed $default;

    public bool $isNullable;

    public function __construct()
    {
        $this->columnName = '';
        $this->propertyName = '';
        $this->propertyTypeName = '';
        $this->type = DbType::VarChar;
        $this->valueOne = null;
        $this->valueTwo = null;
        $this->default = null;
        $this->isNullable = false;
    }
}
