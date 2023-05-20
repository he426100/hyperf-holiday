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

use He426100\Holiday\Command\GenHolidayCommand;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'commands' => [
                GenHolidayCommand::class,
            ],
            'publish' => [
            ],
        ];
    }
}
