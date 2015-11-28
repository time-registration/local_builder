<?php

return array(
    'assembler' => '\Net\Bazzline\Component\Locator\Configuration\Assembler\FromArrayAssembler',
    'class_name' => 'ApplicationLocator',    //determines file name as well as php class name
    'file_exists_strategy' => '\Net\Bazzline\Component\Locator\FileExistsStrategy\DeleteStrategy',
    'file_path' => __DIR__ . '/../source/Net/Bazzline/TimeRegistration/LocalBuilder/Utility',
    'instances' => array(
        array(
            'alias'         => 'Configuration',
            'class_name'    => '\Net\Bazzline\TimeRegistration\LocalBuilder\Configuration\ConfigurationFactory',
            'is_factory'    => true,
            'is_shared'     => true,
            'return_value'  => '\Net\Bazzline\TimeRegistration\LocalBuilder\Configuration\Configuration'
        ),
        array(
            'alias'         => 'Filesystem',
            'class_name'    => '\Net\Bazzline\TimeRegistration\LocalBuilder\Utility\Filesystem',
            'is_factory'    => false,
            'is_shared'     => true
        )
    ),
    'method_prefix' => 'get',
    'namespace' => 'Net\Bazzline\TimeRegistration\LocalBuilder\Utility',
);