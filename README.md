# hyperf-holiday

主要代码来自[xywf221/cn-work-day-database](https://github.com/xywf221/cn-work-day-database/)，在其基础上改成hyperf组件


## 安装

```bash
composer require he426100/hyperf-holiday
```

## 使用
```php
use function He426100\Holiday\is_workday;

var_dump(is_workday(strtotime(date('Y-05-01'))));
```
