{if $loantype->id}
    {$meta_title="Редактировать организацию" scope=parent}
{else}
    {$meta_title="Создать организаацию" scope=parent}
{/if}

{capture name='page_scripts'}

{/capture}

{capture  name='page_styles'}
    <style>
        .onoffswitch {
            display:inline-block!important;
            vertical-align:top!important;
            width:60px!important;
            text-align:left;
        }
        .onoffswitch-switch {
            right:38px!important;
            border-width:1px!important;
        }
        .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
            right:0px!important;
        }
        .onoffswitch-label {
            margin-bottom:0!important;
            border-width:1px!important;
        }
        .onoffswitch-inner::after, 
        .onoffswitch-inner::before {
            height:18px!important;
            line-height:18px!important;
        }
        .onoffswitch-switch {
            width:20px!important;
            margin:1px!important;
        }
        .onoffswitch-inner::before {
            content:'ВКЛ'!important;
            padding-left: 10px!important;
            font-size:10px!important;
        }
        .onoffswitch-inner::after {
            content:'ВЫКЛ'!important;
            padding-right: 6px!important;
            font-size:10px!important;
        }
        
        .scoring-content {
            position:relative;
            z-index:999;
            border:1px solid rgba(120, 130, 140, 0.13);;
            border-top:0;
            background:#fff;
            border-bottom-left-radius:4px;
            border-bottom-right-radius:4px;
            margin-top: -5px;
        }
        
        .collapsed .fa-minus-circle::before {
            content: "\f055";
        }
        h4.text-white {
            display:inline-block
        }
        .move-zone {
            display:inline-block;
            color:#fff;
            padding-right:15px;
            margin-right:10px;
            border-right:1px solid #30b2ff;
            cursor:move
        }
        .move-zone span {
            font-size:24px;
        }
        
        .dd {
            max-width:100%;
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
                    {if $organization->id}
                        {$organization->name|escape}
                    {else}
                        Новая организация
                    {/if}
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="offline_organizations">Организации</a></li>
                    {if $organization->id}
                    <li class="breadcrumb-item active">{$organization->name}</li>
                    {else}
                    <li class="breadcrumb-item active">Новый</li>
                    {/if}
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
        <div class="card card-outline-info">
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        
                        {if $success}
                        <div class="col-12">
                            <div class="alert alert-success">
                                {$success}
                            </div>
                        </div>
                        {/if}
                        
                        {if $error}
                        <div class="col-12">
                            <div class="alert alert-danger">
                                <h3 class="pl-5">Ошибка</h3>
                                <ul>
                                    <li>{$error}</li>
                                </ul>
                            </div>
                        </div>
                        {/if}
                        
                        <div class="col-md-6">
                            <div class="border">
                                <h5 class="card-header"><span class="text-white">Обшие</span></h5>
                                
                                <input type="hidden" name="id" value="{$organization->id}" />
                                
                                <div class="p-2 pt-4">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-5 ">
                                                <label class="control-label">Наименование</label>
                                            </div>
                                            <div class="col-7 ">
                                                <input type="text" class="form-control" name="name" value="{$organization->name|escape}" required="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-5 ">
                                                <label class="control-label">Код организации</label>
                                            </div>
                                            <div class="col-7 ">
                                                <input type="text" class="form-control" name="code" value="{$organization->code|escape}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-5 ">
                                                <label class="control-label">Наименование полное</label>
                                            </div>
                                            <div class="col-7 ">
                                                <input type="text" class="form-control" name="full_name" value="{$organization->full_name|escape}" required="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-5 ">
                                                <label class="control-label">Юридический адрес</label>
                                            </div>
                                            <div class="col-7 ">
                                                <textarea class="form-control" name="yur_address">{$organization->yur_address}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-5 ">
                                                <label class="control-label">Фактический адрес</label>
                                            </div>
                                            <div class="col-7 ">
                                                <textarea class="form-control" name="fakt_address">{$organization->fakt_address}</textarea>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">                            
                            <div class="border">
                                <h5 class="card-header"><span class="text-white">Параметры </span></h5>
                                <div class="p-2 pt-4">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-5 ">
                                                <label class="control-label">ИНН</label>
                                            </div>
                                            <div class="col-7 ">
                                                <input type="text" class="form-control" name="inn" value="{$organization->inn}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-5 ">
                                                <label class="control-label">ОГРН</label>
                                            </div>
                                            <div class="col-7 ">
                                                <input type="text" class="form-control" name="ogrn" value="{$organization->ogrn}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-5 ">
                                                <label class="control-label">Рег. номер МФО</label>
                                            </div>
                                            <div class="col-7 ">
                                                <input type="text" class="form-control" name="reg_number" value="{$organization->reg_number}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-5 ">
                                                <label class="control-label">Директор</label>
                                            </div>
                                            <div class="col-7 ">
                                                <input type="text" class="form-control" name="director_name" value="{$organization->director_name}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-5 ">
                                                <label class="control-label">Комиссия при пролонгации</label>
                                            </div>
                                            <div class="col-7 ">
                                                <input type="text" class="form-control" name="commission" value="{$organization->commission}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        
                        <div class="col-12">
                            <hr class="m-2" />
                            <div class="text-right">
                                <button type="submit" class="btn btn-success btn-lg">Сохранить</button>
                            </div>                                                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
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


