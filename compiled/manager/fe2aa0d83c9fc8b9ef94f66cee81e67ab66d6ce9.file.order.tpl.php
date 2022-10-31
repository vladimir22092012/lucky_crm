<?php /* Smarty version Smarty-3.1.18, created on 2022-10-31 09:19:34
         compiled from "/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/order.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2818875476343af9e6a2cf3-14201628%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fe2aa0d83c9fc8b9ef94f66cee81e67ab66d6ce9' => 
    array (
      0 => '/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/order.tpl',
      1 => 1667197171,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2818875476343af9e6a2cf3-14201628',
  'function' => 
  array (
    'penalty_button' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_6343af9e8b7543_39789197',
  'variables' => 
  array (
    'order' => 0,
    'settings' => 0,
    'manager' => 0,
    'contract' => 0,
    'ordertimer' => 0,
    'alert' => 0,
    'looker_link' => 0,
    'managers' => 0,
    'm' => 0,
    'amount_error' => 0,
    'er' => 0,
    'is_developer' => 0,
    'reject_reasons' => 0,
    'p2p' => 0,
    'have_newest_order' => 0,
    'comments' => 0,
    'penalties' => 0,
    'contactdata_error' => 0,
    'penalty_types' => 0,
    'contactdata_errors' => 0,
    'changelogs' => 0,
    'changelog' => 0,
    'contactdata_is_changed' => 0,
    'field' => 0,
    'old_value' => 0,
    'contacts_error' => 0,
    'addresses_error' => 0,
    'faktaddress' => 0,
    'regaddress' => 0,
    'work_error' => 0,
    'need_update_scorings' => 0,
    'scoring_types' => 0,
    'scoring_type' => 0,
    'scorings' => 0,
    'number_of_active' => 0,
    'recommended_amount' => 0,
    'efrsb_link' => 0,
    'audit_types' => 0,
    'services_error' => 0,
    'contract_insurance' => 0,
    'card_error' => 0,
    'cards' => 0,
    'dupl' => 0,
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
    'comments_1c' => 0,
    'documents' => 0,
    'document' => 0,
    'eventlogs' => 0,
    'eventlog' => 0,
    'events' => 0,
    'changelog_types' => 0,
    'new_value' => 0,
    'contract_operations' => 0,
    'operation' => 0,
    'orders' => 0,
    'o' => 0,
    'order_statuses' => 0,
    'client' => 0,
    'loan_history_item' => 0,
    'communications' => 0,
    'communication' => 0,
    'reject_reason' => 0,
    't' => 0,
    'sms_templates' => 0,
    'sms_template' => 0,
  ),
  'has_nocache_code' => 0,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6343af9e8b7543_39789197')) {function content_6343af9e8b7543_39789197($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/e/ecofinance/lucky_crm/public_html/Smarty/libs/plugins/modifier.date_format.php';
?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable("Заявка №".((string)$_smarty_tpl->tpl_vars['order']->value->order_id), null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_scripts', null, null); ob_start(); ?>

    <!--script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script-->
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/fancybox3/dist/jquery.fancybox.js"></script>
    <script type="text/javascript" src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/order.js?v=1.28"></script>
    <script type="text/javascript" src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/movements.app.js"></script>
    <script>
        $(function () {
            let phone_num = "<?php echo $_smarty_tpl->tpl_vars['order']->value->phone_mobile;?>
";
            let firstname = "<?php echo $_smarty_tpl->tpl_vars['order']->value->firstname;?>
";
            let lastname = "<?php echo $_smarty_tpl->tpl_vars['order']->value->lastname;?>
";
            let patronymic = "<?php echo $_smarty_tpl->tpl_vars['order']->value->patronymic;?>
";

            $.ajax({
                url: "ajax/BlacklistCheck.php",
                data: {
                    phone_num: phone_num,
                    firstname: firstname,
                    lastname: lastname,
                    patronymic: patronymic
                },
                method: 'POST',
                success: function (suc) {
                    if (suc == 1) {
                        $('.form-check-input').attr('checked', 'checked');
                    }
                }
            });

            $.ajax({
                url: "ajax/RfmCheck.php",
                data: {
                    phone_num: phone_num,
                    firstname: firstname,
                    lastname: lastname,
                    patronymic: patronymic
                },
                method: 'POST',
                success: function (suc) {
                    if (suc == 1) {
                        $('.form-check-input').attr('checked', 'checked');
                    }
                }
            });

            $(document).on('click', '.form-check-input', function () {
                $.post({
                    url: "ajax/BlacklistAddDelete.php",
                    data: {
                        phone_num: phone_num,
                        firstname: firstname,
                        lastname: lastname,
                        patronymic: patronymic
                    },
                })
            })
        })
    </script>
    <script>
        function show_changes() {
            var x = document.getElementById("myDIV");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
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
    <!--link href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/fancybox3/dist/jquery.fancybox.css?v=1.03" rel="stylesheet" /-->
    <style>
        .js-open-popup-image .label {
            position: absolute;
            bottom: 2px;
            left: 2px;
        }

        .js-fancybox-approve.btn-success {
            background: #55ce63;
            border: 1px solid #55ce63;
        }

        .js-fancybox-approve.btn-outline-success {
            color: #55ce63;
            background-color: transparent;
            border-color: #55ce63
        }

        .js-fancybox-reject.btn-danger {
            background: #f62d51;
            border: 1px solid #f62d51
        }

        .js-fancybox-reject.btn-outline-danger {
            color: #f62d51;
            background-color: transparent;
            border-color: #f62d51;
        }
    </style>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php if (!function_exists('smarty_template_function_penalty_button')) {
    function smarty_template_function_penalty_button($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->smarty->template_functions['penalty_button']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>

    <?php if (in_array('add_penalty',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
        
    <?php }?>
<?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;
foreach (Smarty::$global_tpl_vars as $key => $value) if(!isset($_smarty_tpl->tpl_vars[$key])) $_smarty_tpl->tpl_vars[$key] = $value;}}?>


<div class="page-wrapper js-event-add-load" data-event="1" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
" data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
     data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php if (in_array($_smarty_tpl->tpl_vars['contract']->value->status,array(2,4))&&!in_array('collectors',$_smarty_tpl->tpl_vars['manager']->value->permissions)&&$_smarty_tpl->tpl_vars['contract']->value->sold==1) {?>
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="text-themecolor mb-0 mt-0"><i class="mdi mdi-animation"></i> Заявка №<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>

                    </h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Главная</a></li>
                        <li class="breadcrumb-item"><a href="orders">Заявки</a></li>
                        <li class="breadcrumb-item active">Заявка №<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
</li>
                    </ol>
                </div>
            </div>
            <div class="row" id="order_wrapper">
                <div class="view-block" style="width: 300px;">
                    <h5>
                        <a href="client/<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
" title="Перейти в карточку клиента">
                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->lastname, ENT_QUOTES, 'UTF-8', true);?>

                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->firstname, ENT_QUOTES, 'UTF-8', true);?>

                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->patronymic, ENT_QUOTES, 'UTF-8', true);?>

                        </a>
                    </h5>
                    <h3>
                        <span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->phone_mobile, ENT_QUOTES, 'UTF-8', true);?>
</span>
                    </h3>
                    <h5>
                        <span>Договор: <?php echo $_smarty_tpl->tpl_vars['contract']->value->number;?>
</span><br><br>
                        <span>Дата заявки: <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['order']->value->date);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['order']->value->date);?>
</span>
                    </h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1">
                        <label class="form-check-label" for="flexCheckDefault">
                            Находится в ч/с
                        </label>
                    </div>
                </div>
                <div style="text-align: center; width: 30%; margin-left: 200px; background-color: rgba(255,0,0,0.6); border-radius: 6px;">
                    <h5 style="text-align: center; color: white; margin:50px">Право требования задолженности по договору
                        уступлено в ООО "Юридическая компания № 1"
                        Адрес 443093, г. Самара, ул. Мориса Тореза, д. 1А, офис 513 , тел.8-800-222-76-69</h5>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="container-fluid">

            <div class="row page-titles">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="text-themecolor mb-0 mt-0"><i class="mdi mdi-animation"></i> Заявка №<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>

                    </h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Главная</a></li>
                        <li class="breadcrumb-item"><a href="orders">Заявки</a></li>
                        <li class="breadcrumb-item active">Заявка №<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
</li>
                    </ol>
                </div>
                <div class="col-md-6 col-4 align-self-center">
                    <h1 class="text-right p-1" id="ordertimer">
                        <?php if ($_smarty_tpl->tpl_vars['ordertimer']->value->last_time) {?>
                            <div class="text-primary js-ordertimer text-center float-right" style="width:150px"
                                 data-time="<?php echo $_smarty_tpl->tpl_vars['ordertimer']->value->last_time;?>
"></div>
                        <?php }?>
                    </h1>
                </div>
            </div>

            <?php if ($_smarty_tpl->tpl_vars['alert']->value) {?>
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-danger text-center">
                            Внимание!<br/>
                            У данного клиента зафиксирована задублированная оплата<br/>
                            Не производите никаких действий до решения проблемы!<br/>
                            Ориентировочное время решения 20:00 МСК
                        </h1>
                    </div>
                </div>
            <?php }?>

            <div class="row" id="order_wrapper">
                <div class="col-lg-12">
                    <div class="card card-outline-info">

                        <div class="card-body">

                            <div class="form-body">
                                <div class="row">
                                    <div class="col-4 col-md-3 col-lg-2">
                                        <h4 class="form-control-static">
                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->client_status) {?>
                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->client_status=='pk') {?>
                                                    <span class="label label-success"
                                                          title="Клиент уже имеет погашенные займы">ПК</span>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->client_status=='crm') {?>
                                                    <span class="label label-primary"
                                                          title="Клиент уже имеет погашенные займы в CRM">ПК CRM</span>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->client_status=='rep') {?>
                                                    <span class="label label-warning"
                                                          title="Клиент уже подавал ранее заявки">Повтор</span>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->client_status=='nk') {?>
                                                    <span class="label label-info" title="Новый клиент">Новая</span>
                                                <?php }?>
                                            <?php } else { ?>
                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->have_crm_closed) {?>
                                                    <span class="label label-primary"
                                                          title="Клиент уже имеет погашенные займы в CRM">ПК CRM</span>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['order']->value->first_loan) {?>
                                                    <span class="label label-info" title="Новый клиент">Новая</span>
                                                <?php } else { ?>
                                                    <span class="label label-success"
                                                          title="Клиент уже имеет погашенные займы">ПК</span>
                                                <?php }?>
                                            <?php }?>
                                        </h4>
                                    </div>
                                    <div class="col-8 col-md-3 col-lg-3">
                                        <h5 class="form-control-static float-left">
                                            дата заявки: <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['order']->value->date);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['order']->value->date);?>

                                        </h5>
                                        <?php if ($_smarty_tpl->tpl_vars['order']->value->penalty_date) {?>
                                            <h5 class="form-control-static float-left">
                                                дата решения: <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['order']->value->penalty_date);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['order']->value->penalty_date);?>

                                            </h5>
                                        <?php }?>
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-2 ">
                                        <h5 class="form-control-static">
                                            Источник:
                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->utm_source) {?>
                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->utm_source, ENT_QUOTES, 'UTF-8', true);?>
 <?php if (!empty($_smarty_tpl->tpl_vars['order']->value->webmaster_id)) {?>(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->webmaster_id, ENT_QUOTES, 'UTF-8', true);?>
)<?php }?>
                                            <?php } else { ?>
                                                не определен
                                            <?php }?>
                                        </h5>
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-2 ">
                                        <?php if ($_smarty_tpl->tpl_vars['looker_link']->value&&!$_smarty_tpl->tpl_vars['order']->value->offline) {?>
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['looker_link']->value;?>
" target="_blank" class="btn btn-info float-right"><i
                                                        class=" fas fa-address-book"></i> Смотреть ЛК</a>
                                        <?php }?>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3 ">
                                        <h5 class="js-order-manager text-right">
                                            <?php if (in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('developer','admin','big_user'))) {?>
                                                <select class="js-order-manager form-control"
                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" name="manager_id">
                                                    <option value="0" <?php if (!$_smarty_tpl->tpl_vars['order']->value->manager_id) {?>selected="selected"<?php }?>>
                                                        Не принята
                                                    </option>
                                                    <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['managers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value) {
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
"
                                                                <?php if ($_smarty_tpl->tpl_vars['m']->value->id==$_smarty_tpl->tpl_vars['order']->value->manager_id) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['m']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                    <?php } ?>
                                                </select>
                                            <?php } else { ?>
                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->manager_id) {?>
                                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['managers']->value[$_smarty_tpl->tpl_vars['order']->value->manager_id]->name, ENT_QUOTES, 'UTF-8', true);?>

                                                <?php }?>
                                            <?php }?>
                                        </h5>
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-12 col-md-4 col-lg-3">
                                        <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
" class="js-order-item-form " id="fio_form">

                                            <input type="hidden" name="action" value="fio"/>
                                            <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                                            <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"/>

                                            <div class="border p-2 view-block">
                                                <h5>
                                                    <a href="client/<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                       title="Перейти в карточку клиента">
                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->lastname, ENT_QUOTES, 'UTF-8', true);?>

                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->firstname, ENT_QUOTES, 'UTF-8', true);?>

                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->patronymic, ENT_QUOTES, 'UTF-8', true);?>

                                                    </a>
                                                </h5>
                                                <h3>
                                                    <span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->phone_mobile, ENT_QUOTES, 'UTF-8', true);?>
</span>
                                                    <button class="js-mango-call mango-call js-event-add-click"
                                                            data-phone="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->phone_mobile, ENT_QUOTES, 'UTF-8', true);?>
"
                                                            title="Выполнить звонок" data-event="60"
                                                            data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                            data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                            data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
">
                                                        <i class="fas fa-mobile-alt"></i>
                                                    </button>
                                                    <button class="js-open-sms-modal mango-call <?php if ($_smarty_tpl->tpl_vars['order']->value->contract->sold) {?>js-yuk<?php }?>"
                                                            data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                            data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
">
                                                        <i class=" far fa-share-square"></i>
                                                    </button>
                                                </h3>
                                                <a href="javascript:void(0);"
                                                   class="text-info js-edit-form edit-amount js-event-add-click"
                                                   data-event="30" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                   data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                            class=" fas fa-edit"></i></a>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Находится в ч/с
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="edit-block hide">
                                                <div class="form-group mb-1">
                                                    <input type="text" name="lastname" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->lastname, ENT_QUOTES, 'UTF-8', true);?>
"
                                                           class="form-control" placeholder="Фамилия"/>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input type="text" name="firstname"
                                                           value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->firstname, ENT_QUOTES, 'UTF-8', true);?>
" class="form-control"
                                                           placeholder="Имя"/>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input type="text" name="patronymic"
                                                           value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->patronymic, ENT_QUOTES, 'UTF-8', true);?>
" class="form-control"
                                                           placeholder="Отчество"/>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input type="text" name="phone_mobile"
                                                           value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->phone_mobile, ENT_QUOTES, 'UTF-8', true);?>
" class="form-control"
                                                           placeholder="Телефон"/>
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-success js-event-add-click"
                                                            data-event="40" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                            data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                            data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i class="fa fa-check"></i>
                                                        Сохранить
                                                    </button>
                                                    <button type="button" class="btn btn-inverse js-cancel-edit">
                                                        Отмена
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="col-12 col-md-8 col-lg-6">
                                        <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
" class="mb-3 p-2 border js-order-item-form js-check-amount"
                                              id="amount_form">

                                            <input type="hidden" name="action" value="amount"/>
                                            <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                                            <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"/>
                                            <?php if ($_smarty_tpl->tpl_vars['amount_error']->value) {?>
                                                <div class="text-danger pt-3">
                                                    <ul>
                                                        <?php  $_smarty_tpl->tpl_vars['er'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['er']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['amount_error']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['er']->key => $_smarty_tpl->tpl_vars['er']->value) {
$_smarty_tpl->tpl_vars['er']->_loop = true;
?>
                                                            <li><?php echo $_smarty_tpl->tpl_vars['er']->value;?>
</li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            <?php }?>
                                            <div class="row view-block ">
                                                <div class="col-6 text-center">
                                                    <h5>Сумма</h5>
                                                    <h3 class="text-primary"><?php echo $_smarty_tpl->tpl_vars['order']->value->amount;?>
 руб</h3>
                                                </div>
                                                <div class="col-6 text-center">
                                                    <h5>Срок</h5>
                                                    <h3 class="text-primary"><?php echo $_smarty_tpl->tpl_vars['order']->value->period;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->tpl_vars['order']->value->period,"день","дней","дня");?>
</h3>
                                                </div>
                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->antirazgon_amount) {?>
                                                    <div class="col-12 text-center">
                                                        <h4 class="text-danger">Максимальная
                                                            сумма: <?php echo $_smarty_tpl->tpl_vars['order']->value->antirazgon_amount;?>
 руб</h4>
                                                    </div>
                                                <?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->status<=2||in_array($_smarty_tpl->tpl_vars['manager']->value->role,array('admin','developer'))) {?>
                                                    <a href="javascript:void(0);"
                                                       class="text-info js-edit-form edit-amount js-event-add-click"
                                                       data-event="31" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                       data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                class=" fas fa-edit"></i></a>
                                                    </h3>
                                                <?php }?>
                                            </div>

                                            <div class="row edit-block hide">
                                                <div class="col-6 col-md-3 text-center">
                                                    <h5>Сумма</h5>
                                                    <input type="text" class="form-control" name="amount"
                                                           value="<?php echo $_smarty_tpl->tpl_vars['order']->value->amount;?>
"/>
                                                </div>
                                                <div class="col-6 col-md-3 text-center">
                                                    <h5>Период</h5>
                                                    <input type="text" class="form-control" name="period"
                                                           value="<?php echo $_smarty_tpl->tpl_vars['order']->value->period;?>
"/>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-actions">
                                                        <h5>&nbsp;</h5>
                                                        <button type="submit" class="btn btn-success js-event-add-click"
                                                                data-event="41" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                    class="fa fa-check"></i> Сохранить
                                                        </button>
                                                        <button type="button" class="btn btn-inverse js-cancel-edit">
                                                            Отмена
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <?php if (!$_smarty_tpl->tpl_vars['order']->value->manager_id&&$_smarty_tpl->tpl_vars['order']->value->status==0) {?>
                                            <div class="pt-3 js-accept-order-block">
                                                <button class="btn btn-info btn-lg btn-block js-accept-order js-event-add-click"
                                                        data-event="10" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
">
                                                    <i class="fas fa-hospital-symbol"></i>
                                                    <span>Принять</span>
                                                </button>
                                            </div>
                                        <?php }?>

                                        <?php if ($_smarty_tpl->tpl_vars['order']->value->status==1&&$_smarty_tpl->tpl_vars['order']->value->manager_id!=$_smarty_tpl->tpl_vars['manager']->value->id) {?>
                                            <div class="pt-1 pb-2 js-accept-order-block">
                                                <button class="btn btn-info btn-block js-accept-order js-event-add-click"
                                                        data-event="11" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">
                                                    <i class="fas fa-hospital-symbol"></i>
                                                    <span>Перепринять</span>
                                                </button>
                                            </div>
                                        <?php }?>

                                        <?php if ($_smarty_tpl->tpl_vars['order']->value->status==1) {?>
                                            <div class="js-approve-reject-block <?php if (!$_smarty_tpl->tpl_vars['order']->value->manager_id) {?>hide<?php }?>">
                                                <button class="btn btn-success btn-block js-approve-order js-event-add-click"
                                                        data-event="12" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Одобрить</span>
                                                </button>
                                                <button class="btn btn-danger btn-block js-reject-order js-event-add-click"
                                                        data-event="13" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">
                                                    <i class="fas fa-times-circle"></i>
                                                    <span>Отказать</span>
                                                </button>
                                            </div>
                                        <?php }?>

                                        <div class="js-order-status">
                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->status==2) {?>
                                                <div class="card card-success mb-1">
                                                    <div class="box text-center">
                                                        <h3 class="text-white mb-0">Одобрена</h3>
                                                    </div>
                                                </div>
                                                <button class="btn btn-danger btn-block js-reject-order js-event-add-click"
                                                        data-event="13" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">
                                                    <i class="fas fa-times-circle"></i>
                                                    <span>Отказать</span>
                                                </button>
                                                <form class=" pt-1 js-confirm-contract">
                                                    <div class="input-group">
                                                        <input type="hidden" name="contract_id" class="js-contract-id"
                                                               value="<?php echo $_smarty_tpl->tpl_vars['order']->value->contract_id;?>
"/>
                                                        <input type="hidden" name="phone" class="js-contract-phone"
                                                               value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->phone_mobile, ENT_QUOTES, 'UTF-8', true);?>
"/>
                                                        <input type="text" class="form-control js-contract-code"
                                                               placeholder="SMS код"
                                                               value="<?php if ($_smarty_tpl->tpl_vars['is_developer']->value) {?><?php echo $_smarty_tpl->tpl_vars['contract']->value->accept_code;?>
<?php }?>"/>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-info js-event-add-click"
                                                                    type="submit" data-event="14"
                                                                    data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                                    data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                    data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">Подтвердить
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <a href="javascript:void(0);" class="js-sms-send"
                                                       data-contract="<?php echo $_smarty_tpl->tpl_vars['order']->value->contract_id;?>
">
                                                        <span>Отправить смс код</span>
                                                        <span class="js-sms-timer"></span>
                                                    </a>
                                                </form>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->status==3) {?>
                                                <div class="card card-danger">
                                                    <div class="box text-center">
                                                        <h3 class="text-white">Отказ</h3>
                                                        <small title="Причина отказа">
                                                            <i><?php echo $_smarty_tpl->tpl_vars['reject_reasons']->value[$_smarty_tpl->tpl_vars['order']->value->reason_id]->admin_name;?>
</i>
                                                        </small>
                                                        <?php if ($_smarty_tpl->tpl_vars['order']->value->antirazgon_date) {?>
                                                            <br/>
                                                            <strong class="text-white">
                                                                <small>Мараторий
                                                                    до <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['order']->value->antirazgon_date);?>
</small>
                                                            </strong>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->status==4) {?>
                                                <div class="card card-primary">
                                                    <div class="box text-center">
                                                        <h3 class="text-white">Подписан</h3>
                                                        <h6>Договор <?php echo $_smarty_tpl->tpl_vars['contract']->value->number;?>
</h6>
                                                    </div>
                                                </div>
                                                <?php if ($_smarty_tpl->tpl_vars['contract']->value->status!=9) {?>
                                                    <button class="btn btn-danger btn-block js-reject-order js-event-add-click"
                                                            data-event="13" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                            data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                            data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">
                                                        <i class="fas fa-times-circle"></i>
                                                        <span>Отказать</span>
                                                    </button>
                                                <?php }?>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->status==5) {?>
                                                <?php if ($_smarty_tpl->tpl_vars['contract']->value->status==4) {?>
                                                    <div class="card card-danger mb-1">
                                                        <div class="box text-center">
                                                            <h3 class="text-white">Просрочен</h3>
                                                            <h6>Договор <?php echo $_smarty_tpl->tpl_vars['contract']->value->number;?>
</h6>
                                                            <h6 class="text-center text-white">
                                                                Погашение: <?php echo $_smarty_tpl->tpl_vars['contract']->value->loan_body_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_percents_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_charge_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_peni_summ;?>

                                                                руб
                                                            </h6>
                                                            <h6 class="text-center text-white">
                                                                Продление:
                                                                <?php if ($_smarty_tpl->tpl_vars['contract']->value->prolongation>0&&!$_smarty_tpl->tpl_vars['contract']->value->sold) {?>
                                                                    <?php echo $_smarty_tpl->tpl_vars['settings']->value->prolongation_amount+$_smarty_tpl->tpl_vars['contract']->value->loan_percents_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_charge_summ;?>
 руб
                                                                <?php } else { ?>
                                                                    <?php echo $_smarty_tpl->tpl_vars['contract']->value->loan_percents_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_charge_summ;?>
 руб
                                                                <?php }?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['contract']->value->status==10) {?>
                                                    <div class="card card-danger mb-1">
                                                        <div class="box text-center">
                                                            <h3 class="text-white">Суд 1С</h3>
                                                            <h6>Договор <?php echo $_smarty_tpl->tpl_vars['contract']->value->number;?>
</h6>
                                                            <h6 class="text-center text-white">
                                                                Погашение: <?php echo $_smarty_tpl->tpl_vars['contract']->value->loan_body_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_percents_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_charge_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_peni_summ;?>

                                                                руб
                                                            </h6>
                                                            <h6 class="text-center text-white">
                                                                Продление:
                                                                <?php if ($_smarty_tpl->tpl_vars['contract']->value->prolongation>0) {?>
                                                                    <?php echo $_smarty_tpl->tpl_vars['settings']->value->prolongation_amount+$_smarty_tpl->tpl_vars['contract']->value->loan_percents_summ;?>
 руб
                                                                <?php } else { ?>
                                                                    <?php echo $_smarty_tpl->tpl_vars['contract']->value->loan_percents_summ;?>
 руб
                                                                <?php }?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="card card-primary mb-1">
                                                        <div class="box text-center">
                                                            <h3 class="text-white">Выдан</h3>
                                                            <h6>Договор <?php echo $_smarty_tpl->tpl_vars['contract']->value->number;?>
</h6>
                                                            <h6 class="text-center text-white">
                                                                Погашение: <?php echo $_smarty_tpl->tpl_vars['contract']->value->loan_body_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_percents_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_charge_summ+$_smarty_tpl->tpl_vars['contract']->value->loan_peni_summ;?>

                                                                руб
                                                            </h6>
                                                            <h6 class="text-center text-white">
                                                                Продление:
                                                                <?php if ($_smarty_tpl->tpl_vars['contract']->value->prolongation>0) {?>
                                                                    <?php echo $_smarty_tpl->tpl_vars['settings']->value->prolongation_amount+$_smarty_tpl->tpl_vars['contract']->value->loan_percents_summ;?>
 руб
                                                                <?php } else { ?>
                                                                    <?php echo $_smarty_tpl->tpl_vars['contract']->value->loan_percents_summ;?>
 руб
                                                                <?php }?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if (in_array('close_contract',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                                                    <button class="btn btn-danger btn-block js-open-close-form js-event-add-click"
                                                            data-event="15" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                            data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                            data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">Закрыть договор
                                                    </button>
                                                <?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['is_developer']->value) {?>
                                                    <button class="btn btn-info btn-block js-open-correct-form "
                                                            data-event="15" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                            data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                            data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">Корректировка
                                                    </button>
                                                <?php }?>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->status==6) {?>
                                                <div class="card card-danger mb-1">
                                                    <div class="box text-center">
                                                        <h3 class="text-white">Не удалось выдать</h3>
                                                        <h6>Договор <?php echo $_smarty_tpl->tpl_vars['contract']->value->number;?>
</h6>
                                                        <?php if ($_smarty_tpl->tpl_vars['p2p']->value->response_xml) {?>
                                                            <?php if ($_smarty_tpl->tpl_vars['p2p']->value->response_xml->message) {?>
                                                                <i>
                                                                    <small>B2P: <?php echo $_smarty_tpl->tpl_vars['p2p']->value->response_xml->message;?>
</small>
                                                                </i>
                                                            <?php } elseif ($_smarty_tpl->tpl_vars['p2p']->value->response_xml->description) {?>
                                                                <i>
                                                                    <small>
                                                                        B2P: <?php echo $_smarty_tpl->tpl_vars['p2p']->value->response_xml->description;?>
</small>
                                                                </i>
                                                            <?php }?>
                                                        <?php } else { ?>
                                                            <i>
                                                                <small>Нет ответа от B2P. <br/>Если повторить выдачу,
                                                                    это может привести к двойной выдаче!
                                                                </small>
                                                            </i>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <?php if ($_smarty_tpl->tpl_vars['have_newest_order']->value) {?>
                                                    <div class="text-center">
                                                        <a href="order/<?php echo $_smarty_tpl->tpl_vars['have_newest_order']->value;?>
"><strong
                                                                    class="text-danger text-center">У клиента есть новая
                                                                заявка</strong></a>
                                                    </div>
                                                <?php } else { ?>
                                                    <?php if (in_array('repay_button',$_smarty_tpl->tpl_vars['manager']->value->permissions)) {?>
                                                        <button type="button"
                                                                class="btn btn-primary btn-block js-repay-contract js-event-add-click"
                                                                data-event="16" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                                data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                data-contract="<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
">Повторить выдачу
                                                        </button>
                                                    <?php }?>
                                                <?php }?>
                                            <?php }?>

                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->status==7) {?>
                                                <div class="card card-primary">
                                                    <div class="box text-center">
                                                        <h3 class="text-white">Погашен</h3>
                                                        <h6>Договор #<?php echo $_smarty_tpl->tpl_vars['contract']->value->number;?>
</h6>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->status==8) {?>
                                                <div class="card card-danger">
                                                    <div class="box text-center">
                                                        <h3 class="text-white">Отказ клиента</h3>
                                                        <small title="Причина отказа">
                                                            <i><?php echo $_smarty_tpl->tpl_vars['reject_reasons']->value[$_smarty_tpl->tpl_vars['order']->value->reason_id]->admin_name;?>
</i>
                                                        </small>
                                                    </div>
                                                </div>
                                            <?php }?>

                                            <?php if ($_smarty_tpl->tpl_vars['contract']->value->status==9) {?>
                                                <div class="card border border-danger">
                                                    <div class="box text-center">
                                                        <h3 class="text-danger">Ошибка выдачи</h3>
                                                        <button class="btn btn-outline-warning js-cancel-contract"
                                                                data-contract="<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
" type="button">Отменить
                                                            заявку
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php }?>

                                            <?php if ($_smarty_tpl->tpl_vars['contract']->value->accept_code) {?>
                                                <h4 class="text-danger mb-0">АСП: <?php echo $_smarty_tpl->tpl_vars['contract']->value->accept_code;?>
</h4>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <ul class="mt-2 nav nav-tabs" role="tablist" id="order_tabs">
                                <li class="nav-item">
                                    <a class="nav-link active js-event-add-click" data-toggle="tab" href="#info"
                                       role="tab" aria-selected="false" data-event="20" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                       data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">
                                        <span class="hidden-sm-up"><i class="ti-home"></i></span>
                                        <span class="hidden-xs-down">Персональная информация</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-event-add-click" data-toggle="tab" href="#comments" role="tab"
                                       aria-selected="false" data-event="21" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                       data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">
                                        <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                        <span class="hidden-xs-down">
                                            Комментарии <?php if (count($_smarty_tpl->tpl_vars['comments']->value)>0) {?><span
                                                    class="label label-rounded label-primary"><?php echo count($_smarty_tpl->tpl_vars['comments']->value);?>
</span><?php }?>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-event-add-click" data-toggle="tab" href="#documents"
                                       role="tab" aria-selected="true" data-event="22" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                       data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">
                                        <span class="hidden-sm-up"><i class="ti-layers"></i></span>
                                        <span class="hidden-xs-down">Документы</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-event-add-click" data-toggle="tab" href="#logs" role="tab"
                                       aria-selected="true" data-event="23" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                       data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">
                                        <span class="hidden-sm-up"><i class="ti-server"></i></span>
                                        <span class="hidden-xs-down">Логирование</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-event-add-click" data-toggle="tab" href="#operations"
                                       role="tab" aria-selected="true" data-event="24" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                       data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">
                                        <span class="hidden-sm-up"><i class="ti-list-ol"></i></span>
                                        <span class="hidden-xs-down">Операции</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-event-add-click" data-toggle="tab" href="#history" role="tab"
                                       aria-selected="true" data-event="25" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                       data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">
                                        <span class="hidden-sm-up"><i class="ti-save-alt"></i></span>
                                        <span class="hidden-xs-down">Кредитная история</span>
                                    </a>
                                </li>
                                <li class="nav-item js-event-add-click">
                                    <a class="nav-link" data-toggle="tab" href="#connexions" role="tab"
                                       aria-selected="true" data-event="25" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                       data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">
                                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                        <span class="hidden-xs-down">Связанные лица</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-event-add-click" data-toggle="tab" href="#communications"
                                       role="tab" aria-selected="true" data-event="25" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                       data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
">
                                        <span class="hidden-sm-up"><i class="ti-mobile"></i></span>
                                        <span class="hidden-xs-down">Коммуникации</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content tabcontent-border" id="order_tabs_content">
                                <div class="tab-pane active" id="info" role="tabpanel">
                                    <div class="form-body p-2 pt-3">

                                        <div class="row">
                                            <div class="col-md-8 ">

                                                <!-- Контакты -->
                                                <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
"
                                                      class="mb-3 border js-order-item-form <?php if ($_smarty_tpl->tpl_vars['penalties']->value['personal']&&$_smarty_tpl->tpl_vars['penalties']->value['personal']->status!=3) {?>card-outline-danger<?php }?>"
                                                      id="personal_data_form">

                                                    <input type="hidden" name="action" value="contactdata"/>
                                                    <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                                                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"/>

                                                    <h5 class="card-header card-success">
                                                        <span class="text-white ">Контакты</span>
                                                        <span class="float-right"> 
                                                            <?php smarty_template_function_penalty_button($_smarty_tpl,array('penalty_block'=>'personal'));?>

                                                            <a href="javascript:void(0);"
                                                               class=" text-white js-edit-form js-event-add-click"
                                                               data-event="32" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                               data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                               data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                        class=" fas fa-edit"></i></a></h3>
                                                        </span>
                                                    </h5>

                                                    <div class="row pt-2 view-block <?php if ($_smarty_tpl->tpl_vars['contactdata_error']->value) {?>hide<?php }?>">

                                                        <?php if ($_smarty_tpl->tpl_vars['penalties']->value['personal']&&(in_array($_smarty_tpl->tpl_vars['manager']->value->permissions,array('add_penalty'))||$_smarty_tpl->tpl_vars['penalties']->value['personal']->manager_id==$_smarty_tpl->tpl_vars['manager']->value->id)) {?>
                                                            <div class="col-md-12">
                                                                <div class="alert alert-danger m-2">
                                                                    <h5 class="text-danger mb-1"><?php echo $_smarty_tpl->tpl_vars['penalty_types']->value[$_smarty_tpl->tpl_vars['penalties']->value['personal']->id]->name;?>
</h5>
                                                                    <small><?php echo $_smarty_tpl->tpl_vars['penalties']->value['personal']->comment;?>
</small>
                                                                </div>
                                                            </div>
                                                        <?php }?>

                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Email:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->email, ENT_QUOTES, 'UTF-8', true);?>
</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Дата
                                                                    рождения:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">
                                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->birth, ENT_QUOTES, 'UTF-8', true);?>

                                                                        <small class="label label-primary"><?php echo $_smarty_tpl->tpl_vars['order']->value->age;?>
</small>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Место
                                                                    рождения:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->birth_place, ENT_QUOTES, 'UTF-8', true);?>
</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Паспорт:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->passport_serial, ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->subdivision_code, ENT_QUOTES, 'UTF-8', true);?>

                                                                        , от <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->passport_date, ENT_QUOTES, 'UTF-8', true);?>
</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Кем выдан:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->passport_issued, ENT_QUOTES, 'UTF-8', true);?>
</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Соцсети:</label>
                                                                <div class="col-md-8">
                                                                    <ul class="list-unstyled form-control-static pl-0">
                                                                        <?php if ($_smarty_tpl->tpl_vars['order']->value->social) {?>
                                                                            <li>
                                                                                <a target="_blank"
                                                                                   href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->social, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->social, ENT_QUOTES, 'UTF-8', true);?>
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
                                                                    <?php if (in_array('empty_email',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>
                                                                        <li>Укажите Email!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_birth',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>
                                                                        <li>Укажите Дату рождения!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_passport_serial',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>
                                                                        <li>Укажите серию и номер паспорта!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_passport_date',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>
                                                                        <li>Укажите дату выдачи паспорта!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_subdivision_code',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>
                                                                        <li>Укажите код подразделения выдавшего
                                                                            паспорт!
                                                                        </li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_passport_issued',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>
                                                                        <li>Укажите кем выдан паспорт!</li>
                                                                    <?php }?>
                                                                </ul>
                                                            </div>
                                                        <?php }?>

                                                        <div class="col-md-6">
                                                            <div class="form-group mb-1 <?php if (in_array('empty_email',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Email</label>
                                                                <input type="text" name="email"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->email, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       class="form-control" placeholder=""/>
                                                                <?php if (in_array('empty_email',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите
                                                                        Email!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-1 <?php if (in_array('empty_birth',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Дата рождения</label>
                                                                <input type="text" name="birth"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->birth, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       class="form-control" placeholder=""
                                                                       required="true"/>
                                                                <?php if (in_array('empty_birth',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите дату
                                                                        рождения!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-2">
                                                                <label class="control-label">Соцсети</label>
                                                                <input type="text" class="form-control" name="social"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->social, ENT_QUOTES, 'UTF-8', true);?>
" placeholder=""/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-2 <?php if (in_array('empty_birth_place',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Место рождения</label>
                                                                <input type="text" name="birth_place"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->birth_place, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       class="form-control" placeholder=""
                                                                       required="true"/>
                                                                <?php if (in_array('empty_birth_place',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите место
                                                                        рождения!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <div class="form-group mb-1 <?php if (in_array('empty_passport_serial',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Серия и номер
                                                                    паспорта</label>
                                                                <input type="text" class="form-control"
                                                                       name="passport_serial"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->passport_serial, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder="" required="true"/>
                                                                <?php if (in_array('empty_passport_serial',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите серию и
                                                                        номер паспорта!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-1 <?php if (in_array('empty_passport_date',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Дата выдачи</label>
                                                                <input type="text" class="form-control"
                                                                       name="passport_date"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->passport_date, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder="" required="true"/>
                                                                <?php if (in_array('empty_passport_date',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите дату
                                                                        выдачи паспорта!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-1 <?php if (in_array('empty_subdivision_code',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Код подразделения</label>
                                                                <input type="text" class="form-control"
                                                                       name="subdivision_code"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->subdivision_code, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder="" required="true"/>
                                                                <?php if (in_array('empty_subdivision_code',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите код
                                                                        подразделения выдавшего паспорт!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group <?php if (in_array('empty_passport_issued',(array)$_smarty_tpl->tpl_vars['contactdata_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Кем выдан</label>
                                                                <input type="text" class="form-control"
                                                                       name="passport_issued"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->passport_issued, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder="" required="true"/>
                                                                <?php if (in_array('empty_passport_issued',(array)$_smarty_tpl->tpl_vars['contactdata_errors']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите кем
                                                                        выдан паспорт!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-12">
                                                            <div class="form-actions">
                                                                <button type="submit"
                                                                        class="btn btn-success js-event-add-click"
                                                                        data-event="42" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                        data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                            class="fa fa-check"></i> Сохранить
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-inverse js-cancel-edit">Отмена
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- / Контакты-->

                                                <!-- Старые контакты-->
                                                <?php if ($_smarty_tpl->tpl_vars['changelogs']->value) {?>

                                                    <?php  $_smarty_tpl->tpl_vars['changelog'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['changelog']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['changelogs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['changelog']->key => $_smarty_tpl->tpl_vars['changelog']->value) {
$_smarty_tpl->tpl_vars['changelog']->_loop = true;
?>
                                                        <?php if ($_smarty_tpl->tpl_vars['changelog']->value->type=='contactdata') {?>
                                                            <?php $_smarty_tpl->tpl_vars["contactdata_is_changed"] = new Smarty_variable("1", null, 0);?>
                                                        <?php }?>
                                                    <?php } ?>
                                                    <?php if ($_smarty_tpl->tpl_vars['contactdata_is_changed']->value) {?>
                                                        <div class="mb-3 border">
                                                            <h5 class="card-header card-success"
                                                                onclick="show_changes()">
                                                                <span class="text-white ">Посмотреть предыдущие паспортные данные</span>
                                                            </h5>
                                                            <div id="myDIV" style="display:none">
                                                                <?php  $_smarty_tpl->tpl_vars['changelog'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['changelog']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['changelogs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['changelog']->key => $_smarty_tpl->tpl_vars['changelog']->value) {
$_smarty_tpl->tpl_vars['changelog']->_loop = true;
?>
                                                                    <?php if ($_smarty_tpl->tpl_vars['changelog']->value->type=='contactdata') {?>
                                                                        <div class="row pt-2 view-block <?php if ($_smarty_tpl->tpl_vars['contactdata_error']->value) {?>hide<?php }?>">
                                                                            <div class="col-md-12">
                                                                                <label class="control-label col-md-4"><span><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['changelog']->value->created);?>
</span></label>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group row m-0">

                                                                                    <?php  $_smarty_tpl->tpl_vars['old_value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['old_value']->_loop = false;
 $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['changelog']->value->old_values; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['old_value']->key => $_smarty_tpl->tpl_vars['old_value']->value) {
$_smarty_tpl->tpl_vars['old_value']->_loop = true;
 $_smarty_tpl->tpl_vars['field']->value = $_smarty_tpl->tpl_vars['old_value']->key;
?>
                                                                                        <?php if (($_smarty_tpl->tpl_vars['field']->value=='passport_date'||$_smarty_tpl->tpl_vars['field']->value=='subdivision_code'||$_smarty_tpl->tpl_vars['field']->value=='passport_serial')) {?>
                                                                                            <label class="control-label col-md-4">Паспорт:</label>
                                                                                            <div class="col-md-8">
                                                                                                <p class="form-control-static">
                                                                                                    <?php if ($_smarty_tpl->tpl_vars['field']->value=='passport_serial') {?>  <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['old_value']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->passport_serial, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
                                                                                                    <?php if ($_smarty_tpl->tpl_vars['field']->value=='subdivision_code') {?> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['old_value']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->subdivision_code, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
                                                                                                    , от
                                                                                                    <?php if ($_smarty_tpl->tpl_vars['field']->value=='passport_date') {?>    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['old_value']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->passport_date, ENT_QUOTES, 'UTF-8', true);?>
<?php }?></p>
                                                                                            </div>
                                                                                        <?php }?>

                                                                                    <?php } ?>

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group row m-0">

                                                                                    <?php  $_smarty_tpl->tpl_vars['old_value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['old_value']->_loop = false;
 $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['changelog']->value->old_values; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['old_value']->key => $_smarty_tpl->tpl_vars['old_value']->value) {
$_smarty_tpl->tpl_vars['old_value']->_loop = true;
 $_smarty_tpl->tpl_vars['field']->value = $_smarty_tpl->tpl_vars['old_value']->key;
?>

                                                                                        <?php if ($_smarty_tpl->tpl_vars['field']->value=='passport_issued') {?>
                                                                                            <label class="control-label col-md-4">Кем
                                                                                                выдан:</label>
                                                                                            <div class="col-md-8">
                                                                                                <p class="form-control-static"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['old_value']->value, ENT_QUOTES, 'UTF-8', true);?>
</p>
                                                                                            </div>
                                                                                        <?php }?>
                                                                                    <?php } ?>

                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    <?php }?>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="row p-2 edit-block <?php if (!$_smarty_tpl->tpl_vars['contactdata_error']->value) {?>hide<?php }?>">
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                <?php }?>
                                                <!-- / Старые контакты-->

                                                <!-- /Контактные лица -->
                                                <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
"
                                                      class="js-order-item-form mb-3 border <?php if ($_smarty_tpl->tpl_vars['penalties']->value['contactpersons']&&$_smarty_tpl->tpl_vars['penalties']->value['contactpersons']->status!=3) {?>card-outline-danger<?php }?>"
                                                      id="contact_persons_form">

                                                    <input type="hidden" name="action" value="contacts"/>
                                                    <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                                                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"/>

                                                    <h5 class="card-header">
                                                        <span class="text-white">Контактные лица</span>
                                                        <span class="float-right">

                                                            <?php smarty_template_function_penalty_button($_smarty_tpl,array('penalty_block'=>'contactpersons'));?>

                                                            <a href="javascript:void(0);"
                                                               class="text-white js-edit-form js-event-add-click"
                                                               data-event="33" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                               data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                               data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                        class=" fas fa-edit"></i></a></h3>
                                                        </span>
                                                    </h5>

                                                    <div class="row view-block m-0 <?php if ($_smarty_tpl->tpl_vars['contacts_error']->value) {?>hide<?php }?>">
                                                        <table class="table table-hover mb-0">
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->contact_person_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->contact_person_relation, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                                                <td class="text-right"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->contact_person_phone, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                                                <td>
                                                                    <button class="js-mango-call mango-call js-event-add-click"
                                                                            data-phone="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->contact_person_phone, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                            title="Выполнить звонок" data-event="61"
                                                                            data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                            data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                            data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
">
                                                                        <i class="fas fa-mobile-alt"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->contact_person2_name, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                                                <td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->contact_person2_relation, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                                                <td class="text-right"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->contact_person2_phone, ENT_QUOTES, 'UTF-8', true);?>
</td>
                                                                <td>
                                                                    <button class="js-mango-call mango-call js-event-add-click"
                                                                            data-event="61"
                                                                            data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                            data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                            data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                                            data-phone="<?php echo $_smarty_tpl->tpl_vars['order']->value->contact_person2_phone;?>
"
                                                                            title="Выполнить звонок">
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
                                                                    <?php if (in_array('empty_contact_person_name',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>
                                                                        <li>Укажите ФИО контакного лица!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_contact_person_phone',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>
                                                                        <li>Укажите тел. контакного лица!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_contact_person2_name',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>
                                                                        <li>Укажите ФИО контакного лица 2!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_contact_person2_phone',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>
                                                                        <li>Укажите тел. контакного лица 2!</li>
                                                                    <?php }?>
                                                                </ul>
                                                            </div>
                                                        <?php }?>
                                                        <div class="col-md-4">
                                                            <div class="form-group <?php if (in_array('empty_contact_person_name',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">ФИО контакного лица</label>
                                                                <input type="text" class="form-control"
                                                                       name="contact_person_name"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->contact_person_name, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder="" required="true"/>
                                                                <?php if (in_array('empty_contact_person_name',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите ФИО
                                                                        контакного лица!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group <?php if (in_array('empty_contact_person_relation',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Кем приходится</label>
                                                                <select class="form-control custom-select"
                                                                        name="contact_person_relation">
                                                                    <option value=""
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person_relation=='') {?>selected=""<?php }?>>
                                                                        Выберите значение
                                                                    </option>
                                                                    <option value="мать/отец"
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person_relation=='мать/отец') {?>selected=""<?php }?>>
                                                                        мать/отец
                                                                    </option>
                                                                    <option value="муж/жена"
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person_relation=='муж/жена') {?>selected=""<?php }?>>
                                                                        муж/жена
                                                                    </option>
                                                                    <option value="сын/дочь"
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person_relation=='сын/дочь') {?>selected=""<?php }?>>
                                                                        сын/дочь
                                                                    </option>
                                                                    <option value="коллега"
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person_relation=='коллега') {?>selected=""<?php }?>>
                                                                        коллега
                                                                    </option>
                                                                    <option value="друг/сосед"
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person_relation=='друг/сосед') {?>selected=""<?php }?>>
                                                                        друг/сосед
                                                                    </option>
                                                                    <option value="иной родственник"
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person_relation=='иной родственник') {?>selected=""<?php }?>>
                                                                        иной родственник
                                                                    </option>
                                                                </select>
                                                                <?php if (in_array('empty_contact_person_relation',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите кем
                                                                        приходится контакное лицо!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group <?php if (in_array('empty_contact_person_phone',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Тел. контакного
                                                                    лица</label>
                                                                <input type="text" class="form-control"
                                                                       name="contact_person_phone"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->contact_person_phone, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder="" required="true"/>
                                                                <?php if (in_array('empty_contact_person_phone',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите тел.
                                                                        контакного лица!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <div class="form-group <?php if (in_array('empty_contact_person2_name',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">ФИО контакного лица
                                                                    2</label>
                                                                <input type="text" class="form-control"
                                                                       name="contact_person2_name"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->contact_person2_name, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder="" required="true"/>
                                                                <?php if (in_array('empty_contact_person2_name',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите ФИО
                                                                        контакного лица!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group <?php if (in_array('empty_contact_person_relation',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Кем приходится</label>
                                                                <select class="form-control custom-select"
                                                                        name="contact_person2_relation">
                                                                    <option value=""
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person2_relation=='') {?>selected=""<?php }?>>
                                                                        Выберите значение
                                                                    </option>
                                                                    <option value="мать/отец"
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person2_relation=='мать/отец') {?>selected=""<?php }?>>
                                                                        мать/отец
                                                                    </option>
                                                                    <option value="муж/жена"
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person2_relation=='муж/жена') {?>selected=""<?php }?>>
                                                                        муж/жена
                                                                    </option>
                                                                    <option value="сын/дочь"
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person2_relation=='сын/дочь') {?>selected=""<?php }?>>
                                                                        сын/дочь
                                                                    </option>
                                                                    <option value="коллега"
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person2_relation=='коллега') {?>selected=""<?php }?>>
                                                                        коллега
                                                                    </option>
                                                                    <option value="друг/сосед"
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person2_relation=='друг/сосед') {?>selected=""<?php }?>>
                                                                        друг/сосед
                                                                    </option>
                                                                    <option value="иной родственник"
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->contact_person2_relation=='иной родственник') {?>selected=""<?php }?>>
                                                                        иной родственник
                                                                    </option>
                                                                </select>
                                                                <?php if (in_array('empty_contact_person_relation',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите кем
                                                                        приходится контакное лицо!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group <?php if (in_array('empty_contact_person2_phone',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Тел. контакного лица
                                                                    2</label>
                                                                <input type="text" class="form-control"
                                                                       name="contact_person2_phone"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->contact_person2_phone, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder=""/>
                                                                <?php if (in_array('empty_contact_person2_phone',(array)$_smarty_tpl->tpl_vars['contacts_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите тел.
                                                                        контакного лица!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-12">
                                                            <div class="form-actions">
                                                                <button type="submit"
                                                                        class="btn btn-success js-event-add-click"
                                                                        data-event="43" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                        data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                            class="fa fa-check"></i> Сохранить
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-inverse js-cancel-edit">Отмена
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
"
                                                      class="js-order-item-form mb-3 border <?php if ($_smarty_tpl->tpl_vars['penalties']->value['addresses']&&$_smarty_tpl->tpl_vars['penalties']->value['addresses']->status!=3) {?>card-outline-danger<?php }?>"
                                                      id="address_form">

                                                    <input type="hidden" name="action" value="addresses"/>
                                                    <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                                                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"/>

                                                    <h5 class="card-header">
                                                        <span class="text-white">Адрес</span>
                                                        <span class="float-right">
                                                            <?php smarty_template_function_penalty_button($_smarty_tpl,array('penalty_block'=>'addresses'));?>

                                                            <a href="javascript:void(0);"
                                                               class="text-white js-edit-form js-event-add-click"
                                                               data-event="34" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                               data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                               data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                        class=" fas fa-edit"></i></a></h3>
                                                        </span>
                                                    </h5>

                                                    <div class="row view-block <?php if ($_smarty_tpl->tpl_vars['addresses_error']->value) {?>hide<?php }?>">
                                                        <div class="col-md-12">
                                                            <table class="table table-hover mb-0">
                                                                <tr>
                                                                    <td>Адрес прописки</td>
                                                                    <td><?php echo $_smarty_tpl->tpl_vars['faktaddress']->value;?>
</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Адрес проживания</td>
                                                                    <td><?php echo $_smarty_tpl->tpl_vars['regaddress']->value;?>
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
                                                                        <?php if (in_array('empty_regregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                            <li>Укажите область!</li>
                                                                        <?php }?>
                                                                        <?php if (in_array('empty_regcity',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                            <li>Укажите город!</li>
                                                                        <?php }?>
                                                                        <?php if (in_array('empty_regstreet',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                            <li>Укажите улицу!</li>
                                                                        <?php }?>
                                                                        <?php if (in_array('empty_reghousing',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                            <li>Укажите дом!</li>
                                                                        <?php }?>
                                                                        <?php if (in_array('empty_faktregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                            <li>Укажите область!</li>
                                                                        <?php }?>
                                                                        <?php if (in_array('empty_faktcity',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                            <li>Укажите город!</li>
                                                                        <?php }?>
                                                                        <?php if (in_array('empty_faktstreet',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                            <li>Укажите улицу!</li>
                                                                        <?php }?>
                                                                        <?php if (in_array('empty_fakthousing',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                            <li>Укажите дом!</li>
                                                                        <?php }?>
                                                                    </ul>
                                                                </div>
                                                            <?php }?>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_regregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <input type="text"
                                                                           class="form-control js-dadata-onestring"
                                                                           name=""
                                                                           value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regaddress_full, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                           placeholder=""/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_regregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Область</label>
                                                                    <div class="row">
                                                                        <div class="col-9">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-region"
                                                                                   name="Regregion"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regregion, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder="" required="true"/>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-region-type"
                                                                                   name="Regregion_shorttype"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regregion_shorttype, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                    </div>
                                                                    <?php if (in_array('empty_regregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                        <small class="form-control-feedback">Укажите
                                                                            область!
                                                                        </small>
                                                                    <?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_regcity',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Город</label>
                                                                    <div class="row">
                                                                        <div class="col-9">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-city"
                                                                                   name="Regcity"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regcity, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-city-type"
                                                                                   name="Regcity_shorttype"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regcity_shorttype, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                    </div>
                                                                    <?php if (in_array('empty_regcity',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                        <small class="form-control-feedback">Укажите
                                                                            город!
                                                                        </small>
                                                                    <?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 ">
                                                                    <label class="control-label">Район</label>
                                                                    <div class="row">
                                                                        <div class="col-9">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-district"
                                                                                   name="Regdistrict"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regdistrict, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-district-type"
                                                                                   name="Regdistrict_shorttype"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regdistrict_shorttype, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 ">
                                                                    <label class="control-label">Нас. пункт</label>
                                                                    <div class="row">
                                                                        <div class="col-9">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-locality"
                                                                                   name="Reglocality"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Reglocality, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-locality-type"
                                                                                   name="Reglocality_shorttype"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Reglocality_shorttype, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_regstreet',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Улица</label>
                                                                    <div class="row">
                                                                        <div class="col-9">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-street"
                                                                                   name="Regstreet"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regstreet, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-street-type"
                                                                                   name="Regstreet_shorttype"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regstreet_shorttype, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                    </div>
                                                                    <?php if (in_array('empty_regstreet',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                        <small class="form-control-feedback">Укажите
                                                                            улицу!
                                                                        </small>
                                                                    <?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Индекс</label>
                                                                    <input type="text"
                                                                           class="form-control js-dadata-index"
                                                                           name="Regindex"
                                                                           value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regindex, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                           placeholder=""/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group <?php if (in_array('empty_reghousing',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Дом</label>
                                                                    <input type="text"
                                                                           class="form-control js-dadata-house"
                                                                           name="Reghousing"
                                                                           value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Reghousing, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                           placeholder=""/>
                                                                    <?php if (in_array('empty_reghousing',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                        <small class="form-control-feedback">Укажите
                                                                            дом!
                                                                        </small>
                                                                    <?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Строение</label>
                                                                    <input type="text"
                                                                           class="form-control js-dadata-building"
                                                                           name="Regbuilding"
                                                                           value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regbuilding, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                           placeholder=""/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Квартира</label>
                                                                    <input type="text"
                                                                           class="form-control js-dadata-room"
                                                                           name="Regroom"
                                                                           value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regroom, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                           placeholder=""/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="custom-checkbox">
                                                                    <input type="checkbox" name="equal" value="1"
                                                                           class="js-equal-address" id="equal_address"/>
                                                                    <label class="" for="equal_address">Адрес проживания
                                                                        совпадает с адресом прописки</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row m-0 js-dadata-address">
                                                            <h6 class="col-12 nav-small-cap">Адрес проживания</h6>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_regregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <input type="text"
                                                                           class="form-control js-dadata-onestring"
                                                                           name=""
                                                                           value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Regaddress_full, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                           placeholder=""/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_faktregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Область</label>
                                                                    <div class="row">
                                                                        <div class="col-9">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-region"
                                                                                   name="Faktregion"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Faktregion, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder="" required="true"/>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-region-type"
                                                                                   name="Faktregion_shorttype"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Faktregion_shorttype, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                    </div>
                                                                    <?php if (in_array('empty_faktregion',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                        <small class="form-control-feedback">Укажите
                                                                            область!
                                                                        </small>
                                                                    <?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_faktcity',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Город</label>
                                                                    <div class="row">
                                                                        <div class="col-9">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-city"
                                                                                   name="Faktcity"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Faktcity, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-city-type"
                                                                                   name="Faktcity_shorttype"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Faktcity_shorttype, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                    </div>
                                                                    <?php if (in_array('empty_faktcity',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                        <small class="form-control-feedback">Укажите
                                                                            город!
                                                                        </small>
                                                                    <?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 ">
                                                                    <label class="control-label">Район</label>
                                                                    <div class="row">
                                                                        <div class="col-9">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-district"
                                                                                   name="Faktdistrict"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Faktdistrict, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-district-type"
                                                                                   name="Faktdistrict_shorttype"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Faktdistrict_shorttype, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 ">
                                                                    <label class="control-label">Нас. пункт</label>
                                                                    <div class="row">
                                                                        <div class="col-9">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-locality"
                                                                                   name="Faktlocality"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Faktlocality, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-locality-type"
                                                                                   name="Faktlocality_shorttype"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Faktlocality_shorttype, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-1 <?php if (in_array('empty_faktstreet',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Улица</label>
                                                                    <div class="row">
                                                                        <div class="col-9">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-street"
                                                                                   name="Faktstreet"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Faktstreet, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <input type="text"
                                                                                   class="form-control js-dadata-street-type"
                                                                                   name="Faktstreet_shorttype"
                                                                                   value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Faktstreet_shorttype, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                   placeholder=""/>
                                                                        </div>
                                                                    </div>
                                                                    <?php if (in_array('empty_faktstreet',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                        <small class="form-control-feedback">Укажите
                                                                            улицу!
                                                                        </small>
                                                                    <?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">Индекс</label>
                                                                    <input type="text"
                                                                           class="form-control js-dadata-index"
                                                                           name="Faktindex"
                                                                           value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Faktindex, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                           placeholder=""/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group <?php if (in_array('empty_fakthousing',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>has-danger<?php }?>">
                                                                    <label class="control-label">Дом</label>
                                                                    <input type="text"
                                                                           class="form-control js-dadata-house"
                                                                           name="Fakthousing"
                                                                           value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Fakthousing, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                           placeholder=""/>
                                                                    <?php if (in_array('empty_fakthousing',(array)$_smarty_tpl->tpl_vars['addresses_error']->value)) {?>
                                                                        <small class="form-control-feedback">Укажите
                                                                            дом!
                                                                        </small>
                                                                    <?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Строение</label>
                                                                    <input type="text"
                                                                           class="form-control js-dadata-building"
                                                                           name="Faktbuilding"
                                                                           value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Faktbuilding, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                           placeholder=""/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="control-label">Квартира</label>
                                                                    <input type="text"
                                                                           class="form-control js-dadata-room"
                                                                           name="Faktroom"
                                                                           value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->Faktroom, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                           placeholder=""/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row m-0 mt-2 mb-2">
                                                            <div class="col-md-12">
                                                                <div class="form-actions">
                                                                    <button type="submit"
                                                                            class="btn btn-success js-event-add-click"
                                                                            data-event="44"
                                                                            data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                            data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                            data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                                class="fa fa-check"></i> Сохранить
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-inverse js-cancel-edit">
                                                                        Отмена
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>


                                                <!-- Данные о работе -->
                                                <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
"
                                                      class="border js-order-item-form mb-3 <?php if ($_smarty_tpl->tpl_vars['penalties']->value['work']&&$_smarty_tpl->tpl_vars['penalties']->value['work']->status!=3) {?>card-outline-danger<?php }?>"
                                                      id="work_data_form">

                                                    <input type="hidden" name="action" value="work"/>
                                                    <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                                                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"/>

                                                    <h5 class="card-header">
                                                        <span class="text-white">Данные о работе</span>
                                                        <span class="float-right">
                                                            <?php smarty_template_function_penalty_button($_smarty_tpl,array('penalty_block'=>'work'));?>

                                                            <a href="javascript:void(0);"
                                                               class="text-white float-right js-edit-form js-event-add-click"
                                                               data-event="35" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                               data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                               data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                        class=" fas fa-edit"></i></a>
                                                        </span>
                                                    </h5>

                                                    <div class="row m-0 pt-2 view-block <?php if ($_smarty_tpl->tpl_vars['work_error']->value) {?>hide<?php }?>">
                                                        <?php if ($_smarty_tpl->tpl_vars['order']->value->workplace||$_smarty_tpl->tpl_vars['order']->value->workphone) {?>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-0  row">
                                                                    <label class="control-label col-md-4">Название
                                                                        организации:</label>
                                                                    <div class="col-md-8">
                                                                        <p class="form-control-static">
                                                                        <span class="clearfix">
                                                                            <span class="float-left">
                                                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->workplace, ENT_QUOTES, 'UTF-8', true);?>

                                                                            </span>
                                                                            <span class="float-right">
                                                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->workphone, ENT_QUOTES, 'UTF-8', true);?>

                                                                                <button class="js-mango-call mango-call js-event-add-click"
                                                                                        data-event="62"
                                                                                        data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                                        data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                                                        data-phone="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->workphone, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                        title="Выполнить звонок">
                                                                                    <i class="fas fa-mobile-alt"></i>
                                                                                </button>
                                                                            </span>
                                                                        </span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['order']->value->workaddress) {?>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-0 row">
                                                                    <label class="control-label col-md-4">Адрес:</label>
                                                                    <div class="col-md-8">
                                                                        <p class="form-control-static">
                                                                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->workaddress, ENT_QUOTES, 'UTF-8', true);?>

                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['order']->value->profession) {?>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-0 row">
                                                                    <label class="control-label col-md-4">Должность:</label>
                                                                    <div class="col-md-8">
                                                                        <p class="form-control-static">
                                                                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->profession, ENT_QUOTES, 'UTF-8', true);?>

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
                                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->chief_name, ENT_QUOTES, 'UTF-8', true);?>

                                                                        , <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->chief_position, ENT_QUOTES, 'UTF-8', true);?>

                                                                        <br/>
                                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->chief_phone, ENT_QUOTES, 'UTF-8', true);?>

                                                                        <button class="js-mango-call mango-call js-event-add-click"
                                                                                data-event="63"
                                                                                data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                                data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                                data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                                                data-phone="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->chief_phone, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                                title="Выполнить звонок">
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
                                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->income, ENT_QUOTES, 'UTF-8', true);?>

                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group  mb-0 row">
                                                                <label class="control-label col-md-4">Расход:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">
                                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->expenses, ENT_QUOTES, 'UTF-8', true);?>

                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if ($_smarty_tpl->tpl_vars['order']->value->workcomment) {?>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-0 row">
                                                                    <label class="control-label col-md-4">Комментарий к
                                                                        работе:</label>
                                                                    <div class="col-md-8">
                                                                        <p class="form-control-static">
                                                                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->workcomment, ENT_QUOTES, 'UTF-8', true);?>

                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                    </div>

                                                    <div class="row m-0 pt-2 edit-block js-dadata-address <?php if (!$_smarty_tpl->tpl_vars['work_error']->value) {?>hide<?php }?>">
                                                        <?php if ($_smarty_tpl->tpl_vars['work_error']->value) {?>
                                                            <div class="col-md-12">
                                                                <ul class="alert alert-danger">

                                                                    <?php if (in_array('empty_workplace',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                        <li>Укажите название организации!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_profession',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                        <li>Укажите должность!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_workphone',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                        <li>Укажите рабочий телефон!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_income',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                        <li>Укажите доход!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_expenses',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                        <li>Укажите расход!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_chief_name',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                        <li>Укажите ФИО начальника!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_chief_position',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                        <li>Укажите Должность начальника!</li>
                                                                    <?php }?>
                                                                    <?php if (in_array('empty_chief_phone',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                        <li>Укажите Телефон начальника!</li>
                                                                    <?php }?>

                                                                </ul>
                                                            </div>
                                                        <?php }?>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_workplace',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Название
                                                                    организации</label>
                                                                <input type="text" class="form-control" name="workplace"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->workplace, ENT_QUOTES, 'UTF-8', true);?>
" placeholder=""
                                                                       required="true"/>
                                                                <?php if (in_array('empty_workplace',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите
                                                                        название организации!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_profession',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Должность</label>
                                                                <input type="text" class="form-control"
                                                                       name="profession"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->profession, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder="" required="true"/>
                                                                <?php if (in_array('empty_profession',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите
                                                                        должность!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-0">
                                                                <label class="control-label">Адрес</label>
                                                                <input type="text" class="form-control"
                                                                       name="workaddress"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->workaddress, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder="" required="true"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_workphone',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Pабочий телефон</label>
                                                                <input type="text" class="form-control" name="workphone"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->workphone, ENT_QUOTES, 'UTF-8', true);?>
" placeholder=""
                                                                       required="true"/>
                                                                <?php if (in_array('empty_workphone',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите рабочий
                                                                        телефон!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_income',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Доход</label>
                                                                <input type="text" class="form-control" name="income"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->income, ENT_QUOTES, 'UTF-8', true);?>
" placeholder=""
                                                                       required="true"/>
                                                                <?php if (in_array('empty_income',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите
                                                                        доход!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_expenses',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Расход</label>
                                                                <input type="text" class="form-control" name="expenses"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->expenses, ENT_QUOTES, 'UTF-8', true);?>
" placeholder=""
                                                                       required="true"/>
                                                                <?php if (in_array('empty_expenses',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите
                                                                        расход!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_chief_name',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">ФИО начальника</label>
                                                                <input type="text" class="form-control"
                                                                       name="chief_name"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->chief_name, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder="" required="true"/>
                                                                <?php if (in_array('empty_chief_name',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите ФИО
                                                                        начальника!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_chief_position',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Должность
                                                                    начальника</label>
                                                                <input type="text" class="form-control"
                                                                       name="chief_position"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->chief_position, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder="" required="true"/>
                                                                <?php if (in_array('empty_chief_position',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите
                                                                        Должность начальника!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 <?php if (in_array('empty_chief_phone',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>has-danger<?php }?>">
                                                                <label class="control-label">Телефон начальника</label>
                                                                <input type="text" class="form-control"
                                                                       name="chief_phone"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->chief_phone, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder=""/>
                                                                <?php if (in_array('empty_chief_phone',(array)$_smarty_tpl->tpl_vars['work_error']->value)) {?>
                                                                    <small class="form-control-feedback">Укажите Телефон
                                                                        начальника!
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group mb-0">
                                                                <label class="control-label">Комментарий к
                                                                    работе</label>
                                                                <input type="text" class="form-control"
                                                                       name="workcomment"
                                                                       value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->workcomment, ENT_QUOTES, 'UTF-8', true);?>
"
                                                                       placeholder=""/>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 pb-2 mt-2">
                                                            <div class="form-actions">
                                                                <button type="submit"
                                                                        class="btn btn-success js-event-add-click"
                                                                        data-event="45" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                        data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                            class="fa fa-check"></i> Сохранить
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-inverse js-cancel-edit">Отмена
                                                                </button>
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

                                                <?php if ($_smarty_tpl->tpl_vars['order']->value->autoretry_result) {?>
                                                    <div class="card mb-1 <?php if ($_smarty_tpl->tpl_vars['order']->value->autoretry_summ) {?>card-success<?php } else { ?>card-danger<?php }?>">
                                                        <div class="box ">
                                                            <h5 class="card-title mb-0 text-white text-center">
                                                                Авторешение</h5>
                                                            <div class="text-white text-center">
                                                                <small class="text-white">
                                                                    <?php echo $_smarty_tpl->tpl_vars['order']->value->autoretry_result;?>

                                                                </small>
                                                            </div>
                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->autoretry_summ&&$_smarty_tpl->tpl_vars['order']->value->status==1) {?>
                                                                <button data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                        class="mt-2 btn btn-block btn-info btn-sm js-autoretry-accept js-event-add-click"
                                                                        data-event="17" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                        data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
">
                                                                    Выдать <?php echo $_smarty_tpl->tpl_vars['order']->value->autoretry_summ;?>
 руб
                                                                </button>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                <?php }?>

                                                <div class="mb-3 border  <?php if ($_smarty_tpl->tpl_vars['penalties']->value['scorings']&&$_smarty_tpl->tpl_vars['penalties']->value['scorings']->status!=3) {?>card-outline-danger<?php }?>">
                                                    <h5 class=" card-header">
                                                        <span class="text-white ">Скоринги</span>
                                                        <span class="float-right">
                                                            <?php smarty_template_function_penalty_button($_smarty_tpl,array('penalty_block'=>'scorings'));?>

                                                            <?php if (($_smarty_tpl->tpl_vars['order']->value->status==1&&($_smarty_tpl->tpl_vars['manager']->value->id==$_smarty_tpl->tpl_vars['order']->value->manager_id))||$_smarty_tpl->tpl_vars['is_developer']->value) {?>
                                                                <a class="text-white js-run-scorings" data-type="all"
                                                                   data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                   href="javascript:void(0);">
                                                                <i class="far fa-play-circle"></i>
                                                            </a>
                                                            <?php }?>
                                                        </span>
                                                        </h2>
                                                        <div class="message-box js-scorings-block <?php if ($_smarty_tpl->tpl_vars['need_update_scorings']->value) {?>js-need-update<?php }?>"
                                                             data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
">

                                                            <?php  $_smarty_tpl->tpl_vars['scoring_type'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['scoring_type']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['scoring_types']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['scoring_type']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['scoring_type']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['scoring_type']->key => $_smarty_tpl->tpl_vars['scoring_type']->value) {
$_smarty_tpl->tpl_vars['scoring_type']->_loop = true;
 $_smarty_tpl->tpl_vars['scoring_type']->iteration++;
 $_smarty_tpl->tpl_vars['scoring_type']->last = $_smarty_tpl->tpl_vars['scoring_type']->iteration === $_smarty_tpl->tpl_vars['scoring_type']->total;
?>
                                                                <div class="pl-2 pr-2 <?php if ($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->status=='new') {?>bg-light-warning<?php } elseif ($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->success) {?>bg-light-success<?php } else { ?>bg-light-danger<?php }?>">
                                                                    <div class="row <?php if (!$_smarty_tpl->tpl_vars['scoring_type']->last) {?>border-bottom<?php }?>">
                                                                        <div class="col-12 col-sm-12 pt-2">
                                                                            <?php if ($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->status=='new') {?>
                                                                                <span class="label label-warning float-right">Ожидание</span>
                                                                            <?php } elseif ($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->status=='process') {?>
                                                                                <span class="label label-info label-sm float-right">Выполняется</span>
                                                                            <?php } elseif ($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->status=='error') {?>
                                                                                <span class="label label-danger label-sm float-right">Ошибка</span>
                                                                            <?php } elseif ($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->status=='stopped') {?>
                                                                                <span class="label label-warning label-sm float-right">Остановлен</span>
                                                                            <?php } elseif ($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->status=='completed') {?>
                                                                                <?php if ($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->success) {?>
                                                                                    <span class="label label-success label-sm float-right">Пройден</span>
                                                                                <?php } else { ?>
                                                                                    <span class="label label-danger float-right">Не пройден</span>
                                                                                <?php }?>
                                                                            <?php }?>
                                                                        </div>
                                                                        <div class="col-8 col-sm-8 pb-2">
                                                                        <span class="mail-desc"
                                                                              title="<?php echo $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->string_result;?>
">
                                                                            <?php echo $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->string_result;?>

                                                                        </span>
                                                                            <?php if ($_smarty_tpl->tpl_vars['scoring_type']->value->name=='nbki') {?>
                                                                                <?php $_smarty_tpl->tpl_vars['number_of_active'] = new Smarty_variable($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->body['number_of_active'][0], null, 0);?>

                                                                                <?php if (($_smarty_tpl->tpl_vars['number_of_active']->value>=1&&$_smarty_tpl->tpl_vars['number_of_active']->value<=5)) {?>
                                                                                    <?php $_smarty_tpl->tpl_vars['recommended_amount'] = new Smarty_variable($_smarty_tpl->tpl_vars['scoring_type']->value->params['recommended_amount_1_5'], null, 0);?>
                                                                                <?php } elseif (($_smarty_tpl->tpl_vars['number_of_active']->value>=6&&$_smarty_tpl->tpl_vars['number_of_active']->value<=10)) {?>
                                                                                    <?php $_smarty_tpl->tpl_vars['recommended_amount'] = new Smarty_variable($_smarty_tpl->tpl_vars['scoring_type']->value->params['recommended_amount_6_10'], null, 0);?>
                                                                                <?php } elseif (($_smarty_tpl->tpl_vars['number_of_active']->value>=11&&$_smarty_tpl->tpl_vars['number_of_active']->value<=29)) {?>
                                                                                    <?php $_smarty_tpl->tpl_vars['recommended_amount'] = new Smarty_variable($_smarty_tpl->tpl_vars['scoring_type']->value->params['recommended_amount_11_29'], null, 0);?>
                                                                                <?php } elseif (($_smarty_tpl->tpl_vars['number_of_active']->value>=30)) {?>
                                                                                    <?php $_smarty_tpl->tpl_vars['recommended_amount'] = new Smarty_variable($_smarty_tpl->tpl_vars['scoring_type']->value->params['recommended_amount_30_'], null, 0);?>
                                                                                <?php } else { ?>
                                                                                    <?php $_smarty_tpl->tpl_vars['recommended_amount'] = new Smarty_variable('???', null, 0);?>
                                                                                <?php }?>
                                                                                <span class="mail-desc"
                                                                                      title="<?php echo $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->body['number_of_active'][1];?>
 - <?php echo $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->body['number_of_active'][0];?>
">
                                                                                    Рекомендуемая сумма: <b><?php echo $_smarty_tpl->tpl_vars['recommended_amount']->value;?>
</b>
                                                                                </span>
                                                                                <span class="mail-desc"
                                                                                      title="<?php echo $_smarty_tpl->tpl_vars['number_of_active']->value;?>
">
                                                                                    Количество активных займов: <b><?php echo $_smarty_tpl->tpl_vars['number_of_active']->value;?>
</b>
                                                                                </span>
                                                                            <?php }?>
                                                                            <span class="time">
                                                                            <?php if ($_smarty_tpl->tpl_vars['scoring_type']->value->name=='whatsapp') {?>
                                                                                <span><?php echo $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->body['status'];?>
</span><br>
                                                                                <span><?php echo $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->body['statusDate'];?>
</span><br>
                                                                                <a href="<?php echo $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->body['image'];?>
" target="_blank">Ссылка на фото</a><br>
                                                                            <?php }?>
                                                                                <?php if ($_smarty_tpl->tpl_vars['scoring_type']->value->name=='contact') {?>
                                                                                    <span><?php echo $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->body['name'];?>
</span><br>
                                                                                    <span><?php echo $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->body['tags'];?>
</span><br>
                                                                                <?php }?>
                                                                                <?php if ($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->created) {?>
                                                                                    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->created);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->created);?>

                                                                                <?php }?>
                                                                                <?php if ($_smarty_tpl->tpl_vars['scoring_type']->value->name=='fssp2') {?>
                                                                                    <a href="/ajax/show_fssp2.php?id=<?php echo $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->id;?>
&password=Hjkdf8d"
                                                                                       target="_blank">Подробнее</a>
                                                                                <?php }?>
                                                                                <?php if ($_smarty_tpl->tpl_vars['scoring_type']->value->name=='efrsb'&&$_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->body) {?>
                                                                                    <?php  $_smarty_tpl->tpl_vars['efrsb_link'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['efrsb_link']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->body; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['efrsb_link']->key => $_smarty_tpl->tpl_vars['efrsb_link']->value) {
$_smarty_tpl->tpl_vars['efrsb_link']->_loop = true;
?>
                                                                                        <a href="<?php echo $_smarty_tpl->tpl_vars['efrsb_link']->value;?>
"
                                                                                           target="_blank"
                                                                                           class="float-right">Подробнее</a>
                                                                                    <?php } ?>
                                                                                <?php }?>
                                                                                <?php if ($_smarty_tpl->tpl_vars['scoring_type']->value->name=='nbki') {?>
                                                                                    <a href="http://<?php echo $_smarty_tpl->tpl_vars['settings']->value->nbki_ip;?>
/nal-plus-nbki/<?php echo $_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->id;?>
?api=F1h1Hdf9g_h"
                                                                                       target="_blank">Подробнее</a>
                                                                                <?php }?>
                                                                        </span>
                                                                        </div>
                                                                        <div class="col-4 col-sm-4 pb-2">
                                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->status<2||$_smarty_tpl->tpl_vars['is_developer']->value) {?>
                                                                                <?php if ($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->status=='new'||$_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]->status=='process') {?>
                                                                                    <a class="btn-load text-info run-scoring-btn float-right"
                                                                                       data-type="<?php echo $_smarty_tpl->tpl_vars['scoring_type']->value->name;?>
"
                                                                                       data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                                       href="javascript:void(0);">
                                                                                        <div class="spinner-border text-info"
                                                                                             role="status"></div>
                                                                                    </a>
                                                                                <?php } elseif ($_smarty_tpl->tpl_vars['scorings']->value[$_smarty_tpl->tpl_vars['scoring_type']->value->name]) {?>
                                                                                    <a class="btn-load text-info js-run-scorings run-scoring-btn float-right"
                                                                                       data-type="<?php echo $_smarty_tpl->tpl_vars['scoring_type']->value->name;?>
"
                                                                                       data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                                       href="javascript:void(0);">
                                                                                        <i class="fas fa-undo"></i>
                                                                                    </a>
                                                                                <?php } else { ?>
                                                                                    <a class="btn-load <?php if (in_array($_smarty_tpl->tpl_vars['scoring_type']->value->name,$_smarty_tpl->tpl_vars['audit_types']->value)) {?>loading<?php }?> text-info js-run-scorings run-scoring-btn float-right"
                                                                                       data-type="<?php echo $_smarty_tpl->tpl_vars['scoring_type']->value->name;?>
"
                                                                                       data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                                       href="javascript:void(0);">
                                                                                        <i class="far fa-play-circle"></i>
                                                                                    </a>
                                                                                <?php }?>
                                                                            <?php }?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                </div>

                                                <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
"
                                                      class="mb-3 border js-order-item-form <?php if ($_smarty_tpl->tpl_vars['penalties']->value['services']&&$_smarty_tpl->tpl_vars['penalties']->value['services']->status!=3) {?>card-outline-danger<?php }?>"
                                                      id="services_form">

                                                    <input type="hidden" name="action" value="services"/>
                                                    <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                                                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"/>


                                                    <h5 class="card-header text-white">
                                                        <span>Услуги</span>
                                                        <span class="float-right ">
                                                            <?php smarty_template_function_penalty_button($_smarty_tpl,array('penalty_block'=>'services'));?>

                                                            <a href="javascript:void(0);"
                                                               class="js-edit-form text-white js-event-add-click"
                                                               data-event="36" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                               data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                               data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                        class=" fas fa-edit"></i></a>
                                                        </span>
                                                    </h5>

                                                    <div class="row view-block p-2 <?php if ($_smarty_tpl->tpl_vars['services_error']->value) {?>hide<?php }?>">
                                                        <div class="col-md-12">
                                                            
                                                            <div class="form-group mb-0 row">
                                                                <label class="control-label col-md-8 col-7">Причина
                                                                    отказа:</label>
                                                                <div class="col-md-4 col-5">
                                                                    <p class="form-control-static text-right">
                                                                        <?php if ($_smarty_tpl->tpl_vars['order']->value->service_reason) {?>
                                                                            <span class="label label-success">Вкл</span>
                                                                        <?php } else { ?>
                                                                            <span class="label label-danger">Выкл</span>
                                                                        <?php }?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-0 row">
                                                                <label class="control-label col-md-8 col-7">
                                                                    Страхование:
                                                                    <?php if ($_smarty_tpl->tpl_vars['contract_insurance']->value->protection) {?>
                                                                        <span class="label label-custom">Z</span>
                                                                        <?php if ($_smarty_tpl->tpl_vars['contract']->value->insurance_returned) {?>
                                                                            <small class="text-danger">Страховка
                                                                                возвращена
                                                                            </small>
                                                                        <?php } else { ?>
                                                                            <button class="btn btn-xs btn-danger js-return-insure"
                                                                                    data-contract="<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
"
                                                                                    type="button">Вернуть
                                                                            </button>
                                                                        <?php }?>
                                                                    <?php }?>
                                                                </label>
                                                                <div class="col-md-4 col-5">
                                                                    <p class="form-control-static text-right">
                                                                        <?php if ($_smarty_tpl->tpl_vars['order']->value->service_insurance) {?>
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
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           name="service_reason" id="service_reason"
                                                                           value="1"
                                                                           <?php if ($_smarty_tpl->tpl_vars['order']->value->service_reason) {?>checked="true"<?php }?> />
                                                                    <label class="custom-control-label"
                                                                           for="service_reason">Причина отказа</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           name="service_insurance"
                                                                           id="service_insurance" value="1"
                                                                           <?php if ($_smarty_tpl->tpl_vars['order']->value->service_insurance) {?>checked="true"<?php }?> />
                                                                    <label class="custom-control-label"
                                                                           for="service_insurance">Страхование</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-actions">
                                                                <button type="submit"
                                                                        class="btn btn-success js-event-add-click"
                                                                        data-event="46" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                        data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                            class="fa fa-check"></i> Сохранить
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-inverse js-cancel-edit">Отмена
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </form>

                                                <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
"
                                                      class="mb-3 border js-order-item-form <?php if ($_smarty_tpl->tpl_vars['penalties']->value['cards']&&$_smarty_tpl->tpl_vars['penalties']->value['cards']->status!=3) {?>card-outline-danger<?php }?>"
                                                      id="cards_form">

                                                    <input type="hidden" name="action" value="cards"/>
                                                    <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                                                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"/>


                                                    <h5 class="card-header text-white">
                                                        <span>Карта</span>
                                                        <span class="float-right">
                                                            <?php smarty_template_function_penalty_button($_smarty_tpl,array('penalty_block'=>'cards'));?>

                                                            <?php if (!in_array($_smarty_tpl->tpl_vars['order']->value->status,array(3,4,5,7,8))) {?>
                                                                <a href="javascript:void(0);"
                                                                   class="js-edit-form text-white js-event-add-click"
                                                                   data-event="37" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                   data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                   data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                            class=" fas fa-edit"></i></a>
                                                            <?php }?>
                                                        </span>
                                                    </h5>

                                                    <div class="row view-block p-2 <?php if ($_smarty_tpl->tpl_vars['card_error']->value) {?>hide<?php }?>">
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-0 row <?php if ($_smarty_tpl->tpl_vars['cards']->value[$_smarty_tpl->tpl_vars['order']->value->card_id]->duplicates) {?>text-danger<?php }?>">
                                                                <label class="control-label col-md-8 col-7">
                                                                    <?php echo $_smarty_tpl->tpl_vars['cards']->value[$_smarty_tpl->tpl_vars['order']->value->card_id]->pan;?>

                                                                    <p><?php echo $_smarty_tpl->tpl_vars['cards']->value[$_smarty_tpl->tpl_vars['order']->value->card_id]->bin_issuer;?>
</p>
                                                                    <?php if ($_smarty_tpl->tpl_vars['cards']->value[$_smarty_tpl->tpl_vars['order']->value->card_id]->deleted) {?>(карта удалена)<?php }?>
                                                                </label>
                                                                <div class="col-md-4 col-5">
                                                                    <p class="form-control-static text-right">
                                                                        <?php echo $_smarty_tpl->tpl_vars['cards']->value[$_smarty_tpl->tpl_vars['order']->value->card_id]->expdate;?>

                                                                    </p>
                                                                </div>
                                                                <?php if ($_smarty_tpl->tpl_vars['cards']->value[$_smarty_tpl->tpl_vars['order']->value->card_id]->duplicates) {?>
                                                                    <div class="col-12">
                                                                        <?php  $_smarty_tpl->tpl_vars['dupl'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dupl']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cards']->value[$_smarty_tpl->tpl_vars['order']->value->card_id]->duplicates; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dupl']->key => $_smarty_tpl->tpl_vars['dupl']->value) {
$_smarty_tpl->tpl_vars['dupl']->_loop = true;
?>
                                                                            <a href="client/<?php echo $_smarty_tpl->tpl_vars['dupl']->value->user_id;?>
"
                                                                               class="text-danger" target="_blank">Найдено
                                                                                совпадение</a>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row p-2 edit-block <?php if (!$_smarty_tpl->tpl_vars['card_error']->value) {?>hide<?php }?>">
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-4 <?php if (in_array('empty_card',(array)$_smarty_tpl->tpl_vars['card_error']->value)) {?>has-danger<?php }?>">
                                                                <select class="form-control" name="card_id">
                                                                    <?php  $_smarty_tpl->tpl_vars['card'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['card']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cards']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['card']->key => $_smarty_tpl->tpl_vars['card']->value) {
$_smarty_tpl->tpl_vars['card']->_loop = true;
?>
                                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['card']->value->id;?>
"
                                                                                <?php if ($_smarty_tpl->tpl_vars['card']->value->id==$_smarty_tpl->tpl_vars['order']->value->card_id) {?>selected<?php }?>>
                                                                            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['card']->value->pan, ENT_QUOTES, 'UTF-8', true);?>
 <?php echo $_smarty_tpl->tpl_vars['card']->value->expdate;?>

                                                                            <?php if ($_smarty_tpl->tpl_vars['card']->value->base_card) {?>(основная)<?php }?>
                                                                            <?php if ($_smarty_tpl->tpl_vars['card']->value->deleted) {?>(карта удалена)<?php }?>
                                                                        </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-actions">
                                                                <button type="submit"
                                                                        class="btn btn-success js-event-add-click"
                                                                        data-event="47" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                        data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"><i
                                                                            class="fa fa-check"></i> Сохранить
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-inverse js-cancel-edit">Отмена
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </form>

                                            </div>
                                        </div>
                                        <!-- -->

                                        <form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array(),$_smarty_tpl);?>
"
                                              class="border js-order-item-form mb-3 js-check-images <?php if ($_smarty_tpl->tpl_vars['penalties']->value['images']&&$_smarty_tpl->tpl_vars['penalties']->value['images']->status!=3) {?>card-outline-danger<?php }?>"
                                              id="images_form" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
">

                                            <input type="hidden" name="action" value="images"/>
                                            <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                                            <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"/>

                                            <h5 class="card-header">
                                                <span class="text-white">Фотографии</span>
                                                <span class="float-right">
                                                    <?php smarty_template_function_penalty_button($_smarty_tpl,array('penalty_block'=>'images'));?>

                                                </span>
                                            </h5>

                                            <div class="row p-2 view-block <?php if ($_smarty_tpl->tpl_vars['socials_error']->value) {?>hide<?php }?>">
                                                <ul class="col-md-12 list-inline order-images-list">
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
                                                        <?php } elseif ($_smarty_tpl->tpl_vars['file']->value->status==4) {?>
                                                            <?php $_smarty_tpl->tpl_vars['item_class'] = new Smarty_variable("border-info border", null, 0);?>
                                                            <?php $_smarty_tpl->tpl_vars['ribbon_class'] = new Smarty_variable("ribbon-info", null, 0);?>
                                                            <?php $_smarty_tpl->tpl_vars['ribbon_icon'] = new Smarty_variable("fab fa-cloudversify", null, 0);?>
                                                        <?php }?>
                                                        <li class="order-image-item ribbon-wrapper rounded-sm border <?php echo $_smarty_tpl->tpl_vars['item_class']->value;?>
 js-image-item"
                                                            data-status="<?php echo $_smarty_tpl->tpl_vars['file']->value->status;?>
" id="file_<?php echo $_smarty_tpl->tpl_vars['file']->value->id;?>
"
                                                            data-id="<?php echo $_smarty_tpl->tpl_vars['file']->value->id;?>
" data-status="<?php echo $_smarty_tpl->tpl_vars['file']->value->status;?>
">
                                                            <a class="js-open-popup-image image-popup-fit-width js-event-add-click"
                                                               data-event="50" data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                               data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                               data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
" data-fancybox="user_image"
                                                               href="<?php echo $_smarty_tpl->tpl_vars['config']->value->front_url;?>
/files/users/<?php echo $_smarty_tpl->tpl_vars['file']->value->name;?>
">
                                                                <div class="ribbon ribbon-corner <?php echo $_smarty_tpl->tpl_vars['ribbon_class']->value;?>
"><i
                                                                            class="<?php echo $_smarty_tpl->tpl_vars['ribbon_icon']->value;?>
"></i></div>
                                                                <img src="<?php echo $_smarty_tpl->tpl_vars['config']->value->front_url;?>
/files/users/<?php echo $_smarty_tpl->tpl_vars['file']->value->name;?>
"
                                                                     alt="" class="img-responsive" style=""/>
                                                                <span class="label label-primary  image-label" style="">
                                                                <?php if ($_smarty_tpl->tpl_vars['file']->value->type=='passport1') {?>Паспорт1
                                                                <?php } elseif ($_smarty_tpl->tpl_vars['file']->value->type=='passport2') {?>Паспорт2
                                                                <?php } elseif ($_smarty_tpl->tpl_vars['file']->value->type=='card') {?>Карта
                                                                <?php } elseif ($_smarty_tpl->tpl_vars['file']->value->type=='face') {?>Селфи
                                                                <?php } else { ?>Нет типа<?php }?>
                                                            </span>
                                                                <?php if (!empty($_smarty_tpl->tpl_vars['file']->value->sent_date)) {?>
                                                                    <span class="label label-danger"
                                                                          style="bottom: -25px;">
                                                                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['file']->value->sent_date,"%d.%m.%Y в %H:%M");?>

                                                                </span>
                                                                <?php }?>
                                                            </a>
                                                            <?php if ($_smarty_tpl->tpl_vars['order']->value->status==1&&($_smarty_tpl->tpl_vars['manager']->value->id==$_smarty_tpl->tpl_vars['order']->value->manager_id)) {?>
                                                                <div class="order-image-actions">
                                                                    <div class="dropdown mr-1 show ">
                                                                        <button type="button"
                                                                                class="btn <?php if ($_smarty_tpl->tpl_vars['file']->value->status==2) {?>btn-success<?php } elseif ($_smarty_tpl->tpl_vars['file']->value->status==3) {?>btn-danger<?php } else { ?>btn-secondary<?php }?> dropdown-toggle"
                                                                                id="dropdownMenuOffset"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="true">
                                                                            <?php if ($_smarty_tpl->tpl_vars['file']->value->status==2) {?>Принят
                                                                            <?php } elseif ($_smarty_tpl->tpl_vars['file']->value->status==3) {?>Отклонен
                                                                            <?php } else { ?>Статус
                                                                            <?php }?>
                                                                        </button>
                                                                        <div class="dropdown-menu"
                                                                             aria-labelledby="dropdownMenuOffset"
                                                                             x-placement="bottom-start">
                                                                            <div class="p-1 dropdown-item">
                                                                                <button class="btn btn-sm btn-block btn-outline-success js-image-accept js-event-add-click"
                                                                                        data-event="51"
                                                                                        data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                                        data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                                                        data-id="<?php echo $_smarty_tpl->tpl_vars['file']->value->id;?>
"
                                                                                        type="button">
                                                                                    <i class="fas fa-check-circle"></i>
                                                                                    <span>Принять</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="p-1 dropdown-item">
                                                                                <button class="btn btn-sm btn-block btn-outline-danger js-image-reject js-event-add-click"
                                                                                        data-event="52"
                                                                                        data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                                        data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                                                        data-id="<?php echo $_smarty_tpl->tpl_vars['file']->value->id;?>
"
                                                                                        type="button">
                                                                                    <i class="fas fa-times-circle"></i>
                                                                                    <span>Отклонить</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="p-1 pt-3 dropdown-item">
                                                                                <button class="btn btn-sm btn-block btn-danger js-image-remove js-event-add-click"
                                                                                        data-event="53"
                                                                                        data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"
                                                                                        data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                                                                        data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                                                        data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"
                                                                                        data-id="<?php echo $_smarty_tpl->tpl_vars['file']->value->id;?>
"
                                                                                        type="button">
                                                                                    <i class="fas fa-trash"></i>
                                                                                    <span>Удалить</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php }?>
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
                                                                        <input type="text" class="js-file-status"
                                                                               id="status_<?php echo $_smarty_tpl->tpl_vars['file']->value->id;?>
"
                                                                               name="status[<?php echo $_smarty_tpl->tpl_vars['file']->value->id;?>
]"
                                                                               value="<?php echo $_smarty_tpl->tpl_vars['file']->value->status;?>
"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-md-12">
                                                    <div class="form-actions">
                                                        <button type="submit" class="btn btn-success"><i
                                                                    class="fa fa-check"></i> Сохранить
                                                        </button>
                                                        <button type="button" class="btn btn-inverse js-cancel-edit">
                                                            Отмена
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- -->
                                        <form method="POST" enctype="multipart/form-data">

                                            <div class="form_file_item">
                                                <input type="file" name="new_file" id="new_file"
                                                       data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
" value="" style="display:none"/>
                                                <label for="new_file" class="btn btn-large btn-primary">
                                                    <i class="fa fa-plus-circle"></i>
                                                    <span>Добавить</span>
                                                </label>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                                <!-- Комментарии -->
                                <div class="tab-pane p-3" id="comments" role="tabpanel">

                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="float-left">Комментарии к клиенту</h4>
                                            <button class="btn float-right hidden-sm-down btn-success js-open-comment-form">
                                                <i class="mdi mdi-plus-circle"></i>
                                                Добавить
                                            </button>
                                        </div>
                                        <hr class="m-3"/>
                                        <div class="col-12">
                                            <?php if ($_smarty_tpl->tpl_vars['contract']->value->premier&&$_smarty_tpl->tpl_vars['manager']->value->role=='user') {?>
                                                <h1 class="text-danger">ДОГОВОР ПРОДАН в КА "Премьер".</h1>
                                            <?php } elseif ($_smarty_tpl->tpl_vars['contract']->value->sold&&$_smarty_tpl->tpl_vars['manager']->value->role=='user') {?>
                                                <h1 class="text-danger">ДОГОВОР ПРОДАН в КА "ЮК1".</h1>
                                            <?php } else { ?>
                                                <?php if ($_smarty_tpl->tpl_vars['comments']->value) {?>
                                                    <div class="message-box">
                                                        <div class="message-widget">
                                                            <?php  $_smarty_tpl->tpl_vars['comment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['comment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['comment']->key => $_smarty_tpl->tpl_vars['comment']->value) {
$_smarty_tpl->tpl_vars['comment']->_loop = true;
?>
                                                                <a href="javascript:void(0);">
                                                                    <div class="user-img">
                                                                        <span class="round"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['comment']->value->letter, ENT_QUOTES, 'UTF-8', true);?>
</span>
                                                                    </div>
                                                                    <div class="mail-contnet">
                                                                        <div class="clearfix">
                                                                            <h5><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['managers']->value[$_smarty_tpl->tpl_vars['comment']->value->manager_id]->name, ENT_QUOTES, 'UTF-8', true);?>
</h5>
                                                                            <?php if ($_smarty_tpl->tpl_vars['comment']->value->official) {?>
                                                                                <span class="label label-success">Оффициальный</span>
                                                                            <?php }?>
                                                                            <?php if ($_smarty_tpl->tpl_vars['comment']->value->organization=='mkk') {?>
                                                                                <span class="label label-info">МКК</span>
                                                                            <?php }?>
                                                                            <?php if ($_smarty_tpl->tpl_vars['comment']->value->organization=='yuk') {?>
                                                                                <span class="label label-danger">ЮК</span>
                                                                            <?php }?>
                                                                        </div>
                                                                        <span class="mail-desc">
                                                                <?php echo nl2br($_smarty_tpl->tpl_vars['comment']->value->text);?>

                                                            </span>
                                                                        <span class="time"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['comment']->value->created);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['comment']->value->created);?>
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
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Комментарии -->

                                <!-- Документы -->
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
                                                        <a target="_blank"
                                                           href="<?php echo $_smarty_tpl->tpl_vars['config']->value->front_url;?>
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
                                <!-- /Документы -->


                                <div class="tab-pane p-3" id="logs" role="tabpanel">

                                    <ul class="nav nav-pills mt-4 mb-4">
                                        <li class=" nav-item"><a href="#eventlogs" class="nav-link active"
                                                                 data-toggle="tab" aria-expanded="false">События</a>
                                        </li>
                                        <li class="nav-item"><a href="#changelogs" class="nav-link" data-toggle="tab"
                                                                aria-expanded="false">Данные</a></li>
                                    </ul>

                                    <div class="tab-content br-n pn">
                                        <div id="eventlogs" class="tab-pane active">
                                            <h3>События</h3>
                                            <?php if ($_smarty_tpl->tpl_vars['eventlogs']->value) {?>
                                                <table class="table table-hover ">
                                                    <tbody>
                                                    <?php  $_smarty_tpl->tpl_vars['eventlog'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['eventlog']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['eventlogs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['eventlog']->key => $_smarty_tpl->tpl_vars['eventlog']->value) {
$_smarty_tpl->tpl_vars['eventlog']->_loop = true;
?>
                                                        <tr class="">
                                                            <td>
                                                                <span><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['eventlog']->value->created);?>
</span>
                                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['eventlog']->value->created);?>

                                                            </td>
                                                            <td>
                                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['events']->value[$_smarty_tpl->tpl_vars['eventlog']->value->event_id], ENT_QUOTES, 'UTF-8', true);?>

                                                            </td>
                                                            <td>
                                                                <a href="manager/<?php echo $_smarty_tpl->tpl_vars['eventlog']->value->manager_id;?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['managers']->value[$_smarty_tpl->tpl_vars['eventlog']->value->manager_id]->name, ENT_QUOTES, 'UTF-8', true);?>
</a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                                <a href="http://45.147.176.183/get/html_to_sheet?name=<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
&code=3Tfiikdfg6">...</a>
                                            <?php } else { ?>
                                                Нет записей
                                            <?php }?>

                                        </div>

                                        <div id="changelogs" class="tab-pane">
                                            <h3>Изменение данных</h3>
                                            <?php if ($_smarty_tpl->tpl_vars['changelogs']->value) {?>
                                                <table class="table table-hover ">
                                                    <tbody>
                                                    <?php  $_smarty_tpl->tpl_vars['changelog'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['changelog']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['changelogs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['changelog']->key => $_smarty_tpl->tpl_vars['changelog']->value) {
$_smarty_tpl->tpl_vars['changelog']->_loop = true;
?>
                                                        <tr class="">
                                                            <td>
                                                                <div class="button-toggle-wrapper">
                                                                    <button class="js-open-order button-toggle"
                                                                            data-id="<?php echo $_smarty_tpl->tpl_vars['changelog']->value->id;?>
" type="button"
                                                                            title="Подробнее"></button>
                                                                </div>
                                                                <span><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['changelog']->value->created);?>
</span>
                                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['changelog']->value->created);?>

                                                            </td>
                                                            <td>
                                                                <?php if ($_smarty_tpl->tpl_vars['changelog_types']->value[$_smarty_tpl->tpl_vars['changelog']->value->type]) {?><?php echo $_smarty_tpl->tpl_vars['changelog_types']->value[$_smarty_tpl->tpl_vars['changelog']->value->type];?>

                                                                <?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['changelog']->value->type, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
                                                            </td>
                                                            <td>
                                                                <a href="manager/<?php echo $_smarty_tpl->tpl_vars['changelog']->value->manager->id;?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['changelog']->value->manager->name, ENT_QUOTES, 'UTF-8', true);?>
</a>
                                                            </td>
                                                            <td>
                                                                <a href="client/<?php echo $_smarty_tpl->tpl_vars['changelog']->value->user->id;?>
">
                                                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['changelog']->value->user->lastname, ENT_QUOTES, 'UTF-8', true);?>

                                                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['changelog']->value->user->firstname, ENT_QUOTES, 'UTF-8', true);?>

                                                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['changelog']->value->user->patronymic, ENT_QUOTES, 'UTF-8', true);?>

                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr class="order-details" id="changelog_<?php echo $_smarty_tpl->tpl_vars['changelog']->value->id;?>
"
                                                            style="display:none">
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
                                            <?php } else { ?>
                                                Нет записей
                                            <?php }?>

                                        </div>

                                    </div>

                                </div>

                                <div class="tab-pane p-3" id="operations" role="tabpanel">
                                    <?php if ($_smarty_tpl->tpl_vars['contract_operations']->value) {?>
                                        <table class="table table-hover table-condense">
                                            <tbody>
                                            <tr>
                                                <th>Дата</th>
                                                <th>Операция</th>
                                                <th>Сумма</th>
                                                <th>ОД</th>
                                                <th>Проц-ты</th>
                                                <th>Отв-ть</th>
                                                <th>Пени</th>
                                                <th>Остаток</th>
                                            </tr>
                                            <?php  $_smarty_tpl->tpl_vars['operation'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['operation']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['contract_operations']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['operation']->key => $_smarty_tpl->tpl_vars['operation']->value) {
$_smarty_tpl->tpl_vars['operation']->_loop = true;
?>
                                                <tr class="
                                                    <?php if (in_array($_smarty_tpl->tpl_vars['operation']->value->type,array('PAY'))) {?>table-success<?php }?> 
                                                    <?php if (in_array($_smarty_tpl->tpl_vars['operation']->value->type,array('PERCENTS','CHARGE','PENI'))) {?>table-danger<?php }?> 
                                                    <?php if (in_array($_smarty_tpl->tpl_vars['operation']->value->type,array('P2P'))) {?>table-info<?php }?> 
                                                    <?php if (in_array($_smarty_tpl->tpl_vars['operation']->value->type,array('INSURANCE'))) {?>table-warning<?php }?>
                                                    <?php if (in_array($_smarty_tpl->tpl_vars['operation']->value->type,array('CORRECT'))) {?>table-primary<?php }?>
                                                ">
                                                    <td>
                                                        
                                                        <span><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['operation']->value->created);?>
</span>
                                                        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['operation']->value->created);?>

                                                    </td>
                                                    <td>
                                                        <?php if ($_smarty_tpl->tpl_vars['operation']->value->type=='P2P') {?>Выдача займа<?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['operation']->value->type=='PAY') {?>
                                                            <?php if ($_smarty_tpl->tpl_vars['operation']->value->transaction->prolongation) {?>
                                                                Пролонгация
                                                            <?php } else { ?>
                                                                Оплата займа
                                                            <?php }?>
                                                        <?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['operation']->value->type=='RECURRENT') {?>Оплата займа<?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['operation']->value->type=='PERCENTS') {?>Начисление процентов<?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['operation']->value->type=='INSURANCE') {?>Страховка<?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['operation']->value->type=='CHARGE') {?>Ответственность<?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['operation']->value->type=='PENI') {?>Пени<?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['operation']->value->type=='CORRECT') {?>Корректировка<?php }?>
                                                    </td>
                                                    <td>
                                                        <strong><?php echo $_smarty_tpl->tpl_vars['operation']->value->amount;?>
 руб</strong>
                                                    </td>
                                                    <td><?php echo $_smarty_tpl->tpl_vars['operation']->value->loan_body_summ;?>
</td>
                                                    <td><?php echo $_smarty_tpl->tpl_vars['operation']->value->loan_percents_summ;?>
</td>
                                                    <td><?php echo $_smarty_tpl->tpl_vars['operation']->value->loan_charge_summ;?>
</td>
                                                    <td><?php echo $_smarty_tpl->tpl_vars['operation']->value->loan_peni_summ;?>
</td>
                                                    <td>
                                                        <strong><?php echo $_smarty_tpl->tpl_vars['operation']->value->loan_body_summ+$_smarty_tpl->tpl_vars['operation']->value->loan_percents_summ+$_smarty_tpl->tpl_vars['operation']->value->loan_charge_summ+$_smarty_tpl->tpl_vars['operation']->value->loan_peni_summ;?>
</strong>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <h4>Нет операций</h4>
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
                                                                <?php  $_smarty_tpl->tpl_vars['o'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['o']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['orders']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['o']->key => $_smarty_tpl->tpl_vars['o']->value) {
$_smarty_tpl->tpl_vars['o']->_loop = true;
?>
                                                                    <?php if ($_smarty_tpl->tpl_vars['o']->value->contract->type!='onec') {?>
                                                                        <tr>
                                                                            <td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['o']->value->date);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['o']->value->date);?>
</td>
                                                                            <td>
                                                                                <a href="order/<?php echo $_smarty_tpl->tpl_vars['o']->value->order_id;?>
"
                                                                                   target="_blank"><?php echo $_smarty_tpl->tpl_vars['o']->value->order_id;?>
</a>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $_smarty_tpl->tpl_vars['o']->value->contract->number;?>

                                                                            </td>
                                                                            <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['o']->value->amount;?>
</td>
                                                                            <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['o']->value->period;?>
</td>
                                                                            <td class="text-right">
                                                                                <?php if ($_smarty_tpl->tpl_vars['o']->value->contract->status==10) {?>
                                                                                    <span class="label label-danger">Суд 1С</span>
                                                                                <?php } else { ?>
                                                                                    <?php echo $_smarty_tpl->tpl_vars['order_statuses']->value[$_smarty_tpl->tpl_vars['o']->value->status];?>

                                                                                <?php }?>
                                                                                <?php if ($_smarty_tpl->tpl_vars['o']->value->contract->status==3) {?>
                                                                                    <br/>
                                                                                    <small><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['o']->value->contract->close_date);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['o']->value->contract->close_date);?>
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
                                                            <h3>Кредитная история 1С</h3>
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
                                                                                <?php if ($_smarty_tpl->tpl_vars['loan_history_item']->value->sud) {?>
                                                                                    <span class="label label-danger">Суд</span>
                                                                                <?php } else { ?>
                                                                                    <?php if ($_smarty_tpl->tpl_vars['loan_history_item']->value->loan_percents_summ>0||$_smarty_tpl->tpl_vars['loan_history_item']->value->loan_body_summ>0) {?>
                                                                                        <span class="label label-danger">Активный</span>
                                                                                    <?php } else { ?>
                                                                                        <span class="label label-success">Закрыт</span>
                                                                                    <?php }?>
                                                                                <?php }?>
                                                                            </td>
                                                                            <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['loan_history_item']->value->amount;?>
</td>
                                                                            <td class="text-center"><?php echo $_smarty_tpl->tpl_vars['loan_history_item']->value->loan_body_summ;?>
</td>
                                                                            <td class="text-right"><?php echo $_smarty_tpl->tpl_vars['loan_history_item']->value->loan_percents_summ;?>
</td>
                                                                            <td>
                                                                                <button type="button"
                                                                                        class="btn btn-xs btn-info js-get-movements"
                                                                                        data-number="<?php echo $_smarty_tpl->tpl_vars['loan_history_item']->value->number;?>
">
                                                                                    Операции
                                                                                </button>
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

                                <div class="tab-pane p-3" id="connexions" role="tabpanel">
                                    <div class="row pb-2">
                                        <div class="col-6">
                                            <h3>Связанные лица</h3>
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-loading btn-info js-run-connexions"
                                                    data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
" type="button">
                                                <i class="fas fa-search"></i>
                                                <span>Искать Совпадения</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="js-app-connexions" data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
">

                                    </div>
                                </div>


                                <div class="tab-pane p-3" id="communications" role="tabpanel">

                                    <h3>Коммуникации с клиентом</h3>
                                    <?php if ($_smarty_tpl->tpl_vars['communications']->value) {?>
                                        <table class="table table-hover table-bordered">
                                            <tbody>
                                            <tr class="table-success">
                                                <th>Дата</th>
                                                <th>Договор</th>
                                                <th>Тип</th>
                                                <th>Пользователь</th>
                                                <th>Орг-я</th>
                                                <th>Номер</th>
                                                <th>Исходящий</th>
                                                <th>Содержание</th>
                                            </tr>
                                            <?php  $_smarty_tpl->tpl_vars['communication'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['communication']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['communications']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['communication']->key => $_smarty_tpl->tpl_vars['communication']->value) {
$_smarty_tpl->tpl_vars['communication']->_loop = true;
?>
                                                <tr class="communication-<?php echo $_smarty_tpl->tpl_vars['communication']->value->order_id;?>
">
                                                    <td>
                                                        <small><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['communication']->value->created);?>
</small>
                                                        <br/>
                                                        <small><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['communication']->value->created);?>
</small>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if ($_smarty_tpl->tpl_vars['communication']->value->order) {?>
                                                            <a href="order/<?php echo $_smarty_tpl->tpl_vars['communication']->value->order_id;?>
" target="_blank">
                                                                <small><?php echo $_smarty_tpl->tpl_vars['communication']->value->order->order_id;?>
</small>
                                                            </a>
                                                        <?php }?>
                                                    </td>
                                                    <td>
                                                        <?php if ($_smarty_tpl->tpl_vars['communication']->value->type=='sms') {?>Смс<?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['communication']->value->type=='zvonobot') {?>Звонобот<?php }?>
                                                        <?php if ($_smarty_tpl->tpl_vars['communication']->value->type=='call') {?>Звонок<?php }?>
                                                    </td>
                                                    <td>
                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['managers']->value[$_smarty_tpl->tpl_vars['communication']->value->manager_id]->name, ENT_QUOTES, 'UTF-8', true);?>

                                                    </td>
                                                    <td>
                                                        <?php if ($_smarty_tpl->tpl_vars['communication']->value->yuk) {?>
                                                            <span class="label label-info">ЮК</span>
                                                        <?php } else { ?>
                                                            <span class="label label-success">МКК</span>
                                                        <?php }?>
                                                    </td>
                                                    <td>
                                                        <?php echo $_smarty_tpl->tpl_vars['communication']->value->to_number;?>

                                                    </td>
                                                    <td>
                                                        <?php echo $_smarty_tpl->tpl_vars['communication']->value->from_number;?>

                                                    </td>
                                                    <td>
                                                        <?php echo $_smarty_tpl->tpl_vars['communication']->value->content;?>

                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <h4>Нет коммуникаций</h4>
                                    <?php }?>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php }?>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

    <?php echo $_smarty_tpl->getSubTemplate ('footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


</div>


<div id="modal_reject_reason" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Отказать в выдаче кредита?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">


                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#reject_mko" role="tab"
                                   aria-controls="home5" aria-expanded="true" aria-selected="true">
                                    <span class="hidden-sm-up"><i class="ti-home"></i></span>
                                    <span class="hidden-xs-down">Отказ МКО</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#reject_client" role="tab"
                                   aria-controls="profile" aria-selected="false">
                                    <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                    <span class="hidden-xs-down">Отказ клиента</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content tabcontent-border p-3" id="myTabContent">
                            <div role="tabpanel" class="tab-pane fade active show" id="reject_mko"
                                 aria-labelledby="home-tab">
                                <form class="js-reject-form">
                                    <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                                    <input type="hidden" name="action" value="reject_order"/>
                                    <input type="hidden" name="status" value="3"/>
                                    <div class="form-group">
                                        <label for="admin_name" class="control-label">Выберите причину отказа:</label>
                                        <select name="reason" class="form-control">
                                            <?php  $_smarty_tpl->tpl_vars['reject_reason'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['reject_reason']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['reject_reasons']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['reject_reason']->key => $_smarty_tpl->tpl_vars['reject_reason']->value) {
$_smarty_tpl->tpl_vars['reject_reason']->_loop = true;
?>
                                                <?php if ($_smarty_tpl->tpl_vars['reject_reason']->value->type=='mko') {?>
                                                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['reject_reason']->value->id, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['reject_reason']->value->admin_name, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                <?php }?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-action clearfix">
                                        <button type="button" class="btn btn-danger btn-lg float-left waves-effect"
                                                data-dismiss="modal">Отменить
                                        </button>
                                        <button type="submit"
                                                class="btn btn-success btn-lg float-right waves-effect waves-light">Да,
                                            отказать
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="reject_client" role="tabpanel" aria-labelledby="profile-tab">
                                <form class="js-reject-form">
                                    <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                                    <input type="hidden" name="action" value="reject_order"/>
                                    <input type="hidden" name="status" value="8"/>
                                    <div class="form-group">
                                        <label for="admin_name" class="control-label">Выберите причину отказа:</label>
                                        <select name="reason" class="form-control">
                                            <?php  $_smarty_tpl->tpl_vars['reject_reason'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['reject_reason']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['reject_reasons']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['reject_reason']->key => $_smarty_tpl->tpl_vars['reject_reason']->value) {
$_smarty_tpl->tpl_vars['reject_reason']->_loop = true;
?>
                                                <?php if ($_smarty_tpl->tpl_vars['reject_reason']->value->type=='client') {?>
                                                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['reject_reason']->value->id, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['reject_reason']->value->admin_name, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                <?php }?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-action clearfix">
                                        <button type="button" class="btn btn-danger btn-lg float-left waves-effect"
                                                data-dismiss="modal">Отменить
                                        </button>
                                        <button type="submit"
                                                class="btn btn-success btn-lg float-right waves-effect waves-light">Да,
                                            отказать
                                        </button>
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

<div id="modal_add_comment" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Добавить комментарий</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_add_comment" action="order/<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
">

                    <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"/>
                    <input type="hidden" name="block" value=""/>
                    <input type="hidden" name="action" value="add_comment"/>

                    <div class="alert" style="display:none"></div>

                    <div class="form-group">
                        <label for="name" class="control-label">Комментарий:</label>
                        <textarea class="form-control" name="text"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mr-sm-2 mb-3">
                            <input class="custom-control-input" type="checkbox" name="official" value="1"
                                   id="official"/>
                            <label for="official" class="custom-control-label">Оффициальный:</label>
                        </div>
                    </div>
                    <div class="form-action">
                        <button type="button" class="btn btn-danger waves-effect js-event-add-click" data-event="70"
                                data-manager="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
" data-order="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"
                                data-user="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
" data-dismiss="modal">Отмена
                        </button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_close_contract" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Закрыть договор</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_close_contract" action="order/<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
">

                    <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"/>
                    <input type="hidden" name="action" value="close_contract"/>

                    <div class="alert" style="display:none"></div>

                    <div class="form-group">
                        <label for="close_date" class="control-label">Дата закрытия:</label>
                        <input type="text" class="form-control" name="close_date" required="" placeholder="ДД.ММ.ГГГГ"
                               value="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier('');?>
"/>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="control-label">Комментарий:</label>
                        <textarea class="form-control" id="comment" name="comment" required=""></textarea>
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

<div id="modal_correct" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header bg-info">
                <h3 class="modal-title text-white text-center">Корректировка</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_correct" action="order/<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
">

                    <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                    <input type="hidden" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->user_id;?>
"/>
                    <input type="hidden" name="action" value="correct"/>

                    <div class="alert" style="display:none"></div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="close_date" class="control-label">ОД:</label>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" name="od" required=""
                                       value="<?php echo $_smarty_tpl->tpl_vars['contract']->value->loan_body_summ;?>
"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="close_date" class="control-label">Проценты:</label>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" name="percents" required=""
                                       value="<?php echo $_smarty_tpl->tpl_vars['contract']->value->loan_percents_summ;?>
"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="close_date" class="control-label">Отв-ть:</label>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" name="charge" required=""
                                       value="<?php echo $_smarty_tpl->tpl_vars['contract']->value->loan_charge_summ;?>
"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="close_date" class="control-label">Пени:</label>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" name="peni" required=""
                                       value="<?php echo $_smarty_tpl->tpl_vars['contract']->value->loan_peni_summ;?>
"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="control-label">Комментарий:</label>
                        <textarea class="form-control" id="comment" name="comment" required=""></textarea>
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

<div id="modal_fssp_info" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Результаты проверки</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>Номер, дата</th>
                        <th>Документ</th>
                        <th>Производство</th>
                        <th>Департамент</th>
                        <th>Закрыт</th>
                    </tr>
                    <tbody class="js-fssp-info-result">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
</div>

<div id="modal_add_penalty" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Оштрафовать</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_add_penalty" action="order/<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
">

                    <input type="hidden" name="order_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->order_id;?>
"/>
                    <input type="hidden" name="manager_id" value="<?php echo $_smarty_tpl->tpl_vars['order']->value->manager_id;?>
"/>
                    <input type="hidden" name="control_manager_id" value="<?php echo $_smarty_tpl->tpl_vars['manager']->value->id;?>
"/>
                    <input type="hidden" name="block" value=""/>
                    <input type="hidden" name="action" value="add_penalty"/>

                    <div class="alert" style="display:none"></div>

                    <div class="form-group">
                        <label for="close_date" class="control-label">Причина:</label>
                        <select name="type_id" class="form-control">
                            <option value=""></option>
                            <?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['t']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['penalty_types']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value) {
$_smarty_tpl->tpl_vars['t']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['t']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['t']->value->name;?>
</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="control-label">Комментарий:</label>
                        <textarea class="form-control" id="comment" name="comment"></textarea>
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

<div id="modal_send_sms" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
                            <div role="tabpanel" class="tab-pane fade active show" id="waiting_reason"
                                 aria-labelledby="home-tab">
                                <form class="js-sms-form">
                                    <input type="hidden" name="user_id" value=""/>
                                    <input type="hidden" name="order_id" value=""/>
                                    <input type="hidden" name="yuk" value=""/>
                                    <input type="hidden" name="action" value="send_sms"/>
                                    <div class="form-group">
                                        <label for="name" class="control-label">Выберите шаблон сообщения:</label>
                                        <select name="template_id" class="form-control">
                                            <?php  $_smarty_tpl->tpl_vars['sms_template'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sms_template']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sms_templates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sms_template']->key => $_smarty_tpl->tpl_vars['sms_template']->value) {
$_smarty_tpl->tpl_vars['sms_template']->_loop = true;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['sms_template']->value->id;?>
"
                                                        title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sms_template']->value->template, ENT_QUOTES, 'UTF-8', true);?>
">
                                                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sms_template']->value->name, ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo $_smarty_tpl->tpl_vars['sms_template']->value->template;?>
)
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-action clearfix">
                                        <button type="button" class="btn btn-danger btn-lg float-left waves-effect"
                                                data-dismiss="modal">Отменить
                                        </button>
                                        <button type="submit"
                                                class="btn btn-success btn-lg float-right waves-effect waves-light">Да,
                                            отправить
                                        </button>
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
