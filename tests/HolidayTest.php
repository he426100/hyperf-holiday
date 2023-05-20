<?php

declare(strict_types=1);
/**
 * This file is part of he426100/hyperf-holiday.
 *
 * @link     https://github.com/he426100/hyperf-holiday
 * @contact  mrpzx001@gmail.com
 * @license  https://github.com/he426100/hyperf-holiday/blob/master/LICENSE
 */

namespace he426100\Holiday\Tests;

use He426100\Holiday\Holiday;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ConfigInterface;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\SimpleCache\CacheInterface;

use function He426100\Holiday\is_workday;

/**
 * @internal
 * @coversNothing
 */
class HolidayTest extends BaseTestCase
{
    protected $container;

    protected $config;

    protected $cache;

    protected function setUp(): void
    {
        $this->container = ApplicationContext::getContainer();
        $this->config = $this->container->get(ConfigInterface::class);
        $this->initConfig();
        $this->cache = $this->container->get(CacheInterface::class);
    }

    public function testHoliday()
    {
        $holiday = (new Holiday())->run();
        $year = explode('-', array_key_first($holiday))[0];
        $this->assertEquals(date('Y'), $year);

        $this->cache->set('holiday-' . $year, $holiday);
        $this->assertTrue(!is_workday(strtotime(date('Y-05-01'))));
    }

    protected function initConfig()
    {
        $this->config->set('cache', [
            'default' => [
                'driver' => \Hyperf\Cache\Driver\CoroutineMemoryDriver::class,
                'packer' => \Hyperf\Codec\Packer\PhpSerializerPacker::class,
                'prefix' => \Hyperf\Support\env('CACHE_PREFIX', 'c:'),
            ],
        ]);
    }
}
