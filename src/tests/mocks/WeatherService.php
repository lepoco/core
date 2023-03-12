<?php

/**
 * This Source Code Form is subject to the terms of the MIT license.
 * Copyright (C) 2023 Leszek Pomianowski and Forward Contributors.
 * All Rights Reserved.
 */

declare(strict_types=1);

namespace Lepo\Core\Tests\Mocks;

final class WeatherService
{
    public function getTemperature(): int
    {
        return 12;
    }
}
