<?php /* Smarty version Smarty-3.1.18, created on 2022-10-12 08:30:20
         compiled from "/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1669877608634650ecb03d06-61028279%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22d0ef13dbeac2c0d188b6cbd1d41a96c6da225e' => 
    array (
      0 => '/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/settings.tpl',
      1 => 1660295918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1669877608634650ecb03d06-61028279',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'settings' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_634650ecb103b5_87931177',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_634650ecb103b5_87931177')) {function content_634650ecb103b5_87931177($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Общие Настройки', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_scripts', null, null); ob_start(); ?>

    <script type="text/javascript">

    </script>

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
                <h3 class="text-themecolor mb-0 mt-0">
                    Общие настройки
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Общие настройки</li>
                </ol>
            </div>
            <div class="col-md-6 col-4 align-self-center">
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
        <form class="" method="POST" >
            
        <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                                Кредитование
                            </h3>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Минимальная сумма</label>
                                <div class="">
                                    <input type="text" class="form-control" name="loan_min_summ" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->loan_min_summ;?>
" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Сумма по умолчанию</label>
                                <div class="">
                                    <input type="text" class="form-control" name="loan_default_summ" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->loan_default_summ;?>
" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Максимальная сумма</label>
                                <div class="">
                                    <input type="text" class="form-control" name="loan_max_summ" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->loan_max_summ;?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Минимальный срок</label>
                                <div class="">
                                    <input type="text" class="form-control" name="loan_min_period" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->loan_min_period;?>
" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Срок по умолчанию</label>
                                <div class="">
                                    <input type="text" class="form-control" name="loan_default_period" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->loan_default_period;?>
" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Максимальный срок</label>
                                <div class="">
                                    <input type="text" class="form-control" name="loan_max_period" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->loan_max_period;?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Процент %/ день</label>
                                <div class="">
                                    <input type="text" class="form-control" name="loan_default_percent" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->loan_default_percent;?>
" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Пени %/ год</label>
                                <div class="">
                                    <input type="text" class="form-control" name="loan_peni" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->loan_peni;?>
" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Ответственность %/ день</label>
                                <div class="">
                                    <input type="text" class="form-control" name="loan_charge_percent" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->loan_charge_percent;?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                                                            
                    <hr class="mb-3 mt-3" />
                    
                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                                Пролонгация
                            </h3>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Срок пролонгации</label>
                                <div class="">
                                    <input type="text" class="form-control" name="prolongation_period" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->prolongation_period;?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Страховка, руб</label>
                                <div class="">
                                    <input type="text" class="form-control" name="prolongation_amount" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->prolongation_amount;?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            
                        </div>
                    </div>
                                                            
                    <hr class="mb-3 mt-3" />
                    
                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                                Цессия
                            </h3>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Срок просрочки, дней</label>
                                <div class="">
                                    <input type="text" class="form-control" name="cession_period" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->cession_period;?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Общая сумма выплат, % ОД</label>
                                <div class="">
                                    <input type="text" class="form-control" name="cession_amount" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->cession_amount;?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            
                        </div>
                    </div>

                    <hr class="mb-3 mt-3" />

                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                                Проверка по возрасту
                            </h3>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Минимальный пороговый возраст</label>
                                <div class="">
                                    <input type="text" class="form-control" name="min_threshold_age" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->min_threshold_age;?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Максимальный пороговый возраст</label>
                                <div class="">
                                    <input type="text" class="form-control" name="max_threshold_age" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->max_threshold_age;?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>

                    <hr class="mb-3 mt-3" />
                    
                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                                Отчеты
                            </h3>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Email для отправки ежедневного отчета</label>
                                <div class="">
                                    <input type="text" class="form-control" name="report_email" value="<?php echo $_smarty_tpl->tpl_vars['settings']->value->report_email;?>
" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        
        <hr class="mb-3 mt-3" />
        
        <div class="row">
            <div class="col-12 grid-stack-item" data-gs-x="0" data-gs-y="0" data-gs-width="12">
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Сохранить</button>
                </div>
            </div>
        </form>
        <!-- Row -->
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <?php echo $_smarty_tpl->getSubTemplate ('footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <!-- ============================================================== -->
</div>




<?php }} ?>
