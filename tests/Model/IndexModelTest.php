<?php
declare(strict_types=1);

namespace AtomicSmash\ReleaseBelt\Tests\Model;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use AtomicSmash\ReleaseBelt\Model\IndexModel;
use AtomicSmash\ReleaseBelt\UrlGenerator;

class IndexModelTest extends TestCase
{
    public function testGetContext(): void
    {
        $packages = [
            'package1' => [
                '1.0' => [],
                '2.0' => [
                    'type' => 'wordpress-plugin',
                ],
            ],
            'package2' => [
                '1.1' => [
                    'foo' => 'bar',
                ],
            ],
        ];

        $urlGeneratorDummy = $this->getMockBuilder(UrlGenerator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $indexModel = new IndexModel($packages, $urlGeneratorDummy);
        $context    = $indexModel->getContext();

        $this->assertEquals([
            [
                'name'     => 'package1',
                'latest'   => '2.0',
                'type'     => 'wordpress-plugin',
                'versions' => [
                    [
                        'type' => 'wordpress-plugin',
                    ],
                    [],
                ],
            ],
            [
                'name'     => 'package2',
                'latest'   => '1.1',
                'versions' => [
                    [
                        'foo' => 'bar',
                    ],
                ],
                'last'     => true,
            ],
        ], $context['packages']);
    }
}
