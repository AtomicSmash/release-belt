<?php

namespace AtomicSmash\ReleaseBelt\Tests\Fractal;

use PHPUnit\Framework\TestCase;
use AtomicSmash\ReleaseBelt\Fractal\PackageSerializer;

class PackageSerializerTest extends TestCase
{
    public function testCollection()
    {
        $packageSerializer = new PackageSerializer();

        $name = 'vendor/package';

        $version = '1.0';
        $package = [
            'name'    => $name,
            'version' => $version,
        ];

        $version2 = '2.0';
        $package2 = [
            'name'    => $name,
            'version' => $version2,
        ];

        $collection = $packageSerializer->collection('key', [$package, $package2]);

        $this->assertEquals([$version => $package, $version2 => $package2], $collection['packages'][$name]);
    }
}
