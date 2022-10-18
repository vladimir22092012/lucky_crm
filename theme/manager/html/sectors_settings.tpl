{$meta_title = 'Сектора' scope=parent}

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
                <h3 class="text-themecolor mb-0 mt-0">
                    Сектора
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Сектора</li>
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
                            МИНБ
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">PAY_CREDIT</label>
                                <div class="">
                                    <input type="text" class="form-control" name="sectors[MINB][PAY_CREDIT]" value="{$settings->sectors['MINB']['PAY_CREDIT']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">RECURRENT</label>
                                <div class="">
                                    <input type="text" class="form-control" name="sectors[MINB][RECURRENT]" value="{$settings->sectors['MINB']['RECURRENT']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">ADD_CARD</label>
                                <div class="">
                                    <input type="text" class="form-control" name="sectors[MINB][ADD_CARD]" value="{$settings->sectors['MINB']['ADD_CARD']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">PAYMENT</label>
                                <div class="">
                                    <input type="text" class="form-control" name="sectors[MINB][PAYMENT]" value="{$settings->sectors['MINB']['PAYMENT']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">YUK</label>
                                <div class="">
                                    <input type="text" class="form-control" name="sectors[MINB][YUK]" value="{$settings->sectors['MINB']['YUK']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">PREMIER</label>
                                <div class="">
                                    <input type="text" class="form-control" name="sectors[MINB][PREMIER]" value="{$settings->sectors['MINB']['PREMIER']}" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h3 class="box-title">
                            СНГБ
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">PAY_CREDIT</label>
                                <div class="">
                                    <input type="text" class="form-control" name="sectors[SNGB][PAY_CREDIT]" value="{$settings->sectors['SNGB']['PAY_CREDIT']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">RECURRENT</label>
                                <div class="">
                                    <input type="text" class="form-control" name="sectors[SNGB][RECURRENT]" value="{$settings->sectors['SNGB']['RECURRENT']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">ADD_CARD</label>
                                <div class="">
                                    <input type="text" class="form-control" name="sectors[SNGB][ADD_CARD]" value="{$settings->sectors['SNGB']['ADD_CARD']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">PAYMENT</label>
                                <div class="">
                                    <input type="text" class="form-control" name="sectors[SNGB][PAYMENT]" value="{$settings->sectors['SNGB']['PAYMENT']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">YUK</label>
                                <div class="">
                                    <input type="text" class="form-control" name="sectors[SNGB][YUK]" value="{$settings->sectors['SNGB']['YUK']}" placeholder="">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">PREMIER</label>
                                <div class="">
                                    <input type="text" class="form-control" name="sectors[SNGB][PREMIER]" value="{$settings->sectors['SNGB']['PREMIER']}" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        
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