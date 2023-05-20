<?php

declare(strict_types=1);
/**
 * This file is part of he426100/hyperf-holiday.
 *
 * @link     https://github.com/he426100/hyperf-holiday
 * @contact  mrpzx001@gmail.com
 * @license  https://github.com/he426100/hyperf-holiday/blob/master/LICENSE
 */
namespace He426100\Holiday\Command;

use He426100\Holiday\Holiday;
use Hyperf\Command\Command;
use Psr\Container\ContainerInterface;
use Psr\SimpleCache\CacheInterface;

class GenHolidayCommand extends Command
{
    public function __construct(protected ContainerInterface $container, protected CacheInterface $cache)
    {
        parent::__construct('gen:holiday');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('爬取百度日历工作日');
    }

    public function handle()
    {
        $holiday = (new Holiday())->run();
        $year = explode('-', array_key_first($holiday))[0];
        $this->cache->set('holiday-' . $year, $holiday);
    }
}
