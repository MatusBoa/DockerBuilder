<?php

namespace MatusBoa\DockerBuilder\Contract;

/**
 * Interface Port
 *
 * @author kotas <matus.koterba@gmail.com>
 */
interface Port
{
    public function getContainerPort(): int;

    public function getExposedPort(): int;
}