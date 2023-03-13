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

use ReflectionClass;

/**
 * Base implementation of the service container.
 */
class Service implements IService
{
    protected readonly ServiceLifetime $lifetime;

    protected readonly array $parameters;

    protected readonly string $serviceClass;

    protected readonly ?string $serviceContract;

    protected readonly bool $isHosted;

    protected mixed $serviceInstance = null;

    public function __construct(
        ServiceLifetime $lifetime,
        string $serviceClassOrContract,
        ?string $serviceClass = null,
        bool $isHosted = false
    ) {
        $this->lifetime = $lifetime;
        $this->isHosted = $isHosted;

        if ($serviceClass == null) {
            $this->serviceContract = null;
            $this->serviceClass = $serviceClassOrContract;
        } else {
            $this->serviceContract = $serviceClassOrContract;
            $this->serviceClass = $serviceClass;
        }

        $this->parameters = $this->collectParametersFromReflection();
    }

    /**
     * Creates a service descriptor with defined object.
     */
    public static function fromObject(
        mixed $serviceObject,
        string $serviceClassOrContract,
        ?string $serviceClass = null
    ): self {
        $service = new self(ServiceLifetime::Scoped, $serviceClassOrContract, $serviceClass);
        $service->setInstance($serviceObject);

        return $service;
    }

    /**
     * @inheritdoc
     */
    public function getType(): string
    {
        return $this->serviceClass;
    }

    /**
     * @inheritdoc
     */
    public function getContract(): ?string
    {
        return $this->serviceContract;
    }

    /**
     * @inheritdoc
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @inheritdoc
     */
    public function isHosted(): bool
    {
        return $this->isHosted;
    }

    /**
     * @inheritdoc
     */
    public function isTransient(): bool
    {
        return $this->lifetime === ServiceLifetime::Transient;
    }

    /**
     * @inheritdoc
     */
    public function getInstance(): mixed
    {
        return $this->serviceInstance;
    }

    /**
     * @inheritdoc
     */
    public function setInstance(mixed $object): void
    {
        $this->serviceInstance = $object;
    }

    /**
     * @inheritdoc
     */
    protected function collectParametersFromReflection(): array
    {
        $serviceReflection = new ReflectionClass($this->serviceClass);
        $serviceConstructor = $serviceReflection->getConstructor();

        if ($serviceConstructor === null) {
            return [];
        }

        return $serviceConstructor->getParameters();
    }
}
