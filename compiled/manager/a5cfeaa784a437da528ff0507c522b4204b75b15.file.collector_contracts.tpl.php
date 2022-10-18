<?php /* Smarty version Smarty-3.1.18, created on 2022-06-28 21:07:29
         compiled from "/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/collector_contracts.tpl" */ ?>
<?php /*%%SmartyHeaderCode:185886583962bb4361d81ce9-10998974%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5cfeaa784a437da528ff0507c522b4204b75b15' => 
    array (
      0 => '/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/collector_contracts.tpl',
      1 => 1656438501,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '185886583962bb4361d81ce9-10998974',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'settings' => 0,
    'manager' => 0,
    'period' => 0,
    'from' => 0,
    'to' => 0,
    'collection_statuses' => 0,
    'filter_status' => 0,
    'cs_id' => 0,
    'cs_name' => 0,
    'sort' => 0,
    'managers' => 0,
    'm' => 0,
    'search' => 0,
    'collector_tags' => 0,
    't' => 0,
    'current_page_num' => 0,
    'items_per_page' => 0,
    'contracts' => 0,
    'contract' => 0,
    'shift' => 0,
    'have_contactperson_search' => 0,
    'comm' => 0,
    'cp' => 0,
    'total_pages_num' => 0,
    'count_od' => 0,
    'count_percents' => 0,
    'count_total_summ' => 0,
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
  'unifunc' => 'content_62bb4361e283f7_07044902',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62bb4361e283f7_07044902')) {function content_62bb4361e283f7_07044902($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Мои договоры', null, 1);
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
/js/apps/orders.js?v=1.14"></script>
    <script type="text/javascript" src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/order.js?v=1.16"></script>
    
    <script>
        $(function(){
            $('.js-open-show').hide();
            
            $(document).on('click', '.js-mango-call', function(e){
                e.preventDefault();
                
                var _phone = $(this).data('phone');
                var _user = $(this).data('user');
                var _yuk = $(this).hasClass('js-yuk') ? 1 : 0;
                
                Swal.fire({
                    title: 'Выполнить звонок?',
                    text: "Вы хотите позвонить на номер: "+_phone,
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Отменить',
                    confirmButtonText: 'Да, позвонить'
                }).then((result) => {
                    if (result.value) {
                        
                        $.ajax({
                            url: '/ajax/communications.php',
                            data: {
                                action: 'check',
                                user_id: _user,
                                call: 1
                            },
                            success: function(resp){
                                if (resp == 1)
                                {
                                    $.ajax({
                                        url: 'ajax/mango_call.php',
                                        data: {
                                            phone: _phone,
                                            yuk: _yuk
                                        },
                                        beforeSend: function(){
                                            
                                        },
                                        success: function(resp){
                                            if (!!resp.error)
                                            {
                                                if (resp.error == 'empty_mango')
                                                {
                                                    Swal.fire(
                                                        'Ошибка!',
                                                        'Необходимо указать Ваш внутренний номер сотрудника Mango-office.',
                                                        'error'
                                                    )
                                                }
                                                
                                                if (resp.error == 'empty_mango')
                                                {
                                                    Swal.fire(
                                                        'Ошибка!',
                                                        'Не хватает прав на выполнение операции.',
                                                        'error'
                                                    )
                                                }
                                            }
                                            else if (resp.success)
                                            {                                                
                                                Swal.fire({
                                                    title: 'Выполняется звонок',
                                                    text: "Удалось ли Вам поговорить?",
                                                    type: 'question',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    cancelButtonText: 'Не успешно',
                                                    confirmButtonText: 'Успешно'
                                                }).then((result) => {
                                                    if (result.value) {
                                                        $.ajax({
                                                            url: 'ajax/communications.php',
                                                            data: {
                                                                action: 'add',
                                                                user_id: _user,
                                                                type: 'call',
                                                                to_number: _phone,
                                                                yuk: _yuk,
                                                            }
                                                        });
                                                    
                                                    }
                                                })    

                                            }
                                            else
                                            {
                                                console.error(resp);
                                                Swal.fire(
                                                    'Ошибка!',
                                                    '',
                                                    'error'
                                                )
                                            }
                                        }
                                    })
                                    
                                }
                                else
                                {
                                    Swal.fire(
                                        'Ошибка!',
                                        'Исчерпан лимит коммуникаций.',
                                        'error'
                                    )
                                    
                                }
                            }
                        })
                        
                        
                    }
                })
                
                
            });

            
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
            });


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
            var _yuk = $(this).hasClass('js-yuk') ? 1 : 0;

            if (_yuk == 1)
            {
                $('[name="template_id"] option[value="3"]').show().attr('selected', true);
                $('[name="template_id"] option[value="4"]').hide();                
            }
            else
            {
                $('[name="template_id"] option[value="3"]').hide();
                $('[name="template_id"] option[value="4"]').show().attr('selected', true);                
            }
            
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
        
/*
        $(document).on('change', '#check_all', function(){
            var lch = $('.js-contract-check:not(checked)').length
        
            console.log(lch)
        });
*/        
        $(document).on('click', '.js-distribute-open', function(e){
            e.preventDefault();
            
            $('.js-distribute-contract').remove();
            $('.js-contract-row').each(function(){
                $('#form_distribute').append('<input type="hidden" name="contracts[]" class="js-distribute-contract" value="'+$(this).data('contract')+'" />');
            });
            
            $('.js-select-type').val('all');
            
            $('#modal_distribute').modal();
        });
        
        $(document).on('change', '.js-select-type', function(){
            var _current = $(this).val();
            if (_current == 'all')
            {
                $('.js-distribute-contract').remove();
                $('.js-contract-row').each(function(){
                    $('#form_distribute').append('<input type="hidden" name="contracts[]" class="js-distribute-contract" value="'+$(this).data('contract')+'" />');
                });                
            }
            else if (_current == 'checked')
            {
                $('.js-distribute-contract').remove();
                $('.js-contract-check').each(function(){
                    if ($(this).is(':checked'))
                    {
                        $('#form_distribute').append('<input type="hidden" name="contracts[]" class="js-distribute-contract" value="'+$(this).val()+'" />');
                    }
                })
            }
            else if (_current == 'optional')
            {
                $('.js-distribute-contract').remove();
            }
            
        });
        
        $(document).on('submit', '#form_distribute', function(e){
            e.preventDefault();
            
            var $form = $(this);
            
            if ($form.hasClass('loading'))
                return false;
            
console.log(location.hash)             
            var _hash = location.hash.replace('#', '?');
            $.ajax({
                url: '/my_contracts'+_hash,
                data: $form.serialize(),
                type: 'POST',
                beforeSend: function(){
                    $form.addClass('loading');
                },
                success: function(resp){
                    if (resp.success)
                    {
                        $('#modal_distribute').modal('hide');            
                        
                        Swal.fire({
                            timer: 5000,
                            title: 'Договора распределены.',
                            type: 'success',
                        });
//                        location.reload();
                    }
                    else
                    {
                        Swal.fire({
                            text: resp.error,
                            type: 'error',
                        });
                        
                    }
                    $form.removeClass('loading');
                }
            })
        })
        
        $(document).on('change', '.js-select-type', function(){
            var _current = $(this).val();
            
            if (_current == 'optional')
            {
                $('.js-input-quantity').fadeIn();
            }
            else
            {
                $('.js-input-quantity').fadeOut();
            }
        })
        
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
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor mb-0 mt-0"><i class="mdi mdi-animation"></i> Мои договоры</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Договоры</li>
                </ol>
            </div>
            <div class="col-md-6 col-4 ">
                <div class="row">
                
                    <div class="col-6 ">
                        <?php if (in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('developer','admin','chief_collector','team_collector'))) {?>
                        <button class="btn btn-primary js-distribute-open float-right" type="button"><i class="mdi mdi-account-convert"></i> Распределить</button>                        
                        <?php }?>
                    </div>

                    <div class="col-6 dropdown text-right hidden-sm-down js-period-filter">
                        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['period']->value;?>
