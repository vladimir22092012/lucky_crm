{$meta_title='Зарплаты сотрудников' scope=parent}

{capture name='page_scripts'}

    <script src="theme/manager/assets/plugins/moment/moment.js"></script>
    
    <script src="theme/manager/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="theme/manager/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="theme/manager/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
    $(function(){
        $('.daterange').daterangepicker({
            autoApply: true,
            locale: {
                format: 'DD.MM.YYYY'
            },
            default:''
        });
    })
    </script>

    <script>
        function WagesApp()
        {
            var app = this;
           
            app.init = function(){
                
                app.send_operation();
                
                app.init_search();
            };
            
            app.send_operation = function(){

                $(document).on('click', '.js-send-operation', function(e){
                    e.preventDefault();
                    
                    var operation_id = $(this).data('operation');
                    
                    $.ajax({
                        data: {
                            operation_id: operation_id
                        },
                        success: function(resp){
                            if (!!resp.error)
                                Swal.fire('Ошибка', resp.error, 'error');
                            else
                                Swal.fire('Успешно', resp.success, 'success');
                        }
                    });
                });
            };
            
            app.load = function(_url, loading){
                $.ajax({
                    url: _url,
                    beforeSend: function(){
                        if (loading)
                        {
                            $('.jsgrid-load-shader').show();
                            $('.jsgrid-load-panel').show();
                        }
                    },
                    success: function(resp){
                        
                        
                        if (loading)
                        {
                            $('html, body').animate({
                                scrollTop: $("#basicgrid").offset().top-80  
                            }, 1000);
                            
                            $('.jsgrid-load-shader').hide();
                            $('.jsgrid-load-panel').hide();
                        }
                        
                    }
                })
            };
            
            app.init_search = function(){
                $(document).on('change', '.js-search-block input', function(){

                    var _searches = {};
                    $('.js-search-block input').each(function(){
                        if ($(this).val() != '')
                        {
                            _searches[$(this).attr('name')] = $(this).val();
                        }
                    });     
                    var _request = {

                    };
                    var _query = Object.keys(_request).map(
                        k => encodeURIComponent(k) + '=' + encodeURIComponent(_request[k])
                    ).join('&');
            
                    _request.search = _searches;
                    if (!$.isEmptyObject(_searches))
                    {
                        _query_searches = '';
                        for (key in _searches) {
                          _query_searches += '&search['+key+']='+_searches[key];
                        }
                        _query += _query_searches;
                    }
                    
                    $.ajax({
                        data: _request,
                        beforeSend: function(){
                        },
                        success: function(resp){
                            var _table = $(resp).find('#table_content').html();
console.log(_table)
                            $('#table_content').html(_table)
                        }
                    })
                });
            };
            
            ;(function(){
                app.init();
            })();
        };
        $(function(){
            new WagesApp();
        });
    </script>
{/capture}

