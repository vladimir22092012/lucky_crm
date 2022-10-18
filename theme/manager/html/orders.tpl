{if $offline}
    {$meta_title='Список оффлайн заявок' scope=parent}
{else}
    {$meta_title='Список заявок' scope=parent}
{/if}

{capture name='page_scripts'}
    <script src="theme/{$settings->theme|escape}/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="theme/manager/assets/plugins/moment/moment.js"></script>
    <script src="theme/manager/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="theme/manager/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="theme/manager/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="theme/{$settings->theme|escape}/js/apps/orders.js?v=1.11"></script>
    <script type="text/javascript" src="theme/{$settings->theme|escape}/js/apps/order.js?v=1.16"></script>
{/capture}

{capture name='page_styles'}
    <link href="theme/{$settings->theme|escape}/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css"
          rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="theme/{$settings->theme|escape}/assets/plugins/jsgrid/jsgrid.min.css"/>
    <link type="text/css" rel="stylesheet"
          href="theme/{$settings->theme|escape}/assets/plugins/jsgrid/jsgrid-theme.min.css"/>
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

        .workout-row > td {
            background: #b2ffaf !important;
        }

        .workout-row a, .workout-row small, .workout-row span {
            color: #555 !important;
            font-weight: 300;
        }

    </style>
{/capture}

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
                <h3 class="text-themecolor mb-0 mt-0"><i class="mdi mdi-animation"></i> Заявки {if $offline}оффлайн{/if}
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Заявки {if $offline}оффлайн{/if}</li>
                </ol>
            </div>
            <div class="col-md-6 col-4 align-self-center">
                <div class="row">

                    <div class="col-6 dropdown text-right hidden-sm-down js-period-filter">
                        <input type="hidden" value="{$period}" id="filter_period"/>
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-calendar-alt"></i>
                            {if $period == 'today'}Сегодня
                            {elseif $period == 'yesterday'}Вчера
                            {elseif $period == 'week'}На этой неделе
                            {elseif $period == 'month'}В этом месяце
                            {elseif $period == 'year'}В этом году
                            {elseif $period == 'all'}За все время
                            {elseif $period == 'optional'}Произвольный
                            {else}{$period}{/if}

                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item js-period-link {if $period == 'today'}active{/if}"
                               href="{url period='today' page=null}">Сегодня</a>
                            <a class="dropdown-item js-period-link {if $period == 'yesterday'}active{/if}"
                               href="{url period='yesterday' page=null}">Вчера</a>
                            <a class="dropdown-item js-period-link {if $period == 'month'}active{/if}"
                               href="{url period='month' page=null}">В этом месяце</a>
                            <a class="dropdown-item js-period-link {if $period == 'year'}active{/if}"
                               href="{url period='year' page=null}">В этом году</a>
                            <a class="dropdown-item js-period-link {if $period == 'all'}active{/if}"
                               href="{url period='all' page=null}">За все время</a>
                            <a class="dropdown-item js-open-daterange {if $period == 'optional'}active{/if}"
                               href="{url period='optional' page=null}">Произвольный</a>
                        </div>

                        <div class="js-daterange-filter input-group mt-3"
                             {if $period!='optional'}style="display:none"{/if}>
                            <input type="text" name="daterange" class="form-control daterange js-daterange-input"
                                   value="{if $from && $to}{$from}-{$to}{/if}">
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
                        <h4 class="card-title">Список заявок </h4>

                        <div class="clearfix">
                            <div class="js-filter-status mb-2 float-left">
                                <a href="{if $filter_status=='new'}{url status=null page=null}{else}{url status='new' page=null}{/if}"
                                   class="btn btn-xs {if $filter_status=='new'}btn-warning{else}btn-outline-warning{/if}">Новая</a>
                                <a href="{if $filter_status==1}{url status=null page=null}{else}{url status=1 page=null}{/if}"
                                   class="btn btn-xs {if $filter_status==1}btn-info{else}btn-outline-info{/if}">Принята</a>
                                <a href="{if $filter_status==2}{url status=null page=null}{else}{url status=2 page=null}{/if}"
                                   class="btn btn-xs {if $filter_status==2}btn-success{else}btn-outline-success{/if}">Одобрена</a>
                                <a href="{if $filter_status==3}{url status=null page=null}{else}{url status=3 page=null}{/if}"
                                   class="btn btn-xs {if $filter_status==3}btn-danger{else}btn-outline-danger{/if}">Отказ</a>
                                <a href="{if $filter_status==4}{url status=null page=null}{else}{url status=4 page=null}{/if}"
                                   class="btn btn-xs {if $filter_status==4}btn-inverse{else}btn-outline-inverse{/if}">Подписан</a>
                                <a href="{if $filter_status==5}{url status=null page=null}{else}{url status=5 page=null}{/if}"
                                   class="btn btn-xs {if $filter_status==5}btn-primary{else}btn-outline-primary{/if}">Выдан</a>
                                <a href="{if $filter_status==6}{url status=null page=null}{else}{url status=6 page=null}{/if}"
                                   class="btn btn-xs {if $filter_status==6}btn-danger{else}btn-outline-danger{/if}">Не
                                    удалось выдать</a>
                                <a href="{if $filter_status==7}{url status=null page=null}{else}{url status=7 page=null}{/if}"
                                   class="btn btn-xs {if $filter_status==7}btn-inverse{else}btn-outline-inverse{/if}">Погашен</a>
                                <a href="{if $filter_status==8}{url status=null page=null}{else}{url status=8 page=null}{/if}"
                                   class="btn btn-xs {if $filter_status==8}btn-danger{else}btn-outline-danger{/if}">Отказ
                                    клиента</a>
                                {if $filter_status}
                                    <input type="hidden" value="{$filter_status}" id="filter_status"/>
                                {/if}
                            </div>
                            <div class="float-right js-filter-client">
                                <a href="{if $filter_client=='new'}{url client=null page=null}{else}{url client='new' page=null}{/if}"
                                   class="btn btn-xs {if $filter_client=='new'}btn-info{else}btn-outline-info{/if}">Новая</a>
                                <a href="{if $filter_client=='repeat'}{url client=null page=null}{else}{url client='repeat' page=null}{/if}"
                                   class="btn btn-xs {if $filter_client=='repeat'}btn-warning{else}btn-outline-warning{/if}">Повтор</a>
                                <a href="{if $filter_client=='pk'}{url client=null page=null}{else}{url client='pk' page=null}{/if}"
                                   class="btn btn-xs {if $filter_client=='pk'}btn-success{else}btn-outline-success{/if}">ПК</a>
                                {if $filter_client}
                                    <input type="hidden" value="{$filter_client}" id="filter_client"/>
                                {/if}
                            </div>
                        </div>

                        <div id="basicgrid" class="jsgrid" style="position: relative; width: 100%;">
                            <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                                <table class="jsgrid-table table table-striped table-hover">
                                    <tr class="jsgrid-header-row">
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-align-right jsgrid-header-sortable {if $sort == 'order_id_desc'}jsgrid-header-sort jsgrid-header-sort-desc{elseif $sort == 'order_id_asc'}jsgrid-header-sort jsgrid-header-sort-asc{/if}">
                                            {if $sort == 'order_id_asc'}<a href="{url page=null sort='order_id_desc'}">
                                                    ID</a>
                                            {else}<a href="{url page=null sort='order_id_asc'}">ID</a>{/if}
                                        </th>
                                        <th style="width: 70px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'date_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'date_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'date_asc'}<a href="{url page=null sort='date_desc'}">Дата /
                                                Время</a>
                                            {else}<a href="{url page=null sort='date_asc'}">Дата / Время</a>{/if}
                                        </th>
                                        <th style="width: 60px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'amount_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'amount_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'amount_asc'}<a href="{url page=null sort='amount_desc'}">
                                                    Сумма, руб</a>
                                            {else}<a href="{url page=null sort='amount_asc'}">Сумма, руб</a>{/if}
                                        </th>
                                        <th style="width: 50px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'period_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'period_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'period_asc'}<a href="{url page=null sort='period_desc'}">
                                                    Срок</a>
                                            {else}<a href="{url page=null sort='period_asc'}">Срок</a>{/if}
                                        </th>
                                        <th style="width: 150px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'fio_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'fio_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'fio_asc'}<a href="{url page=null sort='fio_desc'}">ФИО</a>
                                            {else}<a href="{url page=null sort='fio_asc'}">ФИО</a>{/if}
                                        </th>
                                        <th style="width: 60px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'birth_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'birth_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'birth_asc'}<a href="{url page=null sort='birth_desc'}">Д/Р</a>
                                            {else}<a href="{url page=null sort='birth_asc'}">Д/Р</a>{/if}
                                        </th>
                                        <th style="width: 80px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'phone_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'phone_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'phone_asc'}<a href="{url page=null sort='phone_desc'}">
                                                    Телефон</a>
                                            {else}<a href="{url page=null sort='phone_asc'}">Телефон</a>{/if}
                                        </th>
                                        <th style="width: 100px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'region_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'region_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'region_asc'}<a href="{url page=null sort='region_desc'}">
                                                    Регион</a>
                                            {else}<a href="{url page=null sort='region_asc'}">Регион</a>{/if}
                                        </th>
                                        <th style="width: 100px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'status_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'status_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'manager_asc'}<a href="{url page=null sort='manager_desc'}">
                                                    Менеджер</a>
                                            {else}<a href="{url page=null sort='manager_asc'}">Менеджер</a>{/if}
                                        </th>
                                        <th style="width: 60px;"
                                            class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'status_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'status_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'manager_asc'}<a href="{url page=null sort='manager_desc'}">
                                                    UTM</a>
                                            {else}<a href="{url page=null sort='manager_asc'}">UTM</a>{/if}
                                        </th>
                                        {if $manager->role == 'quality_control'}
                                            <th style="width: 80px;"
                                                class="jsgrid-header-cell {if $sort == 'penalty_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'penalty_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                                {if $sort == 'penalty_asc'}<a
                                                    href="{url page=null sort='penalty_desc'}">Дата решения</a>
                                                {else}<a href="{url page=null sort='penalty_asc'}">Дата решения</a>{/if}
                                            </th>
                                        {else}
                                            <th style="width: 100px;"
                                                class="jsgrid-header-cell {if $sort == 'scoring_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'scoring_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                                {if $sort == 'scoring_asc'}
                                                    <a href="javascript:void(0);">Скоринг</a>
                                                {else}
                                                    <a href="javascript:void(0);">Скоринг</a>
                                                {/if}
                                            </th>
                                        {/if}
                                    </tr>
                                    <tr class="jsgrid-filter-row" id="search_form">

                                        <td style="width: 70px;" class="jsgrid-cell jsgrid-align-right">
                                            <input type="hidden" name="sort" value="{$sort}"/>
                                            <input type="text" name="order_id" value="{$search['order_id']}"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                            <input type="text" name="date" value="{$search['date']}"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 60px;" class="jsgrid-cell">
                                            <input type="text" name="amount" value="{$search['amount']}"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 50px;" class="jsgrid-cell">
                                            <input type="text" name="period" value="{$search['period']}"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 150px;" class="jsgrid-cell">
                                            <input type="text" name="fio" value="{$search['fio']}"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 60px;" class="jsgrid-cell">
                                            <input type="text" name="birth" value="{$search['birth']}"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 80px;" class="jsgrid-cell">
                                            <input type="text" name="phone" value="{$search['phone']}"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 100px;" class="jsgrid-cell">
                                            <input type="text" name="region" value="{$search['region']}"
                                                   class="form-control input-sm">
                                        </td>
                                        <td style="width: 100px;" class="jsgrid-cell">
                                            <select name="manager_id" class="form-control">
                                                <option value="0"></option>
                                                <option value="none">Без менеджера</option>
                                                {foreach $managers as $m}
                                                    <option value="{$m->id}"
                                                            {if $search['manager_id'] == $m->id}selected{/if}>{$m->name|escape}</option>
                                                {/foreach}
                                            </select>
                                        </td>
                                        <td style="width: 60px;" class="jsgrid-cell">
                                        </td>
                                        {if $manager->role == 'quality_control'}
                                            <td style="width: 80px;" class="jsgrid-cell">
                                            </td>
                                        {else}
                                            <td style="width: 100px;" class="jsgrid-cell">
                                            </td>
                                        {/if}
                                    </tr>
                                </table>
                            </div>
                            <div class="jsgrid-grid-body">
                                <table class="jsgrid-table table table-striped table-hover">
                                    <tbody>
                                    {foreach $orders as $order}
                                        {if !$is_developer && $order->phone_mobile == '79608181253'}
                                            {continue}
                                        {/if}
                                        <tr class="jsgrid-row js-order-row {if $order->quality_workout}workout-row{/if}">
                                            <td style="width: 70px;" class="jsgrid-cell jsgrid-align-right">
                                                <a href="order/{$order->order_id}">{$order->order_id}</a>
                                                {if $order->contract}
                                                    <div>
                                                    <small>{$order->contract->number}</small></div>{/if}
                                                {if $order->contract->outer_id}
                                                    <small>{$order->contract->outer_id}</small>
                                                {/if}
                                                <small>
                                                    {if $order->status == 0}
                                                        <span class="label label-warning">Новая</span>
                                                    {elseif $order->status == 1}
                                                        <span class="label label-info">Принята</span>
                                                    {elseif $order->status == 2}
                                                        <span class="label label-success">Одобрена</span>
                                                    {elseif $order->status == 3}
                                                        <span class="label label-danger" title="{$reasons[$order->reason_id]->admin_name}">Отказ</span>
                                                    {elseif $order->status == 4}
                                                        <span class="label label-inverse">Подписан</span>
                                                    {elseif $order->status == 5}
                                                        <span class="label label-primary">Выдан</span>
                                                    {elseif $order->status == 6}
                                                        <span class="label label-danger">Не удалось выдать</span>
                                                    {elseif $order->status == 7}
                                                        <span class="label label-inverse">Погашен</span>
                                                    {elseif $order->status == 8}
                                                        <span class="label label-danger" title="{$reasons[$order->reason_id]->admin_name}">Отказ клиента</span>
                                                    {/if}
                                                </small>
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                {$order->date|date}
                                                {$order->date|time}
                                            </td>
                                            <td style="width: 60px;" class="jsgrid-cell text-center">
                                                <h5>{$order->amount}</h5>
                                            </td>
                                            <td style="width: 50px;" class="jsgrid-cell">
                                                {if $order->period}
                                                    {$order->period} {$order->period|plural:'день':'дней':'дня'}
                                                {/if}
                                            </td>
                                            <td style="width: 150px;" class="jsgrid-cell">
                                                <a href="client/{$order->user_id}">
                                                    {$order->lastname}
                                                    {$order->firstname}
                                                    {$order->patronymic}
                                                </a>
                                                {if $order->client_status}
                                                    {if $order->client_status == 'pk'}
                                                        <span class="label label-success"
                                                              title="Клиент уже имеет погашенные займы">ПК</span>
                                                    {elseif $order->client_status == 'crm'}
                                                        <span class="label label-primary"
                                                              title="Клиент уже имеет погашенные займы в CRM">ПК CRM</span>
                                                    {elseif $order->client_status == 'rep'}
                                                        <span class="label label-warning"
                                                              title="Клиент уже подавал ранее заявки">Повтор</span>
                                                    {elseif $order->client_status == 'nk'}
                                                        <span class="label label-info" title="Новый клиент">Новая</span>
                                                    {/if}
                                                {else}
                                                    {if $order->have_crm_closed}
                                                        <span class="label label-primary"
                                                              title="Клиент уже имеет погашенные займы в CRM">ПК CRM</span>
                                                    {elseif $order->first_loan}
                                                        <span class="label label-info" title="Новый клиент">Новая</span>
                                                    {else}
                                                        <span class="label label-success"
                                                              title="Клиент уже имеет погашенные займы">ПК</span>
                                                    {/if}
                                                {/if}
                                                {if $order->autoretry}
                                                    <span class="label label-danger" title="">Авторешение</span>
                                                {/if}
                                                {if $order->antirazgon}
                                                    <span class="label label-danger"
                                                          title="">АвтоАнтиРазгон {if $order->antirazgon == 1}0-2{elseif $order->antirazgon == 2}3-5{elseif $order->antirazgon == 3}6-10{/if}</span>
                                                {/if}
                                            </td>
                                            <td style="width: 60px;" class="jsgrid-cell">
                                                {$order->birth}
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                {$order->phone_mobile}
                                                <button class="js-mango-call mango-call"
                                                        data-phone="{$order->phone_mobile}" title="Выполнить звонок"><i
                                                            class="fas fa-mobile-alt"></i></button>
                                            </td>
                                            <td style="width: 100px;" class="jsgrid-cell">
                                                {$order->Regregion}
                                            </td>
                                            <td style="width: 100px;" class="jsgrid-cell">
                                                {$managers[$order->manager_id]->name|escape}
                                                {if $is_developer}
                                                <div><small class="text-danger">{$reasons[$order->reason_id]->admin_name}</small></div>
                                                {/if}
                                            </td>
                                            <td style="width: 60px;" class="jsgrid-cell">
                                                {if $order->utm_source}
                                                    {foreach $integrations as $integration}
                                                        {if $integration->utm_source == $order->utm_source}
                                                            <span class="label label-info">{$integration->name}</span>
                                                        {/if}
                                                    {/foreach}
                                                    {else}
                                                    <span class="label label-info">Не опр</span>
                                                {/if}
                                            </td>
                                            {if $manager->role == 'quality_control'}
                                                <td style="width: 80px;" class="jsgrid-cell">
                                                    {if $order->penalty_date}
                                                        {$order->penalty_date|date}
                                                        {$order->penalty_date|time}
                                                    {/if}

                                                    <div class="custom-checkbox mt-1 custom-control">
                                                        <input id="workout_{$order->order_id}" type="checkbox"
                                                               class="custom-control-input js-workout-input"
                                                               value="{$order->order_id}" name="workout"
                                                               {if $order->quality_workout}checked="true"{/if} />
                                                        <label for="workout_{$order->order_id}"
                                                               class="custom-control-label">
                                                            <small>Проверен</small>
                                                        </label>
                                                    </div>
                                                </td>
                                            {else}
                                                <td style="width: 100px;padding:0" class="jsgrid-cell">
                                                    <div style="max-height:128px;padding:5px 0 5px 5px;;overflow-y:auto;overflow-x:hidden">
                                                        {foreach $order->scorings as $sc}
                                                            <span {if $sc->string_result}data-toggle="tooltip"
                                                                  title="{$sc->string_result|escape} {if $sc->type == 'scorista'}{$sc->scorista_ball}{/if}"{/if}
                                                                  class="label label-sm 
                                                                    {if in_array($sc->status, ['repeat','new','process','import'])}label-info
                                                                    {elseif $sc->status=='completed' && $sc->success}label-success
                                                                    {elseif $sc->status=='completed' && !$sc->success}label-danger
                                                                    {elseif in_array($sc->status,['stopped', 'error'])}label-warning
                                                                    {else}label-primary{/if}
                                                                  ">{$scoring_types[$sc->type]->short_title|escape}</span>
                                                        {/foreach}
                                                    </div>
                                                </td>
                                            {/if}
                                        </tr>
                                    {/foreach}
                                    </tbody>
                                </table>
                            </div>

                            {include file='pagination.tpl'}

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
    {include file='footer.tpl'}
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>