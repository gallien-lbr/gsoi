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
    public function test($info): void
    {
        $link = $this->createMock(Link::class);
        $link->method('getType')
            ->will($this->onConsecutiveCalls(LinkTypeEnum::TYPE_VIDEO,
                                                   LinkTypeEnum::TYPE_IMAGE));


        $defaultProperties = [LinkPropertyEnum::PROPERTY_WIDTH, LinkPropertyEnum::PROPERTY_HEIGHT];

        $expectedLinkProperties[LinkTypeEnum::TYPE_IMAGE] = $defaultProperties;
        $expectedLinkProperties[LinkTypeEnum::TYPE_VIDEO] = [...$defaultProperties, LinkPropertyEnum::PROPERTY_DURATION];

        $this->assertEquals($expectedLinkProperties[LinkTypeEnum::TYPE_VIDEO], LinkHelpers::getPropertiesList($link));
        $this->assertEquals($expectedLinkProperties[LinkTypeEnum::TYPE_IMAGE],LinkHelpers::getPropertiesList($link));

        $url['video'] = self::VIMEO_URL;
        $url['image'] = self::FLICK_URL;

        $this->assertTrue(LinkHelpers::isValid($url['image']),'LinkHelpers::isValid function is broken');

        $existingProvider = ProviderEnum::PROVIDER_FLICKR;
        $unknownProvider = 'foo.bar';

        $this->assertSame($existingProvider,LinkHelpers::extractProvider($existingProvider));
        $this->assertNull(LinkHelpers::extractProvider($unknownProvider));

        $link = LinkHelpers::extractLinkEntity($info);
        $this->assertInstanceOf(Link::class,$link);
    }

    public function testOEmbed()
    {
        $embed = new Embed();
        $cache = new FilesystemAdapter();
        $container = $this->createMock(Container::class);
        $container->method('getParameter')->with('cache_ttl')->willReturn(3600);

        $oEmbed = new OEmbed($embed,$cache,$container);
        $info = $oEmbed->get(self::VIMEO_URL);
        $this->assertNotNull($info);
        return $info;
    }

}