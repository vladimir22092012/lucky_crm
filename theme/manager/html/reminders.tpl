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
                                Ремайндеры
                            </h3>
                        </div>
                        <div class="col-md-6 card-outline-info">
                            <div class="border border-radius">
                                <h5 class="card-header text-white">Количество дней без займа (смс)</h5>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">1 день</label>                                    
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_without_a_loan[1]" value="{$settings->days_without_a_loan['1']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">3 дня</label>                                    
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_without_a_loan[2]" value="{$settings->days_without_a_loan['3']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">7 дней</label>                                    
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_without_a_loan[7]" value="{$settings->days_without_a_loan['7']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">14 дней</label>                                    
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_without_a_loan[14]" value="{$settings->days_without_a_loan['14']}" placeholder="">                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">30 дней</label>                                    
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_without_a_loan[30]" value="{$settings->days_without_a_loan['30']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">60 дней</label>                                    
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_without_a_loan[60]" value="{$settings->days_without_a_loan['60']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">90 дней</label>                                    
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_without_a_loan[90]" value="{$settings->days_without_a_loan['90']}" placeholder="">                                
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">180</label>                                    
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_without_a_loan[180]" value="{$settings->days_without_a_loan['180']}" placeholder="">                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 card-outline-info">
                            <div class="border">
                                <h5 class="card-header text-white">Количество дней до даты платежа (IVR)</h5>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">4</label>                                    
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_until_due_date[4]" value="{$settings->days_until_due_date['4']}" placeholder="">                                    
                                        </div>
                                    </div>
                                    <div class="">
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">3</label>
                                        </div>
                                        <div class="col-md-9">                                    
                                            <input type="text" class="form-control" name="days_until_due_date[3]" value="{$settings->days_until_due_date['3']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">2</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_until_due_date[2]" value="{$settings->days_until_due_date['2']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">1</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_until_due_date[1]" value="{$settings->days_until_due_date['1']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">0</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_until_due_date[0]" value="{$settings->days_until_due_date['0']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 card-outline-info">
                            <div class="border">
                                <h5 class="card-header text-white">Количество дней с момента одобрения.</h5>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">1</label>                                    
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_since_approval[1]" value="{$settings->days_since_approval['1']}" placeholder="">                                    
                                        </div>
                                    </div>
                                    <div class="">
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">2</label>
                                        </div>
                                        <div class="col-md-9">                                    
                                            <input type="text" class="form-control" name="days_since_approval[2]" value="{$settings->days_since_approval['2']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">3</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_since_approval[3]" value="{$settings->days_since_approval['3']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">4</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_since_approval[4]" value="{$settings->days_since_approval['4']}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 p-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class=" col-form-label">5</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="days_since_approval[5]" value="{$settings->days_since_approval['5']}" placeholder="">
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
                                    <div class="">
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




