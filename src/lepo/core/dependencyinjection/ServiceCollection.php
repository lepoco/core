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
    private array $services = [];

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
    public function addHostedService(string $serviceClassName): void
    {
        $this->services[] =
            new Service(ServiceLifetime::Scoped, $serviceClassName);
    }

    /**
     * @inheritdoc
     */
    public function addScoped(string $serviceTypeOrContractName, ?string $serviceClassName = null): void
    {
        $this->services[] =
            new Service(ServiceLifetime::Scoped, $serviceTypeOrContractName, $serviceClassName);
    }

    /**
     * @inheritdoc
     */
    public function addTransient(string $serviceTypeOrContractName, ?string $serviceClassName = null): void
    {
        $this->services[] =
            new Service(ServiceLifetime::Transient, $serviceTypeOrContractName, $serviceClassName);
    }

    private function getServiceInstance(IService $service): mixed
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

    private function makeService(IService $service): mixed
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
