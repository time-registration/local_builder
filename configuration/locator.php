<?php

return [
    'assembler' => '\Net\Bazzline\Component\Locator\Configuration\Assembler\FromArrayAssembler',
    'class_name' => 'ApplicationLocator',    //determines file name as well as php class name
    'file_exists_strategy' => '\Net\Bazzline\Component\Locator\FileExistsStrategy\DeleteStrategy',
    'file_path' => __DIR__ . '/../source/Net/Bazzline/TimeRegistration/LocalBuilder/Utility',
    'instances' => [
        [
            'alias'         => 'CollectionOfEntries',
            'class_name'    => '\Net\Bazzline\TimeRegistration\LocalBuilder\Utility\CollectionOfEntriesFactory',
            'is_factory'    => true,
            'is_shared'     => false,
            'return_value'  => '\Net\Bazzline\TimeRegistration\LocalBuilder\Utility\CollectionOfEntries'
        ],
        [
            'alias'         => 'Configuration',
            'class_name'    => '\Net\Bazzline\TimeRegistration\LocalBuilder\Configuration\ConfigurationFactory',
            'is_factory'    => true,
            'is_shared'     => true,
            'return_value'  => '\Net\Bazzline\TimeRegistration\LocalBuilder\Configuration\Configuration'
        ],
        [
            'alias'         => 'Filesystem',
            'class_name'    => '\Net\Bazzline\TimeRegistration\LocalBuilder\Utility\Filesystem',
            'is_factory'    => false,
            'is_shared'     => true
        ],
        [
            'alias'         => 'CharacterString',
            'class_name'    => '\Net\Bazzline\TimeRegistration\LocalBuilder\Utility\CharacterString',
            'is_factory'    => false,
            'is_shared'     => true
        ],
        [
            'alias'         => 'Time',
            'class_name'    => '\Net\Bazzline\TimeRegistration\LocalBuilder\Utility\Time',
            'is_factory'    => false,
            'is_shared'     => true
        ]
    ],
    'method_prefix' => 'get',
    'namespace' => 'Net\Bazzline\TimeRegistration\LocalBuilder\Utility',
];
