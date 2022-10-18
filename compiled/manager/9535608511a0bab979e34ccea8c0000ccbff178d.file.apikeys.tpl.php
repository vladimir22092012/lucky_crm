<?php /* Smarty version Smarty-3.1.18, created on 2022-10-12 08:33:27
         compiled from "/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/apikeys.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1876263643634651a7204fa7-30153742%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9535608511a0bab979e34ccea8c0000ccbff178d' => 
    array (
      0 => '/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/apikeys.tpl',
      1 => 1660295912,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1876263643634651a7204fa7-30153742',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'apikeys' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_634651a72125a2_88943243',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_634651a72125a2_88943243')) {function content_634651a72125a2_88943243($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Ключи для API', null, 1);
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
                                Звонобот
                                <a href="//zvonobot.ru/" target="_blank"> <small> zvonobot.ru</small></a>
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <h4>МКК</h4>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">apiKey</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[zvonobot][apiKey]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['zvonobot']['apiKey'];?>
" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">outgoingPhone</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[zvonobot][outgoingPhone]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['zvonobot']['outgoingPhone'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h4>ЮК</h4>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">apiKey</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[zvonobot_yuk][apiKey]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['zvonobot_yuk']['apiKey'];?>
" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">outgoingPhone</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[zvonobot_yuk][outgoingPhone]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['zvonobot_yuk']['outgoingPhone'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <hr class="mt-3 mb-4" />
                    
                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                                Cloudkassir
                                <a href="//cloudkassir.ru/" target="_blank"> <small> cloudkassir.ru</small></a>
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">ck_API</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[cloudkassir][ck_API]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['cloudkassir']['ck_API'];?>
" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">ck_PublicId</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[cloudkassir][ck_PublicId]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['cloudkassir']['ck_PublicId'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">INN</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[cloudkassir][ck_INN]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['cloudkassir']['ck_INN'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <hr class="mt-3 mb-4" />
                    
                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                                Easy SMS
                                <a href="//smstec.ru" target="_blank"> <small> smstec.ru</small></a>
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">login</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[sms][login]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['sms']['login'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">password</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[sms][password]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['sms']['password'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">originator</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[sms][originator]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['sms']['originator'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">connect_id</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[sms][connect_id]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['sms']['connect_id'];?>
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
                                Mango Office
                                <a href="//mango-office.ru" target="_blank"> <small> mango-office.ru</small></a>
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">API ключ (Уникальный код вашей АТС)</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[mango][api_key]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['mango']['api_key'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">API соль (Ключ для создания подписи)</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[mango][api_salt]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['mango']['api_salt'];?>
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
                    
                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                                ФССП
                                <a href="//fssp.gov.ru" target="_blank"> <small> fssp.gov.ru</small></a>
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">API ключ</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[fssp][api_key]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['fssp']['api_key'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="mt-3 mb-4" />
                    
                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                                Scorista
                                <a href="//scorista.ru" target="_blank"> <small> scorista.ru</small></a>
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Имя пользователя</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[scorista][username]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['scorista']['username'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Токен</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[scorista][token]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['scorista']['token'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                                                            
                    <hr class="mt-3 mb-4" />
                    
                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                                Juicescore
                                <a href="//juicyscore.com" target="_blank"> <small> juicyscore.com</small></a>
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">API ключ</label>
                                <div class="">
                                    <input type="text" class="form-control" name="apikeys[juicescore][api_key]" value="<?php echo $_smarty_tpl->tpl_vars['apikeys']->value['juicescore']['api_key'];?>
" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    
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
