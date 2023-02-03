{$meta_title = 'Настройки cкорингов' scope=parent}

{capture name='page_scripts'}

    <script src="theme/{$settings->theme}/assets/plugins/nestable/jquery.nestable.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        // Nestable
        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        
        $('#nestable2').nestable({
            group: 1
        }).on('change', updateOutput);

        updateOutput($('#nestable2').data('output', $('#nestable2-output')));

    });
    </script>

{/capture}

{capture name='page_styles'}

    <!--nestable CSS -->
    <link href="theme/{$settings->theme}/assets/plugins/nestable/nestable.css" rel="stylesheet" type="text/css" />

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
                    Настройки скорингов
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Скоринги</li>
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
            
        <div class="row grid-stack" data-gs-width="12" data-gs-animate="yes">

<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Скоринги</h4>
            <div class="myadmin-dd-empty dd" id="nestable2">
                <ol class="dd-list">
                    {foreach $scoring_types as $type}
                    <li class="dd-item dd3-item" data-id="{$type->id}">
                        <div class="dd-handle dd3-handle">
                            <input type="hidden" name="position[]" value="{$type->id}" />
                            <input type="hidden" name="settings[{$type->id}][id]" value="{$type->id}" />
                        </div>
                        <div class="dd3-content"> 
                            <div class="row">
                                <div class="col-8 col-sm-9 col-md-10">
                                    <a href="#content_{$type->id}" data-toggle="collapse" class="text-info collapsed">
                                        <i class="fas fa-minus-circle"></i>
                                        <span>
                                            {$type->title}
                                        </span>
                                        {if $type->negative_action=='stop'}
                                        <span class="label label-warning">Остановить</span>
                                        {/if}
                                        {if $type->negative_action=='reject'}
                                        <span class="label label-danger">Отказ</span>
                                        {/if}
                                        {if $type->negative_action=='next'}
                                        <span class="label label-primary">Продолжить</span>
                                        {/if}
                                    </a>                                    
                                </div>
                                <div class="col-4 col-sm-3 col-md-2">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="settings[{$type->id}][active]" class="onoffswitch-checkbox" value="1" id="active_{$type->id}" {if $type->active}checked="true"{/if} />
                                        <label class="onoffswitch-label" for="active_{$type->id}">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>        
                                </div>
                            </div>
                        </div>
                        
                        <div id="content_{$type->id}" class="card-body collapse scoring-content">
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Если получен негативный тест</label>
                                        <select name="settings[{$type->id}][negative_action]" class="form-control">
                                            <option value="next" {if $type->negative_action=='next'}selected="true"{/if}>Продолжить проверку</option>
                                            <option value="stop" {if $type->negative_action=='stop'}selected="true"{/if}>Остановить проверку</option>
                                            <option value="reject" {if $type->negative_action=='reject'}selected="true"{/if}>Остановить проверки и отказать по заявке</option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label">Причина отказа</label>
                                        <select name="settings[{$type->id}][reason_id]" class="form-control">
                                            <option value="0" {if !$type->reason_id}selected="true"{/if}></option>
                                            {foreach $reasons as $reason}
                                            <option value="{$reason->id}" {if $type->reason_id==$reason->id}selected="true"{/if}>{$reason->admin_name}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                                
                                {if $type->name == 'local_time'}
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Максимальное отклонение, сек</label>
                                        <input type="text" name="settings[{$type->id}][params][max_diff]" value="{$type->params['max_diff']}" class="form-control" placeholder="" />
                                    </div>
                                </div>
                                
                                {elseif $type->name == 'location'}
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Список регионов</label>
                                        <textarea name="settings[{$type->id}][params][regions]" class="form-control">{$type->params['regions']}</textarea>
                                    </div>
                                </div>
                
                                {elseif $type->name == 'fssp' || $type->name == 'fssp2'}
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Сумма долга ПК, руб</label>
                                        <input type="text" name="settings[{$type->id}][params][amount]" value="{$type->params['amount']}" class="form-control" placeholder="" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label">Сумма долга НК, руб</label>
                                        <input type="text" name="settings[{$type->id}][params][amount_nk]" value="{$type->params['amount_nk']}" class="form-control" placeholder="" />
                                    </div>
                                </div>
                
                                {elseif $type->name == 'fms'}
                
                
                                {elseif $type->name == 'fns'}
                
                
                                {elseif $type->name == 'scorista'}
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Проходной бал { $type->name} {$type->params['scorebal']}{settings[{$type->id}][params][scorebal]}</label> {$type->params['scorebal']}
                                        <input type="text" name="settings[{$type->id}][params][scorebal]" value="{$type->params['scorebal']}" class="form-control" placeholder="" />
                                    </div>
                                </div>
                
                
                                {elseif $type->name == 'juicescore'}
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Проходной бал</label>
                                        <input type="text" name="settings[{$type->id}][params][scorebal]" value="{$type->params['scorebal']}" class="form-control" placeholder="" />
                                    </div>
                                </div>

                                {elseif $type->name == 'nbki'}
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="control-label">Рекомендуемая сумма, если количество активных займов 1-5</label>
                                        <input type="text" name="settings[{$type->id}][params][recommended_amount_1_5]" value="{$type->params['recommended_amount_1_5']}" class="form-control" placeholder="" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label">Рекомендуемая сумма, если количество активных займов 6-10</label>
                                        <input type="text" name="settings[{$type->id}][params][recommended_amount_6_10]" value="{$type->params['recommended_amount_6_10']}" class="form-control" placeholder="" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label">Рекомендуемая сумма, если количество активных займов 11-29</label>
                                        <input type="text" name="settings[{$type->id}][params][recommended_amount_11_29]" value="{$type->params['recommended_amount_11_29']}" class="form-control" placeholder="" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label">Рекомендуемая сумма, если количество активных займов 30+</label>
                                        <input type="text" name="settings[{$type->id}][params][recommended_amount_30_]" value="{$type->params['recommended_amount_30_']}" class="form-control" placeholder="" />
                                    </div>
                                </div>
                                {elseif $type->name == 'juicescore'}
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="control-label">Проходной бал</label>
                                            <input type="text" name="settings[{$type->id}][params][scorebal]" value="{$type->params['scorebal']}" class="form-control" placeholder="" />
                                        </div>
                                    </div>

                                {elseif $type->name == 'age'}
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="control-label">Минимальный пороговый возраст</label>
                                            <input type="text" name="settings[{$type->id}][params][min_threshold_age]" value="{$type->params['min_threshold_age']}" class="form-control" placeholder="" />
                                        </div>
                                        <div class="form-group ">
                                            <label class="control-label">Максимальный пороговый возраст</label>
                                            <input type="text" name="settings[{$type->id}][params][max_threshold_age]" value="{$type->params['max_threshold_age']}" class="form-control" placeholder="" />
                                        </div>
                                    </div>
                                {elseif $type->name == 'mbki'}
                                
                                
                                {/if}
                                
                            </div>
                        </div>              
                        
                    </li>
                    {/foreach}
                    
                </ol>
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




