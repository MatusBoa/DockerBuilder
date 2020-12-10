<?php

namespace MatusBoa\DockerBuilder;

use MatusBoa\DockerBuilder\Contract\Volume as Contract;

/**
 * Class DockerVolume
 *
 * @author kotas <matus.koterba@gmail.com>
 */
class Volume implements Contract
{
    protected string $exposedVolume;
    protected string $containerVolume;

    public function __construct(string $exposedVolume, string $containerVolume)
    {
        $this->exposedVolume = $exposedVolume;
        $this->containerVolume = $containerVolume;
    }

    /**
     * @return string
     */
    public function getContainerVolume(): string
    {
        return $this->containerVolume;
    }

    /**
     * @return string
     */
    public function getExposedVolume(): string
    {
        return $this->exposedVolume;
    }
}
