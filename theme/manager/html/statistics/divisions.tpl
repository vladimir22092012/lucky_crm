{$meta_title='Статистика выданных займов' scope=parent}

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
                    <span>Статистика выданных займов</span>
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="statistics">Статистика</a></li>
                    <li class="breadcrumb-item active">Отчет по Подразделениям</li>
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
                    <div class="card-body" style="overflow-x: auto;">
                        <h4 class="card-title">Отчет по Подразделениям {if $date_from}{$date_from|date} - {$date_to|date}{/if}</h4>
                        <form>
                            <div class="row">
                                <div class="col-6 col-md-4">
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
                                <div class="col-12 col-md-4">
                                    <button type="submit" class="btn btn-info">Сформировать</button>
                                </div>
                                {if $date_from || $date_to}
                                    <div class="col-12 col-md-4 text-right">
                                        <a href="{url download='excel'}" class="btn btn-success ">
                                            <i class="fas fa-file-excel"></i> Скачать
                                        </a>
                                    </div>
                                {/if}
                            </div>

                        </form>

                        {if $from}
                            <table class="table table-hover">

                                <tr>
                                    <td>
                                        -----
                                    </td>
                                    <td>За период</td>
                                    <td>ИТОГО</td>
                                </tr>
                                <tr>
                                    <td>кол-во заявок</td>
                                    <td>{$orders_array['count_all']}</td>
                                    <td>{$orders_array['count_all']}</td>
                                </tr>
                                <tr>
                                    <td> из них выдано</td>
                                    <td>{$orders_array['count_issued']}</td>
                                    <td>{$orders_array['count_issued']}</td>
                                </tr>
                                <tr>
                                    <td>  из них отклонено</td>
                                    <td>{$orders_array['count_rejected']}</td>
                                    <td>{$orders_array['count_rejected']}</td>
                                </tr>
                                <tr>
                                    <td>  из них ожидающих</td>
                                    <td>{$orders_array['count_waiting']}</td>
                                    <td>{$orders_array['count_waiting']}</td>
                                </tr>
                                <tr>
                                    <td>кол-во новых клиентов</td>
                                    <td>{count($new_clients)}</td>
                                    <td>{count($new_clients)}</td>
                                </tr>
                                    <td>кол-во активных клиентов (---НА ТЕК МОМЕНТ)</td>
                                    <td>{$all_clients_array['active']}</td>
                                    <td>{$all_clients_array['active']}</td>
                                </tr>
                                <tr>
                                    <td>кол-во пассивных клиентов (---НА ТЕК МОМЕНТ)</td>
                                    <td>{$all_clients_array['passive']}</td>
                                    <td>{$all_clients_array['passive']}</td>
                                </tr>
                                <tr>
                                    <td>кол-во выбывших клиентов (???)</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>кол-во клиентов в просрочке (---НА ТЕК МОМЕНТ)</td>
                                    <td>{$all_clients_array['delay']}</td>
                                    <td>{$all_clients_array['delay']}</td>
                                </tr>
                                <tr>
                                    <td>прирост клиентов в просрочке (???)</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>кол-во реструктуризаций (???)</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>кол-во пролонгаций</td>
                                    <td>{$all_clients_array['prolongation']}</td>
                                    <td>{$all_clients_array['prolongation']}</td>
                                </tr>
                                <tr>
                                    <td>средняя сумма займа</td>
                                    <td>{$payments_array['average']}</td>
                                    <td>{$payments_array['average']}</td>
                                </tr>
                                <tr>
                                    <td>общая сумма выданных займов</td>
                                    <td>{$payments_array['sum']}</td>
                                    <td>{$payments_array['sum']}</td>
                                </tr>
                                <tr>
                                    <td>ПОРТФЕЛЬ В РИСКЕ (на текущее время)</td>
                                    <td>{$sum_contracts_array['risk']}</td>
                                    <td>{$sum_contracts_array['risk']}</td>
                                </tr>
                                <tr>
                                    <td>АКТИВНАЯ СУММА ОС (на текущее время)</td>
                                    <td>{$sum_contracts_array['active_sum']}</td>
                                    <td>{$sum_contracts_array['active_sum']}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>К погашению: (НА ТЕК МОМЕНТ)</td>
                                    <td>{$pay_debts_array['count']}</td>
                                    <td>{$pay_debts_array['count']}</td>
                                </tr>
                                <tr>
                                    <td>ОС на сумму: (НА ТЕК МОМЕНТ)</td>
                                    <td>{$pay_debts_array['body']}</td>
                                    <td>{$pay_debts_array['body']}</td>
                                </tr>
                                <tr>
                                    <td>% на сумму: (НА ТЕК МОМЕНТ)</td>
                                    <td>{$pay_debts_array['percents']}</td>
                                    <td>{$pay_debts_array['percents']}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Погашено:</td>
                                    <td>{$payd_debts_array['count']}</td>
                                    <td>{$payd_debts_array['count']}</td>
                                </tr>
                                <tr>
                                    <td>на сумму:</td>
                                    <td>{$payd_debts_array['all']}</td>
                                    <td>{$payd_debts_array['all']}</td>
                                </tr>
                                <tr>
                                    <td>BS ОС</td>
                                    <td>{$payd_debts_array['body']}</td>
                                    <td>{$payd_debts_array['body']}</td>
                                </tr>
                                <tr>
                                    <td>BS %</td>
                                    <td>{$payd_debts_array['percents']}</td>
                                    <td>{$payd_debts_array['percents']}</td>
                                </tr>
                                <tr>
                                    <td>BS Штрафы</td>
                                    <td>{$payd_debts_array['peni']}</td>
                                    <td>{$payd_debts_array['peni']}</td>
                                </tr>
                                <tr>
                                    <td>BS Доппродукты:</td>
                                    <td>{$services_array['count']}</td>
                                    <td>{$services_array['count']}</td>
                                </tr>
                                <tr>
                                    <td>на сумму:</td>
                                    <td>{$services_array['amount']}</td>
                                    <td>{$services_array['amount']}</td>
                                </tr>
                                <tr>
                                    <td>Рекурентных списаний: (???)</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>на сумму: (???)</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>

                            </table>
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