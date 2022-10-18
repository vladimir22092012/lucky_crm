<?php /* Smarty version Smarty-3.1.18, created on 2022-10-10 18:52:06
         compiled from "/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/collector_clients.tpl" */ ?>
<?php /*%%SmartyHeaderCode:193219227063443fa64da9c0-40078737%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e9537229ed2adce0b9cd5d192acc23ba95becc66' => 
    array (
      0 => '/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/collector_clients.tpl',
      1 => 1660295913,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '193219227063443fa64da9c0-40078737',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'date_from' => 0,
    'date_to' => 0,
    'filter_status' => 0,
    'collection_statuses' => 0,
    'manager_id' => 0,
    'managers' => 0,
    'from' => 0,
    'to' => 0,
    'm' => 0,
    'cs_id' => 0,
    'cs_name' => 0,
    'contracts' => 0,
    'count_od' => 0,
    'count_percents' => 0,
    'is_developer' => 0,
    'contract' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_63443fa64f4de3_81927855',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_63443fa64f4de3_81927855')) {function content_63443fa64f4de3_81927855($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Перебросы клиентов', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_scripts', null, null); ob_start(); ?>
    <script src="theme/manager/assets/plugins/moment/moment.js"></script>
    <script src="theme/manager/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="theme/manager/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="theme/manager/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
        $(function () {
            $('.daterange').daterangepicker({
                autoApply: true,
                locale: {
                    format: 'DD.MM.YYYY'
                },
                default: ''
            }, function(start, end, label) {
                /*
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                $.ajax({
                  method: "POST",
                  dataType: "json",
                  data: {
                    "datepick": 1,
                    "start": start.format('YYYY-MM-DD'),
                    "end": end.format('YYYY-MM-DD')
                  },
                  success: function(data) {
                    console.log(data);
                    $("#manager_list").replaceWith(data.str);
                  },
                  error: function(er) {
                    console.log(er);
                  }
                });
                */
                
//                 $('#filter_form').submit()
            });

        })
    </script>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_styles', null, null); ob_start(); ?>
    <link href="theme/manager/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Daterange picker plugins css -->
    <link href="theme/manager/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="theme/manager/assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">
    <style>
        .table td {
        / / text-align: center !important;
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
                    <i class="mdi mdi-file-chart"></i>
                    <span>Перебросы клиентов</span>
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item">Коллекшин</li>
                    <li class="breadcrumb-item active">Перебросы клиентов</li>
                </ol>
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
                        <h4 class="card-title">Перебросы клиентов 
                            <?php if ($_smarty_tpl->tpl_vars['date_from']->value) {?><a class="btn btn-sm btn-outline-primary"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['date_from']->value);?>
 - <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['date_to']->value);?>
</a><?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['filter_status']->value) {?><a class="btn btn-sm btn-outline-primary"><?php echo $_smarty_tpl->tpl_vars['collection_statuses']->value[$_smarty_tpl->tpl_vars['filter_status']->value];?>
</a><?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['manager_id']->value) {?><a class="btn btn-sm btn-outline-primary"><?php echo $_smarty_tpl->tpl_vars['managers']->value[$_smarty_tpl->tpl_vars['manager_id']->value]->name;?>
</a><?php }?>
                        </h4>
                        <form id="filter_form" class="pb-3">
                            <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['filter_status']->value;?>
" name="status" />
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-6 col-md-5">
                                            <div class="input-group mb-3">
                                                <input id="input_daterange" type="text" name="daterange" class="form-control daterange" 
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
                                        <div class="col-6 col-md-5">
                                            <div class="input-group mb-3">
                                                <select id="manager_list" name="manager_id" class="form-control" onchange="$('#filter_form').submit()">
                                                    <option value="" <?php if (!$_smarty_tpl->tpl_vars['manager_id']->value) {?>selected<?php }?>></option>
                                                    <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['managers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value) {
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                                                        <?php if ($_smarty_tpl->tpl_vars['m']->value->role=='collector') {?>
                                                            <option value="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['m']->value->id==$_smarty_tpl->tpl_vars['manager_id']->value) {?>selected<?php }?>>
                                                                <?php echo $_smarty_tpl->tpl_vars['m']->value->name;?>
 (<?php echo $_smarty_tpl->tpl_vars['collection_statuses']->value[$_smarty_tpl->tpl_vars['m']->value->collection_status_id];?>
)
                                                            </option>
                                                        <?php }?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
    
    
                                        <div class="col-12 col-md-2">
                                            <button type="submit" class="btn btn-info">Сформировать</button>
                                        </div>
                                        
                                        <div class="col-12  col-md-12">
                                            <div class="float-left js-filter-client">
                                                <?php  $_smarty_tpl->tpl_vars['cs_name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cs_name']->_loop = false;
 $_smarty_tpl->tpl_vars['cs_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['collection_statuses']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cs_name']->key => $_smarty_tpl->tpl_vars['cs_name']->value) {
$_smarty_tpl->tpl_vars['cs_name']->_loop = true;
 $_smarty_tpl->tpl_vars['cs_id']->value = $_smarty_tpl->tpl_vars['cs_name']->key;
?>
                                                    <?php if ($_smarty_tpl->tpl_vars['filter_status']->value==$_smarty_tpl->tpl_vars['cs_id']->value) {?>
                                                    <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>null),$_smarty_tpl);?>
" class="btn btn-xs btn-success" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cs_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</a>
                                                    <?php } else { ?>
                                                    <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('status'=>$_smarty_tpl->tpl_vars['cs_id']->value),$_smarty_tpl);?>
