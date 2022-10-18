<?php /* Smarty version Smarty-3.1.18, created on 2022-06-28 21:07:26
         compiled from "/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/penalties.tpl" */ ?>
<?php /*%%SmartyHeaderCode:110738689962bb435eae6021-78560260%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '19f595b668fe93af51ad0e31fee27b2898a21fd6' => 
    array (
      0 => '/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/penalties.tpl',
      1 => 1656438503,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '110738689962bb435eae6021-78560260',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'settings' => 0,
    'manager' => 0,
    'managers' => 0,
    'm' => 0,
    'manager_id' => 0,
    'control_manager_id' => 0,
    'period' => 0,
    'from' => 0,
    'to' => 0,
    'filter_status' => 0,
    'sort' => 0,
    'collection_statuses' => 0,
    'penalties' => 0,
    'contract' => 0,
    'penalty' => 0,
    'penalty_types' => 0,
    'penalty_statuses' => 0,
    'total_pages_num' => 0,
    'current_page_num' => 0,
    'visible_pages' => 0,
    'page_from' => 0,
    'page_to' => 0,
    'p' => 0,
    'page_count' => 0,
    'sms_templates' => 0,
    'sms_template' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_62bb435eb52d89_07355198',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62bb435eb52d89_07355198')) {function content_62bb435eb52d89_07355198($_smarty_tpl) {?>1<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Штрафы', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_scripts', null, null); ob_start(); ?>
    
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    
    <script src="theme/manager/assets/plugins/moment/moment.js"></script>
    
    <script src="theme/manager/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="theme/manager/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="theme/manager/assets/plugins/daterangepicker/daterangepicker.js"></script>
    
    <script type="text/javascript" src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/orders.js?v=1.15"></script>
    <script type="text/javascript" src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/order.js?v=1.16"></script>
    
    <script>
        $(function(){
            $('.js-open-show').hide();
            
            
            $(document).on('click', '.js-open-contract', function(e){
                e.preventDefault();
                var _id = $(this).data('id')
                if ($(this).hasClass('open'))
                {
                    $(this).removeClass('open');
                    $('.js-open-hide.js-dopinfo-'+_id).show();
                    $('.js-open-show.js-dopinfo-'+_id).hide();
                }
                else
                {
                    $(this).addClass('open');
                    $('.js-open-hide.js-dopinfo-'+_id).hide();
                    $('.js-open-show.js-dopinfo-'+_id).show();
                }
            })

            $(document).on('change', '.js-contact-status', function(){
                var contact_status = $(this).val();
                var contract_id = $(this).data('contract');
                var user_id = $(this).data('user');
                var $form = $(this).closest('form');
                
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: {
                        action: 'contact_status',
                        user_id: user_id,
                        contact_status: contact_status
                    },
                    success: function(resp){
                        if (contact_status == 1)
                            $('.js-contact-status-block.js-dopinfo-'+contract_id).html('<span class="label label-success">Контактная</span>')
                        else if (contact_status == 2)
                            $('.js-contact-status-block.js-dopinfo-'+contract_id).html('<span class="label label-danger">Не контактная</span>')                            
                        else if (contact_status == 0)
                            $('.js-contact-status-block.js-dopinfo-'+contract_id).html('<span class="label label-warning">Нет данных</span>')
                            
                    }
                })
            })

            $(document).on('change', '.js-contactperson-status', function(){
                var contact_status = $(this).val();
                var contactperson_id = $(this).data('contactperson');
                var $form = $(this).closest('form');
                
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: {
                        action: 'contactperson_status',
                        contactperson_id: contactperson_id,
                        contact_status: contact_status
                    }
                })
            })

            $(document).on('change', '.js-collection-manager', function(){
                var manager_id = $(this).val();
                var contract_id = $(this).data('contract');
                
                var manager_name = $(this).find('option:selected').text();
                
                $.ajax({
                    type: 'POST',
                    data: {
                        action: 'collection_manager',
                        manager_id: manager_id,
                        contract_id: contract_id
                    },
                    success: function(resp){
                        if (manager_id == 0)
                            $('.js-collection-manager-block.js-dopinfo-'+contract_id).html('');
                        else
                            $('.js-collection-manager-block.js-dopinfo-'+contract_id).html(manager_name);
                    }
                })
            })


        $(document).on('click', '.js-open-comment-form', function(e){
            e.preventDefault();
            
            if ($(this).hasClass('js-contactperson'))
            {
                var contactperson_id = $(this).data('contactperson');
                $('#modal_add_comment [name=contactperson_id]').val(contactperson_id);
                $('#modal_add_comment [name=action]').val('contactperson_comment');
                $('#modal_add_comment [name=order_id]').val($(this).data('order'));
            }
            else
            {
                var contactperson_id = $(this).data('contactperson');
                $('#modal_add_comment [name=order_id]').val($(this).data('order'));
                $('#modal_add_comment [name=action]').val('order_comment');                
            }
            
            
            $('#modal_add_comment [name=text]').text('')
            $('#modal_add_comment').modal();
        });

        $(document).on('click', '.js-open-sms-modal', function(e){
            e.preventDefault();
            
            var _user_id = $(this).data('user');
            var _order_id = $(this).data('order');
            var _yuk = $(this).hasClass('is-yuk') ? 1 : 0;
            
            $('#modal_send_sms [name=user_id]').val(_user_id)
            $('#modal_send_sms [name=order_id]').val(_order_id)
            $('#modal_send_sms [name=yuk]').val(_yuk)
            $('#modal_send_sms').modal();
        });
        
        $(document).on('submit', '.js-sms-form', function(e){
            e.preventDefault();
            
            var $form = $(this);
            
            var _user_id = $form.find('[name=user_id]').val();
            
            if ($form.hasClass('loading'))
                return false;
            
            $.ajax({
                url: '/ajax/communications.php',
                data: {
                    action: 'check',
                    user_id: _user_id,
                },
                success: function(resp){
                    if (!!resp)
                    {
                        $.ajax({
                            type: 'POST',
                            data: $form.serialize(),
                            beforeSend: function(){
                                $form.addClass('loading')
                            },
                            success: function(resp){
                                $form.removeClass('loading');
                                $('#modal_send_sms').modal('hide');
                                
                                if (!!resp.error)
                                {
                                    Swal.fire({
                                        timer: 5000,
                                        title: 'Ошибка!',
                                        text: resp.error,
                                        type: 'error',
                                    });
                                }
                                else
                                {
                                    Swal.fire({
                                        timer: 5000,
                                        title: '',
                                        text: 'Сообщение отправлено',
                                        type: 'success',
                                    });
                                    
                                    $.ajax({
                                        url: 'ajax/communications.php',
                                        data: {
                                            action: 'add',
                                            user_id: _user_id,
                                            type: 'sms',
                                            content: $('[name="template_id"] option:selected').text(    )
                                        }
                                    });
            
                                }
                            },
                        })        
                        
                    }
                    else
                    {
                        Swal.fire({
                            title: 'Ошибка!',
                            text: 'Исчерпан лимит коммуникаций',
                            type: 'error',
                        });
                        
                    }
                }
            })
            
        });

        $(document).on('change', '.js-workout-input', function(){
            var $this = $(this);
            
            var _contract = $this.val();
            var _workout = $this.is(':checked') ? 1 : 0;
                
            $.ajax({
                type: 'POST',
                data: {
                    action: 'workout',
                    contract_id: _contract,
                    workout: _workout
                },
                beforeSend: function(){
                    $('.jsgrid-load-shader').show();
                    $('.jsgrid-load-panel').show();
                },
                success: function(resp){
                    
                    if (_workout)
                        $this.closest('.js-contract-row').addClass('workout-row');
                    else
                        $this.closest('.js-contract-row').removeClass('workout-row');

                    $('.jsgrid-load-shader').hide();
                    $('.jsgrid-load-panel').hide();
                        
                    /*
                    $.ajax({
                        success: function(resp){
                            $('#basicgrid .jsgrid-grid-body').html($(resp).find('#basicgrid .jsgrid-grid-body').html());
                            $('#basicgrid .jsgrid-header-row').html($(resp).find('#basicgrid .jsgrid-header-row').html());
                            $('.js-period-filter').html($(resp).find('.js-period-filter').html());
                            $('.js-filter-status').html($(resp).find('.js-filter-status').html());
                            $('.js-filter-client').html($(resp).find('.js-filter-client').html());
            
                            $('.jsgrid-pager-container').html($(resp).find('.jsgrid-pager-container').html());

                            $('.jsgrid-load-shader').hide();
                            $('.jsgrid-load-panel').hide();
                        }
                    });
                    */
                }
            })
                
        });

        $(document).on('submit', '#form_add_comment', function(e){
            e.preventDefault();
            
            var $form = $(this);
            
            $.ajax({
                data: $form.serialize(),
                type: 'POST',
                success: function(resp){
                    if (resp.success)
                    {
                        $('#modal_add_comment').modal('hide');
                        $form.find('[name=text]').val('')
            
                        
                        Swal.fire({
                            timer: 5000,
                            title: 'Комментарий добавлен.',
                            type: 'success',
                        });
                        location.reload();
                    }
                    else
                    {
                        Swal.fire({
                            text: resp.error,
                            type: 'error',
                        });
                        
                    }
                }
            })
        })
        

        var _init_daterange = function(){
            $('.daterange').daterangepicker({
                autoApply: true,
                locale: {
                    format: 'DD.MM.YYYY'
                },
                default:''
            });
            
            $(document).on('change', '.js-daterange-input', function(){
                app.filter()
            })
            
            $(document).on('click', '.js-open-daterange', function(e){
                e.preventDefault();
                
                $('#filter_period').val('optional')
                
                $('.js-period-filter button').html('<i class="fas fa-calendar-alt"></i> Произвольный')
                $('.js-period-filter .dropdown-item').removeClass('active');
                $(this).addClass('active')
                
                $('.js-daterange-filter').show();
            });        
            _init_daterange();
        }
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
    <link type="text/css" rel="stylesheet" href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/jsgrid/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/jsgrid/jsgrid-theme.min.css" />

    <link href="theme/manager/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="theme/manager/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="theme/manager/assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">

    <style>
        .jsgrid-table { margin-bottom:0}
        .label { white-space: pre; }
        
        .js-open-hide {
            display:block;
        }
        .js-open-show {
            display:none;
        }
        .open.js-open-hide {
            display:none;
        }
        .open.js-open-show {
            display:block;
        }
        .form-control.js-contactperson-status,
        .form-control.js-contact-status {
            font-size: 12px;
            padding-left: 0px;
        }
        .workout-row > td {
            background:#f2f7f8!important;
        }
        .workout-row a, .workout-row small, .workout-row span {
            color:#555!important;
            font-weight:300;
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
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor mb-0 mt-0"><i class="mdi mdi-animation"></i> Штрафы</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Штрафы</li>
                </ol>
            </div>
            <div class="col-md-7 col-4 ">
                <div class="row">
                
                    <div class="col-4 ">
                        <?php if (in_array('add_penalty',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                        <select name="manager_id" class="form-control js-subfilter" id="filter_manager" >
                            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('manager_id'=>null,'page'=>null),$_smarty_tpl);?>
">Все пользователи</option>
                            <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['managers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value) {
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                            <?php if ($_smarty_tpl->tpl_vars['m']->value->role=='user'||$_smarty_tpl->tpl_vars['m']->value->role=='big_user') {?>
                            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('manager_id'=>$_smarty_tpl->tpl_vars['m']->value->id,'page'=>null),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['m']->value->id==$_smarty_tpl->tpl_vars['manager_id']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['m']->value->name;?>
</option>
                            <?php }?>
                            <?php } ?>
                        </select>
                        <?php }?>
                    </div>
                    <div class="col-4 ">
                        <select class="form-control  js-subfilter" id="filter_control_manager_id" name="control_manager_id">
                            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('control_manager_id'=>null,'page'=>null),$_smarty_tpl);?>
