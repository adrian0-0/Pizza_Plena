<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9b97786baa18a2131b86fc40df508740
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WebpConverter\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WebpConverter\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9b97786baa18a2131b86fc40df508740::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9b97786baa18a2131b86fc40df508740::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}