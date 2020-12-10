<?php

namespace MatusBoa\DockerBuilder;

use MatusBoa\DockerBuilder\Contract\Port as PortContract;
use MatusBoa\DockerBuilder\Contract\Volume as VolumeContract;

/**
 * Class Builder
 *
 * @author kotas <matus.koterba@gmail.com>
 */
class Builder
{
    protected string $image;

    protected ?string $name = null;

    protected ?string $memoryLimit = null;

    protected ?string $restartPolicy = null;

    /** @var PortContract[] */
    protected array $ports = [];

    /** @var VolumeContract[] */
    protected array $volumes = [];

    protected bool $isDetached = false;

    public function __construct(string $image)
    {
        $this->image = $image;
    }

    public function withName(string $name): Builder
    {
        $this->name = $name;
        return $this;
    }

    public function mapPort(PortContract $port): Builder
    {
        $this->ports[] = $port;
        return $this;
    }

    public function mountVolume(VolumeContract $volume): Builder
    {
        $this->volumes[] = $volume;
        return $this;
    }

    public function limitRam(string $limit): Builder
    {
        $this->memoryLimit = $limit;
        return $this;
    }

    public function restartPolicy(string $policy): Builder
    {
        $this->restartPolicy = $policy;
        return $this;
    }

    public function detached(): Builder
    {
        $this->isDetached = true;
        return $this;
    }

    public function build(): string
    {
        $command = "docker run";

        ## Detached mode
        if ($this->isDetached) {
            $command .= " -d";
        }

        ## Container Name
        if ($this->name) {
            $command .= " --name {$this->name}";
        }

        ## Restart Policy
        if ($this->restartPolicy) {
            $command .= " --restart={$this->restartPolicy}";
        }

        ## RAM Limit
        if ($this->memoryLimit) {
            $command .= " --memory=\"{$this->memoryLimit}\"";
        }

        ## Ports
        foreach ($this->ports as $port) {
            $command .= " -p {$port->getExposedPort()}:{$port->getContainerPort()}";
        }

        ## Volumes
        foreach ($this->volumes as $volume) {
            $command .= " -v {$volume->getExposedVolume()}:{$volume->getContainerVolume()}";
        }

        ## Container image
        $command .= " {$this->image}";

        return $command;
    }

    public static function new(string $image): Builder
    {
        return new self($image);
    }
}
