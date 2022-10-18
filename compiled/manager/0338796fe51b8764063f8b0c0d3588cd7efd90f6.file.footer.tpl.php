<?php /* Smarty version Smarty-3.1.18, created on 2022-06-28 20:58:39
         compiled from "/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:101628226962bb414f874c99-13574878%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0338796fe51b8764063f8b0c0d3588cd7efd90f6' => 
    array (
      0 => '/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/footer.tpl',
      1 => 1656438502,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '101628226962bb414f874c99-13574878',
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
  'unifunc' => 'content_62bb414f877891_17539558',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62bb414f877891_17539558')) {function content_62bb414f877891_17539558($_smarty_tpl) {?><footer class="footer">
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
