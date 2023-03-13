<?php

/**
 * This Source Code Form is subject to the terms of the MIT license.
 * Copyright (C) 2023 Leszek Pomianowski and Forward Contributors.
 * All Rights Reserved.
 */

declare(strict_types=1);

namespace Lepo\Core\DependencyInjection\Tests;

use Lepo\Core\DependencyInjection\DiException;
use Lepo\Core\DependencyInjection\ServiceCollection;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

interface IWeatherService
{
    public function getTemperature(): int;

    public function setTemperature(int $temperature): void;
}

final class WeatherService implements IWeatherService
{
    private int $temperature = 12;

    public function getTemperature(): int
    {
        return $this->temperature;
    }

    public function setTemperature(int $temperature): void
    {
        $this->temperature = $temperature;
    }
}

final class ServiceCollectionTest extends TestCase
{
    #[Test]
    #[TestDox('ServiceCollection properly registers scoped service.')]
    public function addScoped_givenSampleService_registersIt(): void
    {
        $serviceCollection = new ServiceCollection();
        $serviceCollection->addScoped(IWeatherService::class, WeatherService::class);

        $receivedService = $serviceCollection->getService(WeatherService::class);

        $this->assertNotNull($receivedService);
        $this->assertInstanceOf(WeatherService::class, $receivedService);
    }

    #[Test]
    #[TestDox('ServiceCollection properly registers transient service.')]
    public function addTransient_givenSampleService_registersIt(): void
    {
        $serviceCollection = new ServiceCollection();
        $serviceCollection->addTransient(IWeatherService::class, WeatherService::class);

        $receivedService = $serviceCollection->getService(WeatherService::class);

        $this->assertNotNull($receivedService);
        $this->assertInstanceOf(WeatherService::class, $receivedService);
    }

    #[Test]
    #[TestDox('ServiceCollection returns object when asked for type.')]
    public function getService_whenAskedForType_returnsInstance(): void
    {
        $serviceCollection = new ServiceCollection();
        $serviceCollection->addScoped(IWeatherService::class, WeatherService::class);

        $receivedService = $serviceCollection->getService(WeatherService::class);

        $this->assertNotNull($receivedService);
        $this->assertInstanceOf(WeatherService::class, $receivedService);
    }

    #[Test]
    #[TestDox('ServiceCollection returns object when asked for contract.')]
    public function getService_whenAskedForContract_returnsInstance(): void
    {
        $serviceCollection = new ServiceCollection();
        $serviceCollection->addScoped(IWeatherService::class, WeatherService::class);

        $receivedService = $serviceCollection->getService(IWeatherService::class);

        $this->assertNotNull($receivedService);
        $this->assertInstanceOf(WeatherService::class, $receivedService);
    }

    #[Test]
    #[TestDox('ServiceCollection returns same object when asked for scoped service.')]
    public function getService_whenAskedForScopedObject_returnsSameInstance(): void
    {
        $serviceCollection = new ServiceCollection();
        $serviceCollection->addScoped(IWeatherService::class, WeatherService::class);

        $primaryReceivedService = $serviceCollection->getService(IWeatherService::class);
        $primaryReceivedService->setTemperature(20);

        $secondaryReceivedService = $serviceCollection->getService(IWeatherService::class);

        $receivedTemperature = $secondaryReceivedService->getTemperature();
        $expectedTemperature = 20;

        $this->assertNotNull($receivedTemperature);
        $this->assertEquals($expectedTemperature, $receivedTemperature);
    }

    #[Test]
    #[TestDox('ServiceCollection returns same object when asked for transient service.')]
    public function getService_whenAskedForTransientObject_returnsSameInstance(): void
    {
        $serviceCollection = new ServiceCollection();
        $serviceCollection->addTransient(IWeatherService::class, WeatherService::class);

        $primaryReceivedService = $serviceCollection->getService(IWeatherService::class);
        $primaryReceivedService->setTemperature(20);

        $secondaryReceivedService = $serviceCollection->getService(IWeatherService::class);

        $receivedTemperature = $secondaryReceivedService->getTemperature();
        $expectedTemperature = 12;

        $this->assertNotNull($receivedTemperature);
        $this->assertEquals($expectedTemperature, $receivedTemperature);
    }

    #[Test]
    #[TestDox('RouteCollection throws exception when adding same scoped service.')]
    public function addScoped_throwsException_onDuplicate(): void
    {
        $serviceCollection = new ServiceCollection();
        $serviceCollection->addScoped(WeatherService::class);

        $this->expectException(DiException::class);
        $serviceCollection->addScoped(WeatherService::class);
    }

    #[Test]
    #[TestDox('RouteCollection throws exception when adding same scoped service with contract.')]
    public function addScoped_throwsException_onContractDuplicate(): void
    {
        $serviceCollection = new ServiceCollection();
        $serviceCollection->addScoped(IWeatherService::class, WeatherService::class);

        $this->expectException(DiException::class);
        $serviceCollection->addScoped(WeatherService::class);
    }

    #[Test]
    #[TestDox('RouteCollection throws exception when adding same transient service.')]
    public function addTransient_throwsException_onDuplicate(): void
    {
        $serviceCollection = new ServiceCollection();
        $serviceCollection->addTransient(WeatherService::class);

        $this->expectException(DiException::class);
        $serviceCollection->addTransient(WeatherService::class);
    }

    #[Test]
    #[TestDox('RouteCollection throws exception when adding same transient service with contract.')]
    public function addTransient_throwsException_onContractDuplicate(): void
    {
        $serviceCollection = new ServiceCollection();
        $serviceCollection->addTransient(IWeatherService::class, WeatherService::class);

        $this->expectException(DiException::class);
        $serviceCollection->addTransient(WeatherService::class);
    }
}
