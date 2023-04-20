{$meta_title='Статистика просроченных займов' scope=parent}

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
                    <span>Статистика просроченных займов</span>
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="statistics">Статистика</a></li>
                    <li class="breadcrumb-item active">Просроченные займы</li>
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
                        <h4 class="card-title">Просроченные займы </h4>
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
                                <th>Номер по порядку</th>
                                <th>Фамилия Должника</th>
                                <th>Имя Должника</th>
                                <th>Отчество Должника</th>
                                <th>Дата рождения Должника</th>
                                <th>Место рождения Должника</th>
                                <th>Серия паспорта Должника</th>
                                <th>Номер паспорта Должника</th>
                                <th>Кем выдан паспорт Должника</th>
                                <th>Дата выдачи паспорта</th>
                                <th>Телефоны Должника</th>
                                <th>Телефон 1 контакта и ФИО</th>
                                <th>Телефон 2 контакта и ФИО</th>
                                <th>Рабочий телефон</th>
                                <th>Программа кредитования Должника</th>
                                <th>Дата выдачи</th>
                                <th>Номер кредитного договора</th>
                                <th>Номер счета для погашения задолженности</th>
                                <th>Сумма кредитного лимита</th>
                                <th>Валюта кредитного лимита</th>
                                <th>Дата возникновения просроченной задолженности</th>
                                <th>Количество дней просрочки</th>
                                <th>Дата фиксации задолженности</th>
                                <th>Сумма задолженности по основному долгу</th>
                                <th>Сумма задолженности по процентам</th>
                                <th>Сумма задолженности по штрафам</th>
                                <th>Общая сумма взыскиваемой задолженности</th>
                                <th>Адрес проживания</th>
                                <th>Адрес регистрации</th>
                                <th>Пользовательский статус контракта</th>
                            </tr>

                            {foreach $contracts as $contract}
                                <tr>
                                    <td>{$contract@iteration}</td>
                                    <td>{$contract->lastname}</td>
                                    <td>{$contract->firstname}</td>
                                    <td>{$contract->patronymic}</td>
                                    <td>{$contract->birth}</td>
                                    <td>{$contract->birth_place}</td>
                                    <td>{$contract->passport_ser}</td>
                                    <td>{$contract->passport_num}</td>
                                    <td>{$contract->passport_issued}</td>
                                    <td>{date('Y-m-d', strtotime($contract->passport_date))}</td>
                                    <td>{$contract->phone_mobile}</td>
                                    <td>{$contract->contact_person_phone}, {$contract->contact_person_name}</td>
                                    <td>{$contract->contact_person2_phone}, {$contract->contact_person2_name}</td>
                                    <td>{$contract->workphone}</td>
                                    <td></td>
                                    <td>{date('Y-m-d', strtotime($contract->date))}</td>
                                    <td>{$contract->number}</td>
                                    <td>{$contract->pan}</td>
                                    <td>{$contract->amount}</td>
                                    <td>Рубли</td>
                                    <td>{date('Y-m-d', strtotime($contract->return_date))}</td>
                                    <td>{$contract->delay}</td>
                                    <td>{date('Y-m-d', strtotime($contract->return_date))}</td>
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
                                    <td>
                                        {if $contract->balance}
                                            {$contract->balance->loan_body_summ +
                                            $contract->balance->loan_percents_summ +
                                            $contract->balance->loan_peni_summ}
                                        {/if}
                                    </td>
                                    <td>{$contract->faktaddress}</td>
                                    <td>{$contract->regaddress}</td>
                                    <td>Просрочен</td>
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