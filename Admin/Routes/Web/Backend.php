<?php

use phpOMS\Router\RouteVerb;
use phpOMS\Account\PermissionType;
use Modules\EventManagement\Models\PermissionState;
use Modules\EventManagement\Controller\BackendController;

return [
    '^.*/backend/eventmanagement/list.*$' => [
        [
            'dest' => '\Modules\EventManagement\Controller\BackendController:viewEventManagementList',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::EVENT,
            ],
        ],
    ],
    '^.*/backend/eventmanagement/create.*$' => [
        [
            'dest' => '\Modules\EventManagement\Controller\BackendController:viewEventManagementCreate',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::CREATE,
                'state' => PermissionState::EVENT,
            ],
        ],
    ],
    '^.*/backend/eventmanagement/profile.*$' => [
        [
            'dest' => '\Modules\EventManagement\Controller\BackendController:viewEventManagementProfile',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::EVENT,
            ],
        ],
    ],
];
