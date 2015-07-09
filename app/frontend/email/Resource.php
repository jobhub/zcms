<?php
$resource = [
    'name' => 'm_index_menu_email',
    'description' => 'Email Module',
    'author' => 'ZCMS Team',
    'authorUri' => 'http://ZCMS.vn',
    'version' => '0.0.1',
    'uri' => 'http://ZCMS.vn',
    'location' => 'frontend',
    'class_name' => 'ZCMS\\Frontend\\Email\\Module',
    'path' => '/frontend/email/Module.php',
    'acl' => [
        [
            'controller' => 'index',
            'controller_name' => 'Index',
            'rules' => [
                [
                    'action' => 'index',
                    'action_name' => 'Front End',
                    'sub_action' => ''
                ]
            ]
        ]
    ]
];