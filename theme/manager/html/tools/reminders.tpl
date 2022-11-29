{$meta_title = 'Интеграции' scope=parent}

{capture name='page_scripts'}
    <script type="text/javascript" src="theme/{$settings->theme|escape}/js/apps/toolsReminders.js"></script>
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
                    Интеграции
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Инструменты</a></li>
                    <li class="breadcrumb-item active">Ремайндеры</li>
                </ol>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
        <form class="" method="POST">
            <div class="card">
                <div class="card-body">
                    <div class="big-table">
                        <table id="config-table"
                               class="table table-hover"
                               style="display: inline-block; vertical-align: top; max-width: 100%; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch;">
                            <thead style="background-color: #009efb">
                            <tr>
                                <th class="col-2 jsgrid-header-cell jsgrid-align-right jsgrid-header-sortable {if $sort == 'index_number_desc'}jsgrid-header-sort jsgrid-header-sort-desc{elseif $sort == 'index_number_asc'}jsgrid-header-sort jsgrid-header-sort-asc{/if}">
                                    {if $sort == 'index_number_asc'}
                                        <a href="{url page=null sort='index_number_desc'}">#</a>
                                    {else}
                                        <a style="color: white" href="{url page=null sort='index_number_asc'}">#</a>
                                    {/if}
                                </th>
                                <th class="col-2">
                                    {if $sort == 'segment_asc'}
                                        <a style="color: white"
                                           href="{url page=null sort='segment_desc'}">Сегмент</a>
                                    {else}
                                        <a style="color: white"
                                           href="{url page=null sort='segment_asc'}">Сегмент</a>
                                    {/if}
                                </th>
                                <th class="col-3">
                                    {if $sort == 'event_asc'}
                                        <a style="color: white" href="{url page=null sort='event_desc'}">Событие</a>
                                    {else}
                                        <a style="color: white" href="{url page=null sort='event_asc'}">Событие</a>
                                    {/if}
                                </th>
                                <th class="col-2">
                                    {if $sort == 'message_asc'}
                                        <a style="color: white"
                                           href="{url page=null sort='message_desc'}">Сообщение</a>
                                    {else}
                                        <a style="color: white"
                                           href="{url page=null sort='message_asc'}">Сообщение</a>
                                    {/if}
                                </th>
                                <th class="col-2">
                                    {if $sort == 'sender_asc'}
                                        <a style="color: white"
                                           href="{url page=null sort='sender_desc'}">Отправитель</a>
                                    {else}
                                        <a style="color: white"
                                           href="{url page=null sort='sender_asc'}">Отправитель</a>
                                    {/if}
                                </th>
                                <th class="col-2">
                                    {if $sort == 'updated_at_asc'}
                                        <a style="color: white"
                                           href="{url page=null sort='updated_at_desc'}">Изменен</a>
                                    {else}
                                        <a style="color: white"
                                           href="{url page=null sort='updated_at_asc'}">Изменен</a>
                                    {/if}
                                </th>
                                <th>

                                </th>
                                <th>

                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <hr class="mb-3 mt-3"/>

            <div class="row">
                <div class="col-12 grid-stack-item" data-gs-x="0" data-gs-y="0" data-gs-width="12">
                    <div class="btn btn-outline-success addReminder">Добавить</div>
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

<div id="addReminderModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Добавить ремайндер</h4>
            </div>
            <div class="modal-body">
                <form id="addReminderForm">
                    <input type="hidden" name="action" value="addReminder">
                    <div class="form-group" style="display:flex; flex-direction: column">
                        <div class="form-group">
                            <label>Событие</label>
                            <select type="text" name="event"
                                    class="form-control">
                                <option value="0">Выберите событие</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Дней/Часов</label>
                            <select type="text" name="typeTime"
                                    class="form-control">
                                <option value="0">Выберите тип</option>
                                <option value="days">Дней</option>
                                <option value="hours">Часов</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Количество</label>
                            <input type="text" name="count"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Сообщение (СМС)</label>
                            <input type="text" name="msgSms"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Сообщение (Звонобот)</label>
                            <input type="text" name="msgZvon"
                                   class="form-control"/>
                        </div>
                    <div>
                        <input type="button" class="btn btn-danger cancel" data-dismiss="modal" value="Отмена">
                        <input type="button" class="btn btn-success float-right" value="Сохранить">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
