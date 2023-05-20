<?php

declare(strict_types=1);
/**
 * This file is part of he426100/hyperf-holiday.
 *
 * @link     https://github.com/he426100/hyperf-holiday
 * @contact  mrpzx001@gmail.com
 * @license  https://github.com/he426100/hyperf-holiday/blob/master/LICENSE
 */
namespace He426100\Holiday;

use He426100\Holiday\Exception\HolidayException;
use Hyperf\Context\ApplicationContext;
use Psr\SimpleCache\CacheInterface;

/**
 * 指定时间是否是工作日.
 *
 * @param int $time
 */
function is_workday(int $time = null): bool
{
    if (is_null($time) || empty($time)) {
        $time = time();
    }
    $year = date('Y', $time);
    /** @var CacheInterface $cache */
    $cache = ApplicationContext::getContainer()->get(CacheInterface::class);
    $holiday = (array) $cache->get('holiday-' . $year);
    if (empty($holiday)) {
        throw new HolidayException('获取节假日信息失败');
    }
    $day = date('Y-m-d', $time);
    return ! isset($holiday[$day]) || $holiday[$day] === true;
}