">Все проверяющие</option>
                            <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['managers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value) {
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                            <?php if ($_smarty_tpl->tpl_vars['m']->value->role=='quality_control') {?>
                            <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('control_manager_id'=>$_smarty_tpl->tpl_vars['m']->value->id,'page'=>null),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['m']->value->id==$_smarty_tpl->tpl_vars['control_manager_id']->value) {?>selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['m']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</option>
                            <?php }?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-4 dropdown text-right hidden-sm-down js-period-filter">
                    
                        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['period']->value;?>
" id="filter_period" />     
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                            <i class="fas fa-calendar-alt"></i>
                            <?php if ($_smarty_tpl->tpl_vars['period']->value=='month') {?>В этом месяце
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='year') {?>В этом году
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='all') {?>За все время
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='optional') {?>Произвольный
                            <?php } else { ?><?php echo $_smarty_tpl->tpl_vars['period']->value;?>
<?php }?>
                            
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
                            <a class="dropdown-item js-period-link <?php if ($_smarty_tpl->tpl_vars['period']->value=='month') {?>active<?php }?>" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'month','page'=>null),$_smarty_tpl);?>
">В этом месяце</a> 
                            <a class="dropdown-item js-period-link <?php if ($_smarty_tpl->tpl_vars['period']->value=='year') {?>active<?php }?>" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'year','page'=>null),$_smarty_tpl);?>
