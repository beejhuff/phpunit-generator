<?php

return [
    // Erase old target files with new one
    'overwrite' => true,
    // If you want to generate tests for Interface too
    'interface' => true,
    // Automatically generate tests for getter / setter method
    'auto'      => true,
    // Ignore errors that can be ignored
    'ignore'    => true,
    // Regex (/.*config.php/ for example) that files must not match to have a tests generation
    'exclude'   => '/.*config.php/',
    // Regex (/.*.php/ for example) that files should match to have a tests generation
    'include'   => '/.*/',
    // Directories to generate tests for
    'dirs'      => [
        'source/dir/to/parse' => 'target/dir/to/put/generated/files'
    ],
    // Files to generate tests for
    'files'     => [
        'source/file/to/parse' => 'target/file/to/put/generated/file'
    ]
];