{capture name='page_styles'}
    
    <link href="theme/manager/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="theme/manager/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="theme/manager/assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">

    <style>
    .table th td {
        text-align:center!important;
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
                    <span>Зарплаты сотрудников</span>
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Зарплаты сотрудников</li>
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
                        <h4 class="card-title">Зарплаты сотрудников за период {if $date_from}{$date_from|date} - {$date_to|date}{/if}</h4>
                        <form>
                            <input type="hidden" name="report" value="1" />
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    {if $manager->role=='cs_pc'}
                                    <p>{$managers[$manager->id]->name}</p>
                                    <input type="hidden" name="manager_id" value="{$manager->id}" />
                                    {else}
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="manager_id">
                                            <option value=""></option>
                                            {foreach $managers as $m}
                                            {if $m->role == 'cs_pc'}
                                            <option value="{$m->id}" {if $filter_manager_id == $m->id}selected{/if}>{$m->name}</option>
                                            {/if}
                                            {/foreach}
                                        </select>
                                    </div>
                                    {/if}
                                </div>
                                <div class="col-3 col-md-2">
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="month">
                                            {foreach $monthes as $mi => $mn}
                                            <option value="{$mi}" {if $mi == $filter_month}selected{/if}>{$mn}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 col-md-2">
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="year">
                                            {foreach $years as $y}
                                            <option value="{$y}" {if $y == $filter_year}selected{/if}>{$y}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <button type="submit" class="btn btn-info">Сформировать</button>
                                </div>
                            </div>
                            
                        </form>     
                        
                        {if $error}
                        
                        <div class="alert alert-danger">
                            {$error}
                        </div>
                        
                        {elseif $report}                   
                        
                        <table class="table table-hover table-bordered table-striped" id="basicgrid">
                            <thead>
                                <tr class="table-secondary">
                                    <th>Дата</th>
                                    <th>Филиал</th>
                                    <th class="text-center">Время работы</th>
                                    <th class="text-center">ЗП по часам</th>
                                    <th class="text-center">Оплаченные %</th>
                                    <th class="text-center">ЗП с %</th>
                                    <th class="text-center">НК/ПК</th>
                                    <th class="text-center">ЗП доп</th>
                                    <th class="text-center">Выдачи</th>
                                    <th class="text-center">ЗП за день</th>
                                </tr>
                            
                            </thead>
                            
                            <tbody id="table_content">
                                {foreach $report->days as $day}
                                <tr>
                                    <td>
                                        {$day->date|date:'d.m'} 
                                    </td>
                                    <td>
                                        {$day->worktime->offline_point->address}
                                    </td>
                                    <td class="text-center">
                                        {if $day->worktime->open_time && $day->worktime->close_time}
                                            {$day->worktime->open_time|time} - {$day->worktime->close_time|time}
                                        {/if}
                                    </td>
                                    <td class="text-center">
                                        {$day->tariff}
                                    </td>
                                    <td class="text-center">
                                        {$day->day_percents}
                                    </td>
                                    <td class="text-center">
                                        {$day->percents_zp}
                                    </td>
                                    <td class="text-center">
                                        {$day->day_nk} / {$day->day_pk}
                                    </td>
                                    <td class="text-center">
                                        {$day->services}
                                    </td>
                                    <td class="text-center">
                                        {$day->day_inssuance}
                                    </td>
                                    <td class="text-center">
                                        <strong>{$day->day_wage}</strong>
                                    </td>
                                </tr>
                                {/foreach}
                                <tr>
                                    <td colspan="3">
                                        <strong>Всего:</strong>
                                    </td>
                                    <td class="text-center">
                                        {$report->total_wage}
                                    </td>
                                    <td class="text-center">
                                        {$report->total_percents}
                                    </td>
                                    <td class="text-center">
                                        {$report->total_percents}
                                    </td>
                                    <td class="text-center">
                                        {$report->total_nk} / {$report->total_pk}
                                    </td>
                                    <td class="text-center">
                                        {$report->total_services}
                                    </td>
                                    <td class="text-center">
                                        {$report->total_inssuance}
                                    </td>
                                    <td class="text-center">
                                        <strong>{$report->total_wage}</strong>
                                    </td>
                                </tr>
                                
                                {if $report->card}
                                <tr>
                                    <td colspan="9">
                                        <strong>Ежемесячное обслуживание:</strong>
                                    </td>
                                    <td class="text-center">
                                        {$report->card}
                                    </td>
                                </tr>
                                {/if}
                                
                                {if $report->sbor_dr}
                                <tr>
                                    <td colspan="9">
                                        <strong>Сбор на ДР:</strong>
                                    </td>
                                    <td class="text-center">
                                        -{$report->sbor_dr}
                                    </td>
                                </tr>
                                {/if}
                                
                                {if $report->premia_nk}
                                <tr>
                                    <td colspan="9">
                                        <strong>Премия за перевыполнение плана по НК:</strong>
                                    </td>
                                    <td class="text-center">
                                        {$report->premia_nk}
                                    </td>
                                </tr>
                                {/if}
                                
                                {if $report->premia_sbor}
                                <tr>
                                    <td colspan="9">
                                        <strong>Премия за сбор:</strong>
                                    </td>
                                    <td class="text-center">
                                        {$report->premia_sbor}
                                    </td>
                                </tr>
                                {/if}
                                
                                {if $report->penalties}
                                {foreach $report->penalties as $penalty}
                                <tr>
                                    <td colspan="9">
                                        <span>{$penalty->created|date}</span>
                                        <strong class="text-danger">{$penalty->comment}:</strong>
                                    </td> 
                                    <td class="text-center">
                                        - {$penalty->cost}
                                    </td>
                                </tr>
                                {/foreach}
                                {/if}
                                
                                {if $report->total}
                                <tr>
                                    <td colspan="9">
                                        <h5><strong>Итого к выплате:</strong></h5>
                                    </td>
                                    <td class="text-center">
                                        <h5>{$report->total}</h5>
                                    </td>
                                </tr>
                                {/if}

                            </tbody>
                            
                        </table>
                        {else}
                            <div class="alert alert-info">
                                <h4>Выберите параметры для формирования отчета</h4>
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