">В этом году</a> 
                            <a class="dropdown-item js-period-link <?php if ($_smarty_tpl->tpl_vars['period']->value=='all') {?>active<?php }?>" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'all','page'=>null),$_smarty_tpl);?>
">За все время</a> 
                            <a class="dropdown-item js-open-daterange <?php if ($_smarty_tpl->tpl_vars['period']->value=='optional') {?>active<?php }?>" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'optional','page'=>null),$_smarty_tpl);?>
">Произвольный</a> 
                        </div>
                    
                        <div class="js-daterange-filter input-group mb-3 mt-2" <?php if ($_smarty_tpl->tpl_vars['period']->value!='optional') {?>style="display:none"<?php }?>>
                            <input type="text" name="daterange" class="form-control daterange js-daterange-input" value="<?php if ($_smarty_tpl->tpl_vars['from']->value&&$_smarty_tpl->tpl_vars['to']->value) {?><?php echo $_smarty_tpl->tpl_vars['from']->value;?>
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
                        <div class="clearfix">
                            <h4 class="card-title  float-left">Штрафы</h4>
                            <div class="float-right js-filter-client">                                
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value==1) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>'1','page'=>null),$_smarty_tpl);?>
<?php }?>" class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==1) {?>btn-warning<?php } else { ?>btn-outline-warning<?php }?>">Штраф</a>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value==2) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>'2','page'=>null),$_smarty_tpl);?>
<?php }?>" class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==2) {?>btn-success<?php } else { ?>btn-outline-success<?php }?>">На исправление</a>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value==3) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>'3','page'=>null),$_smarty_tpl);?>
<?php }?>" class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==3) {?>btn-primary<?php } else { ?>btn-outline-primary<?php }?>">Исправлен</a>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value==4) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>'4','page'=>null),$_smarty_tpl);?>
<?php }?>" class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==4) {?>btn-inverse<?php } else { ?>btn-outline-inverse<?php }?>">Погашен</a>
                            </div>

                        </div>
                        
                        <div id="basicgrid" class="jsgrid" style="position: relative; width: 100%;">
                            <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                                <table class="jsgrid-table table table-striped table-hover">
                                    <tr class="jsgrid-header-row">
                                        <th style="width: 50px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='created_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='created_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='created_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'created_desc'),$_smarty_tpl);?>
