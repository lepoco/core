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

namespace Lepo\Core\DependencyInjection;

/**
 * Basic service collection.
 */
class ServiceCollection implements IServiceCollection, IServiceProvider
{
    protected array $services = [];

    /**
     * @inheritdoc
     */
    public function getService(string $serviceTypeOrContractName): mixed
    {
        if ($serviceTypeOrContractName === null || trim($serviceTypeOrContractName) === '') {
            throw new DiException('Service name cannot be null');
        }

        /**
         * @var IService $singleService
         */
        foreach ($this->services as $singleService) {
            if (
                $singleService->getContract() === $serviceTypeOrContractName
                || $singleService->getType() === $serviceTypeOrContractName
            ) {
                return $this->getServiceInstance($singleService);
            }
        }

        throw new DiException('Service \'' . $serviceTypeOrContractName . '\' is not registered');
    }

    /**
     * @inheritdoc
     */
    public function addHostedService(string $serviceTypeName): void
    {
        $this->services[] =
            new Service(ServiceLifetime::Scoped, $serviceTypeName, null, true);
    }

    /**
     * @inheritdoc
     */
    public function addScoped(string $serviceTypeOrContractName, ?string $serviceTypeName = null): void
    {
        if ($this->hasService($serviceTypeOrContractName)) {
            throw new DiException("Service {$serviceTypeOrContractName} already registered");
        }

        if ($serviceTypeName !== null) {
            if ($this->hasService($serviceTypeName)) {
                throw new DiException("Service {$serviceTypeName} already registered");
            }
        }

        $this->services[] =
            new Service(ServiceLifetime::Scoped, $serviceTypeOrContractName, $serviceTypeName);
    }

    /**
     * @inheritdoc
     */
    public function addTransient(string $serviceTypeOrContractName, ?string $serviceTypeName = null): void
    {
        if ($this->hasService($serviceTypeOrContractName)) {
            throw new DiException("Service {$serviceTypeOrContractName} already registered");
        }

        if ($serviceTypeName !== null) {
            if ($this->hasService($serviceTypeName)) {
                throw new DiException("Service {$serviceTypeName} already registered");
            }
        }

        $this->services[] =
            new Service(ServiceLifetime::Transient, $serviceTypeOrContractName, $serviceTypeName);
    }

    protected function hasService(string $serviceTypeOrContractName): bool
    {
        /**
         * @var IService $singleService
         */
        foreach ($this->services as $singleService) {
            if (
                $singleService->getContract() === $serviceTypeOrContractName
                || $singleService->getType() === $serviceTypeOrContractName
            ) {
                return true;
            }
        }

        return false;
    }

    protected function getServiceInstance(IService $service): mixed
    {
        if ($service->isTransient()) {
            return $this->makeService($service);
        }

        if ($service->getInstance() === null) {
            $service->setInstance(
                $this->makeService($service)
            );
        }

        return $service->getInstance();
    }

    protected function makeService(IService $service): mixed
    {
        $serviceParameters = $service->getParameters();

        if (empty($serviceParameters)) {
            return new ($service->getType())();
        }

        $arguments = [];

        /**
         * @var \ReflectionParameter $singleParameter
         */
        foreach ($serviceParameters as $singleParameter) {
            $arguments[] = $this->getService($singleParameter->getType()->getName());
        }

        return new ($service->getType())(...$arguments);
    }
}
