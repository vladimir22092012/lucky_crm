{$meta_title='leadcraft' scope=parent}

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

            $('#postback_filter').on('submit', function (e) {
               $.ajax({
                  method: 'get',
                  data: $(this).serialize()
               });
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
                    <span>Лидкрафт</span>
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="statistics">Статистика</a></li>
                    <li class="breadcrumb-item active">Лидкрафт</li>
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
                        <h4 class="card-title">Отчет Лидкрафт за
                            период {if $date_from}{$date_from|date} - {$date_to|date}{/if}</h4>
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
                                <div style="height: 35px; width: 200px">
                                    <button type="submit" class="btn btn-info">
                                        Сформировать
                                    </button>
                                </div>
                                {if $date_from || $date_to}
                                    <div style="width: 150px">
                                        <a href="{url download='excel'}" class="btn btn-success ">
                                            <i class="fas fa-file-excel"></i> Скачать
                                        </a>
                                    </div>
                                    <form id="postback_filter">
                                    <div style="align-content: center">
                                        <button class="btn btn-xs btn-outline-info filter_status" type="submit" name="postback_type" value="pending">pending</button>
                                        <button class="btn btn-xs btn-outline-success filter_status" type="submit" name="postback_type" value="approved">approved</button>
                                        <button class="btn btn-xs btn-outline-danger filter_status" type="submit" name="postback_type" value="cancelled">cancelled</button>
                                        <button class="btn btn-xs btn-outline-primary" type="submit" name="postback_type" value="reset">сбросить фильтр</button>
                                    </div>
                                    </form>
                                {/if}
                            </div>
                        </form>
                        <div class="big-table" style="overflow: auto;position: relative;">
                            {if $from}
                            <table class="table table-hover" id="basicgrid" style="display: inline-block;vertical-align: top;max-width: 100%;
                            overflow-x: auto;white-space: nowrap;-webkit-overflow-scrolling: touch; max-height: 800px">
                                <thead>
                                <tr>
                                    <th>ID вебмастера</th>
                                    <th>Источник</th>
                                    <th>Кликхеш</th>
                                    <th>ID заявки</th>
                                    <th>Дата заявки</th>
                                    <th>Статус</th>
                                    <th>Статус клиента</th>
                                    <th>Постбек</th>
                                    <th>Тип постбека</th>
                                    <th>Цена</th>
                                </tr>
                                </thead>
                                <tbody id="table_content">
                                {foreach $orders as $order}
                                    <tr id="content" data-type = "{$order->leadcraft_postback_type}">
                                        <td>{$order->webmaster_id}</td>
                                        <td>{$order->utm_source}</td>
                                        <td>{$order->click_hash}</td>
                                        <td>{$order->order_id}</td>
                                        <td>{$order->date}</td>
                                        <td><span class="{$color[$order->status]}">{$statuses[$order->status]}</span>
                                        </td>
                                        <td>{$order->client_status}</td>
                                        <td>{$order->leadcraft_postback_date}</td>
                                        <td>
                                            <span class="label label-{$color_postback[$order->leadcraft_postback_type]}">{$order->leadcraft_postback_type}
                                        </td>
                                        <td></td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                            {include file='pagination.tpl'}
                            <div>
                                <span>
                                    upd 01.02.2022:
аппрув отправляем только по "nk" одобренным заявкам
отмену отправляем только по "nk" отказным заявкам
по остальным ничего не отправляем постбэком<br>

upd 18.02.2022:
создан данный отчет, смотреть результат следует не ранее чем за 19.02.22
если требуется скачать для передачи партнерам файл реестра с данными до этой даты - обратитесь к разработчикам
                                </span>
                            </div>
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