{$meta_title='Источники' scope=parent}

{capture name='page_scripts'}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function () {

            moment.locale('ru');

            $('.daterange').daterangepicker({
                locale: {
                    format: 'DD.MM.YYYY',
                    "customRangeLabel": "Произвольно",
                    "applyLabel": "Применить",
                    "cancelLabel": "Отменить",
                },
                default: '',
                ranges: {
                    'Cегодня': [moment(), moment()],
                    'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Последние 7 дней': [moment().subtract(6, 'days'), moment()],
                    'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
                    'Текущая неделя': [moment().startOf('week'), moment()],
                    'Прошлая неделя': [moment().startOf('week').subtract(7, 'days'), moment().startOf('week').subtract(1, 'days')],
                    'Последние 30 дней': [moment().subtract(29, 'days'), moment()],
                    'Текущий месяц': [moment().startOf('month'), moment().endOf('month')],
                    'Прошлый месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Текущий год': [moment().startOf('year'), moment()]
                }
            });

            let checkbox = {{json_encode($thead)}};

            if (checkbox) {
                $('input').prop('checked', false);
            }

            for (let element in checkbox) {
                console.log(element);

                $('input[name="' + element + '"]').prop('checked', true);
            }

            $('input[name="utm_source"]').prop('checked', true);

            let group = {{json_encode($group_by)}};

            if (group) {
                $('select[name="group_by"] option[value=' + group + ']').attr('selected', 'selected');
            }

            let filtres = {{json_encode($filtres)}};

            if (filtres) {
                for (let filter in filtres) {
                    console.log(filtres);
                    $('input[name="' + filter + '"]').prop('checked', true);
                    $('input[name="' + filter + '_val"]').val(filtres[filter]);
                }
            }

            $('#data').on('submit', function (e) {

                $.ajax({
                    data: $(this).serialize(),
                    success: function (ok) {

                    }
                });
            });

            $(".drop").on("click", function (e) {
                e.stopPropagation();
            });

            $('.closed').on("click", function () {
                $('.drop').removeClass('show');
                $('.metrix').removeClass('show');

            });

            $('input[name="prop_all_checkbox"]').on('click', function () {
                $('.metrix').find('input[type="checkbox"]').each(function (e) {
                    $(this).prop('checked', true)
                });

                $('input[name="unprop_all_checkbox"]').prop('checked', false);
            });

            $('input[name="unprop_all_checkbox"]').on('click', function () {
                $('.metrix').find('input[type="checkbox"]').each(function (e) {
                    $(this).prop('checked', false)
                });

                $(this).prop('checked', true);
            });
        })
    </script>
{/capture}