">Дата </a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'created_asc'),$_smarty_tpl);?>
">Дата </a><?php }?>
                                        </th>
                                        <?php if (in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('developer','admin','quality_control'))) {?>
                                        <th style="width:80px" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='manager_id_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='manager_id_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='manager_id_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'manager_id_desc'),$_smarty_tpl);?>
">Пользователь</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'manager_id_asc'),$_smarty_tpl);?>
">Пользователь</a><?php }?>
                                        </th>
                                        <?php }?>
                                        <th style="width: 50px;" class="jsgrid-header-cell jsgrid-align-right jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='order_id_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='order_id_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='order_id_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'order_id_desc'),$_smarty_tpl);?>
">Заявка</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'order_id_asc'),$_smarty_tpl);?>
">Заявка</a><?php }?>
                                        </th>
                                        <th style="width: 70px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='created_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='created_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='created_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'created_desc'),$_smarty_tpl);?>
">ФИО клиента</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'created_asc'),$_smarty_tpl);?>
">ФИО клиента</a><?php }?>
                                        </th>
                                        <th style="width: 100px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='created_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='created_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='created_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'created_desc'),$_smarty_tpl);?>
">Причина</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'created_asc'),$_smarty_tpl);?>
">Причина</a><?php }?>
                                        </th>
                                        <th style="width: 50px;" class="jsgrid-header-cell jsgrid-align-right jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='order_id_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='order_id_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='order_id_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'order_id_desc'),$_smarty_tpl);?>
