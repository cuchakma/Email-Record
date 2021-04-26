<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit88310e4f6455e03deb74a45476dd1759
{
    public static $files = array (
        'e99c78a17d5d71ef38d03e01d1d82dae' => __DIR__ . '/../..' . '/includes/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Em\\Re\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Em\\Re\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Em\\Re\\Admin' => __DIR__ . '/../..' . '/includes/Admin.php',
        'Em\\Re\\Admin\\Callbacks' => __DIR__ . '/../..' . '/includes/Admin/Callbacks.php',
        'Em\\Re\\Admin\\Mailem' => __DIR__ . '/../..' . '/includes/Admin/Mailem.php',
        'Em\\Re\\Admin\\Menu' => __DIR__ . '/../..' . '/includes/Admin/Menu.php',
        'Em\\Re\\Admin\\Record_List' => __DIR__ . '/../..' . '/includes/Admin/Record_List.php',
        'Em\\Re\\Admin\\Records' => __DIR__ . '/../..' . '/includes/Admin/Records.php',
        'Em\\Re\\Admin\\Setting' => __DIR__ . '/../..' . '/includes/Admin/Setting.php',
        'Em\\Re\\Ajax' => __DIR__ . '/../..' . '/includes/Ajax.php',
        'Em\\Re\\Assets' => __DIR__ . '/../..' . '/includes/Assets.php',
        'Em\\Re\\Installer' => __DIR__ . '/../..' . '/includes/Installer.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit88310e4f6455e03deb74a45476dd1759::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit88310e4f6455e03deb74a45476dd1759::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit88310e4f6455e03deb74a45476dd1759::$classMap;

        }, null, ClassLoader::class);
    }
}
