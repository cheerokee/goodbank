<?php
return [
    'router' => [
        'routes' => [
            'api.rest.doctrine.user' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/user[/:user_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\User\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.role' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/role[/:role_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Role\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.resource' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/resource[/:resource_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Resource\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.action' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/action[/:action_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Action\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.privilege' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/privilege[/:privilege_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Privilege\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.possibility' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/possibility[/:possibility_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Possibility\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.category-image' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/category-image[/:category_image_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\CategoryImage\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.reference-image' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/reference-image[/:reference_image_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\ReferenceImage\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.image' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/image[/:image_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Image\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.country' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/country[/:country_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Country\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.state' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/state[/:state_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\State\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.city' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/city[/:city_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\City\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.address' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/address[/:address_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Address\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.configuration' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/configuration[/:configuration_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Configuration\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.plan' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/plan[/:plan_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Plan\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.user-plan' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/user-plan[/:user_plan_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\UserPlan\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.account' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/account[/:account_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Account\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.bank' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/bank[/:bank_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Bank\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.payment-method' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/payment-method[/:payment_method_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\PaymentMethod\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.wallet' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/wallet[/:wallet_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Wallet\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.transaction' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/transaction[/:transaction_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Transaction\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.cycle' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/cycle[/:cycle_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\Cycle\\Controller',
                    ],
                ],
            ],
            'api.rest.doctrine.category-transaction' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/category-transaction[/:category_transaction_id]',
                    'defaults' => [
                        'controller' => 'api\\V1\\Rest\\CategoryTransaction\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            9 => 'api.rest.doctrine.user',
            13 => 'api.rest.doctrine.role',
            14 => 'api.rest.doctrine.resource',
            16 => 'api.rest.doctrine.action',
            17 => 'api.rest.doctrine.privilege',
            18 => 'api.rest.doctrine.possibility',
            0 => 'api.rest.doctrine.category-image',
            19 => 'api.rest.doctrine.reference-image',
            20 => 'api.rest.doctrine.image',
            24 => 'api.rest.doctrine.country',
            25 => 'api.rest.doctrine.state',
            26 => 'api.rest.doctrine.city',
            33 => 'api.rest.doctrine.address',
            36 => 'api.rest.doctrine.configuration',
            37 => 'api.rest.doctrine.plan',
            38 => 'api.rest.doctrine.user-plan',
            39 => 'api.rest.doctrine.account',
            40 => 'api.rest.doctrine.bank',
            41 => 'api.rest.doctrine.payment-method',
            42 => 'api.rest.doctrine.wallet',
            43 => 'api.rest.doctrine.transaction',
            44 => 'api.rest.doctrine.cycle',
            45 => 'api.rest.doctrine.category-transaction',
        ],
    ],
    'zf-rest' => [
        'api\\V1\\Rest\\User\\Controller' => [
            'listener' => \api\V1\Rest\User\UserResource::class,
            'route_name' => 'api.rest.doctrine.user',
            'route_identifier_name' => 'user_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'user',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Register\Entity\User::class,
            'collection_class' => \api\V1\Rest\User\UserCollection::class,
            'service_name' => 'User',
        ],
        'api\\V1\\Rest\\Role\\Controller' => [
            'listener' => \api\V1\Rest\Role\RoleResource::class,
            'route_name' => 'api.rest.doctrine.role',
            'route_identifier_name' => 'role_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'role',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Acl\Entity\Role::class,
            'collection_class' => \api\V1\Rest\Role\RoleCollection::class,
            'service_name' => 'Role',
        ],
        'api\\V1\\Rest\\Resource\\Controller' => [
            'listener' => \api\V1\Rest\Resource\ResourceResource::class,
            'route_name' => 'api.rest.doctrine.resource',
            'route_identifier_name' => 'resource_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'resource',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Acl\Entity\Resource::class,
            'collection_class' => \api\V1\Rest\Resource\ResourceCollection::class,
            'service_name' => 'Resource',
        ],
        'api\\V1\\Rest\\Action\\Controller' => [
            'listener' => \api\V1\Rest\Action\ActionResource::class,
            'route_name' => 'api.rest.doctrine.action',
            'route_identifier_name' => 'action_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'action',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Acl\Entity\Action::class,
            'collection_class' => \api\V1\Rest\Action\ActionCollection::class,
            'service_name' => 'Action',
        ],
        'api\\V1\\Rest\\Privilege\\Controller' => [
            'listener' => \api\V1\Rest\Privilege\PrivilegeResource::class,
            'route_name' => 'api.rest.doctrine.privilege',
            'route_identifier_name' => 'privilege_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'privilege',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Acl\Entity\Privilege::class,
            'collection_class' => \api\V1\Rest\Privilege\PrivilegeCollection::class,
            'service_name' => 'Privilege',
        ],
        'api\\V1\\Rest\\Possibility\\Controller' => [
            'listener' => \api\V1\Rest\Possibility\PossibilityResource::class,
            'route_name' => 'api.rest.doctrine.possibility',
            'route_identifier_name' => 'possibility_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'possibility',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Acl\Entity\Possibility::class,
            'collection_class' => \api\V1\Rest\Possibility\PossibilityCollection::class,
            'service_name' => 'Possibility',
        ],
        'api\\V1\\Rest\\CategoryImage\\Controller' => [
            'listener' => \api\V1\Rest\CategoryImage\CategoryImageResource::class,
            'route_name' => 'api.rest.doctrine.category-image',
            'route_identifier_name' => 'category_image_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'category_image',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Register\\Entity\\CategoryImage',
            'collection_class' => \api\V1\Rest\CategoryImage\CategoryImageCollection::class,
            'service_name' => 'CategoryImage',
        ],
        'api\\V1\\Rest\\ReferenceImage\\Controller' => [
            'listener' => \api\V1\Rest\ReferenceImage\ReferenceImageResource::class,
            'route_name' => 'api.rest.doctrine.reference-image',
            'route_identifier_name' => 'reference_image_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'reference_image',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Register\\Entity\\ReferenceImage',
            'collection_class' => \api\V1\Rest\ReferenceImage\ReferenceImageCollection::class,
            'service_name' => 'ReferenceImage',
        ],
        'api\\V1\\Rest\\Image\\Controller' => [
            'listener' => \api\V1\Rest\Image\ImageResource::class,
            'route_name' => 'api.rest.doctrine.image',
            'route_identifier_name' => 'image_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'image',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Register\\Entity\\Image',
            'collection_class' => \api\V1\Rest\Image\ImageCollection::class,
            'service_name' => 'Image',
        ],
        'api\\V1\\Rest\\Country\\Controller' => [
            'listener' => \api\V1\Rest\Country\CountryResource::class,
            'route_name' => 'api.rest.doctrine.country',
            'route_identifier_name' => 'country_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'country',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => '10000',
            'page_size_param' => null,
            'entity_class' => \Address\Entity\Country::class,
            'collection_class' => \api\V1\Rest\Country\CountryCollection::class,
            'service_name' => 'Country',
        ],
        'api\\V1\\Rest\\State\\Controller' => [
            'listener' => \api\V1\Rest\State\StateResource::class,
            'route_name' => 'api.rest.doctrine.state',
            'route_identifier_name' => 'state_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'state',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => '10000',
            'page_size_param' => null,
            'entity_class' => \Address\Entity\State::class,
            'collection_class' => \api\V1\Rest\State\StateCollection::class,
            'service_name' => 'State',
        ],
        'api\\V1\\Rest\\City\\Controller' => [
            'listener' => \api\V1\Rest\City\CityResource::class,
            'route_name' => 'api.rest.doctrine.city',
            'route_identifier_name' => 'city_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'city',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => '10000',
            'page_size_param' => null,
            'entity_class' => \Address\Entity\City::class,
            'collection_class' => \api\V1\Rest\City\CityCollection::class,
            'service_name' => 'City',
        ],
        'api\\V1\\Rest\\Address\\Controller' => [
            'listener' => \api\V1\Rest\Address\AddressResource::class,
            'route_name' => 'api.rest.doctrine.address',
            'route_identifier_name' => 'address_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'address',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Address\Entity\Address::class,
            'collection_class' => \api\V1\Rest\Address\AddressCollection::class,
            'service_name' => 'Address',
        ],
        'api\\V1\\Rest\\Configuration\\Controller' => [
            'listener' => \api\V1\Rest\Configuration\ConfigurationResource::class,
            'route_name' => 'api.rest.doctrine.configuration',
            'route_identifier_name' => 'configuration_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'configuration',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Configuration\Entity\Configuration::class,
            'collection_class' => \api\V1\Rest\Configuration\ConfigurationCollection::class,
            'service_name' => 'Configuration',
        ],
        'api\\V1\\Rest\\Plan\\Controller' => [
            'listener' => \api\V1\Rest\Plan\PlanResource::class,
            'route_name' => 'api.rest.doctrine.plan',
            'route_identifier_name' => 'plan_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'plan',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Plan\Entity\Plan::class,
            'collection_class' => \api\V1\Rest\Plan\PlanCollection::class,
            'service_name' => 'Plan',
        ],
        'api\\V1\\Rest\\UserPlan\\Controller' => [
            'listener' => \api\V1\Rest\UserPlan\UserPlanResource::class,
            'route_name' => 'api.rest.doctrine.user-plan',
            'route_identifier_name' => 'user_plan_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'user_plan',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \UserPlan\Entity\UserPlan::class,
            'collection_class' => \api\V1\Rest\UserPlan\UserPlanCollection::class,
            'service_name' => 'UserPlan',
        ],
        'api\\V1\\Rest\\Account\\Controller' => [
            'listener' => \api\V1\Rest\Account\AccountResource::class,
            'route_name' => 'api.rest.doctrine.account',
            'route_identifier_name' => 'account_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'account',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Account\Entity\Account::class,
            'collection_class' => \api\V1\Rest\Account\AccountCollection::class,
            'service_name' => 'Account',
        ],
        'api\\V1\\Rest\\Bank\\Controller' => [
            'listener' => \api\V1\Rest\Bank\BankResource::class,
            'route_name' => 'api.rest.doctrine.bank',
            'route_identifier_name' => 'bank_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'bank',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Bank\Entity\Bank::class,
            'collection_class' => \api\V1\Rest\Bank\BankCollection::class,
            'service_name' => 'Bank',
        ],
        'api\\V1\\Rest\\PaymentMethod\\Controller' => [
            'listener' => \api\V1\Rest\PaymentMethod\PaymentMethodResource::class,
            'route_name' => 'api.rest.doctrine.payment-method',
            'route_identifier_name' => 'payment_method_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'payment_method',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \PaymentMethod\Entity\PaymentMethod::class,
            'collection_class' => \api\V1\Rest\PaymentMethod\PaymentMethodCollection::class,
            'service_name' => 'PaymentMethod',
        ],
        'api\\V1\\Rest\\Wallet\\Controller' => [
            'listener' => \api\V1\Rest\Wallet\WalletResource::class,
            'route_name' => 'api.rest.doctrine.wallet',
            'route_identifier_name' => 'wallet_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'wallet',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Wallet\Entity\Wallet::class,
            'collection_class' => \api\V1\Rest\Wallet\WalletCollection::class,
            'service_name' => 'Wallet',
        ],
        'api\\V1\\Rest\\Transaction\\Controller' => [
            'listener' => \api\V1\Rest\Transaction\TransactionResource::class,
            'route_name' => 'api.rest.doctrine.transaction',
            'route_identifier_name' => 'transaction_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'transaction',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => '25',
            'page_size_param' => null,
            'entity_class' => \Transaction\Entity\Transaction::class,
            'collection_class' => \api\V1\Rest\Transaction\TransactionCollection::class,
            'service_name' => 'Transaction',
        ],
        'api\\V1\\Rest\\Cycle\\Controller' => [
            'listener' => \api\V1\Rest\Cycle\CycleResource::class,
            'route_name' => 'api.rest.doctrine.cycle',
            'route_identifier_name' => 'cycle_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'cycle',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Cycle\Entity\Cycle::class,
            'collection_class' => \api\V1\Rest\Cycle\CycleCollection::class,
            'service_name' => 'Cycle',
        ],
        'api\\V1\\Rest\\CategoryTransaction\\Controller' => [
            'listener' => \api\V1\Rest\CategoryTransaction\CategoryTransactionResource::class,
            'route_name' => 'api.rest.doctrine.category-transaction',
            'route_identifier_name' => 'category_transaction_id',
            'entity_identifier_name' => 'id',
            'collection_name' => 'category_transaction',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \CategoryTransaction\Entity\CategoryTransaction::class,
            'collection_class' => \api\V1\Rest\CategoryTransaction\CategoryTransactionCollection::class,
            'service_name' => 'CategoryTransaction',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'api\\V1\\Rest\\User\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Role\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Resource\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Action\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Privilege\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Possibility\\Controller' => 'HalJson',
            'api\\V1\\Rest\\CategoryImage\\Controller' => 'HalJson',
            'api\\V1\\Rest\\ReferenceImage\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Image\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Country\\Controller' => 'HalJson',
            'api\\V1\\Rest\\State\\Controller' => 'HalJson',
            'api\\V1\\Rest\\City\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Address\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Configuration\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Plan\\Controller' => 'HalJson',
            'api\\V1\\Rest\\UserPlan\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Account\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Bank\\Controller' => 'HalJson',
            'api\\V1\\Rest\\PaymentMethod\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Wallet\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Transaction\\Controller' => 'HalJson',
            'api\\V1\\Rest\\Cycle\\Controller' => 'HalJson',
            'api\\V1\\Rest\\CategoryTransaction\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'api\\V1\\Rest\\User\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Role\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Resource\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Action\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Privilege\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Possibility\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\CategoryImage\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\ReferenceImage\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Image\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Country\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\State\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\City\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Address\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Configuration\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Plan\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\UserPlan\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Account\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Bank\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\PaymentMethod\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Wallet\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Transaction\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\Cycle\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'api\\V1\\Rest\\CategoryTransaction\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'api\\V1\\Rest\\User\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Role\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Resource\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Action\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Privilege\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Possibility\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\CategoryImage\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\ReferenceImage\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Image\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Country\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\State\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\City\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Address\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Configuration\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Plan\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\UserPlan\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Account\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Bank\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\PaymentMethod\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Wallet\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Transaction\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\Cycle\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
            'api\\V1\\Rest\\CategoryTransaction\\Controller' => [
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Register\Entity\User::class => [
                'route_identifier_name' => 'user_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.user',
                'hydrator' => 'api\\V1\\Rest\\User\\UserHydrator',
            ],
            \api\V1\Rest\User\UserCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.user',
                'is_collection' => true,
            ],
            \Acl\Entity\Role::class => [
                'route_identifier_name' => 'role_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.role',
                'hydrator' => 'api\\V1\\Rest\\Role\\RoleHydrator',
            ],
            \api\V1\Rest\Role\RoleCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.role',
                'is_collection' => true,
            ],
            \Acl\Entity\Resource::class => [
                'route_identifier_name' => 'resource_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.resource',
                'hydrator' => 'api\\V1\\Rest\\Resource\\ResourceHydrator',
            ],
            \api\V1\Rest\Resource\ResourceCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.resource',
                'is_collection' => true,
            ],
            \Acl\Entity\Action::class => [
                'route_identifier_name' => 'action_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.action',
                'hydrator' => 'api\\V1\\Rest\\Action\\ActionHydrator',
            ],
            \api\V1\Rest\Action\ActionCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.action',
                'is_collection' => true,
            ],
            \Acl\Entity\Privilege::class => [
                'route_identifier_name' => 'privilege_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.privilege',
                'hydrator' => 'api\\V1\\Rest\\Privilege\\PrivilegeHydrator',
            ],
            \api\V1\Rest\Privilege\PrivilegeCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.privilege',
                'is_collection' => true,
            ],
            \Acl\Entity\Possibility::class => [
                'route_identifier_name' => 'possibility_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.possibility',
                'hydrator' => 'api\\V1\\Rest\\Possibility\\PossibilityHydrator',
            ],
            \api\V1\Rest\Possibility\PossibilityCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.possibility',
                'is_collection' => true,
            ],
            'Register\\Entity\\CategoryImage' => [
                'route_identifier_name' => 'category_image_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.category-image',
                'hydrator' => 'api\\V1\\Rest\\CategoryImage\\CategoryImageHydrator',
            ],
            \api\V1\Rest\CategoryImage\CategoryImageCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.category-image',
                'is_collection' => true,
            ],
            'Register\\Entity\\ReferenceImage' => [
                'route_identifier_name' => 'reference_image_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.reference-image',
                'hydrator' => 'api\\V1\\Rest\\ReferenceImage\\ReferenceImageHydrator',
            ],
            \api\V1\Rest\ReferenceImage\ReferenceImageCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.reference-image',
                'is_collection' => true,
            ],
            'Register\\Entity\\Image' => [
                'route_identifier_name' => 'image_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.image',
                'hydrator' => 'api\\V1\\Rest\\Image\\ImageHydrator',
            ],
            \api\V1\Rest\Image\ImageCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.image',
                'is_collection' => true,
            ],
            \Address\Entity\Country::class => [
                'route_identifier_name' => 'country_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.country',
                'hydrator' => 'api\\V1\\Rest\\Country\\CountryHydrator',
            ],
            \api\V1\Rest\Country\CountryCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.country',
                'is_collection' => true,
            ],
            \Address\Entity\State::class => [
                'route_identifier_name' => 'state_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.state',
                'hydrator' => 'api\\V1\\Rest\\State\\StateHydrator',
            ],
            \api\V1\Rest\State\StateCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.state',
                'is_collection' => true,
            ],
            \Address\Entity\City::class => [
                'route_identifier_name' => 'city_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.city',
                'hydrator' => 'api\\V1\\Rest\\City\\CityHydrator',
            ],
            \api\V1\Rest\City\CityCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.city',
                'is_collection' => true,
            ],
            \Address\Entity\Address::class => [
                'route_identifier_name' => 'address_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.address',
                'hydrator' => 'api\\V1\\Rest\\Address\\AddressHydrator',
            ],
            \api\V1\Rest\Address\AddressCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.address',
                'is_collection' => true,
            ],
            \Configuration\Entity\Configuration::class => [
                'route_identifier_name' => 'configuration_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.configuration',
                'hydrator' => 'api\\V1\\Rest\\Configuration\\ConfigurationHydrator',
            ],
            \api\V1\Rest\Configuration\ConfigurationCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.configuration',
                'is_collection' => true,
            ],
            \Plan\Entity\Plan::class => [
                'route_identifier_name' => 'plan_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.plan',
                'hydrator' => 'api\\V1\\Rest\\Plan\\PlanHydrator',
            ],
            \api\V1\Rest\Plan\PlanCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.plan',
                'is_collection' => true,
            ],
            \UserPlan\Entity\UserPlan::class => [
                'route_identifier_name' => 'user_plan_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.user-plan',
                'hydrator' => 'api\\V1\\Rest\\UserPlan\\UserPlanHydrator',
            ],
            \api\V1\Rest\UserPlan\UserPlanCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.user-plan',
                'is_collection' => true,
            ],
            \Account\Entity\Account::class => [
                'route_identifier_name' => 'account_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.account',
                'hydrator' => 'api\\V1\\Rest\\Account\\AccountHydrator',
            ],
            \api\V1\Rest\Account\AccountCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.account',
                'is_collection' => true,
            ],
            \Bank\Entity\Bank::class => [
                'route_identifier_name' => 'bank_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.bank',
                'hydrator' => 'api\\V1\\Rest\\Bank\\BankHydrator',
            ],
            \api\V1\Rest\Bank\BankCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.bank',
                'is_collection' => true,
            ],
            \PaymentMethod\Entity\PaymentMethod::class => [
                'route_identifier_name' => 'payment_method_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.payment-method',
                'hydrator' => 'api\\V1\\Rest\\PaymentMethod\\PaymentMethodHydrator',
            ],
            \api\V1\Rest\PaymentMethod\PaymentMethodCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.payment-method',
                'is_collection' => true,
            ],
            \Wallet\Entity\Wallet::class => [
                'route_identifier_name' => 'wallet_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.wallet',
                'hydrator' => 'api\\V1\\Rest\\Wallet\\WalletHydrator',
            ],
            \api\V1\Rest\Wallet\WalletCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.wallet',
                'is_collection' => true,
            ],
            \Transaction\Entity\Transaction::class => [
                'route_identifier_name' => 'transaction_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.transaction',
                'hydrator' => 'api\\V1\\Rest\\Transaction\\TransactionHydrator',
            ],
            \api\V1\Rest\Transaction\TransactionCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.transaction',
                'is_collection' => true,
            ],
            \Cycle\Entity\Cycle::class => [
                'route_identifier_name' => 'cycle_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.cycle',
                'hydrator' => 'api\\V1\\Rest\\Cycle\\CycleHydrator',
            ],
            \api\V1\Rest\Cycle\CycleCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.cycle',
                'is_collection' => true,
            ],
            \CategoryTransaction\Entity\CategoryTransaction::class => [
                'route_identifier_name' => 'category_transaction_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.category-transaction',
                'hydrator' => 'api\\V1\\Rest\\CategoryTransaction\\CategoryTransactionHydrator',
            ],
            \api\V1\Rest\CategoryTransaction\CategoryTransactionCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.doctrine.category-transaction',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-apigility' => [
        'doctrine-connected' => [
            \api\V1\Rest\User\UserResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\User\\UserHydrator',
            ],
            \api\V1\Rest\Role\RoleResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Role\\RoleHydrator',
            ],
            \api\V1\Rest\Resource\ResourceResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Resource\\ResourceHydrator',
            ],
            \api\V1\Rest\Action\ActionResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Action\\ActionHydrator',
            ],
            \api\V1\Rest\Privilege\PrivilegeResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Privilege\\PrivilegeHydrator',
            ],
            \api\V1\Rest\Possibility\PossibilityResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Possibility\\PossibilityHydrator',
            ],
            \api\V1\Rest\CategoryImage\CategoryImageResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\CategoryImage\\CategoryImageHydrator',
            ],
            \api\V1\Rest\ReferenceImage\ReferenceImageResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\ReferenceImage\\ReferenceImageHydrator',
            ],
            \api\V1\Rest\Image\ImageResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Image\\ImageHydrator',
            ],
            \api\V1\Rest\Country\CountryResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Country\\CountryHydrator',
            ],
            \api\V1\Rest\State\StateResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\State\\StateHydrator',
            ],
            \api\V1\Rest\City\CityResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\City\\CityHydrator',
            ],
            \api\V1\Rest\Address\AddressResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Address\\AddressHydrator',
            ],
            \api\V1\Rest\Configuration\ConfigurationResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Configuration\\ConfigurationHydrator',
            ],
            \api\V1\Rest\Plan\PlanResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Plan\\PlanHydrator',
            ],
            \api\V1\Rest\UserPlan\UserPlanResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\UserPlan\\UserPlanHydrator',
            ],
            \api\V1\Rest\Account\AccountResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Account\\AccountHydrator',
            ],
            \api\V1\Rest\Bank\BankResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Bank\\BankHydrator',
            ],
            \api\V1\Rest\PaymentMethod\PaymentMethodResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\PaymentMethod\\PaymentMethodHydrator',
            ],
            \api\V1\Rest\Wallet\WalletResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Wallet\\WalletHydrator',
            ],
            \api\V1\Rest\Transaction\TransactionResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Transaction\\TransactionHydrator',
            ],
            \api\V1\Rest\Cycle\CycleResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\Cycle\\CycleHydrator',
            ],
            \api\V1\Rest\CategoryTransaction\CategoryTransactionResource::class => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'hydrator' => 'api\\V1\\Rest\\CategoryTransaction\\CategoryTransactionHydrator',
            ],
        ],
    ],
    'doctrine-hydrator' => [
        'api\\V1\\Rest\\User\\UserHydrator' => [
            'entity_class' => \Register\Entity\User::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Role\\RoleHydrator' => [
            'entity_class' => \Acl\Entity\Role::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Resource\\ResourceHydrator' => [
            'entity_class' => \Acl\Entity\Resource::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Action\\ActionHydrator' => [
            'entity_class' => \Acl\Entity\Action::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Privilege\\PrivilegeHydrator' => [
            'entity_class' => \Acl\Entity\Privilege::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Possibility\\PossibilityHydrator' => [
            'entity_class' => \Acl\Entity\Possibility::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\CategoryImage\\CategoryImageHydrator' => [
            'entity_class' => 'Register\\Entity\\CategoryImage',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\ReferenceImage\\ReferenceImageHydrator' => [
            'entity_class' => 'Register\\Entity\\ReferenceImage',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Image\\ImageHydrator' => [
            'entity_class' => 'Register\\Entity\\Image',
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Country\\CountryHydrator' => [
            'entity_class' => \Address\Entity\Country::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\State\\StateHydrator' => [
            'entity_class' => \Address\Entity\State::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\City\\CityHydrator' => [
            'entity_class' => \Address\Entity\City::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Address\\AddressHydrator' => [
            'entity_class' => \Address\Entity\Address::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Configuration\\ConfigurationHydrator' => [
            'entity_class' => \Configuration\Entity\Configuration::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Plan\\PlanHydrator' => [
            'entity_class' => \Plan\Entity\Plan::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\UserPlan\\UserPlanHydrator' => [
            'entity_class' => \UserPlan\Entity\UserPlan::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Account\\AccountHydrator' => [
            'entity_class' => \Account\Entity\Account::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Bank\\BankHydrator' => [
            'entity_class' => \Bank\Entity\Bank::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\PaymentMethod\\PaymentMethodHydrator' => [
            'entity_class' => \PaymentMethod\Entity\PaymentMethod::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Wallet\\WalletHydrator' => [
            'entity_class' => \Wallet\Entity\Wallet::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Transaction\\TransactionHydrator' => [
            'entity_class' => \Transaction\Entity\Transaction::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\Cycle\\CycleHydrator' => [
            'entity_class' => \Cycle\Entity\Cycle::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
        'api\\V1\\Rest\\CategoryTransaction\\CategoryTransactionHydrator' => [
            'entity_class' => \CategoryTransaction\Entity\CategoryTransaction::class,
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'by_value' => true,
            'strategies' => [],
            'use_generated_hydrator' => true,
        ],
    ],
    'zf-content-validation' => [
        'api\\V1\\Rest\\User\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\User\\Validator',
        ],
        'api\\V1\\Rest\\Role\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Role\\Validator',
        ],
        'api\\V1\\Rest\\Resource\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Resource\\Validator',
        ],
        'api\\V1\\Rest\\Action\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Action\\Validator',
        ],
        'api\\V1\\Rest\\Privilege\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Privilege\\Validator',
        ],
        'api\\V1\\Rest\\Possibility\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Possibility\\Validator',
        ],
        'api\\V1\\Rest\\CategoryImage\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\CategoryImage\\Validator',
        ],
        'api\\V1\\Rest\\ReferenceImage\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\ReferenceImage\\Validator',
        ],
        'api\\V1\\Rest\\Image\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Image\\Validator',
        ],
        'api\\V1\\Rest\\Country\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Country\\Validator',
        ],
        'api\\V1\\Rest\\State\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\State\\Validator',
        ],
        'api\\V1\\Rest\\City\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\City\\Validator',
        ],
        'api\\V1\\Rest\\Address\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Address\\Validator',
        ],
        'api\\V1\\Rest\\Configuration\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Configuration\\Validator',
        ],
        'api\\V1\\Rest\\Plan\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Plan\\Validator',
        ],
        'api\\V1\\Rest\\UserPlan\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\UserPlan\\Validator',
        ],
        'api\\V1\\Rest\\Account\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Account\\Validator',
        ],
        'api\\V1\\Rest\\Bank\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Bank\\Validator',
        ],
        'api\\V1\\Rest\\PaymentMethod\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\PaymentMethod\\Validator',
        ],
        'api\\V1\\Rest\\Wallet\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Wallet\\Validator',
        ],
        'api\\V1\\Rest\\Transaction\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Transaction\\Validator',
        ],
        'api\\V1\\Rest\\Cycle\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\Cycle\\Validator',
        ],
        'api\\V1\\Rest\\CategoryTransaction\\Controller' => [
            'input_filter' => 'api\\V1\\Rest\\CategoryTransaction\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'api\\V1\\Rest\\User\\Validator' => [
            0 => [
                'name' => 'type_user',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            1 => [
                'name' => 'document',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            2 => [
                'name' => 'name',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            3 => [
                'name' => 'email',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            4 => [
                'name' => 'phone',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            5 => [
                'name' => 'celphone',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            6 => [
                'name' => 'password',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            7 => [
                'name' => 'salt',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            8 => [
                'name' => 'active',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            9 => [
                'name' => 'activationKey',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            10 => [
                'name' => 'updatedAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            11 => [
                'name' => 'createdAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            12 => [
                'name' => 'isAdmin',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            13 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'image',
            ],
            14 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'id',
            ],
            15 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'birthdate',
            ],
            16 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'gender',
            ],
        ],
        'api\\V1\\Rest\\Role\\Validator' => [
            0 => [
                'name' => 'name',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            1 => [
                'name' => 'isAdmin',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'createdAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            3 => [
                'name' => 'updatedAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
        ],
        'api\\V1\\Rest\\Resource\\Validator' => [
            0 => [
                'name' => 'updatedAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            1 => [
                'name' => 'createdAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'name',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
        ],
        'api\\V1\\Rest\\Action\\Validator' => [
            0 => [
                'name' => 'name',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            1 => [
                'name' => 'createdAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'updatedAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
        ],
        'api\\V1\\Rest\\Privilege\\Validator' => [
            0 => [
                'name' => 'name',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            1 => [
                'name' => 'createdAt',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'updatedAt',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
        ],
        'api\\V1\\Rest\\Possibility\\Validator' => [
            0 => [
                'name' => 'createdAt',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            1 => [
                'name' => 'updatedAt',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
        ],
        'api\\V1\\Rest\\CategoryImage\\Validator' => [
            0 => [
                'name' => 'name',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 225,
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'chave',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 225,
                        ],
                    ],
                ],
            ],
        ],
        'api\\V1\\Rest\\ReferenceImage\\Validator' => [
            0 => [
                'name' => 'name',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 225,
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'chave',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 225,
                        ],
                    ],
                ],
            ],
        ],
        'api\\V1\\Rest\\Image\\Validator' => [
            0 => [
                'name' => 'title',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            1 => [
                'name' => 'image',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 225,
                        ],
                    ],
                ],
            ],
            2 => [
                'name' => 'reference_id',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 225,
                        ],
                    ],
                ],
            ],
            3 => [
                'name' => 'featured',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
        ],
        'api\\V1\\Rest\\Country\\Validator' => [
            0 => [
                'name' => 'updatedAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            1 => [
                'name' => 'createdAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'name',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            3 => [
                'name' => 'abbreviation',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
        ],
        'api\\V1\\Rest\\State\\Validator' => [
            0 => [
                'name' => 'updatedAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            1 => [
                'name' => 'createdAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'name',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            3 => [
                'name' => 'uf',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 10,
                        ],
                    ],
                ],
            ],
        ],
        'api\\V1\\Rest\\City\\Validator' => [
            0 => [
                'name' => 'updatedAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            1 => [
                'name' => 'createdAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'name',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            3 => [
                'name' => 'code',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
        ],
        'api\\V1\\Rest\\Address\\Validator' => [
            0 => [
                'name' => 'updatedAt',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            1 => [
                'name' => 'createdAt',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'number',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            3 => [
                'name' => 'neighborhood',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            4 => [
                'name' => 'zip_code',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            5 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'user',
            ],
            6 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'address',
            ],
            7 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'complement',
            ],
            8 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'country',
            ],
            9 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'state',
            ],
            10 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'city',
            ],
            11 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'id',
            ],
        ],
        'api\\V1\\Rest\\Configuration\\Validator' => [
            0 => [
                'name' => 'title',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 225,
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'chave',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'value',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            3 => [
                'name' => 'editable',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            4 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'id',
            ],
        ],
        'api\\V1\\Rest\\Plan\\Validator' => [
            0 => [
                'name' => 'name',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'price',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'active',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            3 => [
                'name' => 'updatedAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            4 => [
                'name' => 'createdAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            5 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'bitcoin_payment_url',
            ],
        ],
        'api\\V1\\Rest\\UserPlan\\Validator' => [
            0 => [
                'name' => 'receipt',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'status',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\Digits::class,
                    ],
                ],
                'validators' => [],
            ],
            2 => [
                'name' => 'updated_at',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            3 => [
                'name' => 'created_at',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            4 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'user',
            ],
            5 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'plan',
            ],
            6 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'payment_method',
            ],
            7 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'wallet',
            ],
            8 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'account',
            ],
            9 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'first_cycle',
            ],
            10 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'status_str',
            ],
            11 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'approved_date',
            ],
        ],
        'api\\V1\\Rest\\Account\\Validator' => [
            0 => [
                'name' => 'agency',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'account_number',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            2 => [
                'name' => 'type',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            3 => [
                'name' => 'operation',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            4 => [
                'name' => 'type_account',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            5 => [
                'name' => 'cnpj',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            6 => [
                'name' => 'updated_at',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            7 => [
                'name' => 'created_at',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            8 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'id',
            ],
            9 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'bank',
            ],
            10 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'user',
            ],
            11 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'holder',
            ],
            12 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'type_account',
            ],
        ],
        'api\\V1\\Rest\\Bank\\Validator' => [
            0 => [
                'name' => 'name',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'active',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'updatedAt',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            3 => [
                'name' => 'createdAt',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
        ],
        'api\\V1\\Rest\\PaymentMethod\\Validator' => [
            0 => [
                'name' => 'name',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'active',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'updatedAt',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            3 => [
                'name' => 'createdAt',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
        ],
        'api\\V1\\Rest\\Wallet\\Validator' => [
            0 => [
                'name' => 'account',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'active',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'updated_at',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            3 => [
                'name' => 'created_at',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            4 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'id',
            ],
            5 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'user',
            ],
        ],
        'api\\V1\\Rest\\Transaction\\Validator' => [
            0 => [
                'name' => 'type',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            1 => [
                'name' => 'value',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'name' => 'date',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            3 => [
                'name' => 'updated_at',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            4 => [
                'name' => 'created_at',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
        ],
        'api\\V1\\Rest\\Cycle\\Validator' => [
            0 => [
                'name' => 'month',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\Digits::class,
                    ],
                ],
                'validators' => [],
            ],
            1 => [
                'name' => 'year',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\Digits::class,
                    ],
                ],
                'validators' => [],
            ],
            2 => [
                'name' => 'status',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\Digits::class,
                    ],
                ],
                'validators' => [],
            ],
            3 => [
                'name' => 'updatedAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            4 => [
                'name' => 'createdAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
        ],
        'api\\V1\\Rest\\CategoryTransaction\\Validator' => [
            0 => [
                'name' => 'name',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'code',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => 255,
                        ],
                    ],
                ],
            ],
            2 => [
                'name' => 'updatedAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
            3 => [
                'name' => 'createdAt',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ],
        ],
    ],
];
