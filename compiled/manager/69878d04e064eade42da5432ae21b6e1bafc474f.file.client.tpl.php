<?php /* Smarty version Smarty-3.1.18, created on 2022-12-02 16:18:50
         compiled from "/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/client.tpl" */ ?>
<?php /*%%SmartyHeaderCode:135378028663465508cd2ee1-23861507%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69878d04e064eade42da5432ae21b6e1bafc474f' => 
    array (
      0 => '/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/client.tpl',
      1 => 1669978755,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '135378028663465508cd2ee1-23861507',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_63465508d9a2d3_06326221',
  'variables' => 
  array (
    'client' => 0,
    'settings' => 0,
    'comments' => 0,
    'contactdata_error' => 0,
    'contactdata_errors' => 0,
    'contacts_error' => 0,
    'addresses_error' => 0,
    'regaddress' => 0,
    'faktaddress' => 0,
    'order' => 0,
    'work_error' => 0,
    'scoring_types' => 0,
    'scoring_type' => 0,
    'scorings' => 0,
    'scoring' => 0,
    'services_error' => 0,
    'cards' => 0,
    'card' => 0,
    'socials_error' => 0,
    'files' => 0,
    'file' => 0,
    'item_class' => 0,
    'config' => 0,
    'ribbon_class' => 0,
    'ribbon_icon' => 0,
    'images_error' => 0,
    'comment' => 0,
    'managers' => 0,
    'comments_1c' => 0,
    'documents' => 0,
    'document' => 0,
    'changelogs' => 0,
    'changelog' => 0,
    'changelog_types' => 0,
    'field' => 0,
    'old_value' => 0,
    'new_value' => 0,
    'order_statuses' => 0,
    'loan_history_item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_63465508d9a2d3_06326221')) {function content_63465508d9a2d3_06326221($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable(((string)$_smarty_tpl->tpl_vars['client']->value->lastname)." ".((string)$_smarty_tpl->tpl_vars['client']->value->firstname)." ".((string)$_smarty_tpl->tpl_vars['client']->value->patronymic), null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_scripts', null, null); ob_start(); ?>
    
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/fancybox3/dist/jquery.fancybox.js"></script>
    
    <script type="text/javascript" src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/order.js?v=1.28"></script>
    <script type="text/javascript" src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/movements.app.js"></script>
    <script>
        $(function(){
            let phone_num = "<?php echo $_smarty_tpl->tpl_vars['client']->value->phone_mobile;?>
";
            let firstname = "<?php echo $_smarty_tpl->tpl_vars['client']->value->firstname;?>
";
            let lastname = "<?php echo $_smarty_tpl->tpl_vars['client']->value->lastname;?>
";
            let patronymic = "<?php echo $_smarty_tpl->tpl_vars['client']->value->patronymic;?>
";

                $.ajax({
                    url:"ajax/BlacklistCheck.php",
                    data: {
                        phone_num: phone_num,
                        firstname: firstname,
                        lastname: lastname,
                        patronymic: patronymic
                    },
                    method: 'POST',
                    success: function (suc){
                        if(suc == 1)
                        {
                            $('.form-check-input').attr('checked', 'checked');
                        }
                    }
                });

            $(document).on('click', '.js-blocked-input', function(){
                var _blocked = $(this).is(':checked') ? 1 : 0;
                var _user = $(this).data('user');
                
                $.ajax({
                    data: {
                        action: 'blocked',
                        user_id: _user,
                        blocked: _blocked
                    },
                    type:'POST'
                })
            })

            $(document).on('click', '.form-check-input', function ()
                {
                    $.ajax({
                        url: "ajax/BlacklistAddDelete.php",
                        data: {
                            phone_num: phone_num,
                            firstname: firstname,
                            lastname: lastname,
                            patronymic: patronymic
                        },
                        method: 'POST'
                    });
                })
        })
    </script>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>


<?php $_smarty_tpl->_capture_stack[0][] = array('page_styles', null, null); ob_start(); ?>
    <link href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet" />
    <link href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/fancybox3/dist/jquery.fancybox.css" rel="stylesheet" />
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
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor mb-0 mt-0"><i class="mdi mdi-account-card-details"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->lastname, ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->firstname, ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->patronymic, ENT_QUOTES, 'UTF-8', true);?>
</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="clients">Клиенты</a></li>
                    <li class="breadcrumb-item active">Карточка клиента</li>
                </ol>
            </div>
            <div class="col-md-6 col-4 align-self-top">
                <div class="float-right"><?php echo $_smarty_tpl->tpl_vars['client']->value->UID;?>
</div>
            </div>
        </div>
        
        
        <div class="row" id="order_wrapper">
            <div class="col-lg-12">
                <div class="card card-outline-info">
                    
                    <div class="card-body">
                        
                            <div class="form-body">
                                
                                <div class="row pt-2">
                                    <div class="col-12">
                                        <div class="border p-2">
                                            <div class="row">
                                                <h3 class="form-control-static col-md-2">
                                                    <?php if ($_smarty_tpl->tpl_vars['client']->value->loaded_from_1c) {?><span class="label label-primary">1С</span><?php }?>
                                                    <?php if ($_smarty_tpl->tpl_vars['client']->value->have_crm_closed) {?><span class="label label-primary" title="Клиент уже имеет погашенные займы в CRM">ПК CRM</span>
                                                    <?php } elseif (count($_smarty_tpl->tpl_vars['client']->value->loan_history)>0) {?><span class="label label-success" title="Клиент уже имеет погашенные займы в CRM">ПК</span>
                                                    <?php } elseif (count($_smarty_tpl->tpl_vars['client']->value->orders)==1) {?><span class="badge badge-success">Новый клиент</span>
                                                    <?php } elseif (count($_smarty_tpl->tpl_vars['client']->value->orders)>1) {?><span class="label label-warning">Повтор</span>
                                                    <?php } else { ?><span class="label label-info">Лид <?php echo $_smarty_tpl->tpl_vars['client']->value->stages;?>
/6</span>
                                                    <?php }?>
                                                </h3>
                                                <div class="col-md-4">
                                                    <h3>
                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->lastname, ENT_QUOTES, 'UTF-8', true);?>

                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->firstname, ENT_QUOTES, 'UTF-8', true);?>

                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->patronymic, ENT_QUOTES, 'UTF-8', true);?>

                                                    </h3>
                                                    <small>Дата регистрации: 
                                                    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['client']->value->created);?>
</small>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="custom-control custom-checkbox mr-sm-2 mb-3">
                                                        <input type="checkbox" class="custom-control-input js-blocked-input" id="blocked" value="1" data-user="<?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['client']->value->blocked) {?>checked<?php }?>>
                                                        <label class="custom-control-label" for="blocked"><strong class="text-danger">Заблокирован</strong></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="1">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Находится в ч/с
                                                        </label>
                                                    </div>
                                                </div>
                                                <h3 class="col-md-4 text-right">
                                                    <span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->phone_mobile, ENT_QUOTES, 'UTF-8', true);?>
</span>
                                                    <button class="js-mango-call mango-call" data-phone="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->phone_mobile, ENT_QUOTES, 'UTF-8', true);?>
" title="Выполнить звонок">
                                                        <i class="fas fa-mobile-alt"></i>
                                                    </button>                                                
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <ul class="mt-2 nav nav-tabs" role="tablist">
                                <li class="nav-item"> 
                                    <a class="nav-link active" data-toggle="tab" href="#info" role="tab" aria-selected="false">
                                        <span class="hidden-sm-up"><i class="ti-home"></i></span> 
                                        <span class="hidden-xs-down">Персональная информация</span>
                                    </a> 
                                </li>
                                <li class="nav-item"> 
                                    <a class="nav-link" data-toggle="tab" href="#comments" role="tab" aria-selected="false">
                                        <span class="hidden-sm-up"><i class="ti-user"></i></span> 
                                        <span class="hidden-xs-down">
                                            Комментарии <?php if (count($_smarty_tpl->tpl_vars['comments']->value)>0) {?><span class="label label-rounded label-primary"><?php echo count($_smarty_tpl->tpl_vars['comments']->value);?>
</span><?php }?>
                                        </span>
                                    </a> 
                                </li>
                                <li class="nav-item"> 
                                    <a class="nav-link" data-toggle="tab" href="#documents" role="tab" aria-selected="true">
                                        <span class="hidden-sm-up"><i class="ti-email"></i></span> 
                                        <span class="hidden-xs-down">Документы</span>
                                    </a> 
                                </li>
                                <li class="nav-item"> 
                                    <a class="nav-link" data-toggle="tab" href="#logs" role="tab" aria-selected="true">
                                        <span class="hidden-sm-up"><i class="ti-email"></i></span> 
                                        <span class="hidden-xs-down">Логирование</span>
                                    </a> 
                                </li>
                                <li class="nav-item"> 
                                    <a class="nav-link" data-toggle="tab" href="#history" role="tab" aria-selected="true">
                                        <span class="hidden-sm-up"><i class="ti-email"></i></span> 
                                        <span class="hidden-xs-down">Кредитная история</span>
                                    </a> 
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content tabcontent-border">
                                <div class="tab-pane active" id="info" role="tabpanel">
                                    <div class="form-body p-2 pt-3">
                                        
                                        
        
                                        <div class="row">
                                            <div class="col-md-8 ">
                                                
                                                <!-- Контакты -->
                                                <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
" class="mb-3 border js-order-item-form" id="personal_data_form">
                                                
                                                    <input type="hidden" name="action" value="contactdata" />
                                                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
" />
                                                    
                                                    <h5 class="card-header">
                                                        <span class="text-white ">Контакты</span>
                                                        <a href="javascript:void(0);" class="float-right text-white js-edit-form"><i class=" fas fa-edit"></i></a></h3>
                                                    </h5>
                                                    
                                                    <div class="row pt-2 view-block <?php if ($_smarty_tpl->tpl_vars['contactdata_error']->value) {?>hide<?php }?>">
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Email:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->email, ENT_QUOTES, 'UTF-8', true);?>
</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Дата рождения:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->birth, ENT_QUOTES, 'UTF-8', true);?>
</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Место рождения:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->birth_place, ENT_QUOTES, 'UTF-8', true);?>
</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Паспорт:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['client']->value->passport_serial;?>
, от <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->passport_date, ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->subdivision_code, ENT_QUOTES, 'UTF-8', true);?>
</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Кем выдан:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->passport_issued, ENT_QUOTES, 'UTF-8', true);?>
</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Соцсети:</label>
                                                                <div class="col-md-8">
                                                                    <ul class="list-unstyled form-control-static pl-0">
                                                                        <?php if ($_smarty_tpl->tpl_vars['client']->value->social) {?>
                                                                        <li>
                                                                            <a target="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->social, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->social, ENT_QUOTES, 'UTF-8', true);?>
</a>
                                                                        </li>
                                                                        <?php }?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="row p-2 edit-block <?php if (!$_smarty_tpl->tpl_vars['contactdata_error']->value) {?>hide<?php }?>">
                                                        <?php if ($_smarty_tpl->tpl_vars['contactdata_error']->value) {?>
                                                        <div class="col-md-12">
                                                            <ul class="alert alert-danger">
                                                                <?php if (in_array('empty_email',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?><li>Укажите Email!</li><?php }?>
                                                                <?php if (in_array('empty_birth',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?><li>Укажите Дату рождения!</li><?php }?>
                                                                <?php if (in_array('empty_passport_serial',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?><li>Укажите серию и номер паспорта!</li><?php }?>
                                                                <?php if (in_array('empty_passport_date',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?><li>Укажите дату выдачи паспорта!</li><?php }?>
                                                                <?php if (in_array('empty_subdivision_code',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?><li>Укажите код подразделения выдавшего паспорт!</li><?php }?>
                                                                <?php if (in_array('empty_passport_issued',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?><li>Укажите кем выдан паспорт!</li><?php }?>
                                                            </ul>
                                                        </div>
                                                        <?php }?>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-1 <?php if (in_array('empty_email',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Email</label>
                                                                <input type="text" name="email" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->email, ENT_QUOTES, 'UTF-8', true);?>
" class="form-control" placeholder="" required="true" />
                                                                <?php if (in_array('empty_email',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?><small class="form-control-feedback">Укажите Email!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-1 <?php if (in_array('empty_birth',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Дата рождения</label>
                                                                <input type="text" name="birth" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->birth, ENT_QUOTES, 'UTF-8', true);?>
" class="form-control" placeholder="" required="true" />
                                                                <?php if (in_array('empty_birth',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?><small class="form-control-feedback">Укажите дату рождения!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-2">
                                                                <label class="control-label">Соцсети</label>
                                                                <input type="text" class="form-control" name="social" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->social, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-2 <?php if (in_array('empty_birth_place',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Место рождения</label>
                                                                <input type="text" name="birth_place" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->birth_place, ENT_QUOTES, 'UTF-8', true);?>
" class="form-control" placeholder="" required="true" />
                                                                <?php if (in_array('empty_birth_place',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?><small class="form-control-feedback">Укажите место рождения!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-1 <?php if (in_array('empty_passport_serial',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Серия и номер паспорта</label>
                                                                <input type="text" class="form-control" name="passport_serial" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->passport_serial, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_passport_serial',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?><small class="form-control-feedback">Укажите серию и номер паспорта!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-1 <?php if (in_array('empty_passport_date',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Дата выдачи</label>
                                                                <input type="text" class="form-control" name="passport_date" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->passport_date, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_passport_date',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?><small class="form-control-feedback">Укажите дату выдачи паспорта!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-1 <?php if (in_array('empty_subdivision_code',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Код подразделения</label>
                                                                <input type="text" class="form-control" name="subdivision_code" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->subdivision_code, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_subdivision_code',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?><small class="form-control-feedback">Укажите код подразделения выдавшего паспорт!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group <?php if (in_array('empty_passport_issued',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Кем выдан</label>
                                                                <input type="text" class="form-control" name="passport_issued" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->passport_issued, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_passport_issued',(array)$_smarty_tpl->tpl_vars['contactdata_errors']->value)) {?><small class="form-control-feedback">Укажите кем выдан паспорт!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        <div class="col-md-12">
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Сохранить</button>
                                                                <button type="button" class="btn btn-inverse js-cancel-edit">Отмена</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>        
                                                <!-- / Контакты-->

                                                <!-- /Контактные лица -->
                                                <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
" class="js-order-item-form mb-3 border" id="contact_persons_form">
                                                
                                                    <input type="hidden" name="action" value="contacts" />
                                                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
" />
                                                
                                                    <h5 class="card-header">
                                                        <span class="text-white">Контактные лица</span>
                                                        <a href="javascript:void(0);" class="text-white float-right js-edit-form"><i class=" fas fa-edit"></i></a></h3>
                                                    </h5>
                                                    
                                                    <div class="row view-block m-0 <?php if ($_smarty_tpl->tpl_vars['contacts_error']->value) {?>hide<?php }?>">
                                                        <table class="table table-hover mb-0">
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->contact_person_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->contact_person_relation, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                                                <td class="text-right"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->contact_person_phone, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                                                <td>
                                                                    <button class="js-mango-call mango-call" data-phone="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->contact_person_phone, ENT_QUOTES, 'UTF-8', true);?>
" title="Выполнить звонок">
                                                                        <i class="fas fa-mobile-alt"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->contact_person2_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->contact_person2_relation, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                                                <td class="text-right"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->contact_person2_phone, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                                                <td>
                                                                    <button class="js-mango-call mango-call" data-phone="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->contact_person2_phone, ENT_QUOTES, 'UTF-8', true);?>
" title="Выполнить звонок">
                                                                        <i class="fas fa-mobile-alt"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    
                                                    <div class="row m-0 pt-2 pb-2 edit-block <?php if (!$_smarty_tpl->tpl_vars['contacts_error']->value) {?>hide<?php }?>">
                                                        <?php if ($_smarty_tpl->tpl_vars['contacts_error']->value) {?>
                                                        <div class="col-md-12">
                                                            <ul class="alert alert-danger">
                                                                <?php if (in_array('empty_contact_person_name',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?><li>Укажите ФИО контакного лица!</li><?php }?>
                                                                <?php if (in_array('empty_contact_person_phone',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?><li>Укажите тел. контакного лица!</li><?php }?>
                                                                <?php if (in_array('empty_contact_person_relation',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?><li>Укажите кем приходится контакное лицо!</li><?php }?>
                                                                <?php if (in_array('empty_contact_person2_name',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?><li>Укажите ФИО контакного лица 2!</li><?php }?>
                                                                <?php if (in_array('empty_contact_person2_phone',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?><li>Укажите тел. контакного лица 2!</li><?php }?>
                                                                <?php if (in_array('empty_contact_person2_relation',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?><li>Укажите кем приходится контакное лицо 2!</li><?php }?>
                                                            </ul>
                                                        </div>
                                                        <?php }?>
                                                        <div class="col-md-4">
                                                            <div class="form-group <?php if (in_array('empty_contact_person_name',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">ФИО контакного лица</label>
                                                                <input type="text" class="form-control" name="contact_person_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->contact_person_name, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_contact_person_name',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?><small class="form-control-feedback">Укажите ФИО контакного лица!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group <?php if (in_array('empty_contact_person_relation',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Кем приходится</label>
                                                                <select class="form-control custom-select" name="contact_person_relation">
                                                                    <option value="" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person_relation=='') {?>selected=""<?php }?>>Выберите значение</option>
                                                                    <option value="мать/отец" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person_relation=='мать/отец') {?>selected=""<?php }?>>мать/отец</option>
                                                                    <option value="муж/жена" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person_relation=='муж/жена') {?>selected=""<?php }?>>муж/жена</option>
                                                                    <option value="сын/дочь" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person_relation=='сын/дочь') {?>selected=""<?php }?>>сын/дочь</option>
                                                                    <option value="коллега" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person_relation=='коллега') {?>selected=""<?php }?>>коллега</option>
                                                                    <option value="друг/сосед" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person_relation=='друг/сосед') {?>selected=""<?php }?>>друг/сосед</option>
                                                                    <option value="иной родственник" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person_relation=='иной родственник') {?>selected=""<?php }?>>иной родственник</option>
                                                                </select>
                                                                <?php if (in_array('empty_contact_person_relation',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?><small class="form-control-feedback">Укажите кем приходится контакное лицо!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group <?php if (in_array('empty_contact_person_phone',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Тел. контакного лица</label>
                                                                <input type="text" class="form-control" name="contact_person_phone" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->contact_person_phone, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_contact_person_phone',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?><small class="form-control-feedback">Укажите тел. контакного лица!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4">
                                                            <div class="form-group <?php if (in_array('empty_contact_person2_name',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">ФИО контакного лица 2</label>
                                                                <input type="text" class="form-control" name="contact_person2_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->contact_person2_name, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_contact_person2_name',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?><small class="form-control-feedback">Укажите ФИО контакного лица!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group <?php if (in_array('empty_contact_person2_relation',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Кем приходится</label>
                                                                <select class="form-control custom-select" name="contact_person2_relation">
                                                                    <option value="" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person2_relation=='') {?>selected=""<?php }?>>Выберите значение</option>
                                                                    <option value="мать/отец" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person2_relation=='мать/отец') {?>selected=""<?php }?>>мать/отец</option>
                                                                    <option value="муж/жена" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person2_relation=='муж/жена') {?>selected=""<?php }?>>муж/жена</option>
                                                                    <option value="сын/дочь" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person2_relation=='сын/дочь') {?>selected=""<?php }?>>сын/дочь</option>
                                                                    <option value="коллега" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person2_relation=='коллега') {?>selected=""<?php }?>>коллега</option>
                                                                    <option value="друг/сосед" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person2_relation=='друг/сосед') {?>selected=""<?php }?>>друг/сосед</option>
                                                                    <option value="иной родственник" <?php if ($_smarty_tpl->tpl_vars['client']->value->contact_person2_relation=='иной родственник') {?>selected=""<?php }?>>иной родственник</option>
                                                                </select>
                                                                <?php if (in_array('empty_contact_person2_relation',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?><small class="form-control-feedback">Укажите кем приходится контакное лицо!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group <?php if (in_array('empty_contact_person2_phone',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Тел. контакного лица 2</label>
                                                                <input type="text" class="form-control" name="contact_person2_phone" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->contact_person2_phone, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" />
                                                                <?php if (in_array('empty_contact_person2_phone',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?><small class="form-control-feedback">Укажите тел. контакного лица!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        
                                                        <div class="col-md-12">
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Сохранить</button>
                                                                <button type="button" class="btn btn-inverse js-cancel-edit">Отмена</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>        

                                                <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
" class="js-order-item-form mb-3 border" id="address_form">
                                                
                                                    <input type="hidden" name="action" value="addresses" />
                                                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
" />
                                                    
                                                    <h5 class="card-header">
                                                        <span class="text-white">Адрес</span>
                                                        <a href="javascript:void(0);" class="text-white float-right js-edit-form"><i class=" fas fa-edit"></i></a></h3>
                                                    </h5>
                                                    
                                                    <div class="row view-block <?php if ($_smarty_tpl->tpl_vars['addresses_error']->value) {?>hide<?php }?>">
                                                        <div class="col-md-12">
                                                            <table class="table table-hover mb-0">
                                                                <tr>
                                                                    <td>Адрес прописки</td>
                                                                    <td><?php echo $_smarty_tpl->tpl_vars['regaddress']->value;?>
</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Адрес проживания</td>
                                                                    <td><?php echo $_smarty_tpl->tpl_vars['faktaddress']->value;?>
</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="edit-block m-0 <?php if (!$_smarty_tpl->tpl_vars['addresses_error']->value) {?>hide<?php }?>">
                                                        
                                                        <div class="row m-0 mb-2 mt-2 js-dadata-address">
                                                            <h6 class="col-12 nav-small-cap">Адрес прописки</h6>
                                                            <?php if ($_smarty_tpl->tpl_vars['addresses_error']->value) {?>
                                                            <div class="col-md-12">
                                                                <ul class="alert alert-danger">
                                                                    <?php if (in_array('empty_regregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><li>Укажите область!</li><?php }?>
                                                                    <?php if (in_array('empty_regcity',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><li>Укажите город!</li><?php }?>
                                                                    <?php if (in_array('empty_regstreet',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><li>Укажите улицу!</li><?php }?>
                                                                    <?php if (in_array('empty_reghousing',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><li>Укажите дом!</li><?php }?>
                                                                    <?php if (in_array('empty_faktregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><li>Укажите область!</li><?php }?>
                                                                    <?php if (in_array('empty_faktcity',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><li>Укажите город!</li><?php }?>
                                                                    <?php if (in_array('empty_faktstreet',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><li>Укажите улицу!</li><?php }?>
                                                                    <?php if (in_array('empty_fakthousing',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><li>Укажите дом!</li><?php }?>
                                                                </ul>
                                                            </div>
                                                            <?php }?>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_regregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <input type="text" class="form-control js-dadata-onestring" name="" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regaddress_full, ENT_QUOTES, 'UTF-8', true);?>
" placeholder=""/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_regregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Область</label>
                                                                    <input type="text" class="form-control js-dadata-region" name="Regregion" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Regregion, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                    <?php if (in_array('empty_regregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><small class="form-control-feedback">Укажите область!</small><?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_regcity',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Город</label>
                                                                    <input type="text" class="form-control js-dadata-city" name="Regcity" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Regcity, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                    <?php if (in_array('empty_regcity',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><small class="form-control-feedback">Укажите город!</small><?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-1 ">
                                                                    <label class="control-label">Район</label>
                                                                    <input type="text" class="form-control js-dadata-district" name="Regdistrict" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Regdistrict, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-1 ">
                                                                    <label class="control-label">Нас. пункт</label>
                                                                    <input type="text" class="form-control js-dadata-locality" name="Reglocality" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Reglocality, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_regstreet',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Улица</label>
                                                                    <input type="text" class="form-control js-dadata-street" name="Regstreet" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Regstreet, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                    <?php if (in_array('empty_regstreet',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><small class="form-control-feedback">Укажите улицу!</small><?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group <?php if (in_array('empty_reghousing',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Дом</label>
                                                                    <input type="text" class="form-control js-dadata-house" name="Reghousing" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Reghousing, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                    <?php if (in_array('empty_reghousing',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><small class="form-control-feedback">Укажите дом!</small><?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Строение</label>
                                                                    <input type="text" class="form-control js-dadata-building" name="Regbuilding" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Regbuilding, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Квартира</label>
                                                                    <input type="text" class="form-control js-dadata-room" name="Regroom" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Regroom, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Индекс</label>
                                                                    <input type="text" class="form-control js-dadata-index" name="Regindex" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Regindex, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="equal" value="1" class="js-equal-address" id="equal_address" />
                                                                    <label class="" for="equal_address">Адрес проживания совпадает с адресом прописки</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row m-0 js-dadata-address">
                                                            <h6 class="col-12 nav-small-cap">Адрес проживания</h6>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_regregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <input type="text" class="form-control js-dadata-onestring" name="" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regaddress_full, ENT_QUOTES, 'UTF-8', true);?>
" placeholder=""/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_faktregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Область</label>
                                                                    <input type="text" class="form-control js-dadata-region" name="Faktregion" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Faktregion, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                    <?php if (in_array('empty_faktregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><small class="form-control-feedback">Укажите область!</small><?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_faktcity',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Город</label>
                                                                    <input type="text" class="form-control js-dadata-city" name="Faktcity" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Faktcity, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                    <?php if (in_array('empty_faktcity',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><small class="form-control-feedback">Укажите город!</small><?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-1">
                                                                    <label class="control-label">Район</label>
                                                                    <input type="text" class="form-control js-dadata-district" name="Faktdistrict" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Faktdistrict, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-1">
                                                                    <label class="control-label">Нас. пункт</label>
                                                                    <input type="text" class="form-control js-dadata-locality" name="Faktlocality" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Faktlocality, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_faktstreet',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Улица</label>
                                                                    <input type="text" class="form-control js-dadata-street" name="Faktstreet" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Faktstreet, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                    <?php if (in_array('empty_faktstreet',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><small class="form-control-feedback">Укажите улицу!</small><?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group <?php if (in_array('empty_fakthousing',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Дом</label>
                                                                    <input type="text" class="form-control js-dadata-house" name="Fakthousing" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Fakthousing, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                    <?php if (in_array('empty_fakthousing',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?><small class="form-control-feedback">Укажите дом!</small><?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Строение</label>
                                                                    <input type="text" class="form-control js-dadata-building" name="Faktbuilding" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Faktbuilding, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Квартира</label>
                                                                    <input type="text" class="form-control js-dadata-room" name="Faktroom" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Faktroom, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Индекс</label>
                                                                    <input type="text" class="form-control js-dadata-index" name="Faktindex" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->Faktindex, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row m-0 mt-2 mb-2">
                                                            <div class="col-md-12">
                                                                <div class="form-actions">
                                                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Сохранить</button>
                                                                    <button type="button" class="btn btn-inverse js-cancel-edit">Отмена</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                
                                                
                                                
                                                
                                                <!-- Данные о работе -->
                                                <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
" class="border js-order-item-form mb-3" id="work_data_form">
                                                
                                                    <input type="hidden" name="action" value="work" />
                                                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
" />
                                                    
                                                    <h5 class="card-header">
                                                        <span class="text-white">Данные о работе</span>
                                                        <a href="javascript:void(0);" class="text-white float-right js-edit-form"><i class=" fas fa-edit"></i></a></h3>
                                                    </h5>
                                                    
                                                    <div class="row m-0 pt-2 view-block <?php if ($_smarty_tpl->tpl_vars['work_error']->value) {?>hide<?php }?>">
                                                        <?php if ($_smarty_tpl->tpl_vars['client']->value->workplace||$_smarty_tpl->tpl_vars['client']->value->workphone) {?>
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-0  row">
                                                                <label class="control-label col-md-4">Название организации:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">
                                                                        <span class="clearfix">
                                                                            <span class="float-left">
                                                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->workplace, ENT_QUOTES, 'UTF-8', true);?>

                                                                            </span>
                                                                            <span class="float-right">
                                                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->workphone, ENT_QUOTES, 'UTF-8', true);?>

                                                                                <button class="js-mango-call mango-call" data-phone="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->workphone, ENT_QUOTES, 'UTF-8', true);?>
" title="Выполнить звонок">
                                                                                    <i class="fas fa-mobile-alt"></i>
                                                                                </button>
                                                                            </span>
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['client']->value->workaddress) {?>
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-0 row">
                                                                <label class="control-label col-md-4">Адрес:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">
                                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->workaddress, ENT_QUOTES, 'UTF-8', true);?>

                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['client']->value->profession) {?>
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-0 row">
                                                                <label class="control-label col-md-4">Должность:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">
                                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->profession, ENT_QUOTES, 'UTF-8', true);?>

                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php }?>
                                                        <div class="col-md-12">
                                                            <div class="form-group  mb-0 row">
                                                                <label class="control-label col-md-4">Руководитель:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">
                                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->chief_name, ENT_QUOTES, 'UTF-8', true);?>
, <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->chief_position, ENT_QUOTES, 'UTF-8', true);?>

                                                                        <br />
                                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->chief_phone, ENT_QUOTES, 'UTF-8', true);?>

                                                                        <button class="js-mango-call mango-call" data-phone="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->chief_phone, ENT_QUOTES, 'UTF-8', true);?>
" title="Выполнить звонок">
                                                                            <i class="fas fa-mobile-alt"></i>
                                                                        </button>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group  mb-0 row">
                                                                <label class="control-label col-md-4">Доход:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">
                                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->income, ENT_QUOTES, 'UTF-8', true);?>

                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group  mb-0 row">
                                                                <label class="control-label col-md-4">Расход:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">
                                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->expenses, ENT_QUOTES, 'UTF-8', true);?>

                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group  mb-0 row">
                                                                <label class="control-label col-md-4">Комментарий к работе:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">
                                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->workcomment, ENT_QUOTES, 'UTF-8', true);?>

                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row m-0 pt-2 edit-block js-dadata-address <?php if (!$_smarty_tpl->tpl_vars['work_error']->value) {?>hide<?php }?>">
                                                        <?php if ($_smarty_tpl->tpl_vars['work_error']->value) {?>
                                                        <div class="col-md-12">
                                                            <ul class="alert alert-danger">
                                                            
                                                                <?php if (in_array('empty_workplace',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><li>Укажите название организации!</li><?php }?>
                                                                <?php if (in_array('empty_profession',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><li>Укажите должность!</li><?php }?>
                                                                <?php if (in_array('empty_workphone',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><li>Укажите рабочий телефон!</li><?php }?>
                                                                <?php if (in_array('empty_income',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><li>Укажите доход!</li><?php }?>
                                                                <?php if (in_array('empty_expenses',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><li>Укажите расход!</li><?php }?>
                                                                <?php if (in_array('empty_chief_name',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><li>Укажите ФИО начальника!</li><?php }?>
                                                                <?php if (in_array('empty_chief_position',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><li>Укажите Должность начальника!</li><?php }?>
                                                                <?php if (in_array('empty_chief_phone',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><li>Укажите Телефон начальника!</li><?php }?>
                                                                
                                                            </ul>
                                                        </div>
                                                        <?php }?>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_workplace',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Название организации</label>
                                                                <input type="text" class="form-control" name="workplace" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->workplace, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_workplace',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><small class="form-control-feedback">Укажите название организации!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_profession',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Должность</label>
                                                                <input type="text" class="form-control" name="profession" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->profession, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_profession',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><small class="form-control-feedback">Укажите должность!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-0">
                                                                <label class="control-label">Адрес организации</label>
                                                                <input type="text" class="form-control" name="workaddress" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->workaddress, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_workphone',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Pабочий телефон</label>
                                                                <input type="text" class="form-control" name="workphone" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->workphone, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_workphone',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><small class="form-control-feedback">Укажите рабочий телефон!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_income',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Доход</label>
                                                                <input type="text" class="form-control" name="income" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->income, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_income',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><small class="form-control-feedback">Укажите доход!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_expenses',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Расход</label>
                                                                <input type="text" class="form-control" name="expenses" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->expenses, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_expenses',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><small class="form-control-feedback">Укажите расход!</small><?php }?>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_chief_name',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">ФИО начальника</label>
                                                                <input type="text" class="form-control" name="chief_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->chief_name, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_chief_name',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><small class="form-control-feedback">Укажите ФИО начальника!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_chief_position',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Должность начальника</label>
                                                                <input type="text" class="form-control" name="chief_position" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->chief_position, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_chief_position',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><small class="form-control-feedback">Укажите Должность начальника!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_chief_phone',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Телефон начальника</label>
                                                                <input type="text" class="form-control" name="chief_phone" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->chief_phone, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" required="true" />
                                                                <?php if (in_array('empty_chief_phone',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?><small class="form-control-feedback">Укажите Телефон начальника!</small><?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 ">
                                                                <label class="control-label">Комментарий к работе</label>
                                                                <input type="text" class="form-control" name="workcomment" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->workcomment, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="" />
                                                            </div>
                                                        </div>
                                                                                                                
                                                        <div class="col-md-12 pb-2 mt-2">
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Сохранить</button>
                                                                <button type="button" class="btn btn-inverse js-cancel-edit">Отмена</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>                                                
                                                
                                                
                                                <!-- /Данные о работе -->
                                                
                                                
                                                
                                                <!--
                                                <h3 class="box-title mt-5">UTM-метки</h3>
                                                <hr>
                                                -->
                                            </div>
                                            <div class="col-md-4 ">
                                                <div class="mb-3 border">
                                                    <h5 class=" card-header">
                                                        <span class="text-white ">Скоринги</span>
                                                        <a class="text-white float-right js-run-scorings" data-type="all" data-order="<?php echo $_smarty_tpl->tpl_vars['client']->value->order_id;?>
" href="javascript:void(0);">
                                                            <i class="far fa-play-circle"></i>
                                                        </a>
                                                    </h2>
                                                    <div class="message-box">
                                                            
                                                        <?php  $_smarty_tpl->tpl_vars['scoring_type'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['scoring_type']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['scoring_types']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['scoring_type']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['scoring_type']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['scoring_type']->key => $_smarty_tpl->tpl_vars['scoring_type']->value) {
$_smarty_tpl->tpl_vars['scoring_type']->_loop = true;
 $_smarty_tpl->tpl_vars['scoring_type']->iteration++;
 $_smarty_tpl->tpl_vars['scoring_type']->last = $_smarty_tpl->tpl_vars['scoring_type']->iteration === $_smarty_tpl->tpl_vars['scoring_type']->total;
?>
                                                        <div class="pl-2 pr-2 <?php if (is_null($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->success)) {?>bg-light-warning<?php } elseif ($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->success) {?>bg-light-success<?php } else { ?>bg-light-danger<?php }?>">
                                                            <div class="row <?php if (!$_smarty_tpl->tpl_vars['scoring_type']->last) {?>border-bottom<?php }?>">
                                                                <div class="col-12 col-sm-12 pt-2">
                                                                    <h5 class="float-left"><?php echo $_smarty_tpl->tpl_vars['scoring_type']->value->title;?>
</h5>
                                                                    <?php if (is_null($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->success)) {?>
                                                                        <span class="label label-warning float-right">Нет результата</span> 
                                                                    <?php } elseif ($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->success) {?>
                                                                        <span class="label label-success label-sm float-right">Пройден</span>
                                                                    <?php } else { ?>
                                                                        <span class="label label-danger float-right">Не пройден</span>
                                                                    <?php }?>                                                                    
                                                                </div>
                                                                <div class="col-8 col-sm-8 pb-2">
                                                                    <span class="mail-desc" title="<?php echo $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->string_result;?>
"><?php echo $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->string_result;?>
</span>
                                                                    <span class="time">
                                                                        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->created);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['scoring']->value->created);?>

                                                                    </span>
                                                                </div>
                                                                <div class="col-4 col-sm-4 pb-2">
                                                                    <?php if (is_null($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->success)) {?>
                                                                        <a class="load-btn text-info js-run-scorings run-scoring-btn float-right" data-type="<?php echo $_smarty_tpl->tpl_vars['scoring_type']->value->name;?>
" data-order="<?php echo $_smarty_tpl->tpl_vars['client']->value->order_id;?>
" href="javascript:void(0);">
                                                                            <i class="far fa-play-circle"></i>
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <a class="text-info load-btn js-run-scorings run-scoring-btn float-right" data-type="<?php echo $_smarty_tpl->tpl_vars['scoring_type']->value->name;?>
" data-order="<?php echo $_smarty_tpl->tpl_vars['client']->value->order_id;?>
" href="javascript:void(0);">
                                                                            <i class="fas fa-undo"></i>
                                                                        </a>
                                                                    <?php }?>                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            
                                                <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
" class="mb-3 border js-order-item-form" id="services_form">
                
                                                    <input type="hidden" name="action" value="services" />
                                                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
" />
                                                    
                                                    
                                                    <h5 class="card-header text-white">
                                                        <span>Услуги</span>
                                                        <a href="javascript:void(0);" class="js-edit-form float-right text-white"><i class=" fas fa-edit"></i></a>
                                                    </h5>
                                                    
                                                    <div class="row view-block p-2 <?php if ($_smarty_tpl->tpl_vars['services_error']->value) {?>hide<?php }?>">
                                                        <div class="col-md-12">
                                                            
                                                            <div class="form-group mb-0 row">
                                                                <label class="control-label col-md-8 col-7">Причина отказа:</label>
                                                                <div class="col-md-4 col-5">
                                                                    <p class="form-control-static text-right">
                                                                        <?php if ($_smarty_tpl->tpl_vars['client']->value->service_reason) {?>
                                                                            <span class="label label-success">Вкл</span>
                                                                        <?php } else { ?>
                                                                            <span class="label label-danger">Выкл</span>
                                                                        <?php }?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-0 row">
                                                                <label class="control-label col-md-8 col-7">Страхование:</label>
                                                                <div class="col-md-4 col-5">
                                                                    <p class="form-control-static text-right">
                                                                        <?php if ($_smarty_tpl->tpl_vars['client']->value->service_insurance) {?>
                                                                            <span class="label label-success">Вкл</span>
                                                                        <?php } else { ?>
                                                                            <span class="label label-danger">Выкл</span>
                                                                        <?php }?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row p-2 edit-block <?php if (!$_smarty_tpl->tpl_vars['services_error']->value) {?>hide<?php }?>">
                                                        <div class="col-md-12">
                                                            
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="service_reason" id="service_reason" value="1" <?php if ($_smarty_tpl->tpl_vars['client']->value->service_reason) {?>checked="true"<?php }?> />
                                                                    <label class="custom-control-label" for="service_reason">Причина отказа</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="service_insurance" id="service_insurance" value="1" <?php if ($_smarty_tpl->tpl_vars['client']->value->service_insurance) {?>checked="true"<?php }?> />
                                                                    <label class="custom-control-label" for="service_insurance">Страхование</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Сохранить</button>
                                                                <button type="button" class="btn btn-inverse js-cancel-edit">Отмена</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                
                                                <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
" class="mb-3 border js-order-item-form" id="cards_form">
                
                                                    <input type="hidden" name="action" value="cards" />
                                                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
" />
                                                    
                                                    <h5 class="card-header text-white">
                                                        <span>Карты</span>
                                                    </h5>
                                                    
                                                    <div class="row view-block p-2 <?php if ($_smarty_tpl->tpl_vars['services_error']->value) {?>hide<?php }?>">
                                                        <div class="col-md-12">
                                                            <table class="table table-stripped">
                                                            <?php  $_smarty_tpl->tpl_vars['card'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['card']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cards']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['card']->key => $_smarty_tpl->tpl_vars['card']->value) {
$_smarty_tpl->tpl_vars['card']->_loop = true;
?>
                                                                <tr class="<?php if ($_smarty_tpl->tpl_vars['card']->value->deleted) {?>bg-light-danger<?php }?>">
                                                                    <td>
                                                                        <div>
                                                                            <strong><?php echo $_smarty_tpl->tpl_vars['card']->value->pan;?>
</strong>
                                                                            <p><?php echo $_smarty_tpl->tpl_vars['card']->value->bin_issuer;?>
</p>
                                                                        </div>
                                                                                                                                                
                                                                    </td>
                                                                    <td>
                                                                        <?php if ($_smarty_tpl->tpl_vars['card']->value->deleted) {?>
                                                                            <span class="label label-danger">Удалена</span>
                                                                        <?php }?>
                                                                        <?php if ($_smarty_tpl->tpl_vars['card']->value->base_card) {?>
                                                                        <span class="label label-primary">Основная</span>
                                                                        <?php }?>                                                                        
                                                                    </td>
                                                                    <td>
                                                                        <div><?php echo $_smarty_tpl->tpl_vars['card']->value->expdate;?>
</div>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    
                                                </form>
                                            
                                            </div>
                                        </div>
                                        <!-- -->
                                        <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
" class="border js-order-item-form mb-3" id="images_form">
                                        
                                            <input type="hidden" name="action" value="images" />
                                            <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
" />
                                            
                                            <h5 class="card-header">
                                                <span class="text-white">Фотографии</span>
                                                
                                            </h5>
                                            
                                            <div class="row p-2 view-block <?php if ($_smarty_tpl->tpl_vars['socials_error']->value) {?>hide<?php }?>">
                                                <ul class="col-md-12 list-inline">
                                                <?php  $_smarty_tpl->tpl_vars['file'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['file']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['file']->key => $_smarty_tpl->tpl_vars['file']->value) {
$_smarty_tpl->tpl_vars['file']->_loop = true;
?>
                                                    <?php if ($_smarty_tpl->tpl_vars['file']->value->status==0) {?>
                                                        <?php $_smarty_tpl->tpl_vars['item_class'] = new Smarty_variable("border-warning", null, 0);?>
                                                        <?php $_smarty_tpl->tpl_vars['ribbon_class'] = new Smarty_variable("ribbon-warning", null, 0);?>
                                                        <?php $_smarty_tpl->tpl_vars['ribbon_icon'] = new Smarty_variable("fas fa-question", null, 0);?>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['file']->value->status==1) {?>
                                                        <?php $_smarty_tpl->tpl_vars['item_class'] = new Smarty_variable("border-primary", null, 0);?>
                                                        <?php $_smarty_tpl->tpl_vars['ribbon_class'] = new Smarty_variable("ribbon-primary", null, 0);?>
                                                        <?php $_smarty_tpl->tpl_vars['ribbon_icon'] = new Smarty_variable("fas fa-clock", null, 0);?>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['file']->value->status==2) {?>
                                                        <?php $_smarty_tpl->tpl_vars['item_class'] = new Smarty_variable("border-success border border-bg", null, 0);?>
                                                        <?php $_smarty_tpl->tpl_vars['ribbon_class'] = new Smarty_variable("ribbon-success", null, 0);?>
                                                        <?php $_smarty_tpl->tpl_vars['ribbon_icon'] = new Smarty_variable("fa fa-check-circle", null, 0);?>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['file']->value->status==3) {?>
                                                        <?php $_smarty_tpl->tpl_vars['item_class'] = new Smarty_variable("border-danger border", null, 0);?>
                                                        <?php $_smarty_tpl->tpl_vars['ribbon_class'] = new Smarty_variable("ribbon-danger", null, 0);?>
                                                        <?php $_smarty_tpl->tpl_vars['ribbon_icon'] = new Smarty_variable("fas fa-times-circle", null, 0);?>
                                                    <?php }?>
                                                    <li class="order-image-item ribbon-wrapper rounded-sm border <?php echo $_smarty_tpl->tpl_vars['item_class']->value;?>
">
                                                        <a class="image-popup-fit-width" href="javascript:void(0)" onclick="window.open('<?php echo $_smarty_tpl->tpl_vars['config']->value->front_url;?>
/files/users/<?php echo $_smarty_tpl->tpl_vars['file']->value->name;?>
')">                                                            
                                                            <div class="ribbon ribbon-corner <?php echo $_smarty_tpl->tpl_vars['ribbon_class']->value;?>
"><i class="<?php echo $_smarty_tpl->tpl_vars['ribbon_icon']->value;?>
"></i></div>
                                                            <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value->front_url;?>
/files/users/<?php echo $_smarty_tpl->tpl_vars['file']->value->name;?>
" alt="" class="img-responsive" style="" />
                                                        </a>
                                                        <div class="order-image-actions">
                                                            <div class="dropdown mr-1 show ">
                                                                <button type="button" class="btn <?php if ($_smarty_tpl->tpl_vars['file']->value->status==2) {?>btn-success<?php } elseif ($_smarty_tpl->tpl_vars['file']->value->status==3) {?>btn-danger<?php } else { ?>btn-secondary<?php }?> dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                  <?php if ($_smarty_tpl->tpl_vars['file']->value->status==2) {?>Принят
                                                                  <?php } elseif ($_smarty_tpl->tpl_vars['file']->value->status==3) {?>Отклонен
                                                                  <?php } else { ?>Статус
                                                                  <?php }?>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset" x-placement="bottom-start" >
                                                                    <div class="p-1 dropdown-item">
                                                                        <button class="btn btn-sm btn-block btn-success js-image-accept" data-id="<?php echo $_smarty_tpl->tpl_vars['file']->value->id;?>
" type="button">
                                                                            <i class="fas fa-check-circle"></i>
                                                                            <span>Принят</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="p-1 dropdown-item">
                                                                        <button class="btn btn-sm btn-block btn-danger js-image-reject" data-id="<?php echo $_smarty_tpl->tpl_vars['file']->value->id;?>
" type="button">
                                                                            <i class="fas fa-times-circle"></i>
                                                                            <span>Отклонен</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                                </ul>
                                            </div>
                                            
                                            <div class="row edit-block <?php if (!$_smarty_tpl->tpl_vars['images_error']->value) {?>hide<?php }?>">
                                                <?php  $_smarty_tpl->tpl_vars['file'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['file']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['file']->key => $_smarty_tpl->tpl_vars['file']->value) {
$_smarty_tpl->tpl_vars['file']->_loop = true;
?>
                                                <div class="col-md-4 col-lg-3 col-xlg-3">
                                                    <div class="card card-body">
                                                        <div class="row">
                                                            
                                                            <div class="col-md-6 col-lg-8">
                                                                <div class="form-group">
                                                                    <label class="control-label">Статус</label>
                                                                    <input type="text"  id="status_<?php echo $_smarty_tpl->tpl_vars['file']->value->id;?>
" name="status[<?php echo $_smarty_tpl->tpl_vars['file']->value->id;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['file']->value->status;?>
" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="col-md-12">
                                                    <div class="form-actions">
                                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Сохранить</button>
                                                        <button type="button" class="btn btn-inverse js-cancel-edit">Отмена</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- -->
                                        
                                        
                                    </div>
                                </div>
                                
                                <div class="tab-pane p-3" id="comments" role="tabpanel">
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            
                                        </div>
                                        <hr class="m-3" />
                                        <div class="col-12">
                                            <?php if ($_smarty_tpl->tpl_vars['comments']->value) {?>
                                            <h4>Комментарии к заявкам</h4>
                                            <div class="message-box">
                                                <div class="message-widget">
                                                    <?php  $_smarty_tpl->tpl_vars['comment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['comment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['comment']->key => $_smarty_tpl->tpl_vars['comment']->value) {
$_smarty_tpl->tpl_vars['comment']->_loop = true;
?>
                                                    <a href="order/<?php echo $_smarty_tpl->tpl_vars['comment']->value->order_id;?>
">
                                                        <div class="user-img"> 
                                                            <span class="round"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['comment']->value->letter, ENT_QUOTES, 'UTF-8', true);?>
</span>
                                                        </div>
                                                        <div class="mail-contnet">
                                                            <h5><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['managers']->value[$_smarty_tpl->tpl_vars['comment']->value->manager_id]->name, ENT_QUOTES, 'UTF-8', true);?>
</h5> 
                                                            <span class="mail-desc">
                                                                <?php echo nl2br($_smarty_tpl->tpl_vars['comment']->value->text);?>

                                                            </span> 
                                                            <span class="time">
                                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['comment']->value->created);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['comment']->value->created);?>
 
                                                                <i>Комментарий оставлен к заявке №<?php echo $_smarty_tpl->tpl_vars['comment']->value->order_id;?>
</i>
                                                            </span>                                                             
                                                        </div>
                                        
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['comments_1c']->value) {?>
                                            <h3>Комментарии из 1С</h3>
                                            <table class="table">
                                                <tr>
                                                    <th>Дата</th>
                                                    <th>Блок</th>
                                                    <th>Комментарий</th>
                                                </tr>
                                                <?php  $_smarty_tpl->tpl_vars['comment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['comment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comments_1c']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['comment']->key => $_smarty_tpl->tpl_vars['comment']->value) {
$_smarty_tpl->tpl_vars['comment']->_loop = true;
?>
                                                <tr>
                                                    <td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['comment']->value->created);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['comment']->value->created);?>
</td>
                                                    <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['comment']->value->block, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                                    <td><?php echo nl2br($_smarty_tpl->tpl_vars['comment']->value->text);?>
</td>
                                                </tr>
                                                <?php } ?>
                                            </table>
                                            <?php }?>
                                            
                                            <?php if (!$_smarty_tpl->tpl_vars['comments']->value&&!$_smarty_tpl->tpl_vars['comments_1c']->value) {?>
                                            <h4>Нет комментариев</h4>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-pane p-3" id="documents" role="tabpanel">
                                    <?php if ($_smarty_tpl->tpl_vars['documents']->value) {?>
                                    <table class="table">
                                        <?php  $_smarty_tpl->tpl_vars['document'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['document']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['documents']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['document']->key => $_smarty_tpl->tpl_vars['document']->value) {
$_smarty_tpl->tpl_vars['document']->_loop = true;
?>
                                        <tr>
                                            <td class="text-info">
                                                <a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['config']->value->front_url;?>
/document/<?php echo $_smarty_tpl->tpl_vars['document']->value->user_id;?>
/<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
">
                                                    <i class="fas fa-file-pdf fa-lg"></i>&nbsp;
                                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->name, ENT_QUOTES, 'UTF-8', true);?>

                                                </a>
                                            </td>
                                            <td class="text-right">
                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['document']->value->created);?>

                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['document']->value->created);?>

                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                    <?php } else { ?>
                                    <h4>Нет доступных документов</h4>
                                    <?php }?>
                                </div>
                                
                                <div class="tab-pane p-3" id="logs" role="tabpanel">
                                    <?php if ($_smarty_tpl->tpl_vars['changelogs']->value) {?>
                                        <table class="table table-hover ">
                                            <tbody>
                                                <?php  $_smarty_tpl->tpl_vars['changelog'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['changelog']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['changelogs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['changelog']->key => $_smarty_tpl->tpl_vars['changelog']->value) {
$_smarty_tpl->tpl_vars['changelog']->_loop = true;
?>
                                                <tr class="">
                                                    <td >                                                
                                                        <div class="button-toggle-wrapper">
                                                            <button class="js-open-order button-toggle" data-id="<?php echo $_smarty_tpl->tpl_vars['changelog']->value->id;?>
" type="button" title="Подробнее"></button>
                                                        </div>
                                                        <span><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['changelog']->value->created);?>
</span>
                                                        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['changelog']->value->created);?>

                                                    </td>
                                                    <td >
                                                        <?php if ($_smarty_tpl->tpl_vars['changelog_types']->value[$_smarty_tpl->tpl_vars['changelog']->value->type]) {?><?php echo $_smarty_tpl->tpl_vars['changelog_types']->value[$_smarty_tpl->tpl_vars['changelog']->value->type];?>

                                                        <?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['changelog']->value->type, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
                                                    </td>
                                                    <td >
                                                        <a href="manager/<?php echo $_smarty_tpl->tpl_vars['changelog']->value->manager->id;?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['changelog']->value->manager->name, ENT_QUOTES, 'UTF-8', true);?>
</a>
                                                    </td>
                                                    <td >
                                                        <a href="client/<?php echo $_smarty_tpl->tpl_vars['changelog']->value->user->id;?>
">
                                                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['changelog']->value->user->lastname, ENT_QUOTES, 'UTF-8', true);?>
 
                                                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['changelog']->value->user->firstname, ENT_QUOTES, 'UTF-8', true);?>
 
                                                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['changelog']->value->user->patronymic, ENT_QUOTES, 'UTF-8', true);?>

                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr class="order-details" id="changelog_<?php echo $_smarty_tpl->tpl_vars['changelog']->value->id;?>
" style="display:none">
                                                    <td colspan="4">
                                                        <div class="row">
                                                            <ul class="dtr-details col-md-6 list-unstyled">
                                                                <?php  $_smarty_tpl->tpl_vars['old_value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['old_value']->_loop = false;
 $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['changelog']->value->old_values; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['old_value']->key => $_smarty_tpl->tpl_vars['old_value']->value) {
$_smarty_tpl->tpl_vars['old_value']->_loop = true;
 $_smarty_tpl->tpl_vars['field']->value = $_smarty_tpl->tpl_vars['old_value']->key;
?>
                                                                <li>
                                                                    <strong><?php echo $_smarty_tpl->tpl_vars['field']->value;?>
: </strong> 
                                                                    <span><?php echo $_smarty_tpl->tpl_vars['old_value']->value;?>
</span>
                                                                </li>
                                                                <?php } ?>
                                                            </ul>
                                                            <ul class="col-md-6 dtr-details list-unstyled">
                                                                <?php  $_smarty_tpl->tpl_vars['new_value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['new_value']->_loop = false;
 $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['changelog']->value->new_values; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['new_value']->key => $_smarty_tpl->tpl_vars['new_value']->value) {
$_smarty_tpl->tpl_vars['new_value']->_loop = true;
 $_smarty_tpl->tpl_vars['field']->value = $_smarty_tpl->tpl_vars['new_value']->key;
?>
                                                                <li>
                                                                    <strong><?php echo $_smarty_tpl->tpl_vars['field']->value;?>
: </strong> 
                                                                    <span><?php echo $_smarty_tpl->tpl_vars['new_value']->value;?>
</span>
                                                                </li>
                                                                <?php } ?>
                                                            </ul> 
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php }?>    
                                </div>
                                
                                <div id="history" class="tab-pane" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            
                                            <div class="tab-content br-n pn">
                                                <div id="navpills-orders" class="tab-pane active">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h3>Заявки</h3>
                                                            <table class="table">
                                                                <tr>
                                                                    <th>Дата</th>
                                                                    <th>Заявка</th>
                                                                    <th>Договор</th>
                                                                    <th class="text-center">Сумма</th>
                                                                    <th class="text-center">Период</th>
                                                                    <th class="text-right">Статус</th>
                                                                </tr>
                                                                <?php  $_smarty_tpl->tpl_vars['order'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['order']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['client']->value->orders; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value) {
$_smarty_tpl->tpl_vars['order']->_loop = true;
?>
                                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->contract->type!='onec') {?>
                                                                <tr>
                                                                    <td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['order']->value->date);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['order']->value->date);?>
</td>
                                                                    <td>
                                                                        <a href="order/<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
</a>
                                                                    </td>
                                                                    <td><?php echo $_smarty_tpl->tpl_vars['order']->value->contract->number;?>
</td>
                                                                    <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['order']->value->amount;?>
</td>
                                                                    <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['order']->value->period;?>
</td>
                                                                    <td class="text-right">
                                                                        <?php echo $_smarty_tpl->tpl_vars['order_statuses']->value[$_smarty_tpl->tpl_vars['order']->value->status];?>

                                                                        <?php if ($_smarty_tpl->tpl_vars['order']->value->contract->status==3) {?><br /><small><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['order']->value->contract->close_date);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['order']->value->contract->close_date);?>
</small><?php }?>
                                                                    </td>
                                                                </tr>
                                                                <?php }?>
                                                                <?php } ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="navpills-loans" class="tab-pane active">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h3>Кредитная история 1C</h3>
                                                            <?php if (count($_smarty_tpl->tpl_vars['client']->value->loan_history)>0) {?>
                                                            <table class="table">
                                                                <tr>
                                                                    <th>Дата</th>
                                                                    <th>Договор</th>
                                                                    <th class="text-right">Статус</th>
                                                                    <th class="text-center">Сумма</th>
                                                                    <th class="text-center">Остаток ОД</th>
                                                                    <th class="text-right">Остаток процентов</th>
                                                                    <th>&nbsp;</th>
                                                                </tr>
                                                                <?php  $_smarty_tpl->tpl_vars['loan_history_item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['loan_history_item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['client']->value->loan_history; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['loan_history_item']->key => $_smarty_tpl->tpl_vars['loan_history_item']->value) {
$_smarty_tpl->tpl_vars['loan_history_item']->_loop = true;
?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['loan_history_item']->value->date);?>

                                                                    </td>
                                                                    <td>
                                                                        <?php echo $_smarty_tpl->tpl_vars['loan_history_item']->value->number;?>

                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php if ($_smarty_tpl->tpl_vars['loan_history_item']->value->loan_percents_summ>0||$_smarty_tpl->tpl_vars['loan_history_item']->value->loan_body_summ>0) {?>
                                                                            <span class="label label-success">Активный</span>
                                                                        <?php } else { ?>
                                                                            <span class="label label-danger">Закрыт</span>
                                                                        <?php }?>
                                                                    </td>
                                                                    <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['loan_history_item']->value->amount;?>
</td>
                                                                    <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['loan_history_item']->value->loan_body_summ;?>
</td>
                                                                    <td class="text-right"><?php echo $_smarty_tpl->tpl_vars['loan_history_item']->value->loan_percents_summ;?>
</td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-xs btn-info js-get-movements" data-number="<?php echo $_smarty_tpl->tpl_vars['loan_history_item']->value->number;?>
">Операции</button>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                            </table>
                                                            <?php } else { ?>
                                                            <h4>Нет кредитов</h4>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                        
                                            
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    
    <?php echo $_smarty_tpl->getSubTemplate ('footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    
</div>
<div class="modal fade" id="loan_operations" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loan_operations_title">Операции по договору</h5>
        <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times text-white"></i>
        </button>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div><?php }} ?>