" id="filter_period" />     
                        <button class="btn btn-secondary dropdown-toggle float-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
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

                        <div class="js-daterange-filter input-group mb-3" <?php if ($_smarty_tpl->tpl_vars['period']->value!='optional') {?>style="display:none"<?php }?>>
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
                            <h4 class="card-title  float-left">Список договоров </h4>
                            <div class="float-right js-filter-client">

                                <?php  $_smarty_tpl->tpl_vars['cs_name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cs_name']->_loop = false;
 $_smarty_tpl->tpl_vars['cs_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['collection_statuses']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cs_name']->key => $_smarty_tpl->tpl_vars['cs_name']->value) {
$_smarty_tpl->tpl_vars['cs_name']->_loop = true;
 $_smarty_tpl->tpl_vars['cs_id']->value = $_smarty_tpl->tpl_vars['cs_name']->key;
?>
                                <a href="<?php if ($_smarty_tpl->tpl_vars['filter_status']->value==$_smarty_tpl->tpl_vars['cs_id']->value) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null,'page'=>null),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>$_smarty_tpl->tpl_vars['cs_id']->value,'page'=>null),$_smarty_tpl);?>
<?php }?>" class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==$_smarty_tpl->tpl_vars['cs_id']->value) {?>btn-success<?php } else { ?>btn-outline-success<?php }?>"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cs_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</a>
                                <?php } ?>

                            </div>

                        </div>
                        
                        <div id="basicgrid" class="jsgrid" style="position: relative; width: 100%;">
                            <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                                <table class="jsgrid-table table table-hover">
                                    <tr class="jsgrid-header-row">
                                        <th style="width:20px;" class="jsgrid-header-cell">
                                            #
                                            <input id="filter_status" value="<?php echo $_smarty_tpl->tpl_vars['filter_status']->value;?>
