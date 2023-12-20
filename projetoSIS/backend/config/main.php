<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/produto',
                    'extraPatterns' => [
                        'GET imagens' => 'imagens',
                        'GET nomecategoria/{nomecategoria}' => 'produtoporcategoria',
                        'GET receita/{valor}' => 'produtoreceita',
                        'GET medicamentos'  => 'medicamentos',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{data}' => '<data:\d{4}-\d{2}-\d{2}>',
                        '{nomecategoria}' => '<nomecategoria:[\w\s]+>',
                        '{nomeproduto}' => '<nomeproduto:[\w\s]+>',
                        '{valor}' => '<valor:[\w\s]+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/fatura',
                    'extraPatterns' => [
                        'GET faturacliente/{id}' => 'faturasporcliente',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/user',
                    'extraPatterns' => [
                        'GET clientes' => 'clientes',
                        'GET funcionarios' => 'funcionarios',
                        'GET estatisticas/{id}' => 'estatisticas',
                        'GET estatisticas/contarcompras/{id}' => 'contarcompras',
                        'POST criarusers' => 'criarusers',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/receitamedica',
                    'extraPatterns' => [
                        'GET receitacliente/{clienteid}' => 'minhareceita',
                        'GET receitasvalidas' => 'receitasvalidas',
                    ],
                    'tokens' => [
                        '{clienteid}' => '<clienteid:\\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/servico',
                    'extraPatterns' => [
                        'GET servicoestabelecimento/{nomeestabelecimento}' => 'servicosporestabelecimento',
                    ],
                    'tokens' => [
                        '{nomeestabelecimento}' => '<nomeestabelecimento:[\w\s]+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/despesa',
                    'extraPatterns' => [
                        'GET despesaestabelecimento/{precoMin}/{precoMax}' => 'despesasentreprecos',
                    ],
                    'tokens' => [
                        '{precoMin}' => '<precoMin:\d+>',
                        '{precoMax}' => '<precoMax:\d+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/login',
                    'extraPatterns' => [
                        'POST loginuser' => 'login',
                    ],
                    'tokens' => [
                        '{username}' => '<username:[\w\s]+>',
                        '{password}' => '<password:[\w\s*.]+>'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/carrinhocompra',
                    'extraPatterns' => [
                        'GET carrinhoatual/{id}' => 'carrinhocompra',
                        'GET carrinhos/{id}' => 'carrinhos',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
