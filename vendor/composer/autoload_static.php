<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit951ee87f5419551856cb99b769da67bd
{
    public static $prefixLengthsPsr4 = array (
        't' => 
        array (
            'think\\composer\\' => 15,
            'think\\' => 6,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'think\\composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-installer/src',
        ),
        'think\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-image/src',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/application',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit951ee87f5419551856cb99b769da67bd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit951ee87f5419551856cb99b769da67bd::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