" type="hidden" />
                                        </th>
                                        <?php if (in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('developer','admin','chief_collector','team_collector'))) {?>
                                        <th style="width:80px" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='manager_id_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='manager_id_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='manager_id_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'manager_id_desc'),$_smarty_tpl);?>
">Пользователь</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'manager_id_asc'),$_smarty_tpl);?>
">Пользователь</a><?php }?>
                                        </th>
                                        <?php }?>
                                        <th style="width: 120px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='fio_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='fio_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='fio_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'fio_desc'),$_smarty_tpl);?>
">ФИО</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'fio_asc'),$_smarty_tpl);?>
">ФИО</a><?php }?>
                                        </th>
                                        <th style="width: 70px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='body_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='body_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='body_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'body_desc'),$_smarty_tpl);?>
">ОД, руб</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'body_asc'),$_smarty_tpl);?>
">ОД, руб</a><?php }?>
                                        </th>
                                        <th style="width: 70px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='percents_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='percents_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='percents_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'percents_desc'),$_smarty_tpl);?>
">%, руб</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'percents_asc'),$_smarty_tpl);?>
">%, руб</a><?php }?>
                                        </th>
                                        <th style="width: 70px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='total_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='total_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='total_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'total_desc'),$_smarty_tpl);?>
">Итог, руб</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'total_asc'),$_smarty_tpl);?>
">Итог, руб</a><?php }?>
                                        </th>
                                        <?php if (in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('developer','admin','chief_collector','team_collector'))) {?>
                                        <th style="width: 70px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='total_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='total_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='total_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'total_desc'),$_smarty_tpl);?>
">Переплата Х</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'total_asc'),$_smarty_tpl);?>
">Переплата Х</a><?php }?>
                                        </th>
                                        <?php }?>
                                        <th style="width: 80px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='phone_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='phone_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='phone_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'phone_desc'),$_smarty_tpl);?>
">Телефон</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'phone_asc'),$_smarty_tpl);?>
">Телефон</a><?php }?>
                                        </th>
                                        <th style="width: 70px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='return_asc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='return_desc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='return_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'return_desc'),$_smarty_tpl);?>
">Просрочен</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'return_asc'),$_smarty_tpl);?>
">Просрочен</a><?php }?>
                                        </th>
                                        <th style="width: 80px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='return_asc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='return_desc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='return_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'return_desc'),$_smarty_tpl);?>
