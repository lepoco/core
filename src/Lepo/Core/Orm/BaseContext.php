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

use Lepo\Core\Orm\Drivers\DbDriver;
use Lepo\Core\Orm\Drivers\DbDriverConfiguration;
use Lepo\Core\Orm\Drivers\DbDriverFactory;
use Lepo\Core\Orm\Drivers\IDriver;
use ReflectionClass;

/**
 * Base database service.
 */
abstract class BaseContext implements IContext
{
    private readonly IDriver $driver;

    public function __construct(DbDriver $driver, array $configuration = [])
    {
        $configuration = new DbDriverConfiguration(
            $configuration['port'] ?? 0,
            $configuration['host'] ?? '127.0.0.1',
            $configuration['username'] ?? '',
            $configuration['password'] ?? '',
            $configuration['database'] ?? '',
        );

        $this->driver = DbDriverFactory::getDriver($driver, $configuration);

        $this->initializeTables();
    }

    /**
     * @inheritdoc
     */
    public function connect(): bool
    {
        return $this->driver->connect();
    }

    /**
     * @inheritdoc
     */
    public function migrate(): bool
    {
        return $this->driver->migrate($this);
    }

    private function initializeTables(): void
    {
        $properties = (new ReflectionClass($this))->getProperties();

        foreach ($properties as $singleProperty) {
            $propertyType = $singleProperty->getType()->getName();
            $propertyName = $singleProperty->getName();

            if ($propertyType !== DbTable::class) {
                continue;
            }

            $propertyAttributes = $singleProperty->getAttributes(DbModel::class);

            if (empty($propertyAttributes)) {
                throw new DbException(
                    "The table in the database context must have the DbModel attribute defined."
                );
            }

            $attributeArguments = $propertyAttributes[0]->getArguments();

            if (empty($attributeArguments)) {
                throw new DbException(
                    "DbTableValue must indicate the type of data that is assigned to the table."
                );
            }

            $this->$propertyName = new DbTable($this, $propertyName, $attributeArguments[0]);
        }
    }
}
