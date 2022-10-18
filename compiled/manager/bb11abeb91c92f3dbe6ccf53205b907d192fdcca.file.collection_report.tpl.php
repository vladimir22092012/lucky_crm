<?php /* Smarty version Smarty-3.1.18, created on 2022-10-10 18:52:03
         compiled from "/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/collection_report.tpl" */ ?>
<?php /*%%SmartyHeaderCode:123973845163443fa3c50f43-00419417%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bb11abeb91c92f3dbe6ccf53205b907d192fdcca' => 
    array (
      0 => '/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/collection_report.tpl',
      1 => 1660295913,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '123973845163443fa3c50f43-00419417',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'settings' => 0,
    'period' => 0,
    'from' => 0,
    'to' => 0,
    'filter_status' => 0,
    'sort' => 0,
    'collectors' => 0,
    'collector' => 0,
    'collection_statuses' => 0,
    'manager' => 0,
    'filter' => 0,
    'item' => 0,
    'total' => 0,
    'total_pages_num' => 0,
    'current_page_num' => 0,
    'visible_pages' => 0,
    'page_from' => 0,
    'page_to' => 0,
    'p' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_63443fa3c97020_07343125',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_63443fa3c97020_07343125')) {function content_63443fa3c97020_07343125($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Отчет по коллекторам', null, 1);
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
/js/apps/order.js"></script>

    <script>
        $(function () {
            $('.js-open-show').hide();

            $(document).on('click', '.js-mango-call', function (e) {
                e.preventDefault();

                var _phone = $(this).data('phone');

                Swal.fire({
                    title: 'Выполнить звонок?',
                    text: "Вы хотите позвонить на номер: " + _phone,
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Отменить',
                    confirmButtonText: 'Да, позвонить'
                }).then((result) => {
                    if (result.value) {

                        $.ajax({
                            url: 'ajax/mango_call.php',
                            data: {
                                phone: _phone
                            },
                            beforeSend: function () {

                            },
                            success: function (resp) {
                                if (!!resp.error) {
                                    if (resp.error == 'empty_mango') {
                                        Swal.fire(
                                            'Ошибка!',
                                            'Необходимо указать Ваш внутренний номер сотрудника Mango-office.',
                                            'error'
                                        )
                                    }

                                    if (resp.error == 'empty_mango') {
                                        Swal.fire(
                                            'Ошибка!',
                                            'Не хватает прав на выполнение операции.',
                                            'error'
                                        )
                                    }
                                }
                                else if (resp.success) {
                                    Swal.fire(
                                        '',
                                        'Выполняется звонок.',
                                        'success'
                                    )
                                }
                                else {
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
                })


            });

            $(document).on('click', '.js-open-contract', function (e) {
                e.preventDefault();
                var _id = $(this).data('id')
                if ($(this).hasClass('open')) {
                    $(this).removeClass('open');
                    $('.js-open-hide.js-dopinfo-' + _id).show();
                    $('.js-open-show.js-dopinfo-' + _id).hide();
                }
                else {
                    $(this).addClass('open');
                    $('.js-open-hide.js-dopinfo-' + _id).hide();
                    $('.js-open-show.js-dopinfo-' + _id).show();
                }
            })

            $(document).on('change', '.js-contact-status', function () {
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
                    success: function (resp) {
                        if (contact_status == 1)
                            $('.js-contact-status-block.js-dopinfo-' + contract_id).html('<span class="label label-success">Контактная</span>')
                        else if (contact_status == 2)
                            $('.js-contact-status-block.js-dopinfo-' + contract_id).html('<span class="label label-danger">Не контактная</span>')
                        else if (contact_status == 0)
                            $('.js-contact-status-block.js-dopinfo-' + contract_id).html('<span class="label label-warning">Нет данных</span>')

                    }
                })
            })

            $(document).on('change', '.js-contactperson-status', function () {
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

            $(document).on('click', '.js-open-comment-form', function (e) {
                e.preventDefault();

                if ($(this).hasClass('js-contactperson')) {
                    var contactperson_id = $(this).data('contactperson');
                    $('#modal_add_comment [name=contactperson_id]').val(contactperson_id);
                    $('#modal_add_comment [name=action]').val('contactperson_comment');
                    $('#modal_add_comment [name=order_id]').val($(this).data('order'));
                }
                else {
                    var contactperson_id = $(this).data('contactperson');
                    $('#modal_add_comment [name=order_id]').val($(this).data('order'));
                    $('#modal_add_comment [name=action]').val('order_comment');
                }


                $('#modal_add_comment [name=text]').text('')
                $('#modal_add_comment').modal();
            });

            $(document).on('submit', '#form_add_comment', function (e) {
                e.preventDefault();

                var $form = $(this);

                $.ajax({
                    data: $form.serialize(),
                    type: 'POST',
                    success: function (resp) {
                        if (resp.success) {
                            $('#modal_add_comment').modal('hide');
                            $form.find('[name=text]').val('')


                            Swal.fire({
                                timer: 5000,
                                title: 'Комментарий добавлен.',
                                type: 'success',
                            });
                            location.reload();
                        }
                        else {
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
/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css"
          rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/jsgrid/jsgrid.min.css"/>
    <link type="text/css" rel="stylesheet"
          href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/jsgrid/jsgrid-theme.min.css"/>
    <link href="theme/manager/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Daterange picker plugins css -->
    <link href="theme/manager/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="theme/manager/assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">
    <style>
        .jsgrid-table {
            margin-bottom: 0
        }

        .label {
            white-space: pre;
        }

        .js-open-hide {
            display: block;
        }

        .js-open-show {
            display: none;
        }

        .open.js-open-hide {
            display: none;
        }

        .open.js-open-show {
            display: block;
        }

        .form-control.js-contactperson-status,
        .form-control.js-contact-status {
            font-size: 12px;
            padding-left: 0px;
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
                <h3 class="text-themecolor mb-0 mt-0"><i class="mdi mdi-animation"></i> Отчет по коллекторам</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Отчет по коллекторам</li>
                </ol>
            </div>
            <div class="col-md-6 col-4 align-self-center">
                <div class="row">
                    <div class="col-6 ">
                        <div class="js-daterange-filter input-group mb-3"
                             <?php if ($_smarty_tpl->tpl_vars['period']->value!='optional') {?>style="display:none"<?php }?>>
                            <input type="text" name="daterange" class="form-control daterange js-daterange-input"
                                   value="<?php if ($_smarty_tpl->tpl_vars['from']->value&&$_smarty_tpl->tpl_vars['to']->value) {?><?php echo $_smarty_tpl->tpl_vars['from']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['to']->value;?>
<?php }?>">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <span class="ti-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 dropdown hidden-sm-down js-period-filter">
                        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['period']->value;?>
" id="filter_period"/>
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-calendar-alt"></i>
                            <?php if ($_smarty_tpl->tpl_vars['period']->value=='today') {?>Сегодня
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='yesterday') {?>Вчера
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='week') {?>На этой неделе
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='month') {?>В этом месяце
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='year') {?>В этом году
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='all') {?>За все время
                            <?php } elseif ($_smarty_tpl->tpl_vars['period']->value=='optional') {?>Произвольный
                            <?php } else { ?><?php echo $_smarty_tpl->tpl_vars['period']->value;?>
<?php }?>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item js-period-link <?php if ($_smarty_tpl->tpl_vars['period']->value=='today') {?>active<?php }?>"
                               href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'today'),$_smarty_tpl);?>
">Сегодня</a>
                            <a class="dropdown-item js-period-link <?php if ($_smarty_tpl->tpl_vars['period']->value=='yesterday') {?>active<?php }?>"
                               href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'yesterday'),$_smarty_tpl);?>
">Вчера</a>
                            <a class="dropdown-item js-period-link <?php if ($_smarty_tpl->tpl_vars['period']->value=='month') {?>active<?php }?>"
                               href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'month'),$_smarty_tpl);?>
">В этом месяце</a>
                            <a class="dropdown-item js-period-link <?php if ($_smarty_tpl->tpl_vars['period']->value=='year') {?>active<?php }?>"
                               href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'year'),$_smarty_tpl);?>
">В этом году</a>
                            <a class="dropdown-item js-period-link <?php if ($_smarty_tpl->tpl_vars['period']->value=='all') {?>active<?php }?>"
                               href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'all'),$_smarty_tpl);?>
">За все время</a>
                            <a class="dropdown-item js-open-daterange <?php if ($_smarty_tpl->tpl_vars['period']->value=='optional') {?>active<?php }?>"
                               href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('period'=>'optional','page'=>null),$_smarty_tpl);?>
">Произвольный</a>
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
                            <h4 class="card-title  float-left">Отчет по коллекторам</h4>

                            <div class="float-right js-filter-status">
                                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>2),$_smarty_tpl);?>
"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==2) {?>btn-info<?php } else { ?>btn-outline-info<?php }?>">0-2
                                    дни</a>
                                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>3),$_smarty_tpl);?>
"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==3) {?>btn-secondary<?php } else { ?>btn-outline-secondary<?php }?>">Ожидание-1</a>
                                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>4),$_smarty_tpl);?>
"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==4) {?>btn-primary<?php } else { ?>btn-outline-primary<?php }?>">Предсофт</a>
                                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>5),$_smarty_tpl);?>
"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==5) {?>btn-secondary<?php } else { ?>btn-outline-secondary<?php }?>">Ожидание-2</a>
                                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>6),$_smarty_tpl);?>
"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==6) {?>btn-warning<?php } else { ?>btn-outline-warning<?php }?>">Софт</a>
                                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>7),$_smarty_tpl);?>
"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==7) {?>btn-secondary<?php } else { ?>btn-outline-secondary<?php }?>">Ожидание-3</a>
                                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>8),$_smarty_tpl);?>
"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==8) {?>btn-danger<?php } else { ?>btn-outline-danger<?php }?>">Хард</a>
                                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>9),$_smarty_tpl);?>
"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==9) {?>btn-secondary<?php } else { ?>btn-outline-secondary<?php }?>">Ожидание-4</a>
                                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>10),$_smarty_tpl);?>
"
                                   class="btn btn-xs <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==10) {?>btn-danger<?php } else { ?>btn-outline-danger<?php }?>">Хард-2</a>
                            </div>

                        </div>

                        <div id="basicgrid" class="jsgrid" style="position: relative; width: 100%;">
                            <div class="jsgrid-grid-header ">

                                <table class="jsgrid-table table table-striped table-hover">
                                    <tr class="jsgrid-header-row">
                                        <th style="width: 120px;"
                                            class="jsgrid-header-cell jsgrid-align-right jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='manager_id_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='manager_id_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php }?>">
                                            Сотрудник
                                        </th>
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='pay_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='pay_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            Кол-во оплат
                                        </th>
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='closed_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='closed_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            Закрыто
                                        </th>
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='prolongation_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='prolongation_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            Пролонгации
                                        </th>
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='total_brutto_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='total_brutto_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            Сборы без ОД
                                        </th>
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='total_netto_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='total_netto_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            Сборы
                                        </th>
                                    </tr>
                                </table>

                            </div>
                            <div class="jsgrid-grid-body">
                                <table class="jsgrid-table table table-striped table-hover">
                                    <tbody>
                                    <?php  $_smarty_tpl->tpl_vars['collector'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['collector']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['collectors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['collector']->key => $_smarty_tpl->tpl_vars['collector']->value) {
$_smarty_tpl->tpl_vars['collector']->_loop = true;
?>
                                        <?php if ($_smarty_tpl->tpl_vars['collector']->value->total_netto>0) {?>
                                            <tr class="jsgrid-row js-contract-row">
                                                <td style="width: 120px;" class="jsgrid-cell jsgrid-align-right">
                                                    <div class="button-toggle-wrapper">
                                                        <button class="js-open-contract button-toggle js-collector-id-<?php echo $_smarty_tpl->tpl_vars['collector']->value->id;?>
"
                                                                data-id="<?php echo $_smarty_tpl->tpl_vars['collector']->value->id;?>
" type="button"
                                                                title="Подробнее"></button>
                                                    </div>
                                                    <strong>
                                                        <small><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['collector']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</small>
                                                    </strong>
                                                    <br/>
                                                    <?php if ($_smarty_tpl->tpl_vars['collector']->value->collection_status_id) {?>
                                                        <span class="label <?php if ($_smarty_tpl->tpl_vars['collector']->value->collection_status_id==6) {?>label-warning<?php } elseif ($_smarty_tpl->tpl_vars['collector']->value->collection_status_id==8) {?>label-danger<?php } elseif ($_smarty_tpl->tpl_vars['collector']->value->collection_status_id==4) {?>label-primary<?php } else { ?>label-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['collection_statuses']->value[$_smarty_tpl->tpl_vars['collector']->value->collection_status_id];?>
</span>
                                                    <?php }?>
                                                </td>
                                                <td style="width: 70px;" class="jsgrid-cell">
                                                    <strong><?php echo $_smarty_tpl->tpl_vars['collector']->value->actions;?>
 / <?php echo round($_smarty_tpl->tpl_vars['collector']->value->totals);?>
</strong>
                                                </td>
                                                <td style="width: 70px;" class="jsgrid-cell">
                                                    <strong><?php echo round($_smarty_tpl->tpl_vars['collector']->value->closed);?>
</strong>
                                                </td>
                                                <td style="width: 70px;" class="jsgrid-cell">
                                                    <strong><?php echo round($_smarty_tpl->tpl_vars['collector']->value->prolongation);?>
 </strong>
                                                </td>
                                                <td style="width: 70px;" class="jsgrid-cell">
                                                    <strong><?php echo round($_smarty_tpl->tpl_vars['collector']->value->total_brutto);?>
 </strong>
                                                </td>
                                                <td style="width: 70px;" class="jsgrid-cell">
                                                    <strong><?php echo round($_smarty_tpl->tpl_vars['collector']->value->total_netto);?>
 </strong>
                                                </td>
                                            </tr>
                                            <tr class="jsgrid-row <?php if ($_smarty_tpl->tpl_vars['manager']->value->role!='collector') {?>js-open-show<?php }?> js-dopinfo-<?php echo $_smarty_tpl->tpl_vars['collector']->value->id;?>
">
                                                <td style="width: 120px" rowspan="<?php echo (count($_smarty_tpl->tpl_vars['collector']->value->items))+1;?>
"
                                                    class="jsgrid-cell jsgrid-align-right">
                                                    <ul class="list-unstyled">
                                                        <li><h5>ОД: <strong
                                                                        class="text-primary"><?php echo round($_smarty_tpl->tpl_vars['collector']->value->od);?>
</strong>
                                                            </h5></li>
                                                        <li><h5>Проценты: <strong
                                                                        class="text-primary"><?php echo round($_smarty_tpl->tpl_vars['collector']->value->percents);?>
</strong>
                                                            </h5></li>
                                                        <li><h5>Просрочка: <strong
                                                                        class="text-primary"><?php echo round($_smarty_tpl->tpl_vars['collector']->value->charge);?>
</strong>
                                                            </h5></li>
                                                        <li><h5>Пени: <strong
                                                                        class="text-primary"><?php echo round($_smarty_tpl->tpl_vars['collector']->value->peni);?>
</strong>
                                                            </h5></li>
                                                        <li><h5>Коммисия: <strong
                                                                        class="text-primary"><?php echo round($_smarty_tpl->tpl_vars['collector']->value->commision);?>
</strong>
                                                            </h5></li>
                                                        <li>
                                                            <h5>Количество закрытых: <strong class="text-primary"><?php echo round($_smarty_tpl->tpl_vars['collector']->value->closed);?>
</strong></h5>
                                                        </li>
                                                        <li>
                                                            <h5>Количество пролонгаций: <strong class="text-primary"><?php echo round($_smarty_tpl->tpl_vars['collector']->value->prolongation);?>
</strong></h5>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td style="width: 70px;" class="jsgrid-cell bg-info text-white">
                                                    <strong>ФИО</strong>
                                                </td>
                                                <td style="width: 70px;" class="jsgrid-cell bg-info text-white">
                                                    <strong>Закрытие/Пролонгация</strong>
                                                </td>
                                                <td style="width: 70px;" class="jsgrid-cell bg-info text-white">
                                                    <div class="row no-gutter jsgrid-filter-row" data-collector-id="<?php echo $_smarty_tpl->tpl_vars['collector']->value->id;?>
">
                                                        <div class="col-6 pr-0">
                                                            <strong>День просрочки</strong>
                                                        </div>
                                                        <div class="col-3 pr-0">
                                                            <input type="text" placeholder="c" name="delay_from" value="<?php echo $_smarty_tpl->tpl_vars['filter']->value['delay_from'];?>
" class="form-control input-sm">
                                                        </div>
                                                        <div class="col-3 pl-0">
                                                            <input type="text" name="delay_to" placeholder="по" value="<?php echo $_smarty_tpl->tpl_vars['filter']->value['delay_to'];?>
" class="form-control input-sm">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width: 70px;" class="jsgrid-cell bg-info text-white">
                                                    <strong>Сборы без ОД</strong>
                                                </td>
                                                <td style="width: 70px;" class="jsgrid-cell bg-info text-white">
                                                    <strong>Сборы</strong>
                                                </td>
                                            </tr>
                                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['collector']->value->items; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                                <tr class="jsgrid-row <?php if ($_smarty_tpl->tpl_vars['manager']->value->role!='collector') {?>js-open-show<?php }?> js-dopinfo-<?php echo $_smarty_tpl->tpl_vars['collector']->value->id;?>
">
                                                    <td style="width: 120px" class="jsgrid-cell">
                                                        <a href="client/<?php echo $_smarty_tpl->tpl_vars['item']->value->user->id;?>
" target="_blank">
                                                            <strong>
                                                                <small>
                                                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->user->lastname, ENT_QUOTES, 'UTF-8', true);?>

                                                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->user->firstname, ENT_QUOTES, 'UTF-8', true);?>

                                                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value->user->patronymic, ENT_QUOTES, 'UTF-8', true);?>

                                                                </small>
                                                            </strong>
                                                            <?php echo $_smarty_tpl->tpl_vars['item']->value->contract_id;?>

                                                        </a>
                                                    </td>
                                                    <td style="width: 70px;" class="jsgrid-cell">
                                                        <?php if ($_smarty_tpl->tpl_vars['item']->value->closed) {?>
                                                            <span class="label label-success">Закрытие</span>
                                                        <?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['item']->value->prolongation) {?><span class="label label-success">Пролонгация</span><?php }?>
                                                    </td>
                                                    <td style="width: 70px;" class="jsgrid-cell">
                                                <span>
                                                    <?php if (is_null($_smarty_tpl->tpl_vars['item']->value->delay_period)) {?>-
                                                    <?php } else { ?><?php echo $_smarty_tpl->tpl_vars['item']->value->delay_period;?>
<?php }?>
                                                </span>
                                                    </td>
                                                    <td style="width: 70px;" class="jsgrid-cell">
                                                        <strong><?php echo $_smarty_tpl->tpl_vars['item']->value->percents_summ+$_smarty_tpl->tpl_vars['item']->value->charge_summ+$_smarty_tpl->tpl_vars['item']->value->peni_summ;?>
</strong>
                                                    </td>
                                                    <td style="width: 70px;" class="jsgrid-cell">
                                                        <strong><?php echo $_smarty_tpl->tpl_vars['item']->value->percents_summ+$_smarty_tpl->tpl_vars['item']->value->charge_summ+$_smarty_tpl->tpl_vars['item']->value->peni_summ+$_smarty_tpl->tpl_vars['item']->value->body_summ;?>
</strong>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php }?>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="jsgrid-grid-header ">
                                <table class="jsgrid-table table table-striped table-hover">
                                    <tr class="jsgrid-footer-row">
                                        <th style="width: 120px;"
                                            class="jsgrid-header-cell jsgrid-align-right jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='order_id_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='order_id_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php }?>">
                                            Итого:
                                        </th>
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='fio_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='fio_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php echo $_smarty_tpl->tpl_vars['total']->value->actions;?>
 / <?php echo round($_smarty_tpl->tpl_vars['total']->value->totals);?>

                                        </th>
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='fio_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='fio_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php echo round($_smarty_tpl->tpl_vars['total']->value->closed);?>

                                        </th>
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='body_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='body_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php echo round($_smarty_tpl->tpl_vars['total']->value->prolongation);?>

                                        </th>
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='percents_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='percents_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php echo round($_smarty_tpl->tpl_vars['total']->value->total_brutto);?>

                                        </th>
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='total_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='total_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php echo round($_smarty_tpl->tpl_vars['total']->value->total_netto);?>

                                        </th>
                                    </tr>
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
                                <div class="jsgrid-pager-container" style="">
                                    <div class="jsgrid-pager">
                                        Страницы:

                                        <?php if ($_smarty_tpl->tpl_vars['current_page_num']->value==2) {?>
                                            <span class="jsgrid-pager-nav-button "><a
                                                        href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null),$_smarty_tpl);?>
">Пред.</a></span>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['current_page_num']->value>2) {?>
                                            <span class="jsgrid-pager-nav-button "><a
                                                        href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->tpl_vars['current_page_num']->value-1),$_smarty_tpl);?>
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
<?php } else { ?><a
                                            href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->tpl_vars['total_pages_num']->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['total_pages_num']->value;?>
</a><?php }?>
                                    </span>

                                        <?php if ($_smarty_tpl->tpl_vars['current_page_num']->value<$_smarty_tpl->tpl_vars['total_pages_num']->value) {?>
                                            <span class="jsgrid-pager-nav-button"><a
                                                        href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->tpl_vars['current_page_num']->value+1),$_smarty_tpl);?>
">След.</a></span>
                                        <?php }?>
                                        &nbsp;&nbsp; <?php echo $_smarty_tpl->tpl_vars['current_page_num']->value;?>
 из <?php echo $_smarty_tpl->tpl_vars['total_pages_num']->value;?>

                                    </div>
                                </div>
                            <?php }?>

                            <div class="jsgrid-load-shader"
                                 style="display: none; position: absolute; inset: 0px; z-index: 10;">
                            </div>
                            <div class="jsgrid-load-panel"
                                 style="display: none; position: absolute; top: 50%; left: 50%; z-index: 1000;">
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

<div id="modal_add_comment" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Добавить комментарий</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_add_comment" action="">

                    <input type="hidden" name="order_id" value=""/>
                    <input type="hidden" name="contactperson_id" value=""/>
                    <input type="hidden" name="action" value=""/>

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
</div><?php }} ?>