">Дата платежа</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'return_asc'),$_smarty_tpl);?>
">Дата платежа</a><?php }?>
                                        </th>
                                        <th style="width: 80px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='tag_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='tag_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='tag_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'tag_desc'),$_smarty_tpl);?>
">Тег</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'tag_asc'),$_smarty_tpl);?>
">Тег</a><?php }?>
                                        </th>
                                        <th style="width: 140px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='birth_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='birth_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            Комментарий
                                        </th>
                                    </tr>

                                    <tr class="jsgrid-filter-row" id="search_form">
                                        <td style="width:20px;" class="jsgrid-cell">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" class="custom-control-input" id="check_all" value="" />
                                                <label for="check_all" title="Отметить все" class="custom-control-label"> </label>
                                            </div>                                        
                                        </td>                                    
                                        
                                        <?php if (in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('developer','admin','chief_collector','team_collector'))) {?>
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
                                        <?php }?>
                                        <td style="width: 120px;" class="jsgrid-cell">
                                            <input type="text" name="fio" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['fio'];?>
" class="form-control input-sm">
                                        </td>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                            <div class="row no-gutter">
                                                <div class="col-6 pr-0">
                                                    <input type="text" placeholder="c" name="od_from" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['od_from'];?>
" class="form-control input-sm">                                                
                                                </div>
                                                <div class="col-6 pl-0">
                                                    <input type="text" name="od_to" placeholder="по" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['od_to'];?>
" class="form-control input-sm">                                            
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                            <div class="row no-gutter">
                                                <div class="col-6 pr-0">
                                                    <input type="text" placeholder="c" name="percents_from" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['percents_from'];?>
" class="form-control input-sm">                                                
                                                </div>
                                                <div class="col-6 pl-0">
                                                    <input type="text" name="percents_to" placeholder="по" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['percents_to'];?>
" class="form-control input-sm">                                            
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                            <div class="row no-gutter">
                                                <div class="col-6 pr-0">
                                                    <input type="text" placeholder="c" name="total_from" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['total_from'];?>
" class="form-control input-sm">                                                
                                                </div>
                                                <div class="col-6 pl-0">
                                                    <input type="text" name="total_to" placeholder="по" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['total_to'];?>
" class="form-control input-sm">                                            
                                                </div>
                                            </div>
                                        </td>
                                        <?php if (in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('developer','admin','chief_collector','team_collector'))) {?>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                        </td>
                                        <?php }?>
                                        <td style="width: 80px;" class="jsgrid-cell">
                                            <input type="text" name="phone" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['phone'];?>
" class="form-control input-sm">
                                        </td>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                            <div class="row no-gutter">
                                                <div class="col-6 pr-0">
                                                    <input type="text" placeholder="c" name="delay_from" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['delay_from'];?>
" class="form-control input-sm">                                                
                                                </div>
                                                <div class="col-6 pl-0">
                                                    <input type="text" name="delay_to" placeholder="по" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['delay_to'];?>