">Сумма</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'order_id_asc'),$_smarty_tpl);?>
">Сумма</a><?php }?>
                                        </th>
                                        <th style="width: 70px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='created_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='created_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='created_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'created_desc'),$_smarty_tpl);?>
">Статус</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'created_asc'),$_smarty_tpl);?>
">Статус</a><?php }?>
                                        </th>
                                        <th style="width: 70px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='created_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='created_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='created_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'created_desc'),$_smarty_tpl);?>
">Проверяющий </a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'created_asc'),$_smarty_tpl);?>
">Проверяющий </a><?php }?>
                                        </th>                                        
                                        <th style="width: 50px;" class=" text-right jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='created_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='created_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='created_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'created_desc'),$_smarty_tpl);?>
">Дата проверки</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'created_asc'),$_smarty_tpl);?>
">Дата проверки</a><?php }?>
                                        </th>                                        
                                    </tr>

                                    
                                    <tr class="jsgrid-filter-row" id="search_form">
                                        <td style="width:50px;" class="jsgrid-cell"></td>                                    
                                        <td style="width: 80px;" class="jsgrid-cell">
                                            <select class="form-control" name="manager_id">
                                                <option value="0"></option>
                                                <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['managers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value) {
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                                                <?php if ((in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('developer','admin','chief_collector'))&&$_smarty_tpl->tpl_vars['m']->value->role=='collector')||($_smarty_tpl->tpl_vars['manager']->value->role=='team_collector'&&in_array($_smarty_tpl->tpl_vars['m']->value->id,(array)$_smarty_tpl->tpl_vars['manager']->value->team_id))) {?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['m']->value->name, ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo $_smarty_tpl->tpl_vars['collection_statuses']->value[$_smarty_tpl->tpl_vars['m']->value->collection_status_id];?>
)</option>
                                                <?php }?>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="width: 50px;" class="jsgrid-cell">
                                        </td>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                        </td>
                                        <td style="width: 100px;" class="jsgrid-cell">
                                        </td>
                                        <td style="width: 50px;" class="jsgrid-cell">
                                        </td>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                            
                                        </td>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                        </td>
                                        <td style="width: 50px;" class="jsgrid-cell">
                                            
                                        </td>
                                    </tr>
                                    
                                    
                                </table>
                            </div>
                            <div class="jsgrid-grid-body">
                                <table class="jsgrid-table table table-striped table-hover">
                                    <tbody>
                                    <?php  $_smarty_tpl->tpl_vars['penalty'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['penalty']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['penalties']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['penalty']->key => $_smarty_tpl->tpl_vars['penalty']->value) {
$_smarty_tpl->tpl_vars['penalty']->_loop = true;
?>
                                    
                                        <tr class="jsgrid-row js-contract-row <?php if ($_smarty_tpl->tpl_vars['contract']->value->collection_workout) {?>workout-row<?php }?>">
                                            <td style="width: 50px;" class="jsgrid-cell">                                                
                                                <small><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['penalty']->value->order->date);?>
</small> 
                                                <br />
                                                <small><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['penalty']->value->order->date);?>
</small>
                                            </td>
                                            <?php if (in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('developer','admin','quality_control'))) {?>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <a href="manager/<?php echo $_smarty_tpl->tpl_vars['penalty']->value->manager_id;?>
">
                                                    <?php echo $_smarty_tpl->tpl_vars['managers']->value[$_smarty_tpl->tpl_vars['penalty']->value->manager_id]->name;?>

                                                </a>
                                            </td>
                                            <?php }?>
                                            <td style="width:50px" class="jsgrid-cell">
                                                <a href="order/<?php echo $_smarty_tpl->tpl_vars['penalty']->value->order_id;?>
