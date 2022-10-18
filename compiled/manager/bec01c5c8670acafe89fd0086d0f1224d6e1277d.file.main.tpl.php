<?php /* Smarty version Smarty-3.1.18, created on 2022-10-10 13:16:02
         compiled from "/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/statistics/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15801997526343aeed41f2e7-00918444%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bec01c5c8670acafe89fd0086d0f1224d6e1277d' => 
    array (
      0 => '/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/statistics/main.tpl',
      1 => 1665396962,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15801997526343aeed41f2e7-00918444',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_6343aeed429df3_09369382',
  'variables' => 
  array (
    'manager' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6343aeed429df3_09369382')) {function content_6343aeed429df3_09369382($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Статистика', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_scripts', null, null); ob_start(); ?>



<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_styles', null, null); ob_start(); ?>


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
                <h3 class="text-themecolor mb-0 mt-0"><i class="mdi mdi-file-chart"></i> Статистика</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Статистика</li>
                </ol>
            </div>
            <div class="col-md-6 col-4 align-self-center">

            </div>
        </div>

        <div class="row">
            <!-- Column 
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-inverse card-info">
                    <a href="statistics/report" class="box bg-info text-center">
                        <h1 class="font-light text-white">Выдача</h1>
                        <h6 class="text-white">Оперативная отчетность</h6>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-primary card-inverse">
                    <a href="statistics/conversion" class="box text-center">
                        <h1 class="font-light text-white">Конверсия</h1>
                        <h6 class="text-white">Конверсии в выдачу</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <a href="statistics/expired" class="card card-inverse card-success">
                    <div class="box text-center">
                        <h1 class="font-light text-white">Просрочка</h1>
                        <h6 class="text-white">Статистика просрочки</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-inverse card-warning">
                    <a href="statistics/free_pk" class="box text-center">
                        <h1 class="font-light text-white">Свободные ПК</h1>
                        <h6 class="text-white">ПК без открытых договоров</h6>
                    </a>
                </div>
            </div>
            -->
            <?php if (in_array('analitics',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                <?php if ($_smarty_tpl->tpl_vars['manager']->value->role!='analitic_marketing') {?>
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-inverse card-danger">
                            <a href="statistics/scorista_rejects" class="box text-center">
                                <h1 class="font-light text-white">Отказы</h1>
                                <h6 class="text-white">Статистика отказов</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-inverse card-success">
                            <a href="statistics/contracts" class="box text-center">
                                <h1 class="font-light text-white">Договора</h1>
                                <h6 class="text-white">Выданные займы</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-inverse card-primary">
                            <a href="statistics/payments" class="box text-center">
                                <h1 class="font-light text-white">Оплаты</h1>
                                <h6 class="text-white">Операции по займам</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-inverse card-warning">
                            <a href="statistics/eventlogs" class="box text-center">
                                <h1 class="font-light text-white">Логи</h1>
                                <h6 class="text-white">Логи событий</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-info card-danger">
                            <a href="statistics/adservices" class="box text-center">
                                <h1 class="font-light text-white">Доп услуги</h1>
                                <h6 class="text-white">Отчеты по дополнительным услугам</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-info card-danger">
                            <a href="statistics/kpicollection" class="box text-center">
                                <h1 class="font-light text-white">KPI</h1>
                                <h6 class="text-white">Отчеты по KPI коллекторов</h6>
                            </a>
                        </div>
                    </div>
                <?php }?>
                <div class="col-md-6 col-lg-3 col-xlg-3">
                    <div class="card card-inverse card-warning">
                        <a href="statistics/sources" class="box text-center">
                            <h1 class="font-light text-white">Источники</h1>
                            <h6 class="text-white">Маркетинг</h6>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 col-xlg-3">
                    <div class="card card-inverse card-primary">
                        <a href="statistics/conversions" class="box text-center">
                            <h1 class="font-light text-white">Конверсии</h1>
                            <h6 class="text-white">Маркетинг</h6>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 col-xlg-3">
                    <div class="card card-inverse card-primary">
                        <a href="statistics/reminders" class="box text-center">
                            <h1 class="font-light text-white">Ремайндеры</h1>
                            <h6 class="text-white">Отчет по Ремайндерам</h6>
                        </a>
                    </div>
                </div>
            <?php }?>
            <?php if (in_array('penalty_statistics',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                <div class="col-md-6 col-lg-3 col-xlg-3">
                    <div class="card card-inverse card-danger">
                        <a href="statistics/penalties" class="box text-center">
                            <h1 class="font-light text-white">Штрафы</h1>
                            <h6 class="text-white">Статистика штрафов</h6>
                        </a>
                    </div>
                </div>
            <?php }?>
        </div>

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
