<?php /* Smarty version Smarty-3.1.18, created on 2022-10-12 08:31:05
         compiled from "/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/sudblock_statuses.tpl" */ ?>
<?php /*%%SmartyHeaderCode:127002284963465119bcd820-43352136%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '03690789e14e43c2c85282ae68b2143b8e3d757b' => 
    array (
      0 => '/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/sudblock_statuses.tpl',
      1 => 1660295919,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '127002284963465119bcd820-43352136',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'statuses' => 0,
    'st' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_63465119bd4a72_26922189',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_63465119bd4a72_26922189')) {function content_63465119bd4a72_26922189($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Судблок Статусы договоров', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_styles', null, null); ob_start(); ?>
<link href="theme/manager/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="theme/manager/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="theme/manager/assets/plugins/datatables.net-bs4/css/responsive.dataTables.min.css">

<!-- Color picker plugins css -->
<link href="theme/manager/assets/plugins/jquery-asColorPicker-master/dist/css/asColorPicker.css" rel="stylesheet">
    
<style>
    .js-text-admin-name,
    .js-text-client-name {
//        max-width:300px
    }
    .color-badge {
        display:inline-block;
        width:64px;
        height:24px;
        margin-right:20px;
        vertical-align:top;
    }
</style>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_scripts', null, null); ob_start(); ?>

    <script src="theme/manager/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="theme/manager/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="theme/manager/assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    

    <!-- Plugin JavaScript -->
    <script src="theme/manager/assets/plugins/moment/moment.js?v=1.1"></script>
    <script src="theme/manager/assets/plugins/jquery-asColor/dist/jquery-asColor.js?v=1.1"></script>
    <script src="theme/manager/assets/plugins/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js?v=1.1"></script>
    
    <script src="theme/manager/js/apps/sudblock_statuses.app.js?v=1.1"></script>
    
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
                <h3 class="text-themecolor mb-0 mt-0">Статусы договоров</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Главная</a></li>
                    <li class="breadcrumb-item"><a href="sudblock_contracts">Судблок</a></li>
                    <li class="breadcrumb-item active">Статусы договоров</li>
                </ol>
            </div>
            <div class="col-md-6 col-4 align-self-center">
                <button class="btn float-right hidden-sm-down btn-success js-open-add-modal">
                    <i class="mdi mdi-plus-circle"></i> Добавить
                </button>

            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
            
            <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"></h4>
                        <h6 class="card-subtitle"></h6>
                        <div class="table-responsive m-t-40">
                            <div class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">    
                                <table id="config-table" class="table display table-striped dataTable">
                                    <thead>
                                        <tr>
                                            <th class="">ID</th>
                                            <th class="">Название</th>
                                            <th class="">Цвет</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        
                                        <?php  $_smarty_tpl->tpl_vars['st'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['st']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['statuses']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['st']->key => $_smarty_tpl->tpl_vars['st']->value) {
$_smarty_tpl->tpl_vars['st']->_loop = true;
?>
                                        <tr class="js-item">
                                            <td>
                                                <div class="js-text-id">
                                                    <?php echo $_smarty_tpl->tpl_vars['st']->value->id;?>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="js-visible-view js-text-name">
                                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['st']->value->name, ENT_QUOTES, 'UTF-8', true);?>

                                                </div>
                                                <div class="js-visible-edit" style="display:none">
                                                    <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['st']->value->id;?>
" />
                                                    <input type="text" class="form-control form-control" name="name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['st']->value->name, ENT_QUOTES, 'UTF-8', true);?>
" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="js-visible-view js-text-color">
                                                    <div class="color-badge" style="background:<?php echo $_smarty_tpl->tpl_vars['st']->value->color;?>
"></div>
                                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['st']->value->color, ENT_QUOTES, 'UTF-8', true);?>

                                                </div>
                                                <div class="js-visible-edit" style="display:none">
                                                    <input type="text" class="colorpicker form-control form-control" name="color" value="<?php echo $_smarty_tpl->tpl_vars['st']->value->color;?>
" />
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <div class="js-visible-view">
                                                    <a href="#" class="text-info js-edit-item" title="Редактировать"><i class=" fas fa-edit"></i></a>
                                                    <a href="#" class="text-danger js-delete-item" title="Удалить"><i class="far fa-trash-alt"></i></a>
                                                </div>
                                                <div class="js-visible-edit" style="display:none">
                                                    <a href="#" class="text-success js-confirm-edit-item" title="Сохранить"><i class="fas fa-check-circle"></i></a>
                                                    <a href="#" class="text-danger js-cancel-edit-item" title="Отменить"><i class="fas fa-times-circle"></i></a>
                                                </div>
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
        </div>
        
    </div>

    <?php echo $_smarty_tpl->getSubTemplate ('footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


</div>

<div id="modal_add_item" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">Добавить новый статус</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_add_item">
                
                    <div class="alert" style="display:none"></div>
                    
                    <div class="form-group">
                        <label for="name" class="control-label">Название:</label>
                        <input type="text" class="form-control" name="name" id="name" value="" />
                    </div>
                    <div class="form-group">
                        <label for="color" class="control-label">Цвет:</label>
                        <input type="text" class="form-control colorpicker" name="color" id="color" value="#000000" />
                    </div>
                    <div class="form-action">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php }} ?>