"><?php echo $_smarty_tpl->tpl_vars['penalty']->value->order_id;?>
</a>
                                                <br />
                                                <?php if ($_smarty_tpl->tpl_vars['penalty']->value->order->status==0) {?><span class="label label-warning">Новая</span>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['penalty']->value->order->status==1) {?><span class="label label-info">Принята</span>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['penalty']->value->order->status==2) {?><span class="label label-success">Одобрена</span>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['penalty']->value->order->status==3) {?><span class="label label-danger">Отказ</span>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['penalty']->value->order->status==4) {?><span class="label label-inverse">Подписан</span>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['penalty']->value->order->status==5) {?><span class="label label-primary">Выдан</span>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['penalty']->value->order->status==6) {?><span class="label label-danger">Не удалось выдать</span>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['penalty']->value->order->status==7) {?><span class="label label-inverse">Погашен</span>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['penalty']->value->order->status==8) {?><span class="label label-danger">Отказ клиента</span>
                                                <?php }?>
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                <a href="client/<?php echo $_smarty_tpl->tpl_vars['penalty']->value->order->user_id;?>
">
                                                    <?php echo $_smarty_tpl->tpl_vars['penalty']->value->order->lastname;?>

                                                    <?php echo $_smarty_tpl->tpl_vars['penalty']->value->order->firstname;?>

                                                    <?php echo $_smarty_tpl->tpl_vars['penalty']->value->order->patronymic;?>

                                                </a>
                                            </td>
                                            <td style="width: 100px;" class="jsgrid-cell">
                                                <small><strong><?php echo $_smarty_tpl->tpl_vars['penalty_types']->value[$_smarty_tpl->tpl_vars['penalty']->value->type_id]->name;?>
</strong></small>
                                                <br />
                                                <small><?php echo $_smarty_tpl->tpl_vars['penalty']->value->comment;?>
</small>
                                            </td>
                                            <td style="width: 50px;" class="jsgrid-cell">
                                                <?php echo $_smarty_tpl->tpl_vars['penalty']->value->cost;?>

                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                <?php if ($_smarty_tpl->tpl_vars['penalty']->value->status==1) {?><span class="label label-warning"><?php echo $_smarty_tpl->tpl_vars['penalty_statuses']->value[$_smarty_tpl->tpl_vars['penalty']->value->status];?>
</span><?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['penalty']->value->status==2) {?><span class="label label-success"><?php echo $_smarty_tpl->tpl_vars['penalty_statuses']->value[$_smarty_tpl->tpl_vars['penalty']->value->status];?>
</span><?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['penalty']->value->status==3) {?><span class="label label-primary"><?php echo $_smarty_tpl->tpl_vars['penalty_statuses']->value[$_smarty_tpl->tpl_vars['penalty']->value->status];?>
</span><?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['penalty']->value->status==4) {?><span class="label label-danger"><?php echo $_smarty_tpl->tpl_vars['penalty_statuses']->value[$_smarty_tpl->tpl_vars['penalty']->value->status];?>
</span><?php }?>
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                <a href="manager/<?php echo $_smarty_tpl->tpl_vars['penalty']->value->control_manager_id;?>
">
                                                    <?php echo $_smarty_tpl->tpl_vars['managers']->value[$_smarty_tpl->tpl_vars['penalty']->value->control_manager_id]->name;?>

                                                </a>
                                            </td>
                                            <td style="width: 50px;" class="jsgrid-cell text-right">
                                                <small><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['penalty']->value->created);?>
</small> 
                                                <br />
                                                <small><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['penalty']->value->created);?>
