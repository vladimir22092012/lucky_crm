<?php /* Smarty version Smarty-3.1.18, created on 2022-06-29 19:58:15
         compiled from "/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/manager.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2146033762bc84a78e8c30-43846166%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc2c3700b0127141f60ec847090f0f5d1ad7ebc2' => 
    array (
      0 => '/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/manager.tpl',
      1 => 1656438503,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2146033762bc84a78e8c30-43846166',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'roles' => 0,
    'manager' => 0,
    'errors' => 0,
    'message_success' => 0,
    'is_developer' => 0,
    'role' => 0,
    'role_name' => 0,
    'collection_statuses' => 0,
    'collection_status_id' => 0,
    'collection_status_name' => 0,
    'cs_id' => 0,
    'collection_manager_statuses' => 0,
    'cs' => 0,
    'managers' => 0,
    'm' => 0,
    'man' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_62bc84a792a4b1_27341354',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62bc84a792a4b1_27341354')) {function content_62bc84a792a4b1_27341354($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['user']->value->id) {?>
    <?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable("Профиль пользователя ".((string)$_smarty_tpl->tpl_vars['user']->value->name), null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php } else { ?>
    <?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable("Новый пользователь", null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>
<?php }?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_scripts', null, null); ob_start(); ?>
    
    <script>
        
        $(function(){
            $('.js-block-button').click(function(e){
                e.preventDefault();
                
                if ($(this).hasClass('loading'))
                    return false;
                
                var manager_id = $(this).data('manager')
                
                $.ajax({
                    data: {
                        action: 'blocked',
                        manager_id: manager_id,
                        block: 1
                    },
                    beforeSend: function(){
                        $('.js-block-button').addClass('loading');
                    },
                    success: function(resp){
                        $('.js-block-button').removeClass('loading').hide();                        
                        $('.js-unblock-button').show();                    
                    }
                })
            });
            $('.js-unblock-button').click(function(e){
                e.preventDefault();
                
                if ($(this).hasClass('loading'))
                    return false;
                
                var manager_id = $(this).data('manager')
                
                $.ajax({
                    data: {
                        action: 'blocked',
                        manager_id: manager_id,
                        block: 0
                    },
                    beforeSend: function(){
                        $('.js-unblock-button').addClass('loading');
                    },
                    success: function(resp){
                        $('.js-unblock-button').removeClass('loading').hide();                        
                        $('.js-block-button').show();                    
                    }
                })
            });
        })
        
        $('.js-filter-status').click(function(e){
            e.preventDefault();
        
            var _id = $(this).data('status');
            
            if ($(this).hasClass('active'))
            {
                $(this).removeClass('active')

                $('.js-status-item').fadeIn();

            }
            else
            {
                $('.js-filter-status.active').removeClass('active')
            
                $(this).addClass('active');
                
                $('.js-status-item').hide();
                $('.js-status-'+_id).fadeIn();
            }
        });
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
                    <?php if ($_smarty_tpl->tpl_vars['user']->value->id) {?>Профиль <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user']->value->name, ENT_QUOTES, 'UTF-8', true);?>

                    <?php } else { ?>Создать нового пользователя<?php }?>
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="managers">Пользователи</a></li>
                    <li class="breadcrumb-item active">Профиль</li>
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
        <div class="row">
            <!-- Column -->
            <div class="col-md-12 col-lg-4 col-xlg-3">
                <div class="card">
                    <div class="card-body">
                        <center class="mt-4"> 
                        
                            <h4 class="card-title mt-2"><?php echo $_smarty_tpl->tpl_vars['user']->value->name;?>
</h4>
                            <h6 class="card-subtitle">
                                <?php echo $_smarty_tpl->tpl_vars['roles']->value[$_smarty_tpl->tpl_vars['user']->value->role];?>

                            </h6>
                            
                        </center>
                    </div>
                    <div>
                        <hr> </div>
                    <div class="card-body"> 
                        <small class="text-muted">Последний IP адрес</small>
                        <h6><?php echo $_smarty_tpl->tpl_vars['user']->value->last_ip;?>
</h6> 
                        <small class="text-muted p-t-30 db">Последняя активность</small>
                        <h6>
                        <?php if ($_smarty_tpl->tpl_vars['user']->value->last_visit) {?>
                            <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['user']->value->last_visit);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['user']->value->last_visit);?>

                        <?php }?>
                        </h6>                         
                    </div>
                    
                    <?php if ($_smarty_tpl->tpl_vars['user']->value->id&&in_array('block_manager',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                    <div class="mt-2 pt-2 pb-2 text-center">
                        <button <?php if ($_smarty_tpl->tpl_vars['user']->value->blocked) {?>style="display:none"<?php }?> class="btn btn-danger btn-lg js-block-button" data-manager="<?php echo $_smarty_tpl->tpl_vars['user']->value->id;?>
">Заблокировать</button>
                        <button <?php if (!$_smarty_tpl->tpl_vars['user']->value->blocked) {?>style="display:none"<?php }?> class="btn btn-success btn-lg js-unblock-button" data-manager="<?php echo $_smarty_tpl->tpl_vars['user']->value->id;?>
">Разблокировать</button>
                    </div>
                    <?php }?>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-12 col-lg-8 col-xlg-9">
                <div class="card">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs profile-tab" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#settings" role="tab">Основные</a> </li>
                        <li class="nav-item" <?php if ($_smarty_tpl->tpl_vars['user']->value->role!='team_collector') {?>style="display:none"<?php }?>> 
                            <a class="nav-link" data-toggle="tab" href="#team" role="tab">Команда</a> 
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <form class="form-horizontal" method="POST">
                    <div class="tab-content">
                        
                        <div class="tab-pane active" id="settings" role="tabpanel">
                            <div class="card-body">
                                
                                    <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->id;?>
" />
                                    
                                    <?php if ($_smarty_tpl->tpl_vars['errors']->value) {?>
                                    <div class="col-md-12">
                                        <ul class="alert alert-danger">
                                            <?php if (in_array('empty_role',(array)$_smarty_tpl->tpl_vars['errors']->value)) {?><li>Выберите роль пользователя!</li><?php }?>
                                            <?php if (in_array('empty_name',(array)$_smarty_tpl->tpl_vars['errors']->value)) {?><li>Укажите имя пользователя!</li><?php }?>
                                            <?php if (in_array('empty_login',(array)$_smarty_tpl->tpl_vars['errors']->value)) {?><li>Укажите логин для входа!</li><?php }?>
                                            <?php if (in_array('empty_password',(array)$_smarty_tpl->tpl_vars['errors']->value)) {?><li>Укажите пароль!</li><?php }?>
                                            <?php if (in_array('name_1c_not_found',(array)$_smarty_tpl->tpl_vars['errors']->value)) {?><li>Имя для обмена В 1С не найдено, проверьте правильность написания!</li><?php }?>
                                        </ul>
                                    </div>
                                    <?php }?>
                                    
                                    <?php if ($_smarty_tpl->tpl_vars['message_success']->value) {?>
                                    <div class="col-md-12">
                                        <div class="alert alert-success">
                                            <?php if ($_smarty_tpl->tpl_vars['message_success']->value=='added') {?>Новый пользователь добавлен<?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['message_success']->value=='updated') {?>Данные сохранены<?php }?>
                                        </div>
                                    </div>
                                    <?php }?>
                                    
                                    <div class="form-group <?php if (in_array('empty_role',(array)$_smarty_tpl->tpl_vars['errors']->value)) {?>has-danger<?php }?>">
                                        <?php if ($_smarty_tpl->tpl_vars['is_developer']->value||$_smarty_tpl->tpl_vars['user']->value->id!=$_smarty_tpl->tpl_vars['manager']->value->id||($_smarty_tpl->tpl_vars['user']->value->id==$_smarty_tpl->tpl_vars['manager']->value->id&&in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('admin','developer')))) {?>
                                        <label class="col-sm-12">Роль</label>
                                        <div class="col-sm-12">
                                            <select name="role" class="form-control form-control-line" required="true">
                                                <option value=""></option>
                                                <?php  $_smarty_tpl->tpl_vars['role_name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['role_name']->_loop = false;
 $_smarty_tpl->tpl_vars['role'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['roles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['role_name']->key => $_smarty_tpl->tpl_vars['role_name']->value) {
$_smarty_tpl->tpl_vars['role_name']->_loop = true;
 $_smarty_tpl->tpl_vars['role']->value = $_smarty_tpl->tpl_vars['role_name']->key;
?>
                                                    <?php if ($_smarty_tpl->tpl_vars['manager']->value->role=='chief_collector'||$_smarty_tpl->tpl_vars['manager']->value->role=='team_collector') {?>
                                                        <?php if ($_smarty_tpl->tpl_vars['role']->value=='collector'||$_smarty_tpl->tpl_vars['role']->value=='team_collector'||$_smarty_tpl->tpl_vars['role']->value=='user') {?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['role']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['user']->value->role==$_smarty_tpl->tpl_vars['role']->value) {?>selected="true"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['role_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                        <?php }?>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['manager']->value->role=='city_manager') {?>
                                                        <?php if ($_smarty_tpl->tpl_vars['role']->value=='cs_pc') {?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['role']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['user']->value->role==$_smarty_tpl->tpl_vars['role']->value) {?>selected="true"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['role_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                        <?php }?>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $_smarty_tpl->tpl_vars['role']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['user']->value->role==$_smarty_tpl->tpl_vars['role']->value) {?>selected="true"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['role_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                    <?php }?>
                                                <?php } ?>
                                            </select>
                                            <?php if (in_array('empty_role',(array)$_smarty_tpl->tpl_vars['errors']->value)) {?><small class="form-control-feedback">Выберите роль!</small><?php }?>
                                        </div>
                                        <?php } else { ?>
                                        <input type="hidden" name="role" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->role;?>
" />
                                        <?php }?>
                                    </div>
                                    <div class="form-group <?php if (in_array('empty_name',(array)$_smarty_tpl->tpl_vars['errors']->value)) {?>has-danger<?php }?>">
                                        <label class="col-md-12">Пользователь</label>
                                        <div class="col-md-12">
                                            <input type="text" name="name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user']->value->name, ENT_QUOTES, 'UTF-8', true);?>
" class="form-control form-control-line" required="true" />
                                            <?php if (in_array('empty_name',(array)$_smarty_tpl->tpl_vars['errors']->value)) {?><small class="form-control-feedback">Укажите имя!</small><?php }?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Имя для обмена 1С</label>
                                        <div class="col-md-12">
                                            <input type="text" name="name_1c" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user']->value->name_1c, ENT_QUOTES, 'UTF-8', true);?>
" class="form-control form-control-line" />
                                        </div>
                                    </div>

                                    <div class="form-group <?php if (in_array('empty_login',(array)$_smarty_tpl->tpl_vars['errors']->value)) {?>has-danger<?php }?>">
                                        <label for="login" class="col-md-12">Логин для входа</label>
                                        <div class="col-md-12">
                                            <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user']->value->login, ENT_QUOTES, 'UTF-8', true);?>
" class="form-control form-control-line" required="true" />
                                            <?php if (in_array('empty_login',(array)$_smarty_tpl->tpl_vars['errors']->value)) {?><small class="form-control-feedback">Укажите логин!</small><?php }?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if (in_array('empty_password',(array)$_smarty_tpl->tpl_vars['errors']->value)) {?>has-danger<?php }?>">
                                        <label class="col-md-12"><?php if ($_smarty_tpl->tpl_vars['user']->value->id) {?>Новый пароль<?php } else { ?>Пароль<?php }?></label>
                                        <div class="col-md-12">
                                            <input type="password" name="password" value="" class="form-control form-control-line" <?php if (!$_smarty_tpl->tpl_vars['user']->value->id) {?>required="true"<?php }?> />
                                            <?php if (in_array('empty_password',(array)$_smarty_tpl->tpl_vars['errors']->value)) {?><small class="form-control-feedback">Укажите пароль!</small><?php }?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="text" name="email" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->email;?>
" class="form-control form-control-line" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Телефон</label>
                                        <div class="col-md-12">
                                            <input type="text" name="phone" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->phone;?>
" class="form-control form-control-line" />
                                        </div>
                                    </div>
                                    
                                    <?php if (in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('chief_collector','admin','developer'))) {?>
                                    
                                    <div class="form-group">
                                        <label class="col-md-12">Статусы договоров для коллекторов</label>
                                        <div class="col-sm-12">
                                            <select name="collection_status_id" class="form-control form-control-line" >
                                                <option value=""></option>
                                                <?php  $_smarty_tpl->tpl_vars['collection_status_name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['collection_status_name']->_loop = false;
 $_smarty_tpl->tpl_vars['collection_status_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['collection_statuses']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['collection_status_name']->key => $_smarty_tpl->tpl_vars['collection_status_name']->value) {
$_smarty_tpl->tpl_vars['collection_status_name']->_loop = true;
 $_smarty_tpl->tpl_vars['collection_status_id']->value = $_smarty_tpl->tpl_vars['collection_status_name']->key;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['collection_status_id']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['user']->value->collection_status_id==$_smarty_tpl->tpl_vars['collection_status_id']->value) {?>selected="true"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['collection_status_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <?php } else { ?>
                                    
                                    <div class="form-group">
                                        <label class="col-md-12">Статусы договоров для коллекторов</label>
                                        <div class="col-sm-12">
                                            <p><?php echo $_smarty_tpl->tpl_vars['collection_statuses']->value[$_smarty_tpl->tpl_vars['user']->value->collection_status_id];?>
</p>
                                            <input type="hidden" name="collection_status_id" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->collection_status_id;?>
" />
                                        </div>
                                    </div>
                                    
                                    <?php }?>
                                    
                                    <div class="form-group">
                                        <label class="col-md-12">Mango-office внутренний номер</label>
                                        <div class="col-md-12">
                                            <input type="text" name="mango_number" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->mango_number;?>
" class="form-control form-control-line" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" type="submit">Сохранить</button>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="team" role="tabpanel">
                            <div class="card-body">
                                <div class="form-group pl-3 pr-3">
                                    <div class="clearfix pb-3">
                                        <div class="float-left">
                                            <h5>Команда коллектора</h5>
                                        </div>
                                        <div class="float-right">
                                            <?php  $_smarty_tpl->tpl_vars['cs'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cs']->_loop = false;
 $_smarty_tpl->tpl_vars['cs_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['collection_statuses']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cs']->key => $_smarty_tpl->tpl_vars['cs']->value) {
$_smarty_tpl->tpl_vars['cs']->_loop = true;
 $_smarty_tpl->tpl_vars['cs_id']->value = $_smarty_tpl->tpl_vars['cs']->key;
?>
                                                <?php if (in_array($_smarty_tpl->tpl_vars['cs_id']->value,(array)$_smarty_tpl->tpl_vars['collection_manager_statuses']->value)) {?>
                                                <a data-status="<?php echo $_smarty_tpl->tpl_vars['cs_id']->value;?>
" class="js-filter-status btn btn-sm btn-outline-<?php if ($_smarty_tpl->tpl_vars['cs_id']->value==6) {?>warning<?php } elseif ($_smarty_tpl->tpl_vars['cs_id']->value==8) {?>danger<?php } elseif ($_smarty_tpl->tpl_vars['cs_id']->value==4) {?>primary<?php }?>" href="javascript:void();"><?php echo $_smarty_tpl->tpl_vars['cs']->value;?>
</a>
                                                <?php }?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    
                                    <table class="table">
                                    <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['managers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value) {
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                                        <?php if ($_smarty_tpl->tpl_vars['m']->value->role=='collector') {?>
                                        <tr class="js-status-item js-status-<?php echo $_smarty_tpl->tpl_vars['m']->value->collection_status_id;?>
">
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input <?php if (!in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('chief_collector','admin','developer'))) {?>disabled="true"<?php }?> class="custom-control-input" type="checkbox" name="team_id[]" id="team_id_<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
" value="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
" <?php if (in_array($_smarty_tpl->tpl_vars['m']->value->id,(array)$_smarty_tpl->tpl_vars['user']->value->team_id)) {?>checked="true"<?php }?> />
                                                    <label class="custom-control-label" for="team_id_<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="<?php if ($_smarty_tpl->tpl_vars['m']->value->blocked) {?>text-danger<?php }?>" target="_blank" href="manager/<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
">
                                                    <strong><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['m']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</strong>
                                                </a>                                        
                                                <?php if ($_smarty_tpl->tpl_vars['m']->value->blocked) {?><span class="label label-danger">Заблокирован</span><?php }?>
                                            </td>
                                            <td>
                                                <label class="label <?php if ($_smarty_tpl->tpl_vars['m']->value->collection_status_id==6) {?>label-warning<?php } elseif ($_smarty_tpl->tpl_vars['m']->value->collection_status_id==8) {?>label-danger<?php } elseif ($_smarty_tpl->tpl_vars['m']->value->collection_status_id==4) {?>label-primary<?php }?>">
                                                    <?php echo $_smarty_tpl->tpl_vars['collection_statuses']->value[$_smarty_tpl->tpl_vars['m']->value->collection_status_id];?>

                                                </label>
                                            </td>
                                            <td>
                                                <?php  $_smarty_tpl->tpl_vars['man'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['man']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['managers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['man']->key => $_smarty_tpl->tpl_vars['man']->value) {
$_smarty_tpl->tpl_vars['man']->_loop = true;
?>
                                                    <?php if ($_smarty_tpl->tpl_vars['man']->value->role=='team_collector'&&in_array($_smarty_tpl->tpl_vars['m']->value->id,(array)$_smarty_tpl->tpl_vars['man']->value->team_id)) {?>
                                                    <small><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['man']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</small>
                                                    <br />
                                                    <?php }?>
                                                <?php } ?>
                                                
                                            </td>
                                        </tr>
                                        <?php }?>
                                    <?php } ?>    
                                    </table>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" type="submit">Сохранить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- Column -->
        </div>
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
