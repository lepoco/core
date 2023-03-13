<?php

/**
 * This Source Code Form is subject to the terms of the GNU GPL-3.0.
 * If a copy of the GPL was not distributed with this file,
 * You can obtain one at https://www.gnu.org/licenses/gpl-3.0.en.html.
 * Copyright (C) 2023 Leszek Pomianowski and Forward Contributors.
 * All Rights Reserved.
 *
 * Based on .NET ASP.NET Core
 * Copyright (c) .NET Foundation. All rights reserved.
 * Licensed under the Apache License, Version 2.0 or MIT.
 */

declare(strict_types=1);

namespace Lepo\Core\Mvc;

/**
 * Application configuration.
 */
interface IConfiguration
{
    public function getContentRootPath(): string;

    public function getWebRootPath(): string;
}