{capture name='page_styles'}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <style>
        .table th td {
            text-align: center !important;
        }

        table {
            font-size: 11px !important;
        }

        label {
            font-size: 12px !important;
            margin-bottom: 0 !important;
        }

        button, select, input {
            font-size: 12px !important;
        }

        select {
            font: inherit;
            letter-spacing: inherit;
            word-spacing: inherit;
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
            text-align: left;
        }

        select::-ms-expand {
            display: none;
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
                    <span>Отчет по ремайндерам</span>
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="tools">Инструменты</a></li>
                    <li class="breadcrumb-item active">Отчет по ремайндерам</li>
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
                        <input type="hidden" name="to-do" value="report">
                        <div class="card-body">
                            <h4 class="card-title">Отчет по
                                ремайндерам {if $date_from}{$date_from|date} - {$date_to|date}{/if}</h4>
                            <div class="row">
                                <div class="input-group" style="width: 20%">
                                    <div style="margin-left: 12px; width: 100%" id="calendar">
                                        <input type="text" name="daterange" style="text-align: center; width: 100%"
                                               class="form-control daterange"
                                               value="{if $from && $to}{$from}-{$to}{/if}">
                                    </div>
                                </div>
                                <div class="col-2 col-md-2">
                                    <button type="submit" class="btn btn-info">Применить</button>
                                </div>
                            </div>
                            <br/>

                    </form>

                    <div class="big-table" style="overflow: auto; position: relative;">
                        {if $from}
                        <table class="table table-hover" id="basicgrid" style="display: inline-block; vertical-align: top; max-width: 100%;
                            overflow-x: auto; white-space: nowrap;-webkit-overflow-scrolling: touch;">
                            <thead>
                            <tr>
                                <th>Ремайндер</th>
                                <th>Отправлено СМС</th>
                            </tr>
                            </thead>
                            <tbody id="table_content">
                            {foreach $reminders as $reminder}
                                {if $reminder->type == 'days_until_due_date_remin'}
                                    {if $reminder->days_or_minutes == 3}
                                        <tr>
                                            <td>Скоро оплата 3Д</td>
                                            <td>{$reminder->days_until_due_date_remin}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 2}
                                        <tr>
                                            <td>Скоро оплата 2Д</td>
                                            <td>{$reminder->days_until_due_date_remin}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 1}
                                        <tr>
                                            <td>Скоро оплата 1Д</td>
                                            <td>{$reminder->days_until_due_date_remin}</td>
                                        </tr>
                                    {/if}
                                {/if}
                                {if $reminder->type == 'due_date_reminder'}
                                    {if $reminder->days_or_minutes == 6}
                                        <tr>
                                            <td>Дата погашения 6 Мск</td>
                                            <td>{$reminder->days_until_due_date_remin}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 9}
                                        <tr>
                                            <td>Дата погашения 9 Мск</td>
                                            <td>{$reminder->days_until_due_date_remin}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 12}
                                        <tr>
                                            <td>Дата погашения 12 Мск</td>
                                            <td>{$reminder->days_until_due_date_remin}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 15}
                                        <tr>
                                            <td>Дата погашения 15 Мск</td>
                                            <td>{$reminder->days_until_due_date_remin}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 18}
                                        <tr>
                                            <td>Дата погашения 18 Мск</td>
                                            <td>{$reminder->days_until_due_date_remin}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 21}
                                        <tr>
                                            <td>Дата погашения 21 Мск</td>
                                            <td>{$reminder->days_until_due_date_remin}</td>
                                        </tr>
                                    {/if}
                                {/if}
                                {if $reminder->type == 'moment_of_redemption'}
                                        <tr>
                                            <td>Заем погашен</td>
                                            <td>{$reminder->moment_of_redemption}</td>
                                        </tr>
                                {/if}
                                {if $reminder->type == 'days_without_a_loan'}
                                    {if $reminder->days_or_minutes == 1}
                                        <tr>
                                            <td>Без займа 1Д</td>
                                            <td>{$reminder->days_without_a_loan}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 2}
                                        <tr>
                                            <td>Без займа 2Д</td>
                                            <td>{$reminder->days_without_a_loan}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 3}
                                        <tr>
                                            <td>Без займа 3Д</td>
                                            <td>{$reminder->days_without_a_loan}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 5}
                                        <tr>
                                            <td>Без займа 5Д</td>
                                            <td>{$reminder->days_without_a_loan}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 7}
                                        <tr>
                                            <td>Без займа 7Д</td>
                                            <td>{$reminder->days_without_a_loan}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 10}
                                        <tr>
                                            <td>Без займа 10Д</td>
                                            <td>{$reminder->days_without_a_loan}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 14}
                                        <tr>
                                            <td>Без займа 14Д</td>
                                            <td>{$reminder->days_without_a_loan}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 20}
                                        <tr>
                                            <td>Без займа 20Д</td>
                                            <td>{$reminder->days_without_a_loan}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 30}
                                        <tr>
                                            <td>Без займа 30Д</td>
                                            <td>{$reminder->days_without_a_loan}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 45}
                                        <tr>
                                            <td>Без займа 45Д</td>
                                            <td>{$reminder->days_without_a_loan}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 60}
                                        <tr>
                                            <td>Без займа 60Д</td>
                                            <td>{$reminder->days_without_a_loan}</td>
                                        </tr>
                                    {/if}
                                {/if}
                                {if $reminder->type == 'days_since_approval'}
                                    {if $reminder->days_or_minutes == 1}
                                        <tr>
                                            <td>Раздел уведомления одобренных. 1</td>
                                            <td>{$reminder->days_since_approval}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 2}
                                        <tr>
                                            <td>Раздел уведомления одобренных. 2</td>
                                            <td>{$reminder->days_since_approval}</td>
                                        </tr>
                                    {/if}
                                    {if $reminder->days_or_minutes == 3}
                                        <tr>
                                            <td>Раздел уведомления одобренных. 3</td>
                                            <td>{$reminder->days_since_approval}</td>
                                        </tr>
                                    {/if}

                                {/if}
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