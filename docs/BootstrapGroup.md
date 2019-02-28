# BootstrapGroup

This is implementation of [BootstrapInterface](https://www.yiiframework.com/doc/api/2.0/yii-base-bootstrapinterface)
that allows to group few bootstraps into one using proxy pattern.

It may be usefull when you write some 

[Implementation](../src/BootstrapGroup.php)

## Example

```php
<?php
// config.php

use yii\base;
use Horat1us\Yii\BootstrapGroup;


return [
    'class' => base\Application::class, // console, web, etc. application
    'bootstrap' => [
        'myModuleBootstrap' => [
            'class' => BootstrapGroup::class,
            'items' => [
                FirstSubModuleBootstrap::class, // class references   
                SecondSubModuleBootstrap::class,    
            ],
        ],    
    ],
];
```
