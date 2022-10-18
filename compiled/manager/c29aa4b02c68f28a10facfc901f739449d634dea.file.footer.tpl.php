<?php /* Smarty version Smarty-3.1.18, created on 2022-10-10 08:31:08
         compiled from "/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10187808996343ae1ceb0500-25002355%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c29aa4b02c68f28a10facfc901f739449d634dea' => 
    array (
      0 => '/home/e/ecofinance/lucky_crm/public_html/theme/manager/html/footer.tpl',
      1 => 1660295914,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10187808996343ae1ceb0500-25002355',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'manager' => 0,
    'offline_points' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_6343ae1ceb3976_02582851',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6343ae1ceb3976_02582851')) {function content_6343ae1ceb3976_02582851($_smarty_tpl) {?><footer class="footer">
    <div class="float-left">
    © <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier('','Y');?>
 <!--strong style="color:#00b5ff">FIN</strong><strong style="color:#ff8202">FIVE</strong-->
    </div>
    <div class="float-right">
    
    <?php if ($_smarty_tpl->tpl_vars['manager']->value->offline_point_id) {?>
        <?php echo $_smarty_tpl->tpl_vars['offline_points']->value[$_smarty_tpl->tpl_vars['manager']->value->offline_point_id]->city;?>

        <?php echo $_smarty_tpl->tpl_vars['offline_points']->value[$_smarty_tpl->tpl_vars['manager']->value->offline_point_id]->address;?>

    <?php }?>
    </div>
</footer><?php }} ?>
