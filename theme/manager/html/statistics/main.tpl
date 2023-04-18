{$meta_title='Статистика' scope=parent}

{capture name='page_scripts'}



{/capture}

{capture name='page_styles'}


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
                <h3 class="text-themecolor mb-0 mt-0"><i class="mdi mdi-file-chart"></i> Статистика</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Статистика</li>
                </ol>
            </div>
            <div class="col-md-6 col-4 align-self-center">

            </div>
        </div>

        <div class="row">
            <!-- Column 
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-inverse card-info">
                    <a href="statistics/report" class="box bg-info text-center">
                        <h1 class="font-light text-white">Выдача</h1>
                        <h6 class="text-white">Оперативная отчетность</h6>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-primary card-inverse">
                    <a href="statistics/conversion" class="box text-center">
                        <h1 class="font-light text-white">Конверсия</h1>
                        <h6 class="text-white">Конверсии в выдачу</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <a href="statistics/expired" class="card card-inverse card-success">
                    <div class="box text-center">
                        <h1 class="font-light text-white">Просрочка</h1>
                        <h6 class="text-white">Статистика просрочки</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-inverse card-warning">
                    <a href="statistics/free_pk" class="box text-center">
                        <h1 class="font-light text-white">Свободные ПК</h1>
                        <h6 class="text-white">ПК без открытых договоров</h6>
                    </a>
                </div>
            </div>
            -->
            {if in_array('analitics', $manager->permissions)}
                {if $manager->role !='analitic_marketing'}
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-inverse card-danger">
                            <a href="statistics/scorista_rejects" class="box text-center">
                                <h1 class="font-light text-white">Отказы</h1>
                                <h6 class="text-white">Статистика отказов</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-inverse card-success">
                            <a href="statistics/contracts" class="box text-center">
                                <h1 class="font-light text-white">Договора</h1>
                                <h6 class="text-white">Выданные займы</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-inverse card-primary">
                            <a href="statistics/payments" class="box text-center">
                                <h1 class="font-light text-white">Оплаты</h1>
                                <h6 class="text-white">Операции по займам</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-inverse card-warning">
                            <a href="statistics/eventlogs" class="box text-center">
                                <h1 class="font-light text-white">Логи</h1>
                                <h6 class="text-white">Логи событий</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-info card-danger">
                            <a href="statistics/adservices" class="box text-center">
                                <h1 class="font-light text-white">Доп услуги</h1>
                                <h6 class="text-white">Отчеты по дополнительным услугам</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-info card-danger">
                            <a href="statistics/kpicollection" class="box text-center">
                                <h1 class="font-light text-white">KPI</h1>
                                <h6 class="text-white">Отчеты по KPI коллекторов</h6>
                            </a>
                        </div>
                    </div>
                {/if}
                <div class="col-md-6 col-lg-3 col-xlg-3">
                    <div class="card card-inverse card-warning">
                        <a href="statistics/sources" class="box text-center">
                            <h1 class="font-light text-white">Источники</h1>
                            <h6 class="text-white">Маркетинг</h6>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 col-xlg-3">
                    <div class="card card-inverse card-primary">
                        <a href="statistics/conversions" class="box text-center">
                            <h1 class="font-light text-white">Конверсии</h1>
                            <h6 class="text-white">Маркетинг</h6>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 col-xlg-3">
                    <div class="card card-inverse card-primary">
                        <a href="statistics/reminders" class="box text-center">
                            <h1 class="font-light text-white">Ремайндеры</h1>
                            <h6 class="text-white">Отчет по Ремайндерам</h6>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 col-xlg-3">
                    <div class="card card-info card-danger">
                        <a href="statistics/divisions" class="box text-center">
                            <h1 class="font-light text-white">Подразделения</h1>
                            <h6 class="text-white">Отчет по Подразделениям</h6>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 col-xlg-3">
                    <div class="card card-primary card-danger">
                        <a href="statistics/active" class="box text-center">
                            <h1 class="font-light text-white">Активные</h1>
                            <h6 class="text-white">Отчет по активным займам</h6>
                        </a>
                    </div>
                </div>
            {/if}
            {if in_array('penalty_statistics', $manager->permissions)}
                <div class="col-md-6 col-lg-3 col-xlg-3">
                    <div class="card card-inverse card-danger">
                        <a href="statistics/penalties" class="box text-center">
                            <h1 class="font-light text-white">Штрафы</h1>
                            <h6 class="text-white">Статистика штрафов</h6>
                        </a>
                    </div>
                </div>
            {/if}
        </div>

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