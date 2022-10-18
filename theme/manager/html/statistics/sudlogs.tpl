{$meta_title='Логирование событий судблока' scope=parent}

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
                    <span>Логирование событий судблока</span>
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="statistics">Статистика</a></li>
                    <li class="breadcrumb-item active">Логирование событий судблока</li>
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
                        <h4 class="card-title">Логирование событий судблока за
                            период {if $date_from}{$date_from|date} - {$date_to|date}{/if}</h4>
                        <form>
                            <div class="row">
                                <div class="col-6 col-md-3">
                                    <div class="input-group mb-3">
                                        <input type="text" name="daterange" class="form-control daterange"
                                               value="{if $from && $to}{$from}-{$to}{/if}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <span class="ti-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <button type="submit" class="btn btn-info">Сформировать</button>
                                </div>
                                {if !empty($sudblock_contracts)}
                                    <div class="col-12 col-md-3 text-right">
                                        <a href="{url download='excel'}" class="btn btn-success ">
                                            <i class="fas fa-file-excel"></i> Скачать
                                        </a>
                                    </div>
                                {/if}
                            </div>

                        </form>

                        {if $from && !empty($sudblock_contracts)}
                            <table class="table-bordered table ">
                                <col width="50"/>
                                <col width="200"/>
                                <col width="700"/>
                                <tr>
                                    <th>#</th>
                                    <th>Договор</th>
                                    <th>События</th>
                                </tr>

                                {foreach $sudblock_contracts as $contract}
                                    <tr>
                                        <td>{$contract@iteration}</td>
                                        <td>
                                            <small>{$contract->created|date} {$contract->created|time}</small>
                                            <br/>
                                            <small>{$users[$contract->user_id]->lastname} {$users[$contract->user_id]->firstname} {$users[$contract->user_id]->patronymic}</small>
                                            <br/>
                                            <a href="order/{$order->order_id}"
                                               target="_blank"><strong>{$order->order_id}</strong></a>
                                            <span class="label label-success">{$sudblock_statuses[$contract->id]->name}</span>
                                            <br/>
                                            <br/>
                                            <i title="Менеджер">{$managers[$contract->manager_id]->name|escape}</i>
                                        </td>
                                        <td class="p-0 ">
                                            <table class="table table-striped mb-0">
                                                <col width="15%"/>
                                                <col width="10%"/>
                                                <col width="40%"/>
                                                <col width="35%"/>
                                                {foreach $logs as $log}
                                                    <tr>
                                                        <td class="p-2">
                                                            <small>{$log->created|date}</small>
                                                        </td>
                                                        <td class="p-2">
                                                            <small>{$log->created|time}</small>
                                                        </td>
                                                        <td class="p-2">
                                                            <small><b>Событие: </b>{$log->new_values['event_name']}</small>
                                                            <small><b>Комментарий: </b>{$log->new_values['comment']}</small>
                                                        </td>
                                                        <td class="p-2 text-right">
                                                            <i>{$managers[$log->manager_id]->name|escape}</i>
                                                        </td>
                                                    </tr>
                                                {/foreach}
                                            </table>
                                        </td>
                                    </tr>
                                {/foreach}
                            </table>
                            {include file='pagination.tpl'}

                        {elseif $from && empty($sudblock_contracts)}
                            <div class="alert alert-info">
                                <h4>Событий на сегодня нет</h4>
                            </div>
                        {else}
                            <div class="alert alert-info">
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