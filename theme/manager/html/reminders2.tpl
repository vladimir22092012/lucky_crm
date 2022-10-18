{$meta_title = 'Ремайндеры' scope=parent}

{capture name='page_scripts'}

    <script type="text/javascript">

    </script>

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
                <h3 class="text-themecolor mb-0 mt-0">
                    Ремайндеры
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Ремайндеры</li>
                </ol>
            </div>
            <div class="col-md-6 col-4 align-self-center">
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
        <form class="" method="POST" >
            
        <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                                Ремайндеры v2.0
                            </h3>
                        </div>
                        <div class="col-md-6 card-outline-info">
                            <div class="border border-radius">
                                <h5 class="card-header text-white">Количество дней без займа после погашения</h5>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label"></label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            СМС
                                        </div>
                                        <div class="col-md-5">
                                            Звонобот
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">момент погашения</label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_without_a_loan[sms][0]" value="{$settings->days_without_a_loan['sms']['0']}" placeholder="">                                
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_without_a_loan[zvonobot][0]" value="{$settings->days_without_a_loan['zvonobot']['0']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">1 день</label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_without_a_loan[sms][1]" value="{$settings->days_without_a_loan['sms']['1']}" placeholder="">                                
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_without_a_loan[zvonobot][1]" value="{$settings->days_without_a_loan['zvonobot']['1']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">2 дня</label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_without_a_loan[sms][2]" value="{$settings->days_without_a_loan['sms']['2']}" placeholder="">                                
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_without_a_loan[zvonobot][2]" value="{$settings->days_without_a_loan['zvonobot']['2']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">3 дня</label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_without_a_loan[sms][3]" value="{$settings->days_without_a_loan['sms']['3']}" placeholder="">                                
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_without_a_loan[zvonobot][3]" value="{$settings->days_without_a_loan['zvonobot']['3']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">5 дня</label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_without_a_loan[sms][5]" value="{$settings->days_without_a_loan['sms']['5']}" placeholder="">                                
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_without_a_loan[zvonobot][5]" value="{$settings->days_without_a_loan['zvonobot']['5']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">7 дней</label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_without_a_loan[sms][7]" value="{$settings->days_without_a_loan['sms']['7']}" placeholder="">                                
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_without_a_loan[zvonobot][7]" value="{$settings->days_without_a_loan['zvonobot']['7']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">10 дней</label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_without_a_loan[sms][10]" value="{$settings->days_without_a_loan['sms']['10']}" placeholder="">                                
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_without_a_loan[zvonobot][10]" value="{$settings->days_without_a_loan['zvonobot']['10']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">14 дней</label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_without_a_loan[sms][14]" value="{$settings->days_without_a_loan['sms']['14']}" placeholder="">                                    
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_without_a_loan[zvonobot][14]" value="{$settings->days_without_a_loan['zvonobot']['14']}" placeholder="">                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">20 дней</label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_without_a_loan[sms][20]" value="{$settings->days_without_a_loan['sms']['20']}" placeholder="">                                
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_without_a_loan[zvonobot][20]" value="{$settings->days_without_a_loan['zvonobot']['20']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">30 дней</label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_without_a_loan[sms][30]" value="{$settings->days_without_a_loan['sms']['30']}" placeholder="">                                
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_without_a_loan[zvonobot][30]" value="{$settings->days_without_a_loan['zvonobot']['30']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">45 дней</label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_without_a_loan[sms][45]" value="{$settings->days_without_a_loan['sms']['45']}" placeholder="">                                
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_without_a_loan[zvonobot][45]" value="{$settings->days_without_a_loan['zvonobot']['45']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">60 дней</label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_without_a_loan[sms][60]" value="{$settings->days_without_a_loan['sms']['60']}" placeholder="">                                
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_without_a_loan[zvonobot][60]" value="{$settings->days_without_a_loan['zvonobot']['60']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 card-outline-info">
                            <div class="border">
                                <h5 class="card-header text-white">Активный заем. х дней до погашения платежа</h5>
                                                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label"></label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            СМС
                                        </div>
                                        <div class="col-md-5">
                                            Звонобот
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">3</label>
                                        </div>
                                        <div class="col-md-6">                                    
                                            <input type="text" class="form-control" name="days_until_due_date[sms][3]" value="{$settings->days_until_due_date['sms']['3']}" placeholder="">
                                        </div>
                                        <div class="col-md-5">                                    
                                            <input type="text" class="form-control" name="days_until_due_date[zvonobot][3]" value="{$settings->days_until_due_date['zvonobot']['3']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">2</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_until_due_date[sms][2]" value="{$settings->days_until_due_date['sms']['2']}" placeholder="">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_until_due_date[zvonobot][2]" value="{$settings->days_until_due_date['zvonobot']['2']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">1</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_until_due_date[sms][1]" value="{$settings->days_until_due_date['sms']['1']}" placeholder="">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_until_due_date[zvonobot][1]" value="{$settings->days_until_due_date['zvonobot']['1']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="card-header text-white">Дата платежа. Время по мск</h6>
                                    <div class="form-group mb-3 p-2">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label class=" col-form-label">6</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="days_until_due_date[sms][0][6]" value="{$settings->days_until_due_date['sms']['0'][6]}" placeholder="">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="days_until_due_date[zvonobot][0][6]" value="{$settings->days_until_due_date['zvonobot']['0'][6]}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 p-2">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label class=" col-form-label">9</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="days_until_due_date[sms][0][9]" value="{$settings->days_until_due_date['sms']['0'][9]}" placeholder="">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="days_until_due_date[zvonobot][0][9]" value="{$settings->days_until_due_date['zvonobot']['0'][9]}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 p-2">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label class=" col-form-label">12</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="days_until_due_date[sms][0][12]" value="{$settings->days_until_due_date['sms']['0'][12]}" placeholder="">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="days_until_due_date[zvonobot][0][12]" value="{$settings->days_until_due_date['zvonobot']['0'][12]}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 p-2">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label class=" col-form-label">15</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="days_until_due_date[sms][0][15]" value="{$settings->days_until_due_date['sms']['0'][15]}" placeholder="">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="days_until_due_date[zvonobot][0][15]" value="{$settings->days_until_due_date['zvonobot']['0'][15]}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 p-2">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label class=" col-form-label">18</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="days_until_due_date[sms][0][18]" value="{$settings->days_until_due_date['sms']['0'][18]}" placeholder="">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="days_until_due_date[zvonobot][0][18]" value="{$settings->days_until_due_date['zvonobot']['0'][18]}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 p-2">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label class=" col-form-label">21</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="days_until_due_date[sms][0][21]" value="{$settings->days_until_due_date['sms']['0'][21]}" placeholder="">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="days_until_due_date[zvonobot][0][21]" value="{$settings->days_until_due_date['zvonobot']['0'][21]}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 card-outline-info">
                            <div class="border">
                                <h5 class="card-header text-white">Раздел уведомления одобренных</h5>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label"></label>
                                        </div>
                                        <div class="col-md-6">
                                            СМС
                                        </div>
                                        <div class="col-md-5">
                                            Звонобот
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">1</label>                                    
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_since_approval[sms][1]" value="{$settings->days_since_approval['sms']['1']}" placeholder="">                                    
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_since_approval[zvonobot][1]" value="{$settings->days_since_approval['zvonobot']['1']}" placeholder="">                                    
                                        </div>
                                    </div>
                                    <div class="">
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">2</label>
                                        </div>
                                        <div class="col-md-6">                                    
                                            <input type="text" class="form-control" name="days_since_approval[sms][2]" value="{$settings->days_since_approval['sms']['2']}" placeholder="">
                                        </div>
                                        <div class="col-md-5">                                    
                                            <input type="text" class="form-control" name="days_since_approval[zvonobot][2]" value="{$settings->days_since_approval['zvonobot']['2']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class=" col-form-label">3</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="days_since_approval[sms][3]" value="{$settings->days_since_approval['sms']['3']}" placeholder="">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="days_since_approval[zvonobot][3]" value="{$settings->days_since_approval['zvonobot']['3']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 card-outline-info">
                            <div class="border">
                                <h5 class="card-header text-white">Продажа отказного трафика по смс:</h5>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">Момент отказа</label>                                    
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="sales_by_sms[0]" value="{$settings->sales_by_sms['0']}" placeholder="">                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">30 минут после отказа</label>
                                        </div>
                                        <div class="col-md-9">                                    
                                            <input type="text" class="form-control" name="sales_by_sms[30]" value="{$settings->sales_by_sms['30']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">60 минут после отказа</label>
                                        </div>
                                        <div class="col-md-9">                                    
                                            <input type="text" class="form-control" name="sales_by_sms[60]" value="{$settings->sales_by_sms['60']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <hr class="mb-3 mt-3" />
            <div class="col-12 grid-stack-item" data-gs-x="0" data-gs-y="0" data-gs-width="12">
                                    список переменных
                    <br>
                    <br>
                    <span>&#123;</span>сумма<span>&#125;</span> - сумма займа<br>
                    <span>&#123;</span>номер<span>&#125;</span> - номер займа<br>
                    <span>&#123;</span>имя<span>&#125;</span> - имя клиента<br>
            </div>
        <hr class="mb-3 mt-3" />
        <div class="row">
            <div class="col-12 grid-stack-item" data-gs-x="0" data-gs-y="0" data-gs-width="12">
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Сохранить</button>
                </div>
            </div>
        </form>
        <!-- Row -->
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    {include file='footer.tpl'}
    <!-- ============================================================== -->
</div>