" class="form-control input-sm">                                            
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 80px;" class="jsgrid-cell">

                                        </td>
                                        <td style="width: 80px;" class="jsgrid-cell">
                                            <select class="form-control" name="tag_id">
                                                <option value="0"></option>
                                                <?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['t']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['collector_tags']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value) {
$_smarty_tpl->tpl_vars['t']->_loop = true;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['t']->value->id;?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['t']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="width: 140px;" class="jsgrid-cell">
                                        </td>
                                    </tr>

                                </table>
                            </div>
                            <div class="jsgrid-grid-body">
                                <table class="jsgrid-table table table-striped table-hover">
                                    <tbody>
                                    <?php $_smarty_tpl->tpl_vars['shift'] = new Smarty_variable(($_smarty_tpl->tpl_vars['current_page_num']->value-1)*$_smarty_tpl->tpl_vars['items_per_page']->value, null, 0);?>
                                    
                                    <?php  $_smarty_tpl->tpl_vars['contract'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['contract']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['contracts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['contract']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['contract']->key => $_smarty_tpl->tpl_vars['contract']->value) {
$_smarty_tpl->tpl_vars['contract']->_loop = true;
 $_smarty_tpl->tpl_vars['contract']->iteration++;
?>

                                        <?php $_smarty_tpl->tpl_vars['have_contactperson_search'] = new Smarty_variable(0, null, 0);?>
                                        <?php  $_smarty_tpl->tpl_vars['cp'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cp']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['contract']->value->contactpersons; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cp']->key => $_smarty_tpl->tpl_vars['cp']->value) {
$_smarty_tpl->tpl_vars['cp']->_loop = true;
?>
                                            <?php if ($_smarty_tpl->tpl_vars['search']->value['phone']&&$_smarty_tpl->tpl_vars['search']->value['phone']!=$_smarty_tpl->tpl_vars['contract']->value->order->phone_mobile) {?>
                                                <?php $_smarty_tpl->tpl_vars['have_contactperson_search'] = new Smarty_variable(1, null, 0);?>                                        
                                            <?php }?>
                                        <?php } ?>
                                    
                                        <style>
                                            .contract-row-<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
 td {
                                                background:<?php echo $_smarty_tpl->tpl_vars['collector_tags']->value[$_smarty_tpl->tpl_vars['contract']->value->order->contact_status]->color;?>
33!important;
                                                
                                            }
                                        </style>
                                        <tr class="jsgrid-row js-contract-row contract-row-<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
 <?php if ($_smarty_tpl->tpl_vars['contract']->value->collection_workout) {?>workout-row<?php }?>" data-contract="<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
">
                                            <td style="width:20px" class="jsgrid-cell text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" class="custom-control-input js-contract-check" id="contract_<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
" value="<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
" />
                                                    <label for="contract_<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
" class="custom-control-label"> </label>
                                                </div>
                                                <?php echo ($_smarty_tpl->tpl_vars['contract']->iteration)+$_smarty_tpl->tpl_vars['shift']->value;?>

                                            </td>
                                            
                                            <?php if (in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('developer','admin','chief_collector','team_collector'))) {?>
                                            <td style="width:80px" class="jsgrid-cell">
                                                <div class="js-open-hide js-dopinfo-<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
 js-collection-manager-block <?php if ($_smarty_tpl->tpl_vars['have_contactperson_search']->value) {?>open<?php }?>">
                                                    <small><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['managers']->value[$_smarty_tpl->tpl_vars['contract']->value->collection_manager_id]->name, ENT_QUOTES, 'UTF-8', true);?>
</small>
                                                </div>
                                                <div class="js-open-show js-dopinfo-<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
">
                                                <?php if ($_smarty_tpl->tpl_vars['manager']->value->role=='team_collector') {?>
                                                    <small><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['managers']->value[$_smarty_tpl->tpl_vars['contract']->value->collection_manager_id]->name, ENT_QUOTES, 'UTF-8', true);?>
</small>
                                                <?php } else { ?>
                                                    <form action="">
                                                        <select class="form-control js-collection-manager" data-contract="<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
" name="order_manager[<?php echo $_smarty_tpl->tpl_vars['contract']->value->collection_manager_id;?>
]">
                                                            <option value="0" <?php if (!$_smarty_tpl->tpl_vars['contract']->value->collection_manager_id) {?>selected<?php }?>>Не выбран</option>
                                                            <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['managers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value) {
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                                                            <?php if ($_smarty_tpl->tpl_vars['m']->value->role=='collector') {?>
                                                            <option value="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['contract']->value->collection_manager_id==$_smarty_tpl->tpl_vars['m']->value->id) {?>selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['m']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                            <?php }?>
                                                            <?php } ?>
                                                        </select>
                                                    </form>
                                                <?php }?>
                                                </div>
                                            </td>
                                            <?php }?>
                                            <td style="width: 120px;" class="jsgrid-cell">
                                                
                                                <div class="button-toggle-wrapper" style="margin-right:20px;">
                                                    <button class="js-open-contract button-toggle" data-id="<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
