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
 * Database data type.
 */
enum DbType
{
    case PrimaryKey;
    case Bit;
    case Binary;
    case Int;
    case TinyInt;
    case Boolean;
    case SmallInt;
    case MediumInt;
    case BigInt;
    case Float;
    case Decimal;
    case Date;
    case DateTime;
    case TimeStamp;
    case Time;
    case Char;
    case VarChar;
    case Text;
    case TinyText;
    case MediumText;
    case LongText;
    case Enum;
}
