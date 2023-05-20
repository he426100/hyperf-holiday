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

/**
 * 爬取百度日历工作日.
 * @see https://github.com/xywf221/cn-work-day-database/
 */
class Holiday
{
    public function run(): array
    {
        $url = 'https://sp1.baidu.com/8aQDcjqpAAV3otqbppnN2DJv/api.php?tn=wisetpl&format=json&resource_id=39043&query=';
        $datetime = new \DateTime('-1 month first day of January');
        $dates = [];
        foreach (range(1, 12) as $i) {
            $now = $datetime->add(new \DateInterval('P1M'))->format('Y年n月');
            $month = $datetime->format('n');
            $year = $datetime->format('Y');

            $resp = file_get_contents($url . urlencode($now));
            // 可能是缺少header头的原因这里file_get_contents或者的编码为gb18030
            $resp = mb_convert_encoding($resp, 'UTF-8', 'GB18030');
            $payload = json_decode($resp, true);
            if (json_last_error() !== 0) {
                throw new \Exception(json_last_error_msg(), json_last_error());
            }
            foreach ($payload['data'][0]['almanac'] as $calendar) {
                if ($calendar['year'] == $year && $calendar['month'] == $month) {
                    $date = sprintf('%s-%02d-%02d', $calendar['year'], $calendar['month'], $calendar['day']);
                    $is_work_day = false;
                    if (array_key_exists('status', $calendar)) {
                        switch ($calendar['status']) {
                            case 1:
                                $is_work_day = false;
                                break;
                            case 2:
                                $is_work_day = true;
                                break;
                        }
                    } else {
                        // 判断是否是周六或者周日
                        $is_work_day = ! in_array($calendar['cnDay'], ['六', '日']);
                    }
                    $dates[$date] = $is_work_day;
                }
            }
        }

        return $dates;
    }
}