" type="button" title="Подробнее"></button>
                                                </div>
                                                <div style="padding-left:20px;"> 
                                                    <?php if ($_smarty_tpl->tpl_vars['contract']->value->collection_status) {?>
                                                    <span class="label label-primary"><?php echo $_smarty_tpl->tpl_vars['collection_statuses']->value[$_smarty_tpl->tpl_vars['contract']->value->collection_status];?>
</span>
                                                    <?php } else { ?>
                                                    <span class="label label-success">Не просрочен</span>
                                                    <?php }?>
                                                    <?php if ($_smarty_tpl->tpl_vars['contract']->value->premier) {?><span class="label label-warning ">Премьер</span>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['contract']->value->sold) {?><span class="label label-warning ">ЮК</span><?php }?>
                                                    <?php if ($_smarty_tpl->tpl_vars['contract']->value->sud) {?>
                                                    <span class="label label-danger">Суд</span>
                                                    <?php }?>
                                                </div>
                                                <a href="collector_contract/<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
">
                                                    <?php echo $_smarty_tpl->tpl_vars['contract']->value->order->lastname;?>
 
                                                    <?php echo $_smarty_tpl->tpl_vars['contract']->value->order->firstname;?>
 
                                                    <?php echo $_smarty_tpl->tpl_vars['contract']->value->order->patronymic;?>

                                                </a>
                                                <small><?php echo $_smarty_tpl->tpl_vars['contract']->value->order->birth;?>
</small>
                                                <?php if ($_smarty_tpl->tpl_vars['contract']->value->status==10) {?>
                                                <span class="label label-danger">Суд 1С</span>
                                                <?php }?>
                                                <div class="clearfix">
                                                
                                                </div>
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                <?php echo $_smarty_tpl->tpl_vars['contract']->value->loan_body_summ*1;?>
 
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                <?php echo ($_smarty_tpl->tpl_vars['contract']->value->loan_percents_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_charge_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_peni_summ)*1;?>

                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                <strong>
                                                    <?php echo ($_smarty_tpl->tpl_vars['contract']->value->loan_body_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_percents_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_charge_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_peni_summ)*1;?>

                                                </strong>
                                            </td>
                                            <?php if (in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('developer','admin','chief_collector','team_collector'))) {?>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                    <?php echo round(($_smarty_tpl->tpl_vars['contract']->value->total_paid/$_smarty_tpl->tpl_vars['contract']->value->amount),2);?>

                                            </td>
                                            <?php }?>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <div>
                                                    <span class="label <?php if ($_smarty_tpl->tpl_vars['contract']->value->client_time_warning) {?>label-danger<?php } else { ?>label-success<?php }?> "><i class="far fa-clock"></i> <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['contract']->value->client_time);?>
</span>
                                                </div>
                                                <?php if ($_smarty_tpl->tpl_vars['search']->value['phone']&&$_smarty_tpl->tpl_vars['search']->value['phone']==$_smarty_tpl->tpl_vars['contract']->value->order->phone_mobile) {?>
                                                <small class="text-danger"><?php echo $_smarty_tpl->tpl_vars['contract']->value->order->phone_mobile;?>
</small>
                                                <?php } else { ?>
                                                <small><?php echo $_smarty_tpl->tpl_vars['contract']->value->order->phone_mobile;?>
</small>
                                                <?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['contract']->value->collection_status!=8) {?>
                                                <br />
                                                <button class="js-mango-call mango-call <?php if ($_smarty_tpl->tpl_vars['contract']->value->sold) {?>js-yuk<?php }?>" data-user="<?php echo $_smarty_tpl->tpl_vars['contract']->value->user_id;?>
" data-phone="<?php echo $_smarty_tpl->tpl_vars['contract']->value->order->phone_mobile;?>
" title="Выполнить звонок">
                                                    <i class="fas fa-mobile-alt"></i>
                                                </button>
                                                <button class="js-open-sms-modal mango-call <?php if ($_smarty_tpl->tpl_vars['contract']->value->sold) {?>js-yuk<?php }?>" data-user="<?php echo $_smarty_tpl->tpl_vars['contract']->value->user_id;?>
" data-order="<?php echo $_smarty_tpl->tpl_vars['contract']->value->order_id;?>
">
                                                    <i class=" far fa-share-square"></i>
                                                </button>
                                                <?php }?>
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                <?php echo $_smarty_tpl->tpl_vars['contract']->value->delay;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['contract']->value->delay,'день','дней','дня');?>

                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['contract']->value->return_date);?>

                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <div class="js-open-hide js-dopinfo-<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
 js-contact-status-block">
                                                    <?php if (!$_smarty_tpl->tpl_vars['contract']->value->order->contact_status) {?>
                                                        <span class="label label-warning">Нет данных</span>
                                                    <?php } else { ?>
                                                        <span class="label" style="background:<?php echo $_smarty_tpl->tpl_vars['collector_tags']->value[$_smarty_tpl->tpl_vars['contract']->value->order->contact_status]->color;?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['collector_tags']->value[$_smarty_tpl->tpl_vars['contract']->value->order->contact_status]->name, ENT_QUOTES, 'UTF-8', true);?>
</span>
                                                    <?php }?>
                                                                                                        
                                                    <div class="custom-checkbox mt-1 custom-control">
                                                        <input id="workout_<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
