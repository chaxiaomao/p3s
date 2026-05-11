<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
// $directoryAsset = \Yii::$app->czaHelper->getEnvData('AdminlteAssets');
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="<?= Yii::t('app.c2', 'Search...') ?>"/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i
                                class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>

        <!-- /.search form -->
        <?=
        \common\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu', "data-widget" => "tree"],
                'linkTemplate' => '<a href="{url}" {targetPlaceHolder}>{icon} {label}</a>',
                'items' => [
                    ['label' => 'CL-菜单', 'options' => ['class' => 'header'],  'visible' => \Yii::$app->user->can('P_CL'),],
                    [ 'label' => '生产物料预算', 'icon' => 'fa fa-circle-o', 'url' => ['/cl/product-schedule/cost-sheet'],  'visible' => \Yii::$app->user->can('P_CL')],
                    [
                        'label' => 'CL-资料库', 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                        'visible' => \Yii::$app->user->can('P_CL_PRODUCT'),
                        'items' => [
                            [
                                'label' => 'CL-产品管理', 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                                'items' => [
                                    ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Material')]), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/database/material']],
                                    ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Sales Product')]), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/database/product']],
                                    ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Product Combinations')]), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/database/product-combination']],
                                ]
                            ],
                        ]
                    ],
                    [
                        'label' => 'CL-生产/加工', 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                        'visible' => (\Yii::$app->user->can('P_CL_PAM') && \Yii::$app->user->can('P_CL')),
                        'items' => [
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Production Schedule')]), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/pam/production-schedule'], 'visible' => \Yii::$app->user->can('P_CL_PRODUCT_SCHEDULE')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Mixture Schedule')]), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/pam/mixture-schedule'], 'visible' => \Yii::$app->user->can('P_CL_MIXTURE_SCHEDULE')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Process Schedule')]), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/pam/process-schedule'], 'visible' => \Yii::$app->user->can('P_CL_PROCESS_SCHEDULE')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Order Items')]), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/pam/order-item'], 'visible' => \Yii::$app->user->can('P_SYSTEM')],
                            // ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Attributeset')]), 'icon' => 'fa fa-circle-o', 'url' => ['/database/attributeset']],
                        ]
                    ],
                    [
                        'label' => 'CL-' . Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Finance')]), 'visible' => \Yii::$app->user->can('P_CL_FINANCE'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                        'items' => [
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Sales Order')]), 'visible' => \Yii::$app->user->can('P_CL_ORDER'), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/p3s/order']],
                            // ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Order Item Consumption')]), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/order/order-item-consumption']],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Inventory Receipt Note')]), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/p3s/inventory/receipt-note'], 'visible' => \Yii::$app->user->can('P_CL_PURCHASE')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Inventory Delivery Note')]), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/p3s/inventory/delivery-note'], 'visible' => \Yii::$app->user->can('P_CL_DELIVERY')],
                            // ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Warehouse Note')]), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/warehouse-note/default/index'], 'visible' => \Yii::$app->user->can('P_WAREHOUSE_NOTE')],
                        ]
                    ],
                    [
                        'label' => 'CL-' . Yii::t('app.c2', 'Statics'), 'visible' => \Yii::$app->user->can('P_CL_STATICS'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                        'items' => [
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Sales Product Statics')]), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/statics/sales-product'], 'visible' => \Yii::$app->user->can('P_CL_STATICS_SALES')],
                            // ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Warehouse Commit Note Statics')]), 'icon' => 'fa fa-circle-o', 'url' => ['/statics/warehouse-commit-note']],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Receipt Items Statics')]), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/statics/receipt-items'], 'visible' => \Yii::$app->user->can('P_CL_STATICS_PURCHASE')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Delivery Items Statics')]), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/statics/delivery-items'], 'visible' => \Yii::$app->user->can('P_CL_STATICS_DELIVERY')],
                            // ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Warehouse Commit Log')]), 'icon' => 'fa fa-circle-o', 'url' => ['/cl/p3s/warehouse-note/default/log']],
                        ]
                    ],
                    // ['label' => Yii::t('app.c2', 'Resume'), 'icon' => 'fa fa-circle-o', 'url' => ['/resume']],

                    ['label' => Yii::t('app.c2', 'Menu'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('app.c2', 'Dashboard'), 'icon' => 'fa fa-circle-o', 'url' => ['/']],
                    [
                        'label' => Yii::t('app.c2', 'Database'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                        'visible' => \Yii::$app->user->can('P_PRODUCT'),
                        'items' => [
                            [
                                'label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Product')]), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                                'items' => [
                                    ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Material')]), 'icon' => 'fa fa-circle-o', 'url' => ['/database/material']],
                                    ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Sales Product')]), 'icon' => 'fa fa-circle-o', 'url' => ['/database/product']],
                                    ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Product Combinations')]), 'icon' => 'fa fa-circle-o', 'url' => ['/database/product-combination']],
                                ]
                            ],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Category')]), 'icon' => 'fa fa-circle-o', 'url' => ['/database/product-category'], 'visible' => \Yii::$app->user->can('P_PRODUCT')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Customer')]), 'icon' => 'fa fa-circle-o', 'url' => ['/database/user'], 'visible' => \Yii::$app->user->can('P_SYSTEM') || \Yii::$app->user->can('P_USER')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Supplier')]), 'icon' => 'fa fa-circle-o', 'url' => ['/database/supplier'], 'visible' => \Yii::$app->user->can('P_SYSTEM') || \Yii::$app->user->can('P_SUPPILER')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Measure')]), 'icon' => 'fa fa-circle-o', 'url' => ['/logistics/measure'], 'visible' => \Yii::$app->user->can('P_SYSTEM')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Currency')]), 'icon' => 'fa fa-circle-o', 'url' => ['/logistics/currency'], 'visible' => \Yii::$app->user->can('P_SYSTEM')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Warehouse')]), 'icon' => 'fa fa-circle-o', 'url' => ['/database/warehouse'], 'visible' => \Yii::$app->user->can('P_SYSTEM')],
                            // ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Attributeset')]), 'icon' => 'fa fa-circle-o', 'url' => ['/database/attributeset']],
                        ]
                    ],
                    [
                        'label' => Yii::t('app.c2', 'Process/Machining'), 'visible' => \Yii::$app->user->can('P_PAM'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                        'items' => [
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Production Schedule')]), 'icon' => 'fa fa-circle-o', 'url' => ['/pam/production-schedule'], 'visible' => \Yii::$app->user->can('P_PRODUCT_SCHEDULE')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Mixture Schedule')]), 'icon' => 'fa fa-circle-o', 'url' => ['/pam/mixture-schedule'], 'visible' => \Yii::$app->user->can('P_MIXTURE_SCHEDULE')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Process Schedule')]), 'icon' => 'fa fa-circle-o', 'url' => ['/pam/process-schedule'], 'visible' => \Yii::$app->user->can('P_PROCESS_SCHEDULE')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Order Items')]), 'icon' => 'fa fa-circle-o', 'url' => ['/pam/order-item'], 'visible' => \Yii::$app->user->can('P_SYSTEM')],
                            // ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Attributeset')]), 'icon' => 'fa fa-circle-o', 'url' => ['/database/attributeset']],
                        ]
                    ],
                    [
                        'label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Finance')]), 'visible' => \Yii::$app->user->can('P_FINANCE'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                        'items' => [
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Sales Order')]), 'visible' => \Yii::$app->user->can('P_ORDER'), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/order']],
                            // ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Order Item Consumption')]), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/order/order-item-consumption']],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Inventory Receipt Note')]), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/inventory/receipt-note'], 'visible' => \Yii::$app->user->can('P_PURCHASE')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Inventory Delivery Note')]), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/inventory/delivery-note'], 'visible' => \Yii::$app->user->can('P_DELIVERY')],
                            // ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Warehouse Note')]), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/warehouse-note/default/index'], 'visible' => \Yii::$app->user->can('P_WAREHOUSE_NOTE')],
                        ]
                    ],
                    ['label' => Yii::t('app.c2', 'Logs'), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/inventory/logs'], 'visible' => \Yii::$app->user->can('P_SYSTEM')],
                    // [
                    //     'label' => Yii::t('app.c2', 'Purchase Sale Storage System'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                    //     'visible' => \Yii::$app->user->can('P_FINANCE'),
                    //     'items' => [
                    //         [
                    //             'label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Finance')]), 'visible' => \Yii::$app->user->can('P_Finance'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                    //             'items' => [
                    //                 ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Sales Order')]), 'visible' => \Yii::$app->user->can('P_Order'), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/order']],
                    //                 // ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Order Item Consumption')]), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/order/order-item-consumption']],
                    //                 ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Inventory Receipt Note')]), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/inventory/receipt-note'], 'visible' => \Yii::$app->user->can('P_PURCHASE')],
                    //                 ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Inventory Delivery Note')]), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/inventory/delivery-note']],
                    //             ]
                    //         ],
                    //         // [
                    //         //     'label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Warehouse')]), 'visible' => \Yii::$app->user->can('P_Warehouse'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                    //         //     'items' => [
                    //         //         // ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Product Stock')]), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/product-stock']],
                    //         //         ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Pending Inventory Receipt Note')]), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/processing/receipt-note']],
                    //         //         // ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Pending Inventory Delivery Note')]), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/processing/delivery-note']],
                    //         //     ]
                    //         // ],
                    //         ['label' => Yii::t('app.c2', 'Logs'), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/inventory/logs']],
                    //     ]
                    // ],
                    [
                        'label' => Yii::t('app.c2', 'Statics'), 'visible' => \Yii::$app->user->can('P_STATICS'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                        'items' => [
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Sales Product Statics')]), 'icon' => 'fa fa-circle-o', 'url' => ['/statics/sales-product'], 'visible' => \Yii::$app->user->can('P_STATICS_SALES')],
                            // ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Warehouse Commit Note Statics')]), 'icon' => 'fa fa-circle-o', 'url' => ['/statics/warehouse-commit-note']],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Receipt Items Statics')]), 'icon' => 'fa fa-circle-o', 'url' => ['/statics/receipt-items'], 'visible' => \Yii::$app->user->can('P_STATICS_PURCHASE')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Delivery Items Statics')]), 'icon' => 'fa fa-circle-o', 'url' => ['/statics/delivery-items'], 'visible' => \Yii::$app->user->can('P_STATICS_DELIVERY')],
                            ['label' => Yii::t('app.c2', '{s1} Management', ['s1' => Yii::t('app.c2', 'Warehouse Commit Log')]), 'icon' => 'fa fa-circle-o', 'url' => ['/p3s/warehouse-note/default/log']],
                        ]
                    ],
                    [
                        'label' => Yii::t('app.c2', 'System'), 'visible' => \Yii::$app->user->can('P_SYSTEM'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                        'items' => [
                            ['label' => Yii::t('app.c2', 'Configuration'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                                'items' => [
                                    // ['label' => Yii::t('app.c2', 'Merchant Management'), 'icon' => 'fa fa-circle-o', 'url' => ['/crm/merchant'],],
                                    // ['label' => Yii::t('app.c2', 'Params Settings'), 'icon' => 'fa fa-circle-o', 'url' => ['/sys/config/default/params-settings']],
                                    ['label' => Yii::t('app.c2', 'Common Resource'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                                        'items' => [
                                            ['label' => Yii::t('app.c2', 'Attachement Management'), 'icon' => 'fa fa-circle-o', 'url' => ['/sys/common-resource/attachment'],],
                                            ['label' => Yii::t('app.c2', 'Global Settings'), 'icon' => 'fa fa-circle-o', 'url' => ['/sys/config']],
                                        ]
                                    ],
                                    // ['label' => Yii::t('app.c2', 'Transfer Settings'), 'icon' => 'fa fa-circle-o', 'url' => ['/sys/config/default/transfer-settings']],
                                    // ['label' => Yii::t('app.c2', 'Api'), 'icon' => 'fa fa-circle-o', 'url' => ['/api']],
                                ]
                            ],
                            ['label' => Yii::t('app.c2', 'Security'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                                'items' => [
                                    ['label' => Yii::t('app.c2', 'Users & Rbac'), 'icon' => 'fa fa-circle-o', 'url' => ['/user/admin']],
                                ]
                            ],
                            //                            ['label' => Yii::t('app.c2', 'Task Manage'), 'icon' => 'fa fa-circle-o', 'url' => ['/task/cron']],
                        ]
                    ],
                    [
                        'label' => Yii::t('app.c2', 'Logistics'), 'icon' => 'fa fa-circle-o', 'url' => ['#'], 'options' => ['class' => 'treeview'],
                        'items' => [
                            ['label' => Yii::t('app.c2', 'Region'), 'icon' => 'fa fa-circle-o', 'url' => ['/logistics/region']],
                        ]
                    ],
                    ['label' => Yii::t('app.c2', 'Sign out'), 'icon' => 'fa fa-sign-out', 'url' => ['/user/logout']],
                ],
            ]
        )
        ?>

    </section>

</aside>