" class="btn btn-xs btn-outline-success" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cs_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</a>
                                                    <?php }?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($_smarty_tpl->tpl_vars['from']->value) {?>
                                    <div class="col-4">
                                        <div class="card card-inverse card-info">

                                            <div class="box bg-info text-center">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <h5 class="text-center pt-2">Договоров:</h5>
                                                        <h3 class="text-white text-center"><?php echo count($_smarty_tpl->tpl_vars['contracts']->value);?>
</h3>
                                                    </div>
                                                    <div class="col-4">
                                                        <h5 class="text-center pt-2">ОД: </h5>
                                                        <h3 class="text-white text-center"><?php echo $_smarty_tpl->tpl_vars['count_od']->value;?>
</h3>
                                                    </div>
                                                    <div class="col-4">
                                                        <h5 class="text-center pt-2">Проценты: </h5>
                                                        <h3 class="text-white text-center"><?php echo $_smarty_tpl->tpl_vars['count_percents']->value;?>
</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>

                        </form>

                        <?php if ($_smarty_tpl->tpl_vars['from']->value) {?>
                            <div class="row">
                                <div class="col-8"></div>
                            </div>
                            <table class="table table-hover table-bordered">

                                <tr class="table-primary">
                                    <th>#</th>
                                    <th class="text-center">Дата</th>
                                    <th>ФИО</th>
                                    <th>Договор</th>
                                    <th class="text-center">ОД</th>
                                    <th class="text-center">Проценты</th>
                                    <th>Ответственный</th>
                                    <?php if ($_smarty_tpl->tpl_vars['is_developer']->value) {?>
                                    <th>След. действие</th>
                                    <?php }?>
                                </tr>

                                <?php  $_smarty_tpl->tpl_vars['contract'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['contract']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['contracts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['contract']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['contract']->key => $_smarty_tpl->tpl_vars['contract']->value) {
$_smarty_tpl->tpl_vars['contract']->_loop = true;
 $_smarty_tpl->tpl_vars['contract']->iteration++;
?>
                                    <tr>
                                        <td><?php echo $_smarty_tpl->tpl_vars['contract']->iteration;?>
</td>
                                        <td class="text-center"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['contract']->value->from_date);?>
</td>
                                        <td>
                                            <small><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['contract']->value->lastname, ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['contract']->value->firstname, ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['contract']->value->patronymic, ENT_QUOTES, 'UTF-8', true);?>
</small>
                                            <br />
                                            <small><?php echo $_smarty_tpl->tpl_vars['contract']->value->birth;?>
</small>
                                        </td>
                                        <td>
                                            <a target="_blank" href="collector_contract/<?php echo $_smarty_tpl->tpl_vars['contract']->value->id;?>
">
                                                <?php echo $_smarty_tpl->tpl_vars['contract']->value->number;?>

                                            </a>
                                            <br/>
                                            <small><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['contract']->value->inssuance_date);?>
</small>
                                        </td>
                                        <td class="text-center">
                                            <h3 class="text-primary"><?php echo $_smarty_tpl->tpl_vars['contract']->value->summ_body;?>
</h3>
                                        </td>
                                        <td class="text-center">
                                            <h3 class="text-primary"><?php echo $_smarty_tpl->tpl_vars['contract']->value->summ_percents;?>
</h3>
                                        </td>
                                        <td>
                                        <?php if ($_smarty_tpl->tpl_vars['contract']->value->manager_id) {?>
                                            <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['managers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value) {
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
                                                <?php if ($_smarty_tpl->tpl_vars['m']->value->id==$_smarty_tpl->tpl_vars['contract']->value->manager_id) {?>
                                                    <small><?php echo $_smarty_tpl->tpl_vars['m']->value->name;?>
</small>
                                                <?php }?>
                                            <?php } ?>
                                        <?php }?>
                                        </td>
                                        <?php if ($_smarty_tpl->tpl_vars['is_developer']->value) {?>
                                        <td>
                                            <?php if ($_smarty_tpl->tpl_vars['contract']->value->next_moving) {?>
                                            <small class="text-info">
                                                Переход(<?php echo $_smarty_tpl->tpl_vars['collection_statuses']->value[$_smarty_tpl->tpl_vars['contract']->value->next_moving->collection_status];?>
): 
                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['contract']->value->next_moving->from_date);?>

                                            </small><br />
                                            <?php } elseif ($_smarty_tpl->tpl_vars['contract']->value->next_payment) {?>
                                            <small class="text-success">
                                                Оплата(<?php echo $_smarty_tpl->tpl_vars['managers']->value[$_smarty_tpl->tpl_vars['contract']->value->next_payment->manager_id]->name;?>
): <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['contract']->value->next_payment->created);?>

                                            </small>
                                            <?php }?>
                                        </td>
                                        <?php }?>
                                    </tr>
                                <?php } ?>
                                <tr class="bg-info text-white">
                                    <td colspan="2"><strong>Итого</strong></td>

                                    <td>
                                        Договоров:
                                        <strong><?php echo count($_smarty_tpl->tpl_vars['contracts']->value);?>
</strong>
                                    </td>
                                    <td>
                                    </td>
                                    <td class="text-center">
                                        <h4 class="text-white"><?php echo $_smarty_tpl->tpl_vars['count_od']->value;?>
</h4>
                                    </td>
                                    <td class="text-center">
                                        <h4 class="text-white"><?php echo $_smarty_tpl->tpl_vars['count_percents']->value;?>
</h4>
                                    </td>
                                    <td></td>
                                </tr>

                            </table>
                        <?php } else { ?>
                            <div class="alert alert-info mt-5">
                                <h4>Укажите даты для формирования отчета</h4>
                            </div>
                        <?php }?>

                    </div>
                </div>
                <!-- Column -->
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
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
</div><?php }} ?>