" type="checkbox" class="custom-control-input js-workout-input" value="<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
" name="workout" <?php if ($_smarty_tpl->tpl_vars['contract']->value->collection_workout) {?>checked="true"<?php }?> />
                                                        <label for="workout_<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
" class="custom-control-label"><small>Отработан</small></label>
                                                    </div>
                                                    
                                                </div>
                                                <div class="js-open-show js-dopinfo-<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
">
                                                    <form action="order/<?php echo $_smarty_tpl->tpl_vars['contract']->value->order->order_id;?>
">
                                                        <select class="form-control js-contact-status" data-user="<?php echo $_smarty_tpl->tpl_vars['contract']->value->order->user_id;?>
" data-contract="<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
" name="contact_status[<?php echo $_smarty_tpl->tpl_vars['contract']->value->order->user_id;?>
]">
                                                            <option value="0" <?php if (!$_smarty_tpl->tpl_vars['contract']->value->order->contact_status) {?>selected<?php }?>>Нет данных</option>
                                                            <?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['t']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['collector_tags']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value) {
$_smarty_tpl->tpl_vars['t']->_loop = true;
?>
                                                            <option value="<?php echo $_smarty_tpl->tpl_vars['t']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['contract']->value->order->contact_status==$_smarty_tpl->tpl_vars['t']->value->id) {?>selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['t']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                            <?php } ?>
                                                        </select>
                                                    </form>
                                                </div>
                                            </td>
                                            
                                            <td style="width: 140px;line-height:1" class="jsgrid-cell">
                                                <div class="" style="max-height:100px;overflow:hidden;position:relative;">
                                                    <div class="float-right">
                                                        <button class="float-right btn btn-link js-open-comment-form" title="Добавить комментарий" data-contactperson="" data-order="<?php echo $_smarty_tpl->tpl_vars['contract']->value->order->order_id;?>
">
                                                            <i class="fa-lg fas fa-comment-dots"></i> 
                                                        </button>
                                                    </div>
                                                    <?php $_smarty_tpl->tpl_vars['comm'] = new Smarty_variable($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['first'][0][0]->first_modifier($_smarty_tpl->tpl_vars['contract']->value->order->comments), null, 0);?>
                                                    <small><?php echo $_smarty_tpl->tpl_vars['comm']->value->text;?>
</small>
                                                
                                                </div>
                                            </td>
                                        </tr>
                                        <?php  $_smarty_tpl->tpl_vars['cp'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cp']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['contract']->value->contactpersons; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cp']->key => $_smarty_tpl->tpl_vars['cp']->value) {
$_smarty_tpl->tpl_vars['cp']->_loop = true;
?>
                                        <tr class="jsgrid-row js-open-show js-dopinfo-<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['have_contactperson_search']->value) {?>style="display:table-row"<?php }?>>
                                            <td style="width: 60px;" class="jsgrid-cell jsgrid-align-right">
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                            </td>
                                            <td style="width: 120px;" class="jsgrid-cell">
                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cp']->value->name, ENT_QUOTES, 'UTF-8', true);?>

                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <?php if ($_smarty_tpl->tpl_vars['search']->value['phone']&&$_smarty_tpl->tpl_vars['search']->value['phone']==$_smarty_tpl->tpl_vars['cp']->value->phone) {?>
                                                <span class="text-danger js-search-found"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cp']->value->phone, ENT_QUOTES, 'UTF-8', true);?>
</span>
                                                <?php } else { ?>
                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cp']->value->phone, ENT_QUOTES, 'UTF-8', true);?>

                                                <?php }?>
                                                
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <div>
                                                    <form action="order/<?php echo $_smarty_tpl->tpl_vars['contract']->value->order->order_id;?>
">
                                                        <select class="form-control js-contactperson-status" data-contactperson="<?php echo $_smarty_tpl->tpl_vars['cp']->value->id;?>
" name="contactperson_status[<?php echo $_smarty_tpl->tpl_vars['cp']->value->id;?>
]">
                                                            <option value="0" <?php if (!$_smarty_tpl->tpl_vars['cp']->value->contact_status) {?>selected<?php }?>>Нет данных</option>
                                                            <?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['t']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['collector_tags']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value) {
$_smarty_tpl->tpl_vars['t']->_loop = true;
?>
                                                            <option value="<?php echo $_smarty_tpl->tpl_vars['t']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['cp']->value->contact_status==$_smarty_tpl->tpl_vars['t']->value->id) {?>selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['t']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                            <?php } ?>
                                                        </select>
                                                    </form>
                                                </div>
                                            </td>
                                            <td style="width: 140px;line-height:1" class="jsgrid-cell">
                                                <small><?php echo $_smarty_tpl->tpl_vars['cp']->value->comment;?>
</small>
                                                <button class="js-contactperson float-right btn btn-link js-open-comment-form" title="Добавить комментарий" data-contactperson="<?php echo $_smarty_tpl->tpl_vars['cp']->value->id;?>
" data-order="<?php echo $_smarty_tpl->tpl_vars['contract']->value->order_id;?>
">
                                                    <i class="fa-lg fas fa-comment-dots"></i> 
                                                </button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if ($_smarty_tpl->tpl_vars['current_page_num']->value==$_smarty_tpl->tpl_vars['total_pages_num']->value) {?>
                                        <tr>
                                            <td colspan="2"><strong>Итого</strong></td>
                                            
                                            <td>
                                            </td>
                                            <td>
                                                ОД:</br>
                                            <strong><?php echo $_smarty_tpl->tpl_vars['count_od']->value;?>
</strong>
                                            </td>
                                            <td>
                                                %:</br>
                                                <strong><?php echo $_smarty_tpl->tpl_vars['count_percents']->value;?>
</strong>
                                            </td>
                                            <td>
                                                Итог:</br>
                                                <strong><?php echo $_smarty_tpl->tpl_vars['count_total_summ']->value;?>
</strong>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                    <?php }?>
                                        

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
</div>

<div id="modal_distribute" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">Распределить договора</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_distribute" action="">
                    
                    <input type="hidden" name="action" value="distribute" />
                    
                    <div class="alert" style="display:none"></div>
                    
                    <div class="form-group">
                        <select class="form-control js-select-type" name="type">
                            <option value="all">Все видимые</option>
                            <option value="checked">Все отмеченные</option>
                            <option value="optional">Выбрать количество</option>
                        </select>
                        <div class="pt-2">
                            <input class="form-control js-input-quantity" name="quantity" value="" style="display:none" placeholder="Количество договоров для распределения на каждого выбранного сотрудника" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="control-label"><strong>Менеджеры для распределения:</strong></label>
                        <ul class="list-unstyled" style="max-height:250px;overflow:hidden auto;">
                            <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['managers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value) {
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                            <?php if ($_smarty_tpl->tpl_vars['m']->value->role=='collector'&&!$_smarty_tpl->tpl_vars['m']->value->blocked) {?>
                            <li>
                                <div class="">
                                    <input class="" name="managers[]" id="distribute_<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
" value="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
" type="checkbox" />
                                    <label for="distribute_<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
" class=""><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['m']->value->name, ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo $_smarty_tpl->tpl_vars['collection_statuses']->value[$_smarty_tpl->tpl_vars['m']->value->collection_status_id];?>
)</label>
                                </div>
                            </li>
                            <?php }?>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="form-action">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Распределить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php }} ?>