</small>                                                
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <?php if ($_smarty_tpl->tpl_vars['total_pages_num']->value>1) {?>
                           	
                            
                        	<?php $_smarty_tpl->tpl_vars['visible_pages'] = new Smarty_variable(11, null, 0);?>
                        	
                        	<?php $_smarty_tpl->tpl_vars['page_from'] = new Smarty_variable(1, null, 0);?>
                        	
                        	
                        	<?php if ($_smarty_tpl->tpl_vars['current_page_num']->value>floor($_smarty_tpl->tpl_vars['visible_pages']->value/2)) {?>
                        		<?php $_smarty_tpl->tpl_vars['page_from'] = new Smarty_variable(max(1,$_smarty_tpl->tpl_vars['current_page_num']->value-floor($_smarty_tpl->tpl_vars['visible_pages']->value/2)-1), null, 0);?>
                        	<?php }?>	
                        	
                        	
                        	<?php if ($_smarty_tpl->tpl_vars['current_page_num']->value>$_smarty_tpl->tpl_vars['total_pages_num']->value-ceil($_smarty_tpl->tpl_vars['visible_pages']->value/2)) {?>
                        		<?php $_smarty_tpl->tpl_vars['page_from'] = new Smarty_variable(max(1,$_smarty_tpl->tpl_vars['total_pages_num']->value-$_smarty_tpl->tpl_vars['visible_pages']->value-1), null, 0);?>
                        	<?php }?>
                        	
                        	
                        	<?php $_smarty_tpl->tpl_vars['page_to'] = new Smarty_variable(min($_smarty_tpl->tpl_vars['page_from']->value+$_smarty_tpl->tpl_vars['visible_pages']->value,$_smarty_tpl->tpl_vars['total_pages_num']->value-1), null, 0);?>
                        
                            <div class="jsgrid-pager-container float-left" style="">
                                <div class="jsgrid-pager">
                                    Страницы: 

                                    <?php if ($_smarty_tpl->tpl_vars['current_page_num']->value==2) {?>
                                    <span class="jsgrid-pager-nav-button "><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null),$_smarty_tpl);?>
">Пред.</a></span> 
                                    <?php } elseif ($_smarty_tpl->tpl_vars['current_page_num']->value>2) {?>
                                    <span class="jsgrid-pager-nav-button "><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->tpl_vars['current_page_num']->value-1),$_smarty_tpl);?>
">Пред.</a></span>
                                    <?php }?>

                                    <span class="jsgrid-pager-page <?php if ($_smarty_tpl->tpl_vars['current_page_num']->value==1) {?>jsgrid-pager-current-page<?php }?>">
                                        <?php if ($_smarty_tpl->tpl_vars['current_page_num']->value==1) {?>1<?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null),$_smarty_tpl);?>
">1</a><?php }?>
                                    </span>
                                   	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pages'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['name'] = 'pages';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['page_to']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] = (int) $_smarty_tpl->tpl_vars['page_from']->value;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total']);
?>
                                			
                                		<?php $_smarty_tpl->tpl_vars['p'] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['pages']['index']+1, null, 0);?>	
                                			
                                		<?php if (($_smarty_tpl->tpl_vars['p']->value==$_smarty_tpl->tpl_vars['page_from']->value+1&&$_smarty_tpl->tpl_vars['p']->value!=2)||($_smarty_tpl->tpl_vars['p']->value==$_smarty_tpl->tpl_vars['page_to']->value&&$_smarty_tpl->tpl_vars['p']->value!=$_smarty_tpl->tpl_vars['total_pages_num']->value-1)) {?>	
                                		<span class="jsgrid-pager-page <?php if ($_smarty_tpl->tpl_vars['p']->value==$_smarty_tpl->tpl_vars['current_page_num']->value) {?>jsgrid-pager-current-page<?php }?>">
                                            <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->tpl_vars['p']->value),$_smarty_tpl);?>
