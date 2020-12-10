<?php

namespace MatusBoa\DockerBuilder;

use MatusBoa\DockerBuilder\Contract\Port as Contract;

/**
 * Class DockerPort
 *
 * @author kotas <matus.koterba@gmail.com>
 */
class Port implements Contract
{
    protected int $exposedPort;
    protected int $containerPort;

    public function __construct(int $exposedPort, int $containerPort)
    {
        $this->exposedPort = $exposedPort;
        $this->containerPort = $containerPort;
    }

    public function getContainerPort(): int
    {
        return $this->containerPort;
    }

    public function getExposedPort(): int
    {
        return $this->exposedPort;
    }
}
