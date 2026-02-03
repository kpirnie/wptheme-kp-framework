<?php return array(
    'root' => array(
        'name' => 'kevinpirnie/theme-framework',
        'pretty_version' => '1.0.1',
        'version' => '1.0.1.0',
        'reference' => null,
        'type' => 'wordpress-theme',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'kevinpirnie/kpt-wpfieldframework' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => 'befefec76dfac702119fb953d4a189720d84534d',
            'type' => 'library',
            'install_path' => __DIR__ . '/../kevinpirnie/kpt-wpfieldframework',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
        'kevinpirnie/theme-framework' => array(
            'pretty_version' => '1.0.1',
            'version' => '1.0.1.0',
            'reference' => null,
            'type' => 'wordpress-theme',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'squizlabs/php_codesniffer' => array(
            'pretty_version' => '3.13.5',
            'version' => '3.13.5.0',
            'reference' => '0ca86845ce43291e8f5692c7356fccf3bcf02bf4',
            'type' => 'library',
            'install_path' => __DIR__ . '/../squizlabs/php_codesniffer',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
    ),
);
