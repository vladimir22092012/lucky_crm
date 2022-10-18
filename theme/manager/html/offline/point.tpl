{if $point->id}
    {$meta_title="Редактировать оффлайн-отделение" scope=parent}
{else}
    {$meta_title="Создать оффлайн-отделение" scope=parent}
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
                    {if $point->id}
                        {$point->name|escape}
                    {else}
                        Новое Оффлайн-отделения
                    {/if}
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="offline_points">Оффлайн-отделения</a></li>
                    {if $point->id}
                    <li class="breadcrumb-item active">{$point->address}</li>
                    {else}
                    <li class="breadcrumb-item active">Новый</li>
                    {/if}
                </ol>
            </div>
            <div class="col-md-6 col-4 align-self-center">
            </div>
        </div>

        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#settings" role="tab"> <span class="">Настройки</span></a> </li>
            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#kassa" role="tab"> <span class="">Касса</span></a> </li>
        </ul>
                        
        <div class="tab-content tabcontent-border">
            <div class="tab-pane active" id="settings" role="tabpanel">
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
                                        
                                        <input type="hidden" name="id" value="{$point->id}" />
                                        
                                        <div class="p-2 pt-4">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-5 ">
                                                        <label class="control-label">Организация</label>
                                                    </div>
                                                    <div class="col-7 ">
                                                        <select name="organization_id" class="form-control">
                                                            <option value=""></option>
                                                            {foreach $organizations as $org}
                                                            <option value="{$org->id}" {if $org->id==$point->organization_id}selected{/if}>{$org->name}</option>
                                                            {/foreach}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-5 ">
                                                        <label class="control-label">Код </label>
                                                    </div>
                                                    <div class="col-7 ">
                                                        <input type="text" class="form-control" name="code" value="{$point->code|escape}" readonly="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-5 ">
                                                        <label class="control-label">Город</label>
                                                    </div>
                                                    <div class="col-7 ">
                                                        <input type="text" class="form-control" name="city" value="{$point->city|escape}" required="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-5 ">
                                                        <label class="control-label">Адрес</label>
                                                    </div>
                                                    <div class="col-7 ">
                                                        <textarea class="form-control" name="address">{$point->address}</textarea>
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
                                                        <label class="control-label">Часовой пояс</label>
                                                    </div>
                                                    <div class="col-7 ">
                                                        <input type="text" class="form-control" name="timezone" value="{$point->timezone}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-5 ">
                                                        <label class="control-label">Время открытия</label>
                                                    </div>
                                                    <div class="col-7 ">
                                                        <input type="text" class="form-control" name="open_time" value="{$point->open_time}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-5 ">
                                                        <label class="control-label">Время закрытия</label>
                                                    </div>
                                                    <div class="col-7 ">
                                                        <input type="text" class="form-control" name="close_time" value="{$point->close_time}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-5 ">
                                                        <label class="control-label">Часoвая ставка</label>
                                                    </div>
                                                    <div class="col-7 ">
                                                        <input type="text" class="form-control" name="tariff" value="{$point->tariff}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-5 ">
                                                        <label class="control-label">IP адрес</label>
                                                    </div>
                                                    <div class="col-7 ">
                                                        <input type="text" class="form-control" name="ip" value="{$point->ip}" />
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
            </div>
            <div class="tab-pane  p-3" id="kassa" role="tabpanel">
                <div class="card card-outline-info">
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                            
                            </div>
                        </form>
                    </div>
                </div>
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


