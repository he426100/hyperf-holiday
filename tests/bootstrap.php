<?php

declare(strict_types=1);
/**
 * This file is part of he426100/hyperf-holiday.
 *
 * @link     https://github.com/he426100/hyperf-holiday
 * @contact  mrpzx001@gmail.com
 * @license  https://github.com/he426100/hyperf-holiday/blob/master/LICENSE
 */
use Hyperf\Config\Config;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\ClassLoader;
use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSourceFactory;

! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));
! defined('SWOOLE_HOOK_FLAGS') && define('SWOOLE_HOOK_FLAGS', SWOOLE_HOOK_ALL);

Swoole\Runtime::enableCoroutine(true);

require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';

ClassLoader::init();

$container = new Container((new DefinitionSourceFactory())());
$container->set(ConfigInterface::class, $config = new Config([]));

ApplicationContext::setContainer($container);

$container->get(Hyperf\Contract\ApplicationInterface::class);
