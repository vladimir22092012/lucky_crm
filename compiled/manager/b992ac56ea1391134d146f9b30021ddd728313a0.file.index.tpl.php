<?php /* Smarty version Smarty-3.1.18, created on 2022-06-29 18:03:59
         compiled from "/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:69163134362bb414f886b67-22856955%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b992ac56ea1391134d146f9b30021ddd728313a0' => 
    array (
      0 => '/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/index.tpl',
      1 => 1656484110,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '69163134362bb414f886b67-22856955',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_62bb414f8ee603_90017621',
  'variables' => 
  array (
    'config' => 0,
    'meta_title' => 0,
    'canonical' => 0,
    'settings' => 0,
    'manager' => 0,
    'active_notifications' => 0,
    'penalty_notifications' => 0,
    'missings_notifications' => 0,
    'mn' => 0,
    'an' => 0,
    'pn' => 0,
    'is_developer' => 0,
    'offline' => 0,
    'module' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62bb414f8ee603_90017621')) {function content_62bb414f8ee603_90017621($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?php echo $_smarty_tpl->tpl_vars['config']->value->root_url;?>
/"/>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" href="/favicon.ico"/>
    <title><?php echo $_smarty_tpl->tpl_vars['meta_title']->value;?>
</title>

    <?php if ($_smarty_tpl->tpl_vars['canonical']->value) {?>
        <link rel="canonical" href="<?php echo $_smarty_tpl->tpl_vars['canonical']->value;?>
"/>
    <?php }?>
    <!-- Custom CSS -->
    <?php echo Smarty::$_smarty_vars['capture']['page_styles'];?>

    <!-- Bootstrap Core CSS -->
    <link href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/bootstrap/css/bootstrap.min.css?v=1.02" rel="stylesheet">
    <!--alerts CSS -->
    <link href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/sweetalert2/dist/sweetalert2.min.css?v=1.02"
          rel="stylesheet">

    <link href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/css/style.css?v=1.03" rel="stylesheet">
    <link href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/css/colors/default.css?v=1.02" id="theme" rel="stylesheet">
    <link href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/css/custom.css?v=1.06" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        var _front_url = '<?php echo $_smarty_tpl->tpl_vars['config']->value->front_url;?>
';
    </script>
</head>

<body class="fix-header fix-sidebar card-no-border">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->


<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav mr-auto mt-md-0 ">
                    <!-- This is  -->
                    <li class="nav-item"><a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark"
                                            href="javascript:void(0)"><i class="ti-menu"></i></a></li>
                    <li class="nav-item"><a
                                class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark"
                                href="javascript:void(0)"><i class="icon-arrow-left-circle"></i></a></li>

                    <?php if (in_array('notifications',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('penalties',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href=""
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-message"></i>
                                <?php if ($_smarty_tpl->tpl_vars['active_notifications']->value||$_smarty_tpl->tpl_vars['penalty_notifications']->value) {?>
                                    <div class="notify">
                                        <span class="heartbit"></span>
                                        <span class="point"></span>
                                    </div>
                                <?php }?>
                            </a>
                            <div class="dropdown-menu mailbox animated bounceInDown">
                                <ul>
                                    <?php if ($_smarty_tpl->tpl_vars['missings_notifications']->value) {?>
                                        <li>
                                            <div class="drop-title">Отвалы</div>
                                        </li>
                                        <li>
                                            <div class="message-center">
                                                <!-- Message -->
                                                <?php  $_smarty_tpl->tpl_vars['mn'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mn']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['missings_notifications']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mn']->key => $_smarty_tpl->tpl_vars['mn']->value) {
$_smarty_tpl->tpl_vars['mn']->_loop = true;
?>
                                                    <a class="message-item">
                                                        <button type="button"
                                                                class="btn btn-info btn-circle btn-lg js-close-missing"
                                                                data-user="<?php echo $_smarty_tpl->tpl_vars['mn']->value->id;?>
"><i class="fa fa-check"></i>
                                                        </button>
                                                        <div class="mail-contnet" onclick="location.href='missings'">
                                                            <h6><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['mn']->value->phone_mobile, ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['mn']->value->lastname, ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['mn']->value->firstname, ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['mn']->value->patronymic, ENT_QUOTES, 'UTF-8', true);?>
</h6>
                                                            <span class="time">Посл действие: <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['mn']->value->last_stage_date);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['mn']->value->last_stage_date);?>
</span>
                                                        </div>
                                                    </a>
                                                <?php } ?>
                                                <!-- Message -->
                                            </div>
                                        </li>
                                    <?php }?>

                                    <?php if ($_smarty_tpl->tpl_vars['active_notifications']->value) {?>
                                        <li>
                                            <div class="drop-title">Напоминания</div>
                                        </li>
                                        <li>
                                            <div class="message-center">
                                                <!-- Message -->
                                                <?php  $_smarty_tpl->tpl_vars['an'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['an']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['active_notifications']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['an']->key => $_smarty_tpl->tpl_vars['an']->value) {
$_smarty_tpl->tpl_vars['an']->_loop = true;
?>
                                                    <a href="sudblock_notifications">
                                                        <div class="btn btn-danger btn-circle">
                                                            !
                                                        </div>
                                                        <div class="mail-contnet">
                                                            <h5><?php echo $_smarty_tpl->tpl_vars['an']->value->event->action;?>
</h5>
                                                            <span class="mail-desc"><?php echo $_smarty_tpl->tpl_vars['an']->value->comment;?>
</span>
                                                            <span class="time"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['an']->value->notification_date);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['an']->value->notification_date);?>
</span>
                                                        </div>
                                                    </a>
                                                <?php } ?>
                                                <!-- Message -->
                                            </div>
                                        </li>
                                    <?php }?>

                                    <?php if ($_smarty_tpl->tpl_vars['penalty_notifications']->value) {?>
                                        <li>
                                            <div class="drop-title">Штрафы</div>
                                        </li>
                                        <li>
                                            <div class="message-center">
                                                <!-- Message -->
                                                <?php  $_smarty_tpl->tpl_vars['pn'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pn']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['penalty_notifications']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pn']->key => $_smarty_tpl->tpl_vars['pn']->value) {
$_smarty_tpl->tpl_vars['pn']->_loop = true;
?>
                                                    <a href="order/<?php echo $_smarty_tpl->tpl_vars['pn']->value->order_id;?>
">
                                                        <div class="btn btn-danger btn-circle">
                                                            <i class="mdi-alert-octagon mdi"></i>
                                                        </div>
                                                        <div class="mail-contnet">
                                                            <h5><?php echo $_smarty_tpl->tpl_vars['pn']->value->type->name;?>
</h5>
                                                            <span class="mail-desc"><?php echo $_smarty_tpl->tpl_vars['pn']->value->comment;?>
</span>
                                                            <span class="time"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['pn']->value->created);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['pn']->value->created);?>
</span>
                                                        </div>
                                                    </a>
                                                <?php } ?>
                                                <!-- Message -->
                                            </div>
                                        </li>
                                    <?php }?>
                                </ul>
                            </div>
                        </li>
                    <?php }?>

                </ul>

                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <ul class="navbar-nav my-lg-0">

                    <?php if ($_smarty_tpl->tpl_vars['is_developer']->value) {?>
                    <li class="nav-item">
                        <h4 class="text-danger pt-4">DEVELOPER MODE</h4>
                    </li>
                    <?php }?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="far fa-user-circle"></i>
                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['manager']->value->name, ENT_QUOTES, 'UTF-8', true);?>

                        </a>
                        <div class="dropdown-menu dropdown-menu-right animated flipInY">
                            <ul class="dropdown-user">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-text">
                                            <h4><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['manager']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</h4>
                                            <p class="text-muted"><?php echo $_smarty_tpl->tpl_vars['manager']->value->email;?>
</p>
                                            <?php if ($_smarty_tpl->tpl_vars['manager']->value->role=='developer') {?><span
                                                    class="badge badge-danger"><?php echo $_smarty_tpl->tpl_vars['manager']->value->role;?>
</span>
                                            <?php } elseif ($_smarty_tpl->tpl_vars['manager']->value->role=='admin') {?><span
                                                    class="badge badge-success"><?php echo $_smarty_tpl->tpl_vars['manager']->value->role;?>
</span>
                                            <?php } elseif ($_smarty_tpl->tpl_vars['manager']->value->role=='manager') {?><span
                                                    class="badge badge-primary"><?php echo $_smarty_tpl->tpl_vars['manager']->value->role;?>
</span>
                                            <?php } else { ?><span class="badge badge-info"><?php echo $_smarty_tpl->tpl_vars['manager']->value->role;?>
</span><?php }?>
                                        </div>
                                    </div>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li><a href="manager/<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"><i class="ti-user"></i> Профиль</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="logout"><i class="fa fa-power-off"></i> Выход</a></li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <?php if (in_array('orders',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('clients',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('offline',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('penalties',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('missings',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                        <li class="nav-small-cap">Основные</li>
                        <?php if (in_array('orders',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (!$_smarty_tpl->tpl_vars['offline']->value&&in_array($_smarty_tpl->tpl_vars['module']->value,array('OrderController','OrdersController'))) {?>class="active"<?php }?>>
                                <a class="" href="orders/" aria-expanded="false"><i class="mdi mdi-animation"></i><span
                                            class="hide-menu">Заявки</span></a>
                            </li>
                        <?php }?>

                        <?php if (in_array('missings',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('MissingsController'))) {?>class="active"<?php }?>>
                                <a class="" href="missings/" aria-expanded="false"><i
                                            class="mdi mdi-animation"></i><span class="hide-menu">Отвалы</span></a>
                            </li>
                        <?php }?>

                        <?php if (in_array('clients',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('ClientController','ClientsController'))) {?>class="active"<?php }?>>
                                <a class="" href="clients/" aria-expanded="false"><i
                                            class="mdi mdi-chart-bubble"></i><span class="hide-menu">Клиенты</span></a>
                            </li>
                        <?php }?>

                        <?php if (in_array('penalties',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('PenaltiesController'))) {?>class="active"<?php }?>>
                                <a class="" href="penalties" aria-expanded="false"><i class="mdi mdi-alert-octagon"></i><span
                                            class="hide-menu">Штрафы</span></a>
                            </li>
                        <?php }?>

                    <?php }?>


                    <?php if (in_array('offline_settings',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('offline',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                        <li class="nav-small-cap">Оффлайн</li>
                        <?php if (in_array('offline',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('NeworderController','OfflineOrderController','OfflineOrdersController'))) {?>class="active"<?php }?>>
                                <a class="" href="offline_orders" aria-expanded="false"><i
                                            class="mdi mdi-animation"></i><span class="hide-menu">Заявки</span></a>
                            </li>
                        <?php }?>

                        <?php if (in_array('offline',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('WagesController'))) {?>class="active"<?php }?>>
                                <a class="" href="wages" aria-expanded="false"><i class="mdi mdi-animation"></i><span
                                            class="hide-menu">ЗП</span></a>
                            </li>
                        <?php }?>

                        <?php if (in_array('offline_settings',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('OfflineOrganizationsController','OfflinePointsController','LoantypesController','LoantypeController'))) {?>class="active"<?php }?>>
                                <a class="has-arrow" href="settings" aria-expanded="false"><i
                                            class="mdi mdi-settings"></i><span class="hide-menu">Настройки</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <?php if (in_array('offline_settings',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('OfflinePointsController'))) {?>class="active"<?php }?>><a
                                                    href="offline_points">Оффлайн отделения</a></li>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('OfflineOrganizationsController'))) {?>class="active"<?php }?>>
                                            <a href="offline_organizations">Оффлайн Организации</a></li>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('LoantypesController','LoantypeController'))) {?>class="active"<?php }?>>
                                            <a href="loantypes">Виды кредитования</a></li>
                                    <?php }?>
                                </ul>
                            </li>
                        <?php }?>

                    <?php }?>


                    <?php if (in_array('my_contracts',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('collection_report',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('zvonobot',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                        <li class="nav-small-cap">Коллекшин</li>
                        <?php if (in_array('my_contracts',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('CollectorContractsController'))) {?>class="active"<?php }?>>
                                <a class="" href="my_contracts/" aria-expanded="false"><i
                                            class="mdi mdi-book-multiple"></i><span
                                            class="hide-menu">Мои договоры</span></a>
                            </li>
                        <?php }?>
                        <?php if (in_array('collection_report',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('CollectionReportController'))) {?>class="active"<?php }?>>
                                <a class="" href="collection_report/" aria-expanded="false"><i
                                            class="mdi mdi-chart-histogram"></i><span class="hide-menu">Отчет</span></a>
                            </li>
                        <?php }?>
                        <?php if (in_array('collection_moving',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('CollectorClientsController'))) {?>class="active"<?php }?>>
                                <a class="" href="collector_clients" aria-expanded="false"><i
                                            class="mdi mdi-chart-histogram"></i><span class="hide-menu">Перебросы клиентов</span></a>
                            </li>
                        <?php }?>
                        <?php if (in_array('zvonobot',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('ZvonobotController'))) {?>class="active"<?php }?>>
                                <a class="" href="zvonobot" aria-expanded="false"><i class="mdi mdi-deskphone"></i><span
                                            class="hide-menu">Звонобот</span></a>
                            </li>
                        <?php }?>
                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('NotificationsController'))) {?>class="active"<?php }?>>
                            <a class="" href="collection_notifications" aria-expanded="false"><i
                                        class="mdi-note-multiple-outline mdi"></i><span
                                        class="hide-menu">Напоминания</span></a>
                        </li>
                        <?php if (in_array('collector_mailing',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('MailingController'))) {?>class="active"<?php }?>>
                                <a class="" href="mailing/list" aria-expanded="false"><i
                                            class="mdi mdi-voicemail"></i><span class="hide-menu">Рассылка</span></a>
                            </li>
                        <?php }?>

                    <?php }?>

                    <?php if (in_array('sudblock',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('sudblock_settings',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                        <li class="nav-small-cap">Судблок</li>
                        <?php if (in_array('sudblock',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('SudblockContractsController'))) {?>class="active"<?php }?>>
                                <a class="" href="sudblock_contracts" aria-expanded="false"><i
                                            class="mdi mdi-clipboard"></i><span
                                            class="hide-menu">Мои договоры</span></a>
                            </li>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('SudblockNotificationsController'))) {?>class="active"<?php }?>>
                                <a class="" href="sudblock_notifications" aria-expanded="false"><i
                                            class="mdi-note-multiple-outline mdi"></i><span class="hide-menu">Напоминания</span></a>
                            </li>
                        <?php }?>
                        <?php if (in_array('sudblock_settings',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('SudblockStatusesController','SudblockDocumentsController, SudblockEventController'))) {?>class="active"<?php }?>>
                                <a class="has-arrow" href="settings" aria-expanded="false"><i
                                            class="mdi mdi-settings"></i><span class="hide-menu">Справочники</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('SudblockStatusesController'))) {?>class="active"<?php }?>><a
                                                href="sudblock_statuses">Статусы</a></li>
                                    <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('SudblockDocumentsController'))) {?>class="active"<?php }?>><a
                                                href="sudblock_documents">Документы</a></li>
                                    <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('SudblockEventController'))) {?>class="active"<?php }?>><a
                                                href="sudblock_event_types">Типы событий</a></li>
                                </ul>
                            </li>
                        <?php }?>

                    <?php }?>

                    <?php if (in_array('managers',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('changelogs',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('settings',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('handbooks',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('pages',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                        <li class="nav-small-cap">Управление</li>
                        <?php if (in_array('managers',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('ManagerController','ManagersController'))) {?>class="active"<?php }?>>
                                <a class="" href="managers/" aria-expanded="false"><i
                                            class="mdi mdi-account-multiple-outline"></i><span class="hide-menu">Пользователи</span></a>
                            </li>
                        <?php }?>
                        <?php if (in_array('changelogs',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('ChangelogsController'))) {?>class="active"<?php }?>>
                                <a class="" href="changelogs/" aria-expanded="false"><i
                                            class="mdi mdi-book-open-page-variant"></i><span class="hide-menu">Логирование</span></a>
                            </li>
                        <?php }?>
                        <?php if (in_array('settings',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('offline_settings',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('SettingsController','OfflinePointsController','ScoringsController','ApikeysController','WhitelistController','BlacklistController','PenaltyTypesController'))) {?>class="active"<?php }?>>
                                <a class="has-arrow" href="settings" aria-expanded="false"><i
                                            class="mdi mdi-settings"></i><span class="hide-menu">Настройки</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <?php if (in_array('settings',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('SettingsController'))) {?>class="active"<?php }?>><a
                                                    href="settings/">Общие</a></li>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('ScoringsController'))) {?>class="active"<?php }?>><a
                                                    href="scorings/">Скоринги</a></li>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('ApikeysController'))) {?>class="active"<?php }?>><a
                                                    href="apikeys/">Ключи для API</a></li>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('WhitelistController'))) {?>class="active"<?php }?>><a
                                                    href="whitelist/">Whitelist</a></li>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('BlacklistController'))) {?>class="active"<?php }?>><a
                                                    href="blacklist/">Blacklist</a></li>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('RfmController'))) {?>class="active"<?php }?>><a
                                                    href="rfm/">РФМ</a></li>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('PenaltyTypesController'))) {?>class="active"<?php }?>><a
                                                    href="penalty_types">Штрафы</a></li>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('CollectionPeriodsController'))) {?>class="active"<?php }?>>
                                            <a href="collection_periods">Периоды коллекшина</a></li>
                                    <?php }?>
                                </ul>
                            </li>
                        <?php }?>
                        <?php if (in_array('handbooks',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('sms_templates',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('tags',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('communications',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('HandbooksController','ReasonsController','SmsTemplatesController','SettingsCommunicationsController','TicketStatusesController','TicketReasonsController'))) {?>class="active"<?php }?>>
                                <a class="has-arrow" href="#" aria-expanded="false"><i
                                            class="mdi mdi-database"></i><span class="hide-menu">Справочники</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <?php if (in_array('handbooks',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('ReasonsController'))) {?>class="active"<?php }?>><a
                                                    href="reasons/">Причины отказа</a></li>
                                    <?php }?>
                                    <?php if (in_array('sms_templates',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('SmsTemplatesController'))) {?>class="active"<?php }?>><a
                                                    href="sms_templates">Шаблоны сообщений</a></li>
                                    <?php }?>
                                    <?php if (in_array('tags',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('CollectorTagsController'))) {?>class="active"<?php }?>><a
                                                    href="collector_tags">Теги для коллекторов</a></li>
                                    <?php }?>
                                    <?php if (in_array('communications',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('SettingsCommunicationsController'))) {?>class="active"<?php }?>>
                                            <a href="settings_communications">Лимиты коммуникаций</a></li>
                                    <?php }?>
                                    <?php if (in_array('ticket_handbooks',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('TicketStatusesController'))) {?>class="active"<?php }?>><a
                                                    href="ticket_statuses">Статусы тикетов</a></li>
                                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('TicketReasonsController'))) {?>class="active"<?php }?>><a
                                                    href="ticket_reasons">Причины закрытия тикетов</a></li>
                                    <?php }?>
                                </ul>
                            </li>
                        <?php }?>
                        <?php if (in_array('pages',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('PageController','PagesController'))) {?>class="active"<?php }?>>
                                <a class="" href="pages" aria-expanded="false"><i class="mdi mdi-application"></i><span
                                            class="hide-menu">Страницы</span></a>
                            </li>
                        <?php }?>
                    <?php }?>

                    <?php if (in_array('analitics',$_smarty_tpl->tpl_vars['manager']->value->permissions)||in_array('penalty_statistics',$_smarty_tpl->tpl_vars['manager']->value->permissions)||$_smarty_tpl->tpl_vars['manager']->value->role=='chief_sudblock') {?>
                        <li class="nav-small-cap">Аналитика</li>
                        <?php if ($_smarty_tpl->tpl_vars['manager']->value->role!='chief_sudblock') {?>
                        <?php if ($_smarty_tpl->tpl_vars['manager']->value->role!='analitic_marketing') {?>
                            <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('DashboardController'))) {?>class="active"<?php }?>>
                                <a class="" href="dashboard" aria-expanded="false"><i class="mdi mdi-gauge"></i><span
                                            class="hide-menu">Dashboard</span></a>
                            </li>
                        <?php }?>
                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('ToolsController'))) {?>class="active"<?php }?>>
                            <a class="" href="tools" aria-expanded="false"><i class="mdi mdi-settings"></i><span
                                        class="hide-menu">Инструменты</span></a>
                        </li>
                        <?php }?>
                        <li <?php if (in_array($_smarty_tpl->tpl_vars['module']->value,array('StatisticsController'))) {?>class="active"<?php }?>>
                            <a class="" href="statistics" aria-expanded="false"><i class="mdi mdi-file-chart"></i><span
                                        class="hide-menu">Статистика</span></a>
                        </li>
                    <?php }?>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->


    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <?php echo $_smarty_tpl->tpl_vars['content']->value;?>

    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->

</div>

<div id="sms_code_modal"></div>

<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/jquery/jquery.min.js?v=1.01"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/bootstrap/js/popper.min.js?v=1.02"></script>
<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/bootstrap/js/bootstrap.js?v=1.01"></script>

<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/fancybox3/dist/jquery.fancybox.min.js?v=1.03"></script>
<link rel="stylesheet" href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/fancybox3/dist/jquery.fancybox.css?v=1.03"/>

<!-- slimscrollbar scrollbar JavaScript -->
<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/jquery.slimscroll.js?v=1.01"></script>
<!--Wave Effects -->
<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/waves.js?v=1.01"></script>
<!--Menu sidebar -->
<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/sidebarmenu.js?v=1.01"></script>
<!--stickey kit -->
<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js?v=1.01"></script>

<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/sweetalert2/dist/sweetalert2.all.min.js?v=1.01"></script>
<!--Custom JavaScript -->
<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/custom.min.js?v=1.01"></script>
<!-- ============================================================== -->

<link rel="stylesheet" href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/autocomplete/styles.css?v=1.01"/>
<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/autocomplete/jquery.autocomplete-min.js?v=1.01"></script>
<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/dadata.app.js?v=1.05"></script>

<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/run_scorings.app.js?v=1.01"></script>
<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/sms.app.js?v=1.01"></script>

<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/eventlogs.app.js?v=1.01"></script>

<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/connexions.app.js?v=1.10"></script>

<?php echo Smarty::$_smarty_vars['capture']['page_scripts'];?>

<!-- Style switcher -->
<!-- ============================================================== -->
<script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

<script>
    $(function () {

        $(document).on('click', '.js-close-missing', function () {
            var $this = $(this);

            var _user_id = $(this).data('user');

            $.ajax({
                type: 'POST',
                data: {
                    action: 'close_missing',
                    user_id: _user_id
                },
                success: function (resp) {
                    if (!!resp.error) {
                        Swal.fire({
                            text: resp.error,
                            type: 'error',
                        });
                    }
                    else {
                        $this.closest('.jsgrid-row').fadeOut();
                        $this.closest('.message-item').fadeOut();
                    }
                }
            })
        });

    })
</script>

<script>
    setInterval(function(){
        $.get('/ajax/worktime.php?action=update');
    }, 60000);
</script>

</body>

</html><?php }} ?>
