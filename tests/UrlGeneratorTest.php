<?php
declare(strict_types=1);

namespace AtomicSmash\ReleaseBelt\Tests;

use Psr\Http\Message\UriInterface;
use AtomicSmash\ReleaseBelt\UrlGenerator;
use PHPUnit\Framework\TestCase;
use Slim\Interfaces\RouteParserInterface;

class UrlGeneratorTest extends TestCase
{
    public function testGetFileUrl(): void
    {
        $routerMock = $this->getMockBuilder(RouteParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $routerMock->expects($this->once())
            ->method('urlFor')
            ->with('file', ['vendor' => 'vendor', 'file' => 'file.zip'])
            ->willReturn('/vendor/file.zip');

        $urlMock = $this->getMockBuilder(UriInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $urlMock->expects($this->once())
            ->method('withPath')
            ->with('/vendor/file.zip')
            ->willReturn($urlMock);

        $urlMock->expects($this->once())
            ->method('withUserInfo')
            ->with('')
            ->willReturn($urlMock);

        $urlMock->expects($this->once())
            ->method('__toString')
            ->willReturn('https://example.com/vendor/file.zip');

        $urlGenerator = new UrlGenerator($routerMock, $urlMock);

        $this->assertSame('https://example.com/vendor/file.zip', $urlGenerator->getFileUrl('vendor', 'file.zip'));
    }
}
