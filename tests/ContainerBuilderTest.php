<?php

namespace MatusBoa\Tests;

use MatusBoa\DockerBuilder\Port;
use MatusBoa\DockerBuilder\Volume;
use MatusBoa\DockerBuilder\Builder;

/**
 * Class ContainerBuilderTest
 *
 * @author kotas <matus.koterba@gmail.com>
 */
class ContainerBuilderTest extends TestCase
{
    /** @test */
    public function itCreatesCommandWithImage(): void
    {
        $this->assertEquals(
            "docker run testImage",
            Builder::new("testImage")->build()
        );
    }

    /** @test */
    public function itCreatesCommandInDetachedMode(): void
    {
        $this->assertEquals(
            "docker run -d testImage",
            Builder::new("testImage")
                ->detached()
                ->build()
        );
    }

    /** @test */
    public function itCreatesCommandWithName(): void
    {
        $this->assertEquals(
            "docker run --name testContainer testImage",
            Builder::new("testImage")
                ->withName("testContainer")
                ->build()
        );
    }

    /** @test */
    public function itCreatesCommandWithRestartPolicy(): void
    {
        $this->assertEquals(
            "docker run --restart=on-failure testImage",
            Builder::new("testImage")
                ->restartPolicy("on-failure")
                ->build()
        );
    }

    /** @test */
    public function itCreatesCommandWithPorts(): void
    {
        $this->assertEquals(
            "docker run -p 8080:80 -p 443:443 testImage",
            Builder::new("testImage")
                ->mapPort(new Port(8080, 80))
                ->mapPort(new Port(443, 443))
                ->build()
        );
    }

    /** @test */
    public function itCreatesCommandWithVolumes(): void
    {
        $this->assertEquals(
            "docker run -v /var/www/html:/var/www/html -v /var/www/example.com:/var/www/html testImage",
            Builder::new("testImage")
                ->mountVolume(new Volume("/var/www/html", "/var/www/html"))
                ->mountVolume(new Volume("/var/www/example.com", "/var/www/html"))
                ->build()
        );
    }

    /** @test */
    public function itCreatesCommandWithRamLimit(): void
    {
        $this->assertEquals(
            "docker run --memory=\"1G\" testImage",
            Builder::new("testImage")
                ->limitRam("1G")
                ->build()
        );
    }

    /** @test */
    public function itCreatesCommandWithAllPossibleParameters(): void
    {
        $this->assertEquals(
            "docker run -d --name testContainer --restart=unless-stopped --memory=\"400m\" -p 8080:80 -v /var/www/html:/var/www/html testImage",
            Builder::new("testImage")
                ->detached()
                ->withName("testContainer")
                ->mapPort(new Port(8080, 80))
                ->limitRam("400m")
                ->restartPolicy("unless-stopped")
                ->mountVolume(new Volume("/var/www/html", "/var/www/html"))
                ->build()
        );
    }
}