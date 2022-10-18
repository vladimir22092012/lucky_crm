<?php /* Smarty version Smarty-3.1.18, created on 2022-10-10 18:51:56
         compiled from "/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/clients.tpl" */ ?>
<?php /*%%SmartyHeaderCode:33950729063443f9cb18d14-65888097%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bc045cb12843cb23b6e5a2e8531d60a11d6b1d88' => 
    array (
      0 => '/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/clients.tpl',
      1 => 1660295913,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '33950729063443f9cb18d14-65888097',
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
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_63443f9cb447e8_19085710',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_63443f9cb447e8_19085710')) {function content_63443f9cb447e8_19085710($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Клиенты', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['meta_title'] = clone $_smarty_tpl->tpl_vars['meta_title'];?>

<?php $_smarty_tpl->_capture_stack[0][] = array('page_scripts', null, null); ob_start(); ?>
    
    <script type="text/javascript" src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/apps/clients.js"></script>
    

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
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor mb-0 mt-0"><i class="mdi mdi-chart-bubble"></i> Клиенты</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Клиенты</li>
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
                        <h4 class="card-title">Клиенты</h4>
                        <div id="basicgrid" class="jsgrid" style="position: relative; width: 100%;">
                            <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                                <table class="jsgrid-table table table-striped table-hover">
                                    <tr class="jsgrid-header-row">
                                        <th style="width: 60px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='id_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='id_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='id_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'id_desc'),$_smarty_tpl);?>
">ID</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'id_asc'),$_smarty_tpl);?>
">ID</a><?php }?>
                                        </th>
                                        <th style="width: 80px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='date_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='date_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='date_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'date_desc'),$_smarty_tpl);?>
">Дата</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'date_asc'),$_smarty_tpl);?>
">Дата</a><?php }?>
                                        </th>
                                        <th style="width: 120px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='fio_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='fio_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='fio_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'fio_desc'),$_smarty_tpl);?>
">ФИО</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'fio_asc'),$_smarty_tpl);?>
">ФИО</a><?php }?>
                                        </th>
                                        <th style="width: 80px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='birth_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='birth_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='birth_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'birth_desc'),$_smarty_tpl);?>
">Д/Р</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'birth_asc'),$_smarty_tpl);?>
">Д/Р</a><?php }?>
                                        </th>
                                        <th style="width: 100px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='email_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='email_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='email_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'email_desc'),$_smarty_tpl);?>
">Email</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'email_asc'),$_smarty_tpl);?>
">Email</a><?php }?>
                                        </th>
                                        <th style="width: 100px;" class="jsgrid-header-cell jsgrid-header-sortable <?php if ($_smarty_tpl->tpl_vars['sort']->value=='phone_asc') {?>jsgrid-header-sort jsgrid-header-sort-asc<?php } elseif ($_smarty_tpl->tpl_vars['sort']->value=='phone_desc') {?>jsgrid-header-sort jsgrid-header-sort-desc<?php }?>">
                                            <?php if ($_smarty_tpl->tpl_vars['sort']->value=='phone_asc') {?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'phone_desc'),$_smarty_tpl);?>
">Телефон</a>
                                            <?php } else { ?><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>null,'sort'=>'phone_asc'),$_smarty_tpl);?>
">Телефон</a><?php }?>
                                        </th>
                                    </tr>

                                    <tr class="jsgrid-filter-row" id="search_form">                                    
                                        <td style="width: 60px;" class="jsgrid-cell jsgrid-align-right">
                                            <input type="hidden" name="sort" value="<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
" />
                                            <input type="text" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['user_id'];?>
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
                                        <td style="width: 80px;" class="jsgrid-cell jsgrid-align-right">
                                            <input type="text" name="birth" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['birth'];?>
" class="form-control input-sm">
                                        </td>
                                        <td style="width: 100px;" class="jsgrid-cell">
                                            <input type="text" name="email" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['email'];?>
" class="form-control input-sm">
                                        </td>
                                        <td style="width: 100px;" class="jsgrid-cell">
                                            <input type="text" name="phone" value="<?php echo $_smarty_tpl->tpl_vars['search']->value['phone'];?>
" class="form-control input-sm">
                                        </td>
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
                                        <tr class="jsgrid-row ">
                                            <td style="width: 60px;" class="jsgrid-cell jsgrid-align-right">
                                                <a href="client/<?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['client']->value->id;?>
</a>
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <span><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->tpl_vars['client']->value->created);?>
</span>
                                                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->tpl_vars['client']->value->created);?>

                                            </td>
                                            <td style="width: 120px;" class="jsgrid-cell">
                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->lastname, ENT_QUOTES, 'UTF-8', true);?>

                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->firstname, ENT_QUOTES, 'UTF-8', true);?>

                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->patronymic, ENT_QUOTES, 'UTF-8', true);?>

                                                <?php if ($_smarty_tpl->tpl_vars['client']->value->loaded_from_1c) {?><span class="label label-primary">1C</span><?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['client']->value->blocked) {?><span class="label label-danger">Заблокирован</span><?php }?>
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <?php echo $_smarty_tpl->tpl_vars['client']->value->birth;?>

                                            </td>
                                            <td style="width: 100px;" class="jsgrid-cell">
                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->email, ENT_QUOTES, 'UTF-8', true);?>

                                            </td>
                                            <td style="width: 100px;" class="jsgrid-cell">
                                                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['client']->value->phone_mobile, ENT_QUOTES, 'UTF-8', true);?>

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
</div><?php }} ?>
