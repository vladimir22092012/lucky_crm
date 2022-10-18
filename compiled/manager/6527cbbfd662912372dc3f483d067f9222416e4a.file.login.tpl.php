<?php /* Smarty version Smarty-3.1.18, created on 2022-06-28 20:57:03
         compiled from "/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14567233162bb40efe667f5-17795991%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6527cbbfd662912372dc3f483d067f9222416e4a' => 
    array (
      0 => '/home/e/ecofinance/rubl_crm/public_html/theme/manager/html/login.tpl',
      1 => 1656438502,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14567233162bb40efe667f5-17795991',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'settings' => 0,
    'select_offline_point' => 0,
    'error' => 0,
    'login' => 0,
    'offline_points' => 0,
    'point' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_62bb40efea62d9_81315235',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62bb40efea62d9_81315235')) {function content_62bb40efea62d9_81315235($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['wrapper'] = new Smarty_variable('', null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['wrapper'] = clone $_smarty_tpl->tpl_vars['wrapper'];?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <base href="<?php echo $_smarty_tpl->tpl_vars['config']->value->root_url;?>
/" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Вход в панель управления</title>

    <!-- Bootstrap Core CSS -->
    <link href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/css/colors/default.css" id="theme" rel="stylesheet">
    <!-- Custom CSS -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="login-register login-sidebar"  style="background-image:url(theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/images/background/login-register.jpg);" >
            <div class="login-box card">
            <div class="card-body">

                <?php if (!$_smarty_tpl->tpl_vars['select_offline_point']->value) {?>

                <form class="form-horizontal form-material" id="loginform" method="POST">

                    <div class="text-center mt-3" >
                        <img src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/images/logo.png" alt="homepage" class="dark-logo" />
                    </div>

                    <?php if ($_smarty_tpl->tpl_vars['error']->value) {?>
                    <div class="alert alert-danger mt-5">
                        <?php if ($_smarty_tpl->tpl_vars['error']->value=='login_incorrect') {?>Логин или пароль не совпадают
                        <?php } else { ?><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
<?php }?>
                    </div>
                    <?php }?>

                    <div class="form-group mt-5">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" name="login" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['login']->value, ENT_QUOTES, 'UTF-8', true);?>
" placeholder="Логин"> </div>
                        </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" name="password" placeholder="Пароль"> </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary float-left pt-0">
                                <input id="checkbox-signup" type="checkbox" name="remember" value="1">
                                <label for="checkbox-signup"> Запомнить меня </label>
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-group text-center mt-3">
                        <div class="col-xs-12">
                            <button class="btn btn-outline-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Войти</button>
                        </div>
                    </div>
                </form>

                <?php } else { ?>

                <form class="form-horizontal form-material" id="offlineform" method="POST">

                    <input type="hidden" name="offline_form" value="1" />

                    <div class="text-center mt-3" >
                        <img src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/images/logo.png" alt="homepage" class="dark-logo" />
                    </div>

                    <?php if ($_smarty_tpl->tpl_vars['error']->value) {?>
                    <div class="alert alert-danger mt-5">
                        <?php if ($_smarty_tpl->tpl_vars['error']->value=='login_incorrect') {?>Логин или пароль не совпадают
                        <?php } else { ?><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
<?php }?>
                    </div>
                    <?php }?>

                    <div class="form-group mt-5">
                        <div class="col-xs-12">
                            <label>Выберите отделение</label>
                            <select name="offline_point_id" class="form-control">
                                <option value=""></option>
                                <?php  $_smarty_tpl->tpl_vars['point'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['point']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['offline_points']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['point']->key => $_smarty_tpl->tpl_vars['point']->value) {
$_smarty_tpl->tpl_vars['point']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['point']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['point']->value->city;?>
 <?php echo $_smarty_tpl->tpl_vars['point']->value->address;?>
</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group text-center mt-3">
                        <div class="col-xs-12">
                            <button class="btn btn-outline-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Выбрать</button>
                        </div>
                    </div>
                </form>

                <?php }?>

            </div>
          </div>

    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/js/custom.min.js"></script>
    <!-- ============================================================== -->

    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="theme/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value->theme, ENT_QUOTES, 'UTF-8', true);?>
/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>
<?php }} ?>
