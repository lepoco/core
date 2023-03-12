<?php

/**
 * This Source Code Form is subject to the terms of the MIT license.
 * Copyright (C) 2023 Leszek Pomianowski and Forward Contributors.
 * All Rights Reserved.
 */

declare(strict_types=1);

use Lepo\Core\DependencyInjection\ServiceCollection;
use Lepo\Core\Tests\Mocks\WeatherService;
use PHPUnit\Framework\TestCase;

final class ServiceCollectionTest extends TestCase
{
    public function testCanBeWhatever(): void
    {
        $serviceCollection = new ServiceCollection();
        $serviceCollection->addScoped(WeatherService::class);

        $receivedService = $serviceCollection->getService(WeatherService::class);

        $this->assertNotNull($receivedService);
        $this->assertInstanceOf(WeatherService::class, $receivedService);
    }
}
