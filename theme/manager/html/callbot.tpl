{$meta_title = 'Настройки звонобота' scope=parent}
{capture name='page_scripts'}
    <script src="https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script>
        $(function () {
           $('input[name="time"]').mask('99:99');
        });
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
                    Настройки звонобота
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Звонобот</li>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row mt-3">
                                    <div class="col-2">
                                        <label class=" col-form-label">Текст звонобота</label>
                                    </div>
                                    <div class="col-6">
                                        <textarea type="text" class="form-control" name="textCallBot" placeholder="">{$callBotSettings->textCallBot}</textarea>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-2">
                                        <label class=" col-form-label">Время отправки сообщения</label>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="time" placeholder="" value="{$callBotSettings->time|time}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-2">
                                        <label class=" col-form-label">Периодичность</label>
                                    </div>
                                    <div class="col-2">
                                        <select class="form-control" name="periods">
                                            <option value="everyDay" {if $callBotSettings->periods == 'everyDay'}selected{/if}>Каждый день</option>
                                            <option value="twiceDay" {if $callBotSettings->periods == 'twiceDay'}selected{/if}>Раз в 2 дня</option>
                                            <option value="thriceDay" {if $callBotSettings->periods == 'thriceDay'}selected{/if}>Раз в 3 дня</option>
                                            <option value="oneToWeek" {if $callBotSettings->periods == 'oneToWeek'}selected{/if}>Раз в неделю</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-2">
                                        <label class=" col-form-label">Текст смс сообщения</label>
                                    </div>
                                    <div class="col-6">
                                        <textarea type="text" class="form-control" name="textSms" placeholder="">{$callBotSettings->textSms}</textarea>
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




