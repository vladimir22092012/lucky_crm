<?php /* Smarty version Smarty-3.1.18, created on 2022-06-28 21:09:05
         compiled from "/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/managers.tpl" */ ?>
<?php /*%%SmartyHeaderCode:201554596362bb43c1246779-95252968%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f731d3c35e8ad0c23e9aca68b83ac6c25bffb7ed' => 
    array (
      0 => '/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/managers.tpl',
      1 => 1656438503,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '201554596362bb43c1246779-95252968',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'manager' => 0,
    'managers' => 0,
    'm' => 0,
    'label_class' => 0,
    'roles' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_62bb43c125a699_59596091',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62bb43c125a699_59596091')) {function content_62bb43c125a699_59596091($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable("Пользователи", null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

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
                    Пользователи
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item">Пользователи</li>
                </ol>
            </div>
            <div class="col-md-6 col-4 align-self-center">
                <?php if (in_array('create_managers',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                <a href="manager" class="btn float-right hidden-sm-down btn-success">
                    <i class="mdi mdi-plus-circle"></i> 
                    Создать пользователя
                </a>
                <?php }?>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Список пользователей</h4>
                        <div class="table-responsive">
                            <table class="table no-wrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Пользователь</th>
                                        <th>IP адрес</th>
                                        <th>Активность</th>
                                        <th>Роль</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['managers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value) {
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                                    <tr class="<?php if ($_smarty_tpl->tpl_vars['m']->value->blocked) {?>bg-light-danger<?php }?>">
                                        <td><?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
</td>
                                        <td>
                                            <a href="manager/<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['m']->value->name;?>
</a>
                                            <?php if ($_smarty_tpl->tpl_vars['m']->value->blocked) {?><br /><span class="badge badge-danger">Заблокирован</span><?php }?>
                                        </td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['m']->value->last_ip;?>
</td>
                                        <td>
                                            <?php if ($_smarty_tpl->tpl_vars['m']->value->last_visit) {?>
                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['m']->value->last_visit);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['m']->value->last_visit);?>

                                            <?php }?>
                                        </td>
                                        <td>
                                            <?php $_smarty_tpl->tpl_vars['label_class'] = new Smarty_variable("info", null, 0);?>
                                            <?php if ($_smarty_tpl->tpl_vars['m']->value->role=='developer'||$_smarty_tpl->tpl_vars['m']->value->role=='technic') {?><?php $_smarty_tpl->tpl_vars['label_class'] = new Smarty_variable("danger", null, 0);?><?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['m']->value->role=='admin'||$_smarty_tpl->tpl_vars['m']->value->role=='chief_collector'||$_smarty_tpl->tpl_vars['m']->value->role=='team_collector') {?><?php $_smarty_tpl->tpl_vars['label_class'] = new Smarty_variable("success", null, 0);?><?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['m']->value->role=='verificator'||$_smarty_tpl->tpl_vars['m']->value->role=='user') {?><?php $_smarty_tpl->tpl_vars['label_class'] = new Smarty_variable("warning", null, 0);?><?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['m']->value->role=='collector') {?><?php $_smarty_tpl->tpl_vars['label_class'] = new Smarty_variable("primary", null, 0);?><?php }?>
                                            
                                            <span class="label label-<?php echo $_smarty_tpl->tpl_vars['label_class']->value;?>
">
                                                <?php if ($_smarty_tpl->tpl_vars['roles']->value[$_smarty_tpl->tpl_vars['m']->value->role]) {?>
                                                    <?php echo $_smarty_tpl->tpl_vars['roles']->value[$_smarty_tpl->tpl_vars['m']->value->role];?>

                                                <?php } else { ?>
                                                    <?php echo $_smarty_tpl->tpl_vars['m']->value->role;?>

                                                <?php }?>
                                            </span> 
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                        </div>
            </div>
        </div>
        <!-- Row -->
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
