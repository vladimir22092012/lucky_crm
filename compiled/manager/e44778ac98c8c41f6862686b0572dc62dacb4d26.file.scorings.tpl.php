<?php /* Smarty version Smarty-3.1.18, created on 2022-10-12 08:33:15
         compiled from "/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/scorings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20958834186346519ba2c5b5-87925187%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e44778ac98c8c41f6862686b0572dc62dacb4d26' => 
    array (
      0 => '/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/scorings.tpl',
      1 => 1660295918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20958834186346519ba2c5b5-87925187',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'settings' => 0,
    'scoring_types' => 0,
    'type' => 0,
    'reasons' => 0,
    'reason' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_6346519ba4ae47_50068095',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6346519ba4ae47_50068095')) {function content_6346519ba4ae47_50068095($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Настройки cкорингов', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_scripts', null, null); ob_start(); ?>

    <script src="theme/<?php echo $_smarty_tpl->tpl_vars['settings']->value->theme;?>
/assets/plugins/nestable/jquery.nestable.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        // Nestable
        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        
        $('#nestable2').nestable({
            group: 1
        }).on('change', updateOutput);

        updateOutput($('#nestable2').data('output', $('#nestable2-output')));

    });
    </script>

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_styles', null, null); ob_start(); ?>

    <!--nestable CSS -->
    <link href="theme/<?php echo $_smarty_tpl->tpl_vars['settings']->value->theme;?>
/assets/plugins/nestable/nestable.css" rel="stylesheet" type="text/css" />

    <style>
        .onoffswitch {
            display:inline-block!important;
            vertical-align:top!important;
            width:60px!important;
            text-align:left;
        }
        .onoffswitch-switch {
            right:38px!important;
            border-width:1px!important;
        }
        .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
            right:0px!important;
        }
        .onoffswitch-label {
            margin-bottom:0!important;
            border-width:1px!important;
        }
        .onoffswitch-inner::after, 
        .onoffswitch-inner::before {
            height:18px!important;
            line-height:18px!important;
        }
        .onoffswitch-switch {
            width:20px!important;
            margin:1px!important;
        }
        .onoffswitch-inner::before {
            content:'ВКЛ'!important;
            padding-left: 10px!important;
            font-size:10px!important;
        }
        .onoffswitch-inner::after {
            content:'ВЫКЛ'!important;
            padding-right: 6px!important;
            font-size:10px!important;
        }
        
        .scoring-content {
            position:relative;
            z-index:999;
            border:1px solid rgba(120, 130, 140, 0.13);;
            border-top:0;
            background:#fff;
            border-bottom-left-radius:4px;
            border-bottom-right-radius:4px;
            margin-top: -5px;
        }
        
        .collapsed .fa-minus-circle::before {
            content: "\f055";
        }
        h4.text-white {
            display:inline-block
        }
        .move-zone {
            display:inline-block;
            color:#fff;
            padding-right:15px;
            margin-right:10px;
            border-right:1px solid #30b2ff;
            cursor:move
        }
        .move-zone span {
            font-size:24px;
        }
        
        .dd {
            max-width:100%;
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
                <h3 class="text-themecolor mb-0 mt-0">
                    Настройки скорингов
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Скоринги</li>
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
            
        <div class="row grid-stack" data-gs-width="12" data-gs-animate="yes">

<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Скоринги</h4>
            <div class="myadmin-dd-empty dd" id="nestable2">
                <ol class="dd-list">
                    <?php  $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['type']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['scoring_types']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['type']->key => $_smarty_tpl->tpl_vars['type']->value) {
$_smarty_tpl->tpl_vars['type']->_loop = true;
?>
                    <li class="dd-item dd3-item" data-id="<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
">
                        <div class="dd-handle dd3-handle">
                            <input type="hidden" name="position[]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
" />
                            <input type="hidden" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][id]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
" />
                        </div>
                        <div class="dd3-content"> 
                            <div class="row">
                                <div class="col-8 col-sm-9 col-md-10">
                                    <a href="#content_<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
" data-toggle="collapse" class="text-info collapsed">
                                        <i class="fas fa-minus-circle"></i>
                                        <span>
                                            <?php echo $_smarty_tpl->tpl_vars['type']->value->title;?>

                                        </span>
                                        <?php if ($_smarty_tpl->tpl_vars['type']->value->negative_action=='stop') {?>
                                        <span class="label label-warning">Остановить</span>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['type']->value->negative_action=='reject') {?>
                                        <span class="label label-danger">Отказ</span>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['type']->value->negative_action=='next') {?>
                                        <span class="label label-primary">Продолжить</span>
                                        <?php }?>
                                    </a>                                    
                                </div>
                                <div class="col-4 col-sm-3 col-md-2">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][active]" class="onoffswitch-checkbox" value="1" id="active_<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['type']->value->active) {?>checked="true"<?php }?> />
                                        <label class="onoffswitch-label" for="active_<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>        
                                </div>
                            </div>
                        </div>
                        
                        <div id="content_<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
" class="card-body collapse scoring-content">
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Если получен негативный тест</label>
                                        <select name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][negative_action]" class="form-control">
                                            <option value="next" <?php if ($_smarty_tpl->tpl_vars['type']->value->negative_action=='next') {?>selected="true"<?php }?>>Продолжить проверку</option>
                                            <option value="stop" <?php if ($_smarty_tpl->tpl_vars['type']->value->negative_action=='stop') {?>selected="true"<?php }?>>Остановить проверку</option>
                                            <option value="reject" <?php if ($_smarty_tpl->tpl_vars['type']->value->negative_action=='reject') {?>selected="true"<?php }?>>Остановить проверки и отказать по заявке</option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label">Причина отказа</label>
                                        <select name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][reason_id]" class="form-control">
                                            <option value="0" <?php if (!$_smarty_tpl->tpl_vars['type']->value->reason_id) {?>selected="true"<?php }?>></option>
                                            <?php  $_smarty_tpl->tpl_vars['reason'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['reason']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['reasons']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['reason']->key => $_smarty_tpl->tpl_vars['reason']->value) {
$_smarty_tpl->tpl_vars['reason']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['reason']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['type']->value->reason_id==$_smarty_tpl->tpl_vars['reason']->value->id) {?>selected="true"<?php }?>><?php echo $_smarty_tpl->tpl_vars['reason']->value->admin_name;?>
</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <?php if ($_smarty_tpl->tpl_vars['type']->value->name=='local_time') {?>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Максимальное отклонение, сек</label>
                                        <input type="text" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][params][max_diff]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->params['max_diff'];?>
" class="form-control" placeholder="" />
                                    </div>
                                </div>
                                
                                <?php } elseif ($_smarty_tpl->tpl_vars['type']->value->name=='location') {?>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Список регионов</label>
                                        <textarea name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][params][regions]" class="form-control"><?php echo $_smarty_tpl->tpl_vars['type']->value->params['regions'];?>
</textarea>
                                    </div>
                                </div>
                
                                <?php } elseif ($_smarty_tpl->tpl_vars['type']->value->name=='fssp'||$_smarty_tpl->tpl_vars['type']->value->name=='fssp2') {?>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Сумма долга ПК, руб</label>
                                        <input type="text" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][params][amount]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->params['amount'];?>
" class="form-control" placeholder="" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label">Сумма долга НК, руб</label>
                                        <input type="text" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][params][amount_nk]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->params['amount_nk'];?>
" class="form-control" placeholder="" />
                                    </div>
                                </div>
                
                                <?php } elseif ($_smarty_tpl->tpl_vars['type']->value->name=='fms') {?>
                
                
                                <?php } elseif ($_smarty_tpl->tpl_vars['type']->value->name=='fns') {?>
                
                
                                <?php } elseif ($_smarty_tpl->tpl_vars['type']->value->name=='scorista') {?>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Проходной бал</label>
                                        <input type="text" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][params][scorebal]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->params['scorebal'];?>
" class="form-control" placeholder="" />
                                    </div>
                                </div>
                
                
                                <?php } elseif ($_smarty_tpl->tpl_vars['type']->value->name=='juicescore') {?>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Проходной бал</label>
                                        <input type="text" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][params][scorebal]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->params['scorebal'];?>
" class="form-control" placeholder="" />
                                    </div>
                                </div>

                                <?php } elseif ($_smarty_tpl->tpl_vars['type']->value->name=='nbki') {?>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Рекомендуемая сумма, если количество активных займов 1-5</label>
                                        <input type="text" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][params][recommended_amount_1_5]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->params['recommended_amount_1_5'];?>
" class="form-control" placeholder="" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label">Рекомендуемая сумма, если количество активных займов 6-10</label>
                                        <input type="text" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][params][recommended_amount_6_10]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->params['recommended_amount_6_10'];?>
" class="form-control" placeholder="" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label">Рекомендуемая сумма, если количество активных займов 11-29</label>
                                        <input type="text" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][params][recommended_amount_11_29]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->params['recommended_amount_11_29'];?>
" class="form-control" placeholder="" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label">Рекомендуемая сумма, если количество активных займов 30+</label>
                                        <input type="text" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][params][recommended_amount_30_]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->params['recommended_amount_30_'];?>
" class="form-control" placeholder="" />
                                    </div>
                                </div>
                                <?php } elseif ($_smarty_tpl->tpl_vars['type']->value->name=='juicescore') {?>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="control-label">Проходной бал</label>
                                            <input type="text" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][params][scorebal]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->params['scorebal'];?>
" class="form-control" placeholder="" />
                                        </div>
                                    </div>

                                <?php } elseif ($_smarty_tpl->tpl_vars['type']->value->name=='age') {?>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="control-label">Минимальный пороговый возраст</label>
                                            <input type="text" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][params][min_threshold_age]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->params['min_threshold_age'];?>
" class="form-control" placeholder="" />
                                        </div>
                                        <div class="form-group ">
                                            <label class="control-label">Максимальный пороговый возраст</label>
                                            <input type="text" name="settings[<?php echo $_smarty_tpl->tpl_vars['type']->value->id;?>
][params][max_threshold_age]" value="<?php echo $_smarty_tpl->tpl_vars['type']->value->params['max_threshold_age'];?>
" class="form-control" placeholder="" />
                                        </div>
                                    </div>
                                <?php } elseif ($_smarty_tpl->tpl_vars['type']->value->name=='mbki') {?>
                                
                                
                                <?php }?>
                                
                            </div>
                        </div>              
                        
                    </li>
                    <?php } ?>
                    
                </ol>
            </div>
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
