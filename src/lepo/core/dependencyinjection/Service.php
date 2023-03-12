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

namespace Lepo\Core\DependencyInjection;

use ReflectionClass;

class Service implements IService
{
    private readonly ServiceLifetime $lifetime;

    private readonly array $parameters;

    private readonly string $serviceClass;

    private readonly ?string $serviceContract;

    private mixed $serviceInstance = null;

    public function __construct(
        ServiceLifetime $lifetime,
        string $serviceClassOrContract,
        ?string $serviceClass = null
    ) {
        $this->lifetime = $lifetime;

        if ($serviceClass == null) {
            $this->serviceContract = null;
            $this->serviceClass = $serviceClassOrContract;
        } else {
            $this->serviceContract = $serviceClassOrContract;
            $this->serviceClass = $serviceClass;
        }

        $this->parameters = $this->collectParametersFromReflection();
    }

    public static function fromObject(
        string $serviceContractName,
        mixed $serviceObject
    ): self {
        $service = new self(ServiceLifetime::Scoped, $serviceContractName);
        $service->setInstance($serviceObject);

        return $service;
    }

    public function getType(): string
    {
        return $this->serviceClass;
    }

    public function getContract(): ?string
    {
        return $this->serviceContract;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function isHosted(): bool
    {
        return false;
    }

    public function isTransient(): bool
    {
        return $this->lifetime === ServiceLifetime::Transient;
    }

    public function getInstance(): mixed
    {
        return $this->serviceInstance;
    }

    public function setInstance(mixed $object): void
    {
        $this->serviceInstance = $object;
    }

    private function collectParametersFromReflection(): array
    {
        $serviceReflection = new ReflectionClass($this->serviceClass);
        $serviceConstructor = $serviceReflection->getConstructor();

        if ($serviceConstructor === null) {
            return [];
        }

        return $serviceConstructor->getParameters();
    }
}
