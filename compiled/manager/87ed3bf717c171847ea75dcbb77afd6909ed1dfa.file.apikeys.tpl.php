<?php /* Smarty version Smarty-3.1.18, created on 2022-06-29 19:25:09
         compiled from "/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/apikeys.tpl" */ ?>
<?php /*%%SmartyHeaderCode:78970093862bc69ee948596-19529080%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87ed3bf717c171847ea75dcbb77afd6909ed1dfa' => 
    array (
      0 => '/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/apikeys.tpl',
      1 => 1656519898,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '78970093862bc69ee948596-19529080',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_62bc69ee95f937_83165570',
  'variables' => 
  array (
    'apikeys' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62bc69ee95f937_83165570')) {function content_62bc69ee95f937_83165570($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Ключи для API', null, 1);
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
                <h3 class="text-themecolor mb-0 mt-0">
                    Ключи для API
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Ключи для API</li>
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
                                SMSC
                                <a href="//smsc.ru" target="_blank"> <small> smsc.ru</small></a>
                            </h3>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Логин</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[smsc][login]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['smsc']['login'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Пароль</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[smsc][password]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['smsc']['password'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Отправитель</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[smsc][sender]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['smsc']['sender'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="mt-3 mb-4" />
                    
                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                                Dadata
                                <a href="//dadata.ru" target="_blank"> <small> dadata.ru</small></a>
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">API-ключ</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[dadata][api_key]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['dadata']['api_key'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Секретный ключ для стандартизации</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[dadata][secret_key]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['dadata']['secret_key'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                                                            
                    <hr class="mt-3 mb-4" />
                    
                    

                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                                Anticaptcha
                                <a href="//anti-captcha.com" target="_blank"> <small> anti-captcha.com</small></a>
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">API ключ</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[anticaptcha][api_key]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['anticaptcha']['api_key'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                                        
                    <hr class="mt-3 mb-4" />
                    
                    

                    
                </div>
            </div>
            
        
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
</div><?php }} ?>
