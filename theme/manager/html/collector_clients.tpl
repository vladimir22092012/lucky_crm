{$meta_title='Перебросы клиентов' scope=parent}

{capture name='page_scripts'}
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
{/capture}

{capture name='page_styles'}
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
                            {if $date_from}<a class="btn btn-sm btn-outline-primary">{$date_from|date} - {$date_to|date}</a>{/if}
                            {if $filter_status}<a class="btn btn-sm btn-outline-primary">{$collection_statuses[$filter_status]}</a>{/if}
                            {if $manager_id}<a class="btn btn-sm btn-outline-primary">{$managers[$manager_id]->name}</a>{/if}
                        </h4>
                        <form id="filter_form" class="pb-3">
                            <input type="hidden" value="{$filter_status}" name="status" />
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-6 col-md-5">
                                            <div class="input-group mb-3">
                                                <input id="input_daterange" type="text" name="daterange" class="form-control daterange" 
                                                       value="{if $from && $to}{$from}-{$to}{/if}">
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
                                                    <option value="" {if !$manager_id}selected{/if}></option>
                                                    {foreach $managers as $m}
                                                        {if $m->role == 'collector'}
                                                            <option value="{$m->id}" {if $m->id==$manager_id}selected{/if}>
                                                                {$m->name} ({$collection_statuses[$m->collection_status_id]})
                                                            </option>
                                                        {/if}
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </div>
    
    
                                        <div class="col-12 col-md-2">
                                            <button type="submit" class="btn btn-info">Сформировать</button>
                                        </div>
                                        
                                        <div class="col-12  col-md-12">
                                            <div class="float-left js-filter-client">
                                                {foreach $collection_statuses as $cs_id => $cs_name}
                                                    {if $filter_status==$cs_id}
                                                    <a href="{url status=null}" class="btn btn-xs btn-success" >{$cs_name|escape}</a>
                                                    {else}
                                                    <a href="{url status=$cs_id}" class="btn btn-xs btn-outline-success" >{$cs_name|escape}</a>
                                                    {/if}
                                                {/foreach}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {if $from}
                                    <div class="col-4">
                                        <div class="card card-inverse card-info">

                                            <div class="box bg-info text-center">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <h5 class="text-center pt-2">Договоров:</h5>
                                                        <h3 class="text-white text-center">{$contracts|count}</h3>
                                                    </div>
                                                    <div class="col-4">
                                                        <h5 class="text-center pt-2">ОД: </h5>
                                                        <h3 class="text-white text-center">{$count_od}</h3>
                                                    </div>
                                                    <div class="col-4">
                                                        <h5 class="text-center pt-2">Проценты: </h5>
                                                        <h3 class="text-white text-center">{$count_percents}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {/if}
                            </div>

                        </form>

                        {if $from}
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
                                    {if $is_developer}
                                    <th>След. действие</th>
                                    {/if}
                                </tr>

                                {foreach $contracts as $contract}
                                    <tr>
                                        <td>{$contract@iteration}</td>
                                        <td class="text-center">{$contract->from_date|date}</td>
                                        <td>
                                            <small>{$contract->lastname|escape} {$contract->firstname|escape} {$contract->patronymic|escape}</small>
                                            <br />
                                            <small>{$contract->birth}</small>
                                        </td>
                                        <td>
                                            <a target="_blank" href="collector_contract/{$contract->id}">
                                                {$contract->number}
                                            </a>
                                            <br/>
                                            <small>{$contract->inssuance_date|date}</small>
                                        </td>
                                        <td class="text-center">
                                            <h3 class="text-primary">{$contract->summ_body}</h3>
                                        </td>
                                        <td class="text-center">
                                            <h3 class="text-primary">{$contract->summ_percents}</h3>
                                        </td>
                                        <td>
                                        {if $contract->manager_id}
                                            {foreach $managers as $m}
                                                {if $m->id == $contract->manager_id}
                                                    <small>{$m->name}</small>
                                                {/if}
                                            {/foreach}
                                        {/if}
                                        </td>
                                        {if $is_developer}
                                        <td>
                                            {if $contract->next_moving}
                                            <small class="text-info">
                                                Переход({$collection_statuses[$contract->next_moving->collection_status]}): 
                                                {$contract->next_moving->from_date|date}
                                            </small><br />
                                            {elseif $contract->next_payment}
                                            <small class="text-success">
                                                Оплата({$managers[$contract->next_payment->manager_id]->name}): {$contract->next_payment->created|date}
                                            </small>
                                            {/if}
                                        </td>
                                        {/if}
                                    </tr>
                                {/foreach}
                                <tr class="bg-info text-white">
                                    <td colspan="2"><strong>Итого</strong></td>

                                    <td>
                                        Договоров:
                                        <strong>{$contracts|count}</strong>
                                    </td>
                                    <td>
                                    </td>
                                    <td class="text-center">
                                        <h4 class="text-white">{$count_od}</h4>
                                    </td>
                                    <td class="text-center">
                                        <h4 class="text-white">{$count_percents}</h4>
                                    </td>
                                    <td></td>
                                </tr>

                            </table>
                        {else}
                            <div class="alert alert-info mt-5">
                                <h4>Укажите даты для формирования отчета</h4>
                            </div>
                        {/if}

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
    {include file='footer.tpl'}
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>