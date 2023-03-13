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

use ReflectionClass;

class DbTable
{
    private readonly IContext $context;

    private readonly string $tableName;

    private readonly string $modelTypeName;

    private readonly array $modelColumns;

    public function __construct(IContext $context, string $tableName, string $modelTypeName)
    {
        $this->context = $context;
        $this->tableName = self::convertToTableName($tableName);
        $this->modelTypeName = $modelTypeName;
        $this->modelColumns = $this->getColumnsFromReflectedModel();
    }

    /**
     * @return DbColumn[]
     */
    private function getColumnsFromReflectedModel(): array
    {
        $modelReflection = new ReflectionClass($this->modelTypeName);
        /** @var DbColumn[] $dbColumns */
        $dbColumns = [];

        foreach ($modelReflection->getProperties() as $singleProperty) {
            $valueAttributes = $singleProperty->getAttributes(DbValue::class);
            $nullableAttributes = $singleProperty->getAttributes(DbNullable::class);

            $dbColumn = new DbColumn();
            $dbColumn->propertyName = $singleProperty->getName();
            $dbColumn->propertyTypeName = $singleProperty->getType()->getName();
            $dbColumn->columnName = self::convertToTableName($singleProperty->getName());
            $dbColumn->isNullable = !empty($nullableAttributes);

            if (empty($valueAttributes)) {
                continue;
            }

            $valueAttributeArguments = $valueAttributes[0]->getArguments();

            if (empty($valueAttributeArguments)) {
                continue;
            }

            $dbColumn->type = $valueAttributeArguments[0];
            $dbColumn->valueOne = $valueAttributeArguments[1] ?? null;
            $dbColumn->valueTwo = $valueAttributeArguments[2] ?? null;
            $dbColumn->default = $valueAttributeArguments[3] ?? null;

            $dbColumns[] = $dbColumn;
        }

        return $dbColumns;
    }

    private static function convertToTableName(string $value): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $value));
    }
}
