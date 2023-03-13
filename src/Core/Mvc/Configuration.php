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
 * Base configuration.
 */
class Configuration implements IConfiguration
{
    public array $args;

    public readonly string $applicationName;

    public readonly string $contentRootPath;

    public readonly string $webRootPath;

    public function __construct(
        ?string $applicationName,
        ?string $webRootPath,
        ?string $contentRootPath,
    ) {
        $this->applicationName = $applicationName ?? "lepo\core";
        $this->webRootPath = $webRootPath ?? (rtrim(realpath(__DIR__ . '/../../../'), '/') . '/');
        $this->contentRootPath = $contentRootPath ?? $this->webRootPath . "html/";
    }

    public function getContentRootPath(): string
    {
        return $this->contentRootPath;
    }

    public function getWebRootPath(): string
    {
        return $this->webRootPath;
    }
}
