{$meta_title='Статистика активных займов' scope=parent}

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
                    <span>Статистика активных займов</span>
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="statistics">Статистика</a></li>
                    <li class="breadcrumb-item active">Активные займы</li>
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
                        <h4 class="card-title">Активные займы </h4>
                        <form>
                            <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                                <div class="col-12 col-md-12 text-right">
                                    <a href="{url download='excel'}" class="btn btn-success ">
                                        <i class="fas fa-file-excel"></i> Скачать
                                    </a>
                                </div>
                            </div>

                        </form>

                        <table class="table table-hover">

                            <tr>
                                <th>№</th>
                                <th>№ по гр.</th>
                                <th>Регион</th>
                                <th>Филиал</th>
                                <th>Подразделение</th>
                                <th>Источник финансирования</th>
                                <th>Клиент</th>
                                <th>Контракт</th>
                                <th>Дата выдачи</th>
                                <th>Дата последнего погашения</th>
                                <th>Дата последнего начисления</th>
                                <th>Процентная ставка</th>
                                <th>Кол-во траншей</th>
                                <th>Кол-во льготных периодов</th>
                                <th>Сумма займа</th>
                                <th>Баланс по ОД</th>
                                <th>Баланс по %</th>
                                <th>Баланс по штрафам</th>
                                <th>Тип займа</th>
                                <th>Статус контракта</th>
                                <th>Количество дней просрочки по статусу</th>
                                <th>Количество дней просрочки фактическое</th>
                                <th>Остановка начисления процентов</th>
                                <th>Дата остановки начисления процентов</th>
                                <th>Остановка начисления штрафов</th>
                                <th>Дата остановки начисления штрафов</th>
                                <th>Судебник</th>
                                <th>Дата признака Судебник</th>
                                <th>Пользовательский статус контракта</th>
                            </tr>

                            {foreach $contracts as $contract}
                                <tr>
                                    <td>{$contract@iteration}</td>
                                    <td>{$contract@iteration}</td>
                                    <td>Россия</td>
                                    <td>Головной</td>
                                    <td>Основное</td>
                                    <td>Собственные средства</td>
                                    <td>
                                        <a href="client/{$contract->user_id}" target="_blank">
                                            {$contract->lastname|escape}
                                            {$contract->firstname|escape}
                                            {$contract->patronymic|escape}
                                        </a>
                                    </td>
                                    <td>{$contract->contract_id}</td>
                                    <td>{$contract->inssuance_date}</td>
                                    <td>{if $contract->last_pay}
                                            {date('Y-m-d', strtotime($contract->last_pay))}
                                        {/if}</td>
                                    <td>
                                        {if $contract->balance}
                                            {date('Y-m-d', strtotime($contract->balance->created))}
                                        {/if}
                                    </td>
                                    <td>{$contract->base_percent}</td>
                                    <td>{$contract->payments_count}</td>
                                    <td></td>
                                    <td>{$contract->amount}</td>
                                    <td>
                                        {if $contract->balance}
                                            {$contract->balance->loan_body_summ}
                                        {/if}
                                    </td>
                                    <td>
                                        {if $contract->balance}
                                            {$contract->balance->loan_percents_summ}
                                        {/if}
                                    </td>
                                    <td>
                                        {if $contract->balance}
                                            {$contract->balance->loan_peni_summ}
                                        {/if}
                                    </td>
                                    <td>Краткосрочный</td>
                                    <td>
                                        {if $contract->status == 2}
                                            Выданный
                                        {elseif $contract->status == 4}
                                            Просроченный
                                        {else}
                                            ---
                                        {/if}
                                    </td>
                                    <td>{$contract->delay_status}</td>
                                    <td>{$contract->delay_fakt}</td>
                                    <td>
                                        {if $contract->stop_profit}
                                            Да
                                        {else}
                                            Нет
                                        {/if}
                                    </td>
                                    <td>
                                        {if $contract->stop_profit}
                                            {if $contract->balance}
                                                {$contract->balance->created}
                                            {/if}
                                        {/if}
                                    </td>
                                    <td>
                                        {if $contract->stop_profit}
                                            Да
                                        {else}
                                            Нет
                                        {/if}
                                    </td>
                                    <td>
                                        {if $contract->stop_profit}
                                            {if $contract->balance}
                                                {$contract->balance->created}
                                            {/if}
                                        {/if}
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        {if $contract->status == 2}
                                            Выдан
                                        {elseif $contract->status == 4}
                                            Просрочен
                                        {else}
                                            ---
                                        {/if}
                                    </td>
                                </tr>
                            {/foreach}

                        </table>
                        

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