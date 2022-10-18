<?php /* Smarty version Smarty-3.1.18, created on 2022-06-28 20:58:39
         compiled from "/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/orders.tpl" */ ?>
<?php /*%%SmartyHeaderCode:119112150762bb414f7d56d6-89852027%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '520e3caee8d7602c5b97378893d4e8341dae84dd' => 
    array (
      0 => '/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/orders.tpl',
      1 => 1656438503,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '119112150762bb414f7d56d6-89852027',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'offline' => 0,
    'settings' => 0,
    'manager' => 0,
    'period' => 0,
    'from' => 0,
    'to' => 0,
    'filter_status' => 0,
    'filter_client' => 0,
    'sort' => 0,
    'search' => 0,
    'managers' => 0,
    'm' => 0,
    'orders' => 0,
    'is_developer' => 0,
    'order' => 0,
    'reasons' => 0,
    'integrations' => 0,
    'integration' => 0,
    'sc' => 0,
    'scoring_types' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_62bb414f854e46_52783787',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62bb414f854e46_52783787')) {function content_62bb414f854e46_52783787($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['offline']->value) {?>
    <?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Список оффлайн заявок', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php } else { ?>
    <?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Список заявок', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php }?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_scripts', null, null); ob_start(); ?>
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="theme/manager/assets/plugins/moment/moment.js"></script>
    <script src="theme/manager/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="theme/manager/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="theme/manager/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/orders.js?v=1.11"></script>
    <script type="text/javascript" src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/order.js?v=1.16"></script>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_styles', null, null); ob_start(); ?>
    <link href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css"
          rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/jsgrid/jsgrid.min.css"/>
    <link type="text/css" rel="stylesheet"
          href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/jsgrid/jsgrid-theme.min.css"/>
    <link href="theme/manager/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Daterange picker plugins css -->
    <link href="theme/manager/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="theme/manager/assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">
    <style>
        .jsgrid-table {
            margin-bottom: 0
        }

        .label {
            white-space: pre;
        }

        .workout-row > td {
            background: #b2ffaf !important;
        }

        .workout-row a, .workout-row small, .workout-row span {
            color: #555 !important;
            font-weight: 300;
        }

    </style>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor mb-0 mt-0"><i class="mdi mdi-animation"></i> Заявки <?php if ($_smarty_tpl->tpl_vars['offline']->value) {?>оффлайн<?php }?>
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Заявки <?php if ($_smarty_tpl->tpl_vars['offline']->value) {?>оффлайн<?php }?></li>
                </ol>
            </div>
            <div class="col-md-6 col-4 align-self-center">
                <div class="row">

                    <div class="col-6 text-right">
                        <?php if (in_array('neworder',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                            <a href="neworder" class="btn btn-success btn-large">
                                <i class="fas fa-plus-circle"></i>
                                <span>Новая заявка</span>
                            </a>
                        <?php }?>
                    </div>

                    <div class="col-6 dropdown text-right hidden-sm-down js-period-filter">
                        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['period']->value;?>
" id="filter_period"/>
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-calendar-alt"></i>
                            <?php if ($_smarty_tpl->tpl_vars['period']->value=='today') {?>Сегодня
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='yesterday') {?>Вчера
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='week') {?>На этой неделе
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='month') {?>В этом месяце
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='year') {?>В этом году
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='all') {?>За все время
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='optional') {?>Произвольный
                            <?php } else { ?><?php echo $_smarty_tpl->tpl_vars['period']->value;?>
<?php }?>

                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item js-period-link <?php if ($_smarty_tpl->tpl_vars['period']->value=='today') {?>active<?php }?>"
                               href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'today','page'=>null),$_smarty_tpl);?>
">Сегодня</a>
                            <a class="dropdown-item js-period-link <?php if ($_smarty_tpl->tpl_vars['period']->value=='yesterday') {?>active<?php }?>"
                               href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'yesterday','page'=>null),$_smarty_tpl);?>
">Вчера</a>
                            <a class="dropdown-item js-period-link <?php if ($_smarty_tpl->tpl_vars['period']->value=='month') {?>active<?php }?>"
                               href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'month','page'=>null),$_smarty_tpl);?>
">В этом месяце</a>
                            <a class="dropdown-item js-period-link <?php if ($_smarty_tpl->tpl_vars['period']->value=='year') {?>active<?php }?>"
                               href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'year','page'=>null),$_smarty_tpl);?>
">В этом году</a>
                            <a class="dropdown-item js-period-link <?php if ($_smarty_tpl->tpl_vars['period']->value=='all') {?>active<?php }?>"
                               href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'all','page'=>null),$_smarty_tpl);?>
">За все время</a>
                            <a class="dropdown-item js-open-daterange <?php if ($_smarty_tpl->tpl_vars['period']->value=='optional') {?>active<?php }?>"
                               href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'optional','page'=>null),$_smarty_tpl);?>
">Произвольный</a>
                        </div>

                        <div class="js-daterange-filter input-group mt-3"
                             <?php if ($_smarty_tpl->tpl_vars['period']->value!='optional') {?>style="display:none"<?php }?>>
                            <input type="text" name="daterange" class="form-control daterange js-daterange-input"
                                   value="<?php if ($_smarty_tpl->tpl_vars['from']->value&&$_smarty_tpl->tpl_vars['to']->value) {?><?php echo $_smarty_tpl->tpl_vars['from']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['to']->value;?>
<?php }?>">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <span class="ti-calendar"></span>
                                </span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <!-- Column -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Список заявок </h4>

                        <div class="clearfix">
                            <div class="js-filter-status mb-2 float-left">
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value=='new') {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>'new','page'=>null),$_smarty_tpl);?>
<?php }?>"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value=='new') {?>btn-warning<?php } else { ?>btn-outline-warning<?php }?>">Новая</a>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value==1) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>1,'page'=>null),$_smarty_tpl);?>
<?php }?>"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==1) {?>btn-info<?php } else { ?>btn-outline-info<?php }?>">Принята</a>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value==2) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>2,'page'=>null),$_smarty_tpl);?>
<?php }?>"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==2) {?>btn-success<?php } else { ?>btn-outline-success<?php }?>">Одобрена</a>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value==3) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>3,'page'=>null),$_smarty_tpl);?>
<?php }?>"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==3) {?>btn-danger<?php } else { ?>btn-outline-danger<?php }?>">Отказ</a>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value==4) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>4,'page'=>null),$_smarty_tpl);?>
<?php }?>"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==4) {?>btn-inverse<?php } else { ?>btn-outline-inverse<?php }?>">Подписан</a>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value==5) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>5,'page'=>null),$_smarty_tpl);?>
<?php }?>"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==5) {?>btn-primary<?php } else { ?>btn-outline-primary<?php }?>">Выдан</a>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value==6) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>6,'page'=>null),$_smarty_tpl);?>
<?php }?>"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==6) {?>btn-danger<?php } else { ?>btn-outline-danger<?php }?>">Не
                                    удалось выдать</a>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value==7) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>7,'page'=>null),$_smarty_tpl);?>
<?php }?>"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==7) {?>btn-inverse<?php } else { ?>btn-outline-inverse<?php }?>">Погашен</a>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value==8) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>8,'page'=>null),$_smarty_tpl);?>
<?php }?>"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==8) {?>btn-danger<?php } else { ?>btn-outline-danger<?php }?>">Отказ
                                    клиента</a>
                                <?php if ($_smarty_tpl->tpl_vars['filter_status']->value) {?>
                                    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['filter_status']->value;?>
" id="filter_status"/>
                                <?php }?>
                            </div>
                            <div class="float-right js-filter-client">
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_client']->value=='new') {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('client'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('client'=>'new','page'=>null),$_smarty_tpl);?>
<?php }?>"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_client']->value=='new') {?>btn-info<?php } else { ?>btn-outline-info<?php }?>">Новая</a>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_client']->value=='repeat') {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('client'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('client'=>'repeat','page'=>null),$_smarty_tpl);?>
<?php }?>"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_client']->value=='repeat') {?>btn-warning<?php } else { ?>btn-outline-warning<?php }?>">Повтор</a>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_client']->value=='pk') {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('client'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('client'=>'pk','page'=>null),$_smarty_tpl);?>
<?php }?>"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_client']->value=='pk') {?>btn-success<?php } else { ?>btn-outline-success<?php }?>">ПК</a>
                                <?php if ($_smarty_tpl->tpl_vars['filter_client']->value) {?>
                                    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['filter_client']->value;?>
" id="filter_client"/>
                                <?php }?>
                            </div>
                        </div>

                        <div id="basicgrid" class="jsgrid" style="position: relative; width: 100%;">
                            <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                                <table class="jsgrid-table table table-striped table-hover">
                                    <tr class="jsgrid-header-row">
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-align-right jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='order_id_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='order_id_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='order_id_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'order_id_desc'),$_smarty_tpl);?>
">
                                                    ID</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'order_id_asc'),$_smarty_tpl);?>
">ID</a><?php }?>
                                        </th>
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='date_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='date_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='date_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'date_desc'),$_smarty_tpl);?>
">Дата /
                                                Время</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'date_asc'),$_smarty_tpl);?>
">Дата / Время</a><?php }?>
                                        </th>
                                        <th style="width: 60px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='amount_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='amount_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='amount_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'amount_desc'),$_smarty_tpl);?>
">
                                                    Сумма, руб</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'amount_asc'),$_smarty_tpl);?>
">Сумма, руб</a><?php }?>
                                        </th>
                                        <th style="width: 50px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='period_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='period_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='period_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'period_desc'),$_smarty_tpl);?>
">
                                                    Срок</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'period_asc'),$_smarty_tpl);?>
">Срок</a><?php }?>
                                        </th>
                                        <th style="width: 150px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='fio_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='fio_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='fio_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'fio_desc'),$_smarty_tpl);?>
">ФИО</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'fio_asc'),$_smarty_tpl);?>
">ФИО</a><?php }?>
                                        </th>
                                        <th style="width: 60px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='birth_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='birth_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='birth_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'birth_desc'),$_smarty_tpl);?>
">Д/Р</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'birth_asc'),$_smarty_tpl);?>
">Д/Р</a><?php }?>
                                        </th>
                                        <th style="width: 80px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='phone_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='phone_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='phone_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'phone_desc'),$_smarty_tpl);?>
">
                                                    Телефон</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'phone_asc'),$_smarty_tpl);?>
">Телефон</a><?php }?>
                                        </th>
                                        <th style="width: 100px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='region_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='region_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='region_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'region_desc'),$_smarty_tpl);?>
">
                                                    Регион</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'region_asc'),$_smarty_tpl);?>
">Регион</a><?php }?>
                                        </th>
                                        <th style="width: 100px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='status_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='status_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='manager_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'manager_desc'),$_smarty_tpl);?>
">
                                                    Менеджер</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'manager_asc'),$_smarty_tpl);?>
">Менеджер</a><?php }?>
                                        </th>
                                        <th style="width: 60px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='status_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='status_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='manager_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'manager_desc'),$_smarty_tpl);?>
">
                                                    UTM</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'manager_asc'),$_smarty_tpl);?>
">UTM</a><?php }?>
                                        </th>
                                        <?php if ($_smarty_tpl->tpl_vars['manager']->value->role=='quality_control') {?>
                                            <th style="width: 80px;"
                                                class="jsgrid-header-cell <?php if ($_smarty_tpl->tpl_vars['sort']->value=='penalty_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='penalty_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                                <?php if ($_smarty_tpl->tpl_vars['sort']->value=='penalty_asc') {?><a
                                                    href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'penalty_desc'),$_smarty_tpl);?>
">Дата решения</a>
                                                <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'penalty_asc'),$_smarty_tpl);?>
">Дата решения</a><?php }?>
                                            </th>
                                        <?php } else { ?>
                                            <th style="width: 100px;"
                                                class="jsgrid-header-cell <?php if ($_smarty_tpl->tpl_vars['sort']->value=='scoring_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='scoring_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                                <?php if ($_smarty_tpl->tpl_vars['sort']->value=='scoring_asc') {?>
                                                    <a href="javascript:void(0);">Скоринг</a>
                                                <?php } else { ?>
                                                    <a href="javascript:void(0);">Скоринг</a>
                                                <?php }?>
                                            </th>
                                        <?php }?>
                                    </tr>
                                    <tr class="jsgrid-filter-row" id="search_form">

                                        <td style="width: 70px;" class="jsgrid-cell jsgrid-align-right">
                                            <input type="hidden" name="sort" value="<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
"/>
                                            <input type="text" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['order_id'];?>
"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                            <input type="text" name="date" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['date'];?>
"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 60px;" class="jsgrid-cell">
                                            <input type="text" name="amount" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['amount'];?>
"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 50px;" class="jsgrid-cell">
                                            <input type="text" name="period" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['period'];?>
"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 150px;" class="jsgrid-cell">
                                            <input type="text" name="fio" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['fio'];?>
"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 60px;" class="jsgrid-cell">
                                            <input type="text" name="birth" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['birth'];?>
"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 80px;" class="jsgrid-cell">
                                            <input type="text" name="phone" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['phone'];?>
"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 100px;" class="jsgrid-cell">
                                            <input type="text" name="region" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['region'];?>
"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 100px;" class="jsgrid-cell">
                                            <select name="manager_id" class="form-control">
                                                <option value="0"></option>
                                                <option value="none">Без менеджера</option>
                                                <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['managers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value) {
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                                                    <option value="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
"
                                                            <?php if ($_smarty_tpl->tpl_vars['search']->value['manager_id']==$_smarty_tpl->tpl_vars['m']->value->id) {?>selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['m']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="width: 60px;" class="jsgrid-cell">
                                        </td>
                                        <?php if ($_smarty_tpl->tpl_vars['manager']->value->role=='quality_control') {?>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                            </td>
                                        <?php } else { ?>
                                            <td style="width: 100px;" class="jsgrid-cell">
                                            </td>
                                        <?php }?>
                                    </tr>
                                </table>
                            </div>
                            <div class="jsgrid-grid-body">
                                <table class="jsgrid-table table table-striped table-hover">
                                    <tbody>
                                    <?php  $_smarty_tpl->tpl_vars['order'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['order']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['orders']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value) {
$_smarty_tpl->tpl_vars['order']->_loop = true;
?>
                                        <?php if (!$_smarty_tpl->tpl_vars['is_developer']->value&&$_smarty_tpl->tpl_vars['order']->value->phone_mobile=='79608181253') {?>
                                            <?php continue 1?>
                                        <?php }?>
                                        <tr class="jsgrid-row js-order-row <?php if ($_smarty_tpl->tpl_vars['order']->value->quality_workout) {?>workout-row<?php }?>">
                                            <td style="width: 70px;" class="jsgrid-cell jsgrid-align-right">
                                                <a href="order/<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"><?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
</a>
                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->contract) {?>
                                                    <div>
                                                    <small><?php echo $_smarty_tpl->tpl_vars['order']->value->contract->number;?>
</small></div><?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->contract->outer_id) {?>
                                                    <small><?php echo $_smarty_tpl->tpl_vars['order']->value->contract->outer_id;?>
</small>
                                                <?php }?>
                                                <small>
                                                    <?php if ($_smarty_tpl->tpl_vars['order']->value->status==0) {?>
                                                        <span class="label label-warning">Новая</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->status==1) {?>
                                                        <span class="label label-info">Принята</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->status==2) {?>
                                                        <span class="label label-success">Одобрена</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->status==3) {?>
                                                        <span class="label label-danger" title="<?php echo $_smarty_tpl->tpl_vars['reasons']->value[$_smarty_tpl->tpl_vars['order']->value->reason_id]->admin_name;?>
">Отказ</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->status==4) {?>
                                                        <span class="label label-inverse">Подписан</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->status==5) {?>
                                                        <span class="label label-primary">Выдан</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->status==6) {?>
                                                        <span class="label label-danger">Не удалось выдать</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->status==7) {?>
                                                        <span class="label label-inverse">Погашен</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->status==8) {?>
                                                        <span class="label label-danger" title="<?php echo $_smarty_tpl->tpl_vars['reasons']->value[$_smarty_tpl->tpl_vars['order']->value->reason_id]->admin_name;?>
">Отказ клиента</span>
                                                    <?php }?>
                                                </small>
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['order']->value->date);?>

                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['order']->value->date);?>

                                            </td>
                                            <td style="width: 60px;" class="jsgrid-cell text-center">
                                                <h5><?php echo $_smarty_tpl->tpl_vars['order']->value->amount;?>
</h5>
                                            </td>
                                            <td style="width: 50px;" class="jsgrid-cell">
                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->period) {?>
                                                    <?php echo $_smarty_tpl->tpl_vars['order']->value->period;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['order']->value->period,'день','дней','дня');?>

                                                <?php }?>
                                            </td>
                                            <td style="width: 150px;" class="jsgrid-cell">
                                                <a href="client/<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
">
                                                    <?php echo $_smarty_tpl->tpl_vars['order']->value->lastname;?>

                                                    <?php echo $_smarty_tpl->tpl_vars['order']->value->firstname;?>

                                                    <?php echo $_smarty_tpl->tpl_vars['order']->value->patronymic;?>

                                                </a>
                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->client_status) {?>
                                                    <?php if ($_smarty_tpl->tpl_vars['order']->value->client_status=='pk') {?>
                                                        <span class="label label-success"
                                                              title="Клиент уже имеет погашенные займы">ПК</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->client_status=='crm') {?>
                                                        <span class="label label-primary"
                                                              title="Клиент уже имеет погашенные займы в CRM">ПК CRM</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->client_status=='rep') {?>
                                                        <span class="label label-warning"
                                                              title="Клиент уже подавал ранее заявки">Повтор</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->client_status=='nk') {?>
                                                        <span class="label label-info" title="Новый клиент">Новая</span>
                                                    <?php }?>
                                                <?php } else { ?>
                                                    <?php if ($_smarty_tpl->tpl_vars['order']->value->have_crm_closed) {?>
                                                        <span class="label label-primary"
                                                              title="Клиент уже имеет погашенные займы в CRM">ПК CRM</span>
                                                    <?php } elseif (count($_smarty_tpl->tpl_vars['order']->value->loan_history)>0) {?>
                                                        <span class="label label-success"
                                                              title="Клиент уже имеет погашенные займы">ПК</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->first_loan) {?>
                                                        <span class="label label-info" title="Новый клиент">Новая</span>
                                                    <?php } else { ?>
                                                        <span class="label label-warning"
                                                              title="Клиент уже подавал ранее заявки">Повтор</span>
                                                    <?php }?>
                                                <?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->autoretry) {?>
                                                    <span class="label label-danger" title="">Авторешение</span>
                                                <?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->antirazgon) {?>
                                                    <span class="label label-danger"
                                                          title="">АвтоАнтиРазгон <?php if ($_smarty_tpl->tpl_vars['order']->value->antirazgon==1) {?>0-2<?php } elseif ($_smarty_tpl->tpl_vars['order']->value->antirazgon==2) {?>3-5<?php } elseif ($_smarty_tpl->tpl_vars['order']->value->antirazgon==3) {?>6-10<?php }?></span>
                                                <?php }?>
                                            </td>
                                            <td style="width: 60px;" class="jsgrid-cell">
                                                <?php echo $_smarty_tpl->tpl_vars['order']->value->birth;?>

                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <?php echo $_smarty_tpl->tpl_vars['order']->value->phone_mobile;?>

                                                <button class="js-mango-call mango-call"
                                                        data-phone="<?php echo $_smarty_tpl->tpl_vars['order']->value->phone_mobile;?>
" title="Выполнить звонок"><i
                                                            class="fas fa-mobile-alt"></i></button>
                                            </td>
                                            <td style="width: 100px;" class="jsgrid-cell">
                                                <?php echo $_smarty_tpl->tpl_vars['order']->value->Regregion;?>

                                            </td>
                                            <td style="width: 100px;" class="jsgrid-cell">
                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['managers']->value[$_smarty_tpl->tpl_vars['order']->value->manager_id]->name, ENT_QUOTES, 'UTF-8', true);?>

                                                <?php if ($_smarty_tpl->tpl_vars['is_developer']->value) {?>
                                                <div><small class="text-danger"><?php echo $_smarty_tpl->tpl_vars['reasons']->value[$_smarty_tpl->tpl_vars['order']->value->reason_id]->admin_name;?>
</small></div>
                                                <?php }?>
                                            </td>
                                            <td style="width: 60px;" class="jsgrid-cell">
                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->utm_source) {?>
                                                    <?php  $_smarty_tpl->tpl_vars['integration'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['integration']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['integrations']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['integration']->key => $_smarty_tpl->tpl_vars['integration']->value) {
$_smarty_tpl->tpl_vars['integration']->_loop = true;
?>
                                                        <?php if ($_smarty_tpl->tpl_vars['integration']->value->utm_source==$_smarty_tpl->tpl_vars['order']->value->utm_source) {?>
                                                            <span class="label label-info"><?php echo $_smarty_tpl->tpl_vars['integration']->value->name;?>
</span>
                                                        <?php }?>
                                                    <?php } ?>
                                                    <?php } else { ?>
                                                    <span class="label label-info">Не опр</span>
                                                <?php }?>
                                            </td>
                                            <?php if ($_smarty_tpl->tpl_vars['manager']->value->role=='quality_control') {?>
                                                <td style="width: 80px;" class="jsgrid-cell">
                                                    <?php if ($_smarty_tpl->tpl_vars['order']->value->penalty_date) {?>
                                                        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['order']->value->penalty_date);?>

                                                        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['order']->value->penalty_date);?>

                                                    <?php }?>

                                                    <div class="custom-checkbox mt-1 custom-control">
                                                        <input id="workout_<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" type="checkbox"
                                                               class="custom-control-input js-workout-input"
                                                               value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" name="workout"
                                                               <?php if ($_smarty_tpl->tpl_vars['order']->value->quality_workout) {?>checked="true"<?php }?> />
                                                        <label for="workout_<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                               class="custom-control-label">
                                                            <small>Проверен</small>
                                                        </label>
                                                    </div>
                                                </td>
                                            <?php } else { ?>
                                                <td style="width: 100px;padding:0" class="jsgrid-cell">
                                                    <div style="max-height:128px;padding:5px 0 5px 5px;;overflow-y:auto;overflow-x:hidden">
                                                        <?php  $_smarty_tpl->tpl_vars['sc'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sc']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order']->value->scorings; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sc']->key => $_smarty_tpl->tpl_vars['sc']->value) {
$_smarty_tpl->tpl_vars['sc']->_loop = true;
?>
                                                            <span <?php if ($_smarty_tpl->tpl_vars['sc']->value->string_result) {?>data-toggle="tooltip"
                                                                  title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sc']->value->string_result, ENT_QUOTES, 'UTF-8', true);?>
 <?php if ($_smarty_tpl->tpl_vars['sc']->value->type=='scorista') {?><?php echo $_smarty_tpl->tpl_vars['sc']->value->scorista_ball;?>
<?php }?>"<?php }?>
                                                                  class="label label-sm 
                                                                    <?php if (in_array($_smarty_tpl->tpl_vars['sc']->value->status,array('repeat','new','process','import'))) {?>label-info
                                                                    <?php } elseif ($_smarty_tpl->tpl_vars['sc']->value->status=='completed'&&$_smarty_tpl->tpl_vars['sc']->value->success) {?>label-success
                                                                    <?php } elseif ($_smarty_tpl->tpl_vars['sc']->value->status=='completed'&&!$_smarty_tpl->tpl_vars['sc']->value->success) {?>label-danger
                                                                    <?php } elseif (in_array($_smarty_tpl->tpl_vars['sc']->value->status,array('stopped','error'))) {?>label-warning
                                                                    <?php } else { ?>label-primary<?php }?>
                                                                  "><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['scoring_types']->value[$_smarty_tpl->tpl_vars['sc']->value->type]->short_title, ENT_QUOTES, 'UTF-8', true);?>
</span>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            <?php }?>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php echo $_smarty_tpl->getSubTemplate ('pagination.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <?php echo $_smarty_tpl->getSubTemplate ('footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div><?php }} ?>
