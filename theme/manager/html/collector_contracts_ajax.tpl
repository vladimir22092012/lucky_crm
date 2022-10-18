
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
                        {if in_array($manager->role, ['developer', 'admin', 'chief_collector', 'team_collector'])}
                        <button class="btn btn-primary js-distribute-open float-right" type="button"><i class="mdi mdi-account-convert"></i> Распределить</button>
                        {/if}
                    </div>

                    <div class="col-6 dropdown text-right hidden-sm-down js-period-filter">
                        <input type="hidden" value="{$period}" id="filter_period" />
                        <button class="btn btn-secondary dropdown-toggle float-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-calendar-alt"></i>
                            {if $period == 'month'}В этом месяце
                            {elseif $period == 'year'}В этом году
                            {elseif $period == 'all'}За все время
                            {elseif $period == 'optional'}Произвольный
                            {else}{$period}{/if}

                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item js-period-link {if $period == 'month'}active{/if}" href="{url period='month' page=null}">В этом месяце</a>
                            <a class="dropdown-item js-period-link {if $period == 'year'}active{/if}" href="{url period='year' page=null}">В этом году</a>
                            <a class="dropdown-item js-period-link {if $period == 'all'}active{/if}" href="{url period='all' page=null}">За все время</a>
                            <a class="dropdown-item js-open-daterange {if $period == 'optional'}active{/if}" href="{url period='optional' page=null}">Произвольный</a>
                        </div>

                        <div class="js-daterange-filter input-group mb-3" {if $period!='optional'}style="display:none"{/if}>
                            <input type="text" name="daterange" class="form-control daterange js-daterange-input" value="{if $from && $to}{$from}-{$to}{/if}">
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

                                {foreach $collection_statuses as $cs_id => $cs_name}
                                    <a href="{if $filter_status==$cs_id}{url status=null page=null}{else}{url status=$cs_id page=null}{/if}" class="btn btn-xs {if $filter_status==$cs_id}btn-success{else}btn-outline-success{/if}">{$cs_name|escape}</a>
                                {/foreach}

                            </div>

                        </div>

                        <div id="basicgrid" class="jsgrid" style="position: relative; width: 100%;">
                            <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                                <table class="jsgrid-table table table-hover">
                                    <tr class="jsgrid-header-row">
                                        <th style="width:20px;" class="jsgrid-header-cell">
                                            #
                                            <input id="filter_status" value="{$filter_status}" type="hidden" />
                                        </th>
                                        {if in_array($manager->role, ['developer', 'admin', 'chief_collector', 'team_collector'])}
                                        <th style="width:80px" class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'manager_id_desc'}jsgrid-header-sort jsgrid-header-sort-desc{elseif $sort == 'manager_id_asc'}jsgrid-header-sort jsgrid-header-sort-asc{/if}">
                                            {if $sort == 'manager_id_asc'}<a href="{url page=null sort='manager_id_desc'}">Пользователь</a>
                                            {else}<a href="{url page=null sort='manager_id_asc'}">Пользователь</a>{/if}
                                        </th>
                                        {/if}
                                        <th style="width: 120px;" class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'fio_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'fio_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'fio_asc'}<a href="{url page=null sort='fio_desc'}">ФИО</a>
                                            {else}<a href="{url page=null sort='fio_asc'}">ФИО</a>{/if}
                                        </th>
                                        <th style="width: 70px;" class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'body_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'body_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'body_asc'}<a href="{url page=null sort='body_desc'}">ОД, руб</a>
                                            {else}<a href="{url page=null sort='body_asc'}">ОД, руб</a>{/if}
                                        </th>
                                        <th style="width: 70px;" class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'percents_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'percents_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'percents_asc'}<a href="{url page=null sort='percents_desc'}">%, руб</a>
                                            {else}<a href="{url page=null sort='percents_asc'}">%, руб</a>{/if}
                                        </th>
                                        <th style="width: 70px;" class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'total_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'total_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'total_asc'}<a href="{url page=null sort='total_desc'}">Итог, руб</a>
                                            {else}<a href="{url page=null sort='total_asc'}">Итог, руб</a>{/if}
                                        </th>
                                        {if in_array($manager->role, ['developer', 'admin', 'chief_collector', 'team_collector'])}
                                        <th style="width: 70px;" class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'total_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'total_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'total_asc'}<a href="{url page=null sort='total_desc'}">Переплата Х</a>
                                            {else}<a href="{url page=null sort='total_asc'}">Переплата Х</a>{/if}
                                        </th>
                                        {/if}
                                        <th style="width: 80px;" class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'phone_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'phone_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'phone_asc'}<a href="{url page=null sort='phone_desc'}">Телефон</a>
                                            {else}<a href="{url page=null sort='phone_asc'}">Телефон</a>{/if}
                                        </th>
                                        <th style="width: 70px;" class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'return_asc'}jsgrid-header-sort jsgrid-header-sort-desc{elseif $sort == 'return_desc'}jsgrid-header-sort jsgrid-header-sort-asc{/if}">
                                            {if $sort == 'return_asc'}<a href="{url page=null sort='return_desc'}">Просрочен</a>
                                            {else}<a href="{url page=null sort='return_asc'}">Просрочен</a>{/if}
                                        </th>
                                        <th style="width: 80px;" class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'return_asc'}jsgrid-header-sort jsgrid-header-sort-desc{elseif $sort == 'return_desc'}jsgrid-header-sort jsgrid-header-sort-asc{/if}">
                                            {if $sort == 'return_asc'}<a href="{url page=null sort='return_desc'}">Дата платежа</a>
                                            {else}<a href="{url page=null sort='return_asc'}">Дата платежа</a>{/if}
                                        </th>
                                        <th style="width: 80px;" class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'tag_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'tag_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
                                            {if $sort == 'tag_asc'}<a href="{url page=null sort='tag_desc'}">Тег</a>
                                            {else}<a href="{url page=null sort='tag_asc'}">Тег</a>{/if}
                                        </th>
                                        <th style="width: 140px;" class="jsgrid-header-cell jsgrid-header-sortable {if $sort == 'birth_asc'}jsgrid-header-sort jsgrid-header-sort-asc{elseif $sort == 'birth_desc'}jsgrid-header-sort jsgrid-header-sort-desc{/if}">
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
                                        {*}
                                        <td style="width: 60px;" class="jsgrid-cell jsgrid-align-right">
                                            <input type="hidden" name="sort" value="{$sort}" />
                                            <input type="text" name="order_id" value="{$search['order_id']}" class="form-control input-sm">
                                        </td>
                                        {*}
                                        {if in_array($manager->role, ['developer', 'admin', 'chief_collector', 'team_collector'])}
                                        <td style="width: 80px;" class="jsgrid-cell">
                                            <select class="form-control" name="manager_id">
                                                <option value="0"></option>
                                                {foreach $managers as $m}
                                                {if (in_array($manager->role, ['developer', 'admin', 'chief_collector']) && $m->role=='collector') || ($manager->role == 'team_collector' && in_array($m->id, (array)$manager->team_id))}
                                                <option value="{$m->id}">{$m->name|escape} ({$collection_statuses[$m->collection_status_id]})</option>
                                                {/if}
                                                {/foreach}
                                            </select>
                                        </td>
                                        {/if}
                                        <td style="width: 120px;" class="jsgrid-cell">
                                            <input type="text" name="fio" value="{$search['fio']}" class="form-control input-sm">
                                        </td>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                            <div class="row no-gutter">
                                                <div class="col-6 pr-0">
                                                    <input type="text" placeholder="c" name="od_from" value="{$search['od_from']}" class="form-control input-sm">
                                                </div>
                                                <div class="col-6 pl-0">
                                                    <input type="text" name="od_to" placeholder="по" value="{$search['od_to']}" class="form-control input-sm">
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                            <div class="row no-gutter">
                                                <div class="col-6 pr-0">
                                                    <input type="text" placeholder="c" name="percents_from" value="{$search['percents_from']}" class="form-control input-sm">
                                                </div>
                                                <div class="col-6 pl-0">
                                                    <input type="text" name="percents_to" placeholder="по" value="{$search['percents_to']}" class="form-control input-sm">
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                            <div class="row no-gutter">
                                                <div class="col-6 pr-0">
                                                    <input type="text" placeholder="c" name="total_from" value="{$search['total_from']}" class="form-control input-sm">
                                                </div>
                                                <div class="col-6 pl-0">
                                                    <input type="text" name="total_to" placeholder="по" value="{$search['total_to']}" class="form-control input-sm">
                                                </div>
                                            </div>
                                        </td>
                                        {if in_array($manager->role, ['developer', 'admin', 'chief_collector', 'team_collector'])}
                                        <td style="width: 70px;" class="jsgrid-cell">
                                        </td>
                                        {/if}
                                        <td style="width: 80px;" class="jsgrid-cell">
                                            <input type="text" name="phone" value="{$search['phone']}" class="form-control input-sm">
                                        </td>
                                        <td style="width: 70px;" class="jsgrid-cell">
                                            <div class="row no-gutter">
                                                <div class="col-6 pr-0">
                                                    <input type="text" placeholder="c" name="delay_from" value="{$search['delay_from']}" class="form-control input-sm">
                                                </div>
                                                <div class="col-6 pl-0">
                                                    <input type="text" name="delay_to" placeholder="по" value="{$search['delay_to']}" class="form-control input-sm">
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 80px;" class="jsgrid-cell">

                                        </td>
                                        <td style="width: 80px;" class="jsgrid-cell">
                                            <select class="form-control" name="tag_id">
                                                <option value="0"></option>
                                                {foreach $collector_tags as $t}
                                                <option value="{$t->id}">{$t->name|escape}</option>
                                                {/foreach}
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
                                    {$shift = ($current_page_num - 1) * $items_per_page}

                                    {foreach $contracts as $contract}

                                        {$have_contactperson_search = 0}
                                        {foreach $contract->contactpersons as $cp}
                                            {if $search['phone'] && $search['phone'] != $contract->order->phone_mobile}
                                                {$have_contactperson_search = 1}
                                            {/if}
                                        {/foreach}

                                        <style>
                                            .contract-row-{$contract->id} td {
                                                background:{$collector_tags[$contract->order->contact_status]->color}33!important;

                                            }
                                        </style>
                                        <tr class="jsgrid-row js-contract-row contract-row-{$contract->id} {if $contract->collection_workout}workout-row{/if}" data-contract="{$contract->id}">
                                            <td style="width:20px" class="jsgrid-cell text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" class="custom-control-input js-contract-check" id="contract_{$contract->id}" value="{$contract->id}" />
                                                    <label for="contract_{$contract->id}" class="custom-control-label"> </label>
                                                </div>
                                                {($contract@iteration)+$shift}
                                            </td>
                                            {*}
                                            <td style="width: 60px;" class="jsgrid-cell jsgrid-align-right">
                                                <div class="button-toggle-wrapper">
                                                    <button class="js-open-contract button-toggle" data-id="{$contract->id}" type="button" title="Подробнее"></button>
                                                </div>
                                                <a href="my_contract/{$contract->order->order_id}">
                                                    {$contract->order->order_id}
                                                </a>
                                                <span class="label label-primary">{$collection_statuses[$contract->collection_status]}</span>
                                                {if $contract->sud}
                                                <span class="label label-danger">Суд</span>
                                                {/if}
                                            </td>
                                            {*}
                                            {if in_array($manager->role, ['developer', 'admin', 'chief_collector', 'team_collector'])}
                                            <td style="width:80px" class="jsgrid-cell">
                                                <div class="js-open-hide js-dopinfo-{$contract->id} js-collection-manager-block {if $have_contactperson_search}open{/if}">
                                                    <small>{$managers[$contract->collection_manager_id]->name|escape}</small>
                                                </div>
                                                <div class="js-open-show js-dopinfo-{$contract->id}">
                                                {if $manager->role == 'team_collector'}
                                                    <small>{$managers[$contract->collection_manager_id]->name|escape}</small>
                                                {else}
                                                    <form action="">
                                                        <select class="form-control js-collection-manager" data-contract="{$contract->id}" name="order_manager[{$contract->collection_manager_id}]">
                                                            <option value="0" {if !$contract->collection_manager_id}selected{/if}>Не выбран</option>
                                                            {foreach $managers as $m}
                                                            {if $m->role == 'collector'}
                                                            <option value="{$m->id}" {if $contract->collection_manager_id == $m->id}selected{/if}>{$m->name|escape}</option>
                                                            {/if}
                                                            {/foreach}
                                                        </select>
                                                    </form>
                                                {/if}
                                                </div>
                                            </td>
                                            {/if}
                                            <td style="width: 120px;" class="jsgrid-cell">

                                                <div class="button-toggle-wrapper" style="margin-right:20px;">
                                                    <button class="js-open-contract button-toggle" data-id="{$contract->id}" type="button" title="Подробнее"></button>
                                                </div>
                                                <div style="padding-left:20px;">
                                                    {if $contract->collection_status}
                                                    <span class="label label-primary">{$collection_statuses[$contract->collection_status]}</span>
                                                    {else}
                                                    <span class="label label-success">Не просрочен</span>
                                                    {/if}
                                                    {if $contract->premier}<span class="label label-warning ">Премьер</span>
                                                    {elseif $contract->sold}<span class="label label-warning ">ЮК</span>{/if}
                                                    {if $contract->sud}
                                                    <span class="label label-danger">Суд</span>
                                                    {/if}
                                                </div>
                                                <a href="collector_contract/{$contract->id}">
                                                    {$contract->order->lastname}
                                                    {$contract->order->firstname}
                                                    {$contract->order->patronymic}
                                                </a>
                                                <small>{$contract->order->birth}</small>
                                                {if $contract->status==10}
                                                <span class="label label-danger">Суд 1С</span>
                                                {/if}
                                                <div class="clearfix">

                                                </div>
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                {$contract->loan_body_summ*1}
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                {($contract->loan_percents_summ + $contract->loan_charge_summ + $contract->loan_peni_summ) * 1}
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                <strong>
                                                    {($contract->loan_body_summ + $contract->loan_percents_summ + $contract->loan_charge_summ + $contract->loan_peni_summ) * 1}
                                                </strong>
                                            </td>
                                            {if in_array($manager->role, ['developer', 'admin', 'chief_collector', 'team_collector'])}
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                    {($contract->total_paid / $contract->amount)|round:2}
                                            </td>
                                            {/if}
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <div>
                                                    <span class="label {if $contract->client_time_warning}label-danger{else}label-success{/if} "><i class="far fa-clock"></i> {$contract->client_time|time}</span>
                                                </div>
                                                {if $search['phone'] && $search['phone'] == $contract->order->phone_mobile}
                                                <small class="text-danger">{$contract->order->phone_mobile}</small>
                                                {else}
                                                <small>{$contract->order->phone_mobile}</small>
                                                {/if}
                                                {if $contract->collection_status != 8}
                                                <br />
                                                <button class="js-mango-call mango-call {if $contract->sold}js-yuk{/if}" data-user="{$contract->user_id}" data-phone="{$contract->order->phone_mobile}" title="Выполнить звонок">
                                                    <i class="fas fa-mobile-alt"></i>
                                                </button>
                                                <button class="js-open-sms-modal mango-call {if $contract->sold}js-yuk{/if}" data-user="{$contract->user_id}" data-order="{$contract->order_id}">
                                                    <i class=" far fa-share-square"></i>
                                                </button>
                                                {/if}
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                                {$contract->delay} {$contract->delay|plural:'день':'дней':'дня'}
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                {$contract->return_date|date}
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <div class="js-open-hide js-dopinfo-{$contract->id} js-contact-status-block">
                                                    {if !$contract->order->contact_status}
                                                        <span class="label label-warning">Нет данных</span>
                                                    {else}
                                                        <span class="label" style="background:{$collector_tags[$contract->order->contact_status]->color}">{$collector_tags[$contract->order->contact_status]->name|escape}</span>
                                                    {/if}

                                                    <div class="custom-checkbox mt-1 custom-control">
                                                        <input id="workout_{$contract->id}" type="checkbox" class="custom-control-input js-workout-input" value="{$contract->id}" name="workout" {if $contract->collection_workout}checked="true"{/if} />
                                                        <label for="workout_{$contract->id}" class="custom-control-label"><small>Отработан</small></label>
                                                    </div>

                                                </div>
                                                <div class="js-open-show js-dopinfo-{$contract->id}">
                                                    <form action="order/{$contract->order->order_id}">
                                                        <select class="form-control js-contact-status" data-user="{$contract->order->user_id}" data-contract="{$contract->id}" name="contact_status[{$contract->order->user_id}]">
                                                            <option value="0" {if !$contract->order->contact_status}selected{/if}>Нет данных</option>
                                                            {foreach $collector_tags as $t}
                                                            <option value="{$t->id}" {if $contract->order->contact_status == $t->id}selected{/if}>{$t->name|escape}</option>
                                                            {/foreach}
                                                        </select>
                                                    </form>
                                                </div>
                                            </td>

                                            <td style="width: 140px;line-height:1" class="jsgrid-cell">
                                                <div class="" style="max-height:100px;overflow:hidden;position:relative;">
                                                    <div class="float-right">
                                                        <button class="float-right btn btn-link js-open-comment-form" title="Добавить комментарий" data-contactperson="" data-order="{$contract->order->order_id}">
                                                            <i class="fa-lg fas fa-comment-dots"></i>
                                                        </button>
                                                    </div>
                                                    {$comm = $contract->order->comments|first}
                                                    <small>{$comm->text}</small>

                                                </div>
                                            </td>
                                        </tr>
                                        {foreach $contract->contactpersons as $cp}
                                        <tr class="jsgrid-row js-open-show js-dopinfo-{$contract->id}" {if $have_contactperson_search}style="display:table-row"{/if}>
                                            <td style="width: 60px;" class="jsgrid-cell jsgrid-align-right">
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                            </td>
                                            <td style="width: 120px;" class="jsgrid-cell">
                                                {$cp->name|escape}
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                            </td>
                                            <td style="width: 70px;" class="jsgrid-cell">
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                {if $search['phone'] && $search['phone'] == $cp->phone}
                                                <span class="text-danger js-search-found">{$cp->phone|escape}</span>
                                                {else}
                                                {$cp->phone|escape}
                                                {/if}
                                                {*if $contract->collection_status != 8}
                                                <button class="js-mango-call mango-call {if $contract->sold}js-yuk{/if}" data-phone="{$contract->phone}" title="Выполнить звонок"><i class="fas fa-mobile-alt"></i></button>
                                                {/if*}
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                            </td>
                                            <td style="width: 80px;" class="jsgrid-cell">
                                                <div>
                                                    <form action="order/{$contract->order->order_id}">
                                                        <select class="form-control js-contactperson-status" data-contactperson="{$cp->id}" name="contactperson_status[{$cp->id}]">
                                                            <option value="0" {if !$cp->contact_status}selected{/if}>Нет данных</option>
                                                            {foreach $collector_tags as $t}
                                                            <option value="{$t->id}" {if $cp->contact_status == $t->id}selected{/if}>{$t->name|escape}</option>
                                                            {/foreach}
                                                        </select>
                                                    </form>
                                                </div>
                                            </td>
                                            <td style="width: 140px;line-height:1" class="jsgrid-cell">
                                                <small>{$cp->comment}</small>
                                                <button class="js-contactperson float-right btn btn-link js-open-comment-form" title="Добавить комментарий" data-contactperson="{$cp->id}" data-order="{$contract->order_id}">
                                                    <i class="fa-lg fas fa-comment-dots"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        {/foreach}
                                    {/foreach}

                                    {if $current_page_num==$total_pages_num}
                                        <tr>
                                            <td colspan="2"><strong>Итого</strong></td>

                                            <td>
                                            </td>
                                            <td>
                                                ОД:</br>
                                            <strong>{$count_od}</strong>
                                            </td>
                                            <td>
                                                %:</br>
                                                <strong>{$count_percents}</strong>
                                            </td>
                                            <td>
                                                Итог:</br>
                                                <strong>{$count_total_summ}</strong>
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
                                    {/if}


                                    </tbody>
                                </table>
                            </div>

                            {if $total_pages_num>1}

                            {* Количество выводимых ссылок на страницы *}
                        	{$visible_pages = 11}
                        	{* По умолчанию начинаем вывод со страницы 1 *}
                        	{$page_from = 1}

                        	{* Если выбранная пользователем страница дальше середины "окна" - начинаем вывод уже не с первой *}
                        	{if $current_page_num > floor($visible_pages/2)}
                        		{$page_from = max(1, $current_page_num-floor($visible_pages/2)-1)}
                        	{/if}

                        	{* Если выбранная пользователем страница близка к концу навигации - начинаем с "конца-окно" *}
                        	{if $current_page_num > $total_pages_num-ceil($visible_pages/2)}
                        		{$page_from = max(1, $total_pages_num-$visible_pages-1)}
                        	{/if}

                        	{* До какой страницы выводить - выводим всё окно, но не более ощего количества страниц *}
                        	{$page_to = min($page_from+$visible_pages, $total_pages_num-1)}

                            <div class="jsgrid-pager-container float-left" style="">
                                <div class="jsgrid-pager">
                                    Страницы:

                                    {if $current_page_num == 2}
                                    <span class="jsgrid-pager-nav-button "><a href="{url page=null}">Пред.</a></span>
                                    {elseif $current_page_num > 2}
                                    <span class="jsgrid-pager-nav-button "><a href="{url page=$current_page_num-1}">Пред.</a></span>
                                    {/if}

                                    <span class="jsgrid-pager-page {if $current_page_num==1}jsgrid-pager-current-page{/if}">
                                        {if $current_page_num==1}1{else}<a href="{url page=null}">1</a>{/if}
                                    </span>
                                   	{section name=pages loop=$page_to start=$page_from}
                                		{* Номер текущей выводимой страницы *}
                                		{$p = $smarty.section.pages.index+1}
                                		{* Для крайних страниц "окна" выводим троеточие, если окно не возле границы навигации *}
                                		{if ($p == $page_from + 1 && $p != 2) || ($p == $page_to && $p != $total_pages_num-1)}
                                		<span class="jsgrid-pager-page {if $p==$current_page_num}jsgrid-pager-current-page{/if}">
                                            <a href="{url page=$p}">...</a>
                                        </span>
                                		{else}
                                		<span class="jsgrid-pager-page {if $p==$current_page_num}jsgrid-pager-current-page{/if}">
                                            {if $p==$current_page_num}{$p}{else}<a href="{url page=$p}">{$p}</a>{/if}
                                        </span>
                                		{/if}
                                	{/section}
                                    <span class="jsgrid-pager-page {if $current_page_num==$total_pages_num}jsgrid-pager-current-page{/if}">
                                        {if $current_page_num==$total_pages_num}{$total_pages_num}{else}<a href="{url page=$total_pages_num}">{$total_pages_num}</a>{/if}
                                    </span>

                                    {if $current_page_num<$total_pages_num}
                                    <span class="jsgrid-pager-nav-button"><a href="{url page=$current_page_num+1}">След.</a></span>
                                    {/if}

                                    &nbsp;&nbsp; {$current_page_num} из {$total_pages_num}
                                </div>
                            </div>
                            {/if}


                            <div class="float-right pt-1">
                                <select class="form-control form-control-sm js-page-count" name="page-count">
                                    <option value="{url page_count=50}" {if $page_count==50}selected=""{/if}>Показывать 50</option>
                                    <option value="{url page_count=100}" {if $page_count==100}selected=""{/if}>Показывать 100</option>
                                    <option value="{url page_count=500}" {if $page_count==500}selected=""{/if}>Показывать 500</option>
                                    {*}
                                    <option value="{url page_count='all'}" {if $page_count=='all'}selected=""{/if}>Показывать все</option>
                                    {*}
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

    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>

