<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit94350ada7475ac36615ee057fcbc3933
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\CssSelector\\' => 30,
        ),
        'P' => 
        array (
            'Pelago\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\CssSelector\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/css-selector',
        ),
        'Pelago\\' => 
        array (
            0 => __DIR__ . '/..' . '/pelago/emogrifier/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit94350ada7475ac36615ee057fcbc3933::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit94350ada7475ac36615ee057fcbc3933::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
