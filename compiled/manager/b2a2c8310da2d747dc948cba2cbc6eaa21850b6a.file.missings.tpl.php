<?php /* Smarty version Smarty-3.1.18, created on 2022-06-28 21:07:09
         compiled from "/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/missings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:128127410062bb434ded0b68-32438663%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b2a2c8310da2d747dc948cba2cbc6eaa21850b6a' => 
    array (
      0 => '/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/missings.tpl',
      1 => 1656438503,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '128127410062bb434ded0b68-32438663',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'settings' => 0,
    'sort' => 0,
    'search' => 0,
    'clients' => 0,
    'client' => 0,
    'total_pages_num' => 0,
    'current_page_num' => 0,
    'visible_pages' => 0,
    'page_from' => 0,
    'page_to' => 0,
    'p' => 0,
    'sms_templates' => 0,
    'sms_template' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_62bb434df0ea97_34162886',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62bb434df0ea97_34162886')) {function content_62bb434df0ea97_34162886($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Отвалы клиентов', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_scripts', null, null); ob_start(); ?>

    <script type="text/javascript" src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/clients.js"></script>

    <script>
        function MissingsApp()
        {
            var app = this;

            app.init_set_manager = function(){
                $(document).on('click', '.js-set-manager', function(){
                     var $this = $(this);

                     var _user_id = $(this).data('user');

                     $.ajax({
                        type: 'POST',
                        data: {
                            action: 'set_manager',
                            user_id: _user_id
                        },
                        success: function(resp){
                            if (!!resp.error)
                            {
                                Swal.fire({
                                    text: resp.error,
                                    type: 'error',
                                });
                            }
                            else
                            {
console.log($this.closest('.jsgrid-row'))
                                $this.closest('.jsgrid-row').find('.js-close-missing').show();
                                $this.closest('.jsgrid-row').find('.js-missing-manager-name').text(resp.manager_name);
                            }
                        }
                     })
                });
            };

            app.init_close_missing = function(){
            }

            ;(function(){
                app.init_set_manager();
                app.init_close_missing();
            })();
        }
        $(function(){
            new MissingsApp();
        })
    </script>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_styles', null, null); ob_start(); ?>
    <link type="text/css" rel="stylesheet" href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/jsgrid/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/jsgrid/jsgrid-theme.min.css" />
    <style>
        .jsgrid-table { margin-bottom:0}
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
            <div class="col-md-6 col-4 align-self-center">
                <h3 class="text-themecolor mb-0 mt-0">
                    <i class="mdi mdi-sleep"></i>
                    <span>Отвалы клиентов</span>
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Отвалы</li>
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
                        <h4 class="card-title">Отвалы клиентов</h4>
                        <div id="basicgrid" class="jsgrid" style="position: relative; width: 100%;">
                            <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                                <table class="jsgrid-table table table-striped table-hover">
                                    <tr class="jsgrid-header-row">
                                        <th style="width: 100px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='id_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='id_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='id_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'id_desc'),$_smarty_tpl);?>
">ID</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'id_asc'),$_smarty_tpl);?>
">ID</a><?php }?>
                                        </th>
                                        <th style="width: 100px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='id_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='id_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='status_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'status_desc'),$_smarty_tpl);?>
">Статус</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'status_asc'),$_smarty_tpl);?>
">Статус</a><?php }?>
                                        </th>
                                        <th style="width: 80px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='date_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='date_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='date_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'date_desc'),$_smarty_tpl);?>
">Регистрация</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'date_asc'),$_smarty_tpl);?>
">Регистрация</a><?php }?>
                                        </th>
                                        <th style="width: 80px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='date_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='date_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='date_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'date_desc'),$_smarty_tpl);?>
">Посл. действие</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'date_asc'),$_smarty_tpl);?>
">Посл. действие</a><?php }?>
                                        </th>
                                        <th style="width: 120px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='fio_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='fio_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='fio_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'fio_desc'),$_smarty_tpl);?>
">ФИО</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'fio_asc'),$_smarty_tpl);?>
">ФИО</a><?php }?>
                                        </th>
                                        <th style="width: 100px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='phone_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='phone_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='phone_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'phone_desc'),$_smarty_tpl);?>
">Телефон</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'phone_asc'),$_smarty_tpl);?>
">Телефон</a><?php }?>
                                        </th>
                                        <th style="width:150px" class="jsgrid-header-cell ">
                                            <a href="javascript:void(0);">Этапы</a>
                                        </th>
                                    </tr>

                                    <tr class="jsgrid-filter-row" id="search_form">
                                        <td style="width: 100px;" class="jsgrid-cell jsgrid-align-right">
                                            <input type="hidden" name="sort" value="<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
" />
                                            <input type="text" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['user_id'];?>
" class="form-control input-sm">
                                        </td>
                                        <td style="width: 100px;" class="jsgrid-cell jsgrid-align-right">

                                        </td>
                                        <td style="width: 80px;" class="jsgrid-cell jsgrid-align-right">
                                            <input type="text" name="created" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['created'];?>
" class="form-control input-sm">
                                        </td>
                                        <td style="width: 80px;" class="jsgrid-cell jsgrid-align-right">
                                            <input type="text" name="created" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['created'];?>
" class="form-control input-sm">
                                        </td>
                                        <td style="width: 120px;" class="jsgrid-cell jsgrid-align-right">
                                            <input type="text" name="fio" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['fio'];?>
" class="form-control input-sm">
                                        </td>
                                        <td style="width: 100px;" class="jsgrid-cell">
                                            <input type="text" name="phone" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['phone'];?>
" class="form-control input-sm">
                                        </td>
                                        <td style="width: 60px;" class="jsgrid-cell"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="jsgrid-grid-body">
                                <table class="jsgrid-table table table-striped table-hover ">
                                    <tbody>
                                    <?php  $_smarty_tpl->tpl_vars['client'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['client']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['clients']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['client']->key => $_smarty_tpl->tpl_vars['client']->value) {
$_smarty_tpl->tpl_vars['client']->_loop = true;
?>
                                        <tr class="jsgrid-row">
                                            <td style="width: 100px;" class="jsgrid-cell jsgrid-align-right">
                                                <a href="client/<?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
</a>
                                            </td>
                                            <td style="width: 100px;" class="jsgrid-cell jsgrid-align-left">
                                                <?php if (!$_smarty_tpl->tpl_vars['client']->value->missing_status) {?>
                                                <span class="label label-danger">Новая</span>
                                                <a class="js-close-missing float-right btn-xs btn-success btn-rounded" data-user="<?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
" style="cursor:pointer"><i class="text-white fas fa-check"></i> Закрыть</a>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['client']->value->missing_status==1) {?>
                                                <span class="label label-info">Закрыта</span>
                                                <?php }?>
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <span><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['client']->value->created);?>
</span>
                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['client']->value->created);?>

                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <span><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['client']->value->last_stage_date);?>
</span>
                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['client']->value->last_stage_date);?>

                                            </td>
                                            <td style="width: 120px;" class="jsgrid-cell">
                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->lastname, ENT_QUOTES, 'UTF-8', true);?>

                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->firstname, ENT_QUOTES, 'UTF-8', true);?>

                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->patronymic, ENT_QUOTES, 'UTF-8', true);?>

                                            </td>
                                            <td style="width: 100px;" class="jsgrid-cell">
                                                <span class="phone-cell"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->phone_mobile, ENT_QUOTES, 'UTF-8', true);?>
</span>
                                                <button class="js-mango-call mango-call"  data-phone="<?php echo $_smarty_tpl->tpl_vars['client']->value->phone_mobile;?>
"
                                                        title="Выполнить звонок">
                                                    <i class="fas fa-mobile-alt"></i></button>
                                                <button class="js-open-sms-modal mango-call" title="Отправить смс" data-user="<?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
">
                                                    <i class="far fa-share-square"></i>
                                                </button>

                                            </td>
                                            <td style="width: 150px;" class="jsgrid-cell">
                                                <span class="label label-success">Регистрация</span>
                                                <span class="label <?php if ($_smarty_tpl->tpl_vars['client']->value->stage_personal) {?>label-success<?php } else { ?>label-inverse<?php }?>">Перс. инфо</span>
                                                <span class="label <?php if ($_smarty_tpl->tpl_vars['client']->value->stage_passport) {?>label-success<?php } else { ?>label-inverse<?php }?>">Паспорт</span>
                                                <span class="label <?php if ($_smarty_tpl->tpl_vars['client']->value->stage_address) {?>label-success<?php } else { ?>label-inverse<?php }?>">Адрес</span>
                                                <span class="label <?php if ($_smarty_tpl->tpl_vars['client']->value->stage_work) {?>label-success<?php } else { ?>label-inverse<?php }?>">Работа</span>
                                                <span class="label <?php if ($_smarty_tpl->tpl_vars['client']->value->stage_files) {?>label-success<?php } else { ?>label-inverse<?php }?>">Файлы</span>
                                                <span class="label <?php if ($_smarty_tpl->tpl_vars['client']->value->stage_card) {?>label-success<?php } else { ?>label-inverse<?php }?>">Карта</span>
                                                <?php if ($_smarty_tpl->tpl_vars['client']->value->stage_sms_sended) {?>
                                                <span class="label label-primary" title="СМС сообщение отправлено">СМС</span>
                                                <?php }?>
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

                            <div class="jsgrid-pager-container" style="">
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
<?php }} ?>
