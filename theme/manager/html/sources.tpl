{$meta_title='Источники' scope=parent}

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

            $('select').on('change', function (e) {
                e.preventDefault();

                let value = $(this).val();

                if (value == 'casual') {
                    $('#calendar').show();
                }
                else {
                    $('#calendar').hide();
                }
            });

            $('#data').on('submit', function (e) {

                $.ajax({
                    data: $(this).serialize(),
                    success: function (ok) {

                    }
                });
            })
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
        .table th td {
            text-align: center !important;
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
                    <span>Источники</span>
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="statistics">Статистика</a></li>
                    <li class="breadcrumb-item active">Источники</li>
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
                    <form id="data">
                        <input type="hidden" name="action" value="report">
                        <div class="card-body">
                            <h4 class="card-title">Отчет по
                                источникам {if $date_from}{$date_from|date} - {$date_to|date}{/if}</h4>
                            <div class="row">
                                <div class="col-1 col-md-2">
                                    <div class="input-group mb-3">
                                        <select name="options" class="form-control">
                                            <option value="today">За сегодня</option>
                                            <option value="yesterday">За вчера</option>
                                            <option value="seven_days">За 7 дней</option>
                                            <option value="this_week">За текущую неделю</option>
                                            <option value="last_week">За прошлую неделю</option>
                                            <option value="this_months">За текущий месяц</option>
                                            <option value="last_months">За прошлый месяц</option>
                                            <option value="casual">Произвольный</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1 col-md-1">
                                    <div class="custom-checkbox" style="margin-top: 5px">
                                        <input type="checkbox" name="visits" value="1"/>
                                        <label>Визиты</label>
                                    </div>
                                </div>
                                <div style="width: 80px!important;">
                                    <div class="custom-checkbox" style="margin-top: 5px">
                                        <input type="checkbox" name="CR" value="1"/>
                                        <label>CR %</label>
                                    </div>
                                </div>
                                <div class="col-1 col-md-1">
                                    <button type="button" class="btn btn-light dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Источники
                                    </button>
                                    <div class="js-risk-op-check dropdown-menu" id="dropdown_managers">
                                        <ul class="list-unstyled m-2">
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="yandex" value="1"/>
                                                    <label>Яндекс</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="leadcraft" value="1"/>
                                                    <label>Лидкрафт</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-1 col-md-1">
                                    <button type="button" class="btn btn-light dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Заявки
                                    </button>
                                    <div class="js-risk-op-check dropdown-menu" id="dropdown_managers">
                                        <ul class="list-unstyled m-2">
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="all_orders" value="1"/>
                                                    <label>Все</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="orders_nk" value="1"/>
                                                    <label>НК</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="orders_pk" value="1"/>
                                                    <label>ПК</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="orders_bk" value="1"/>
                                                    <label>БК</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-1 col-md-1">
                                    <button type="button" class="btn btn-light dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Выдано
                                    </button>
                                    <div class="js-risk-op-check dropdown-menu" id="dropdown_managers">
                                        <ul class="list-unstyled m-2">
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="accept_all" value="1"/>
                                                    <label>Всего</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="accept_nk" value="1"/>
                                                    <label>НК</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="accept_pk" value="1"/>
                                                    <label>ПК</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="accept_bk" value="1"/>
                                                    <label>БК</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-1 col-md-1">
                                    <button type="button" class="btn btn-light dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        AR %
                                    </button>
                                    <div class="js-risk-op-check dropdown-menu" id="dropdown_managers">
                                        <ul class="list-unstyled m-2">
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="ar_all" value="1"/>
                                                    <label>Всего</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="ar_nk" value="1"/>
                                                    <label>НК</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="ar_pk" value="1"/>
                                                    <label>ПК</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="ar_bk" value="1"/>
                                                    <label>БК</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-1 col-md-1">
                                    <button type="button" class="btn btn-light dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Отказы
                                    </button>
                                    <div class="js-risk-op-check dropdown-menu" id="dropdown_managers">
                                        <ul class="list-unstyled m-2">
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="reject_all" value="1"/>
                                                    <label>Всего</label>
                                                    <input type="checkbox" name="reject_all_prc" value="1"/>
                                                    <label>%</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="reject_nk" value="1"/>
                                                    <label>НК</label>
                                                    <input type="checkbox" name="reject_nk_prc" value="1"/>
                                                    <label>%</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="reject_pk" value="1"/>
                                                    <label>ПК</label>
                                                    <input type="checkbox" name="reject_pk_prc" value="1"/>
                                                    <label>%</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="reject_bk" value="1"/>
                                                    <label>БК</label>
                                                    <input type="checkbox" name="reject_bk_prc" value="1"/>
                                                    <label>%</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-1 col-md-1">
                                    <button type="button" class="btn btn-light dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Проверка
                                    </button>
                                    <div class="js-risk-op-check dropdown-menu" id="dropdown_managers">
                                        <ul class="list-unstyled m-2">
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="check_all_summ" value="1"/>
                                                    <label>Сумма</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="check_nk_summ" value="1"/>
                                                    <label>Сумма НК</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="check_pk_summ" value="1"/>
                                                    <label>Сумма ПК</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="check_srch" value="1"/>
                                                    <label>СРЧ</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="check_srch_nk" value="1"/>
                                                    <label>СРЧ НК</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" name="check_srch_pk" value="1"/>
                                                    <label>СРЧ ПК</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-2 col-md-2">
                                    <button type="submit" class="btn btn-info">Сформировать</button>
                                </div>
                                <div style="display: none; width: 300px!important; margin-left: 12px" id="calendar">
                                    <input type="text" name="daterange" class="form-control daterange"
                                           value="{if $from && $to}{$from}-{$to}{/if}">
                                </div>
                            </div>
                            <br/>

                    </form>

                    <div class="big-table" style="overflow: auto;position: relative;">
                        {if $date_from}
                        <table class="table table-hover" id="basicgrid" style="display: inline-block;vertical-align: top;max-width: 100%;
                            overflow-x: auto;white-space: nowrap;-webkit-overflow-scrolling: touch;">
                            <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Источник</th>
                                {foreach $thead as $th}
                                    <th>{$th}</th>
                                {/foreach}
                            </tr>
                            </thead>
                            <tbody id="table_content">
                            {foreach $results as $date => $source}
                                <tr>
                                    <td rowspan="{count($source)}">{$date}</td>
                                    {foreach $source as $key => $value}
                                        <td rowspan="{count($value)}">{$key}</td>
                                        {foreach $value as $val}
                                            <td>{$val}</td>
                                        {/foreach}
                                    {/foreach}
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                    {else}
                    <div class="alert alert-info">
                        <h4>Укажите параметры для отчета</h4>
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