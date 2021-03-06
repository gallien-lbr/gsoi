<?php
declare(strict_types=1);

namespace Test;

use App\Entity\Link;
use App\Enum\LinkPropertyEnum;
use App\Enum\LinkTypeEnum;
use App\Enum\ProviderEnum;
use App\Proxy\OEmbed;
use App\Service\LinkHelpers;
use Embed\Embed;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\Container;

final class LinkHelpersTest extends TestCase
{

    public const VIMEO_URL = 'https://vimeo.com/26020014';
    public const FLICK_URL = 'https://www.flickr.com/photos/danielcheong/51920514592/in/explore-2022-03-07/';

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    /**
     * @return void
     * @depends testOEmbed
     */
    public function testHelpers($info): void
    {
        // arrange
        $link = $this->createMock(Link::class);
        $link->method('getType')
            ->will($this->onConsecutiveCalls(LinkTypeEnum::TYPE_VIDEO,
                                                   LinkTypeEnum::TYPE_IMAGE));


        $defaultProperties = [LinkPropertyEnum::PROPERTY_WIDTH, LinkPropertyEnum::PROPERTY_HEIGHT];

        $expectedLinkProperties[LinkTypeEnum::TYPE_IMAGE] = $defaultProperties;
        $expectedLinkProperties[LinkTypeEnum::TYPE_VIDEO] = [...$defaultProperties, LinkPropertyEnum::PROPERTY_DURATION];

        $url['video'] = self::VIMEO_URL;
        $url['image'] = self::FLICK_URL;
        $existingProvider = ProviderEnum::PROVIDER_FLICKR;
        $unknownProvider = 'foo.bar';

        // assert
        $this->assertEquals($expectedLinkProperties[LinkTypeEnum::TYPE_VIDEO], LinkHelpers::getPropertiesList($link));
        $this->assertEquals($expectedLinkProperties[LinkTypeEnum::TYPE_IMAGE],LinkHelpers::getPropertiesList($link));
        $this->assertTrue(LinkHelpers::isValid($url['image']),'LinkHelpers::isValid function is broken');
        $this->assertSame($existingProvider,LinkHelpers::extractProvider($existingProvider));
        $this->assertNull(LinkHelpers::extractProvider($unknownProvider));
        $this->assertInstanceOf(Link::class, LinkHelpers::extractLinkEntity($info));
    }

    public function testOEmbed()
    {
        // arrange
        $embed = new Embed();
        $cache = new FilesystemAdapter();
        $container = $this->createMock(Container::class);
        $container->method('getParameter')->with('cache_ttl')->willReturn(3600);
        $oEmbed = new OEmbed($embed,$cache,$container);
        // act
        $info = $oEmbed->get(self::VIMEO_URL);
        // assert
        $this->assertNotNull($info);
        return $info;
    }

}