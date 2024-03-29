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
                    <li class="breadcrumb-item active">Выданные займы</li>
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
                        <h4 class="card-title">Выданные займы за
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
                                    <th>
                                        Дата
                                        <br/>
                                        Договор
                                    </th>
                                    <th>Дата закрытия договора</th>
                                    <th>ФИО</th>
                                    <th>Дата рождения</th>
                                    <th>Место рождения</th>
                                    <th>Паспортные данные</th>
                                    <th>
                                        Телефон
                                        <br/>
                                        Email
                                    </th>
                                    <th>
                                        Контакты 3-х лиц
                                    </th>
                                    <th>Адрес регистрации</th>
                                    <th>Адрес проживания</th>
                                    <th>Рабочий телефон</th>
                                    <th>Сумма</th>
                                    <th>Проценты</th>
                                    <th>Штрафы</th>
                                    <th>ПК/НК</th>
                                    <th>Менеджер</th>
                                    <th>Орг-я</th>
                                    <th>Просрочка</th>
                                    <th>Оплачено</th>
                                    <th>Статус</th>
                                    <th>Источник</th>
                                    <th>Поступление заявки</th>
                                    <th>Пролонгация на этапе</th>
                                    <th>Продолжительность просрочки перед пролонгацией</th>
                                </tr>

                                {foreach $contracts as $contract}
                                    <tr>
                                        <td>
                                            {$contract->date|date}
                                            <br/>
                                            <a target="_blank"
                                               href="order/{$contract->order_id}"><strong>{$contract->number}</strong></a>
                                        </td>
                                        <td>
                                            {if $contract->close_date == false}
                                                не закрыт
                                            {/if}
                                            {if $contract->close_date == true}
                                                {$contract->close_date|date}
                                            {/if}
                                        </td>
                                        <td>
                                            <a href="client/{$contract->user_id}" target="_blank">
                                                {$contract->lastname|escape}
                                                {$contract->firstname|escape}
                                                {$contract->patronymic|escape}
                                            </a>
                                        </td>
                                        <td>
                                            {$contract->birth|date}
                                        </td>
                                        <td>
                                            {$contract->birth_place}
                                        </td>
                                        <td>
                                            Паспорт {$contract->passport_serial} Выдан {$contract->passport_issued}
                                            от {$contract->passport_date|date} код подразделения {$contract->subdivision_code}
                                        </td>
                                        <td>
                                            {$contract->phone_mobile}
                                            <br/>
                                            <small>{$contract->email}</small>
                                        </td>
                                        <td>
                                            {$contract->contact_person_name}/{$contract->contact_person_phone}<br>
                                            {$contract->contact_person2_name}/{$contract->contact_person2_phone}
                                        </td>
                                        <td>
                                            {$contract->Regregion}
                                        </td>
                                        <td>
                                            {$contract->FaktRegion}
                                        </td>
                                        <td>
                                            {$contract->workphone}
                                        </td>
                                        <td><h3 class="text-primary">{$contract->amount*1}</h3></td>
                                        <td><h3 class="text-primary">{$contract->loan_percents_summ}</h3></td>
                                        <td><h3 class="text-primary">{$contract->loan_peni_summ}</h3></td>
                                        <td class="text-center">
                                            {if $contract->client_status == 'pk'}
                                                <span class="label label-info">ПК</span>
                                            {/if}
                                            {if $contract->client_status == 'nk'}
                                                <span class="label label-success">НК</span>
                                            {/if}
                                            {if $contract->client_status == 'crm'}<span class="label label-primary">ПК CRM</span>{/if}
                                            {if $contract->client_status == 'rep'}<span class="label label-warning">Повтор</span>{/if}
                                        </td>
                                        <td>
                                            <small>{$managers[$contract->manager_id]->name|escape}</small>
                                        </td>
                                        <td>
                                            {if $contract->premier}
                                                <span class="label label-primary">Премьер</span>
                                            {elseif $contract->sold}
                                                <span class="label label-danger">ЮК</span>
                                            {else}
                                                <span class="label label-info">МКК</span>
                                            {/if}
                                        </td>
                                        <td>{$contract->expiration}</td>
                                        <td>{$contract->total_paid}</td>
                                        <td class="text-right">

                                            {if $contract->collection_status}
                                                <span class="label label-danger">{$collection_statuses[$contract->collection_status]}</span>
                                            {else}
                                                {if $contract->status == 3}
                                                    <span class="label label-info">{$statuses[$contract->status]}</span>
                                                {elseif $contract->status == 2}
                                                    <span class="label label-success">{$statuses[$contract->status]}</span>
                                                {else}
                                                    <span class="label label-danger">{$statuses[$contract->status]}</span>
                                                {/if}
                                            {/if}
                                        </td>
                                        <td>
                                            {$contract->utm_source}
                                        </td>
                                        <td>
                                            {$contract->order_date|date:'d.m.Y H:i:s'}
                                        </td>
                                        <td>
                                            {foreach $contract->collections as $collection}
                                                {if $collection@first}
                                                    {if $collection->prolongation}
                                                        <span class="label label-info">{$collection_statuses[$collection->collection_status]}</span>
                                                    {/if}
                                                {/if}
                                            {/foreach}
                                        </td>
                                        <td>
                                            {foreach $contract->collections as $collection}
                                                {if $collection@first}
                                                    {if $collection->prolongation}
                                                        {$collection->delay_period}
                                                    {/if}
                                                {/if}
                                            {/foreach}
                                        </td>
                                    </tr>
                                {/foreach}

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