">...</a>
                                        </span>
                                		<?php } else { ?>
                                		<span class="jsgrid-pager-page <?php if ($_smarty_tpl->tpl_vars['p']->value==$_smarty_tpl->tpl_vars['current_page_num']->value) {?>jsgrid-pager-current-page<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['p']->value==$_smarty_tpl->tpl_vars['current_page_num']->value) {?><?php echo $_smarty_tpl->tpl_vars['p']->value;?>
<?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->tpl_vars['p']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['p']->value;?>
</a><?php }?>
                                        </span>
                                		<?php }?>
                                	<?php endfor; endif; ?>
                                    <span class="jsgrid-pager-page <?php if ($_smarty_tpl->tpl_vars['current_page_num']->value==$_smarty_tpl->tpl_vars['total_pages_num']->value) {?>jsgrid-pager-current-page<?php }?>">
                                        <?php if ($_smarty_tpl->tpl_vars['current_page_num']->value==$_smarty_tpl->tpl_vars['total_pages_num']->value) {?><?php echo $_smarty_tpl->tpl_vars['total_pages_num']->value;?>
<?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->tpl_vars['total_pages_num']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['total_pages_num']->value;?>
</a><?php }?>
                                    </span>

                                    <?php if ($_smarty_tpl->tpl_vars['current_page_num']->value<$_smarty_tpl->tpl_vars['total_pages_num']->value) {?>
                                    <span class="jsgrid-pager-nav-button"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->tpl_vars['current_page_num']->value+1),$_smarty_tpl);?>
">След.</a></span>  
                                    <?php }?>
                                    &nbsp;&nbsp; <?php echo $_smarty_tpl->tpl_vars['current_page_num']->value;?>
 из <?php echo $_smarty_tpl->tpl_vars['total_pages_num']->value;?>

                                </div>
                            </div>
                            <?php }?>
                            
                            
                            <div class="float-right pt-1">
                                <select class="form-control form-control-sm js-page-count" name="page-count">
                                    <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page_count'=>50),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['page_count']->value==50) {?>selected=""<?php }?>>Показывать 50</option>
                                    <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page_count'=>100),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['page_count']->value==100) {?>selected=""<?php }?>>Показывать 100</option>
                                    <option value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page_count'=>500),$_smarty_tpl);?>
" <?php if ($_smarty_tpl->tpl_vars['page_count']->value==500) {?>selected=""<?php }?>>Показывать 500</option>
                                    
                                </select>
                            </div>
                            
                            <div style="clear:both"></div>
                            
                            <div class="jsgrid-load-shader" style="display: none; position: absolute; inset: 0px; z-index: 10;">
                            </div>
                            <div class="jsgrid-load-panel" style="display: none; position: absolute; top: 50%; left: 50%; z-index: 1000;">
                                Идет загрузка...
                            </div>
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
</div>

<div id="modal_add_comment" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">Добавить комментарий</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_add_comment" action="">
                    
                    <input type="hidden" name="order_id" value="" />
                    <input type="hidden" name="contactperson_id" value="" />
                    <input type="hidden" name="action" value="" />
                    
                    <div class="alert" style="display:none"></div>
                    
                    <div class="form-group">
                        <label for="name" class="control-label">Комментарий:</label>
                        <textarea class="form-control" name="text"></textarea>
                    </div>
                    <div class="form-action">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_send_sms" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">Отправить смс-сообщение?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                
                
                <div class="card">
                    <div class="card-body">
                        
                        <div class="tab-content tabcontent-border p-3" id="myTabContent">
                            <div role="tabpanel" class="tab-pane fade active show" id="waiting_reason" aria-labelledby="home-tab">
                                <form class="js-sms-form">
                                    <input type="hidden" name="user_id" value="" />
                                    <input type="hidden" name="order_id" value="" />
                                    <input type="hidden" name="yuk" value="" />
                                    <input type="hidden" name="action" value="send_sms" />
                                    <div class="form-group">
                                        <label for="name" class="control-label">Выберите шаблон сообщения:</label>
                                        <select name="template_id" class="form-control">
                                            <?php  $_smarty_tpl->tpl_vars['sms_template'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sms_template']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sms_templates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sms_template']->key => $_smarty_tpl->tpl_vars['sms_template']->value) {
$_smarty_tpl->tpl_vars['sms_template']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['sms_template']->value->id;?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sms_template']->value->template, ENT_QUOTES, 'UTF-8', true);?>
">
                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sms_template']->value->name, ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo $_smarty_tpl->tpl_vars['sms_template']->value->template;?>
)
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-action clearfix">
                                        <button type="button" class="btn btn-danger btn-lg float-left waves-effect" data-dismiss="modal">Отменить</button>
                                        <button type="submit" class="btn btn-success btn-lg float-right waves-effect waves-light">Да, отправить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php }} ?>
