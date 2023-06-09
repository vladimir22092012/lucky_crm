{$meta_title="Заявка №`$order->order_id`" scope=parent}

{capture name='page_scripts'}

    <!--script src="theme/{$settings->theme|escape}/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script-->
    <script src="theme/{$settings->theme|escape}/assets/plugins/fancybox3/dist/jquery.fancybox.js"></script>
    <script type="text/javascript" src="theme/{$settings->theme|escape}/js/apps/order.js?v=1.28"></script>
    <script type="text/javascript" src="theme/{$settings->theme|escape}/js/apps/movements.app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>
    <script>
        $(function () {
            let phone_num = "{$order->phone_mobile}";
            let firstname = "{$order->firstname}";
            let lastname = "{$order->lastname}";
            let patronymic = "{$order->patronymic}";

            let token_dadata = "25c845f063f9f3161487619f630663b2d1e4dcd7";

            $('.Regadress').suggestions({
                token: token_dadata,
                type: "ADDRESS",
                minChars: 3,
                /* Вызывается, когда пользователь выбирает одну из подсказок */
                onSelect: function (suggestion) {
                    $('input[name="Regadressfull"]').val(suggestion.value);
                    $('.Registration').val(JSON.stringify(suggestion));
                    $(this).val('');
                }
            });

            $('.Faktaddress').suggestions({
                token: token_dadata,
                type: "ADDRESS",
                minChars: 3,
                /* Вызывается, когда пользователь выбирает одну из подсказок */
                onSelect: function (suggestion) {
                    $('input[name="Faktadressfull"]').val(suggestion.value);
                    $('.Fakt_adress').val(JSON.stringify(suggestion));
                    $(this).val('');
                }
            });

            $('.saveAddress').on('click', function () {

                let form = $(this).closest('form').serialize();

                $.ajax({
                    method: 'POST',
                    data: form,
                    success: function () {
                        location.reload();
                    }
                });
            });

            $.ajax({
                url: "ajax/BlacklistCheck.php",
                data: {
                    phone_num: phone_num,
                    firstname: firstname,
                    lastname: lastname,
                    patronymic: patronymic
                },
                method: 'POST',
                success: function (suc) {
                    if (suc == 1) {
                        $('.form-check-input').attr('checked', 'checked');
                    }
                }
            });

            $.ajax({
                url: "ajax/RfmCheck.php",
                data: {
                    phone_num: phone_num,
                    firstname: firstname,
                    lastname: lastname,
                    patronymic: patronymic
                },
                method: 'POST',
                success: function (suc) {
                    if (suc == 1) {
                        $('.form-check-input').attr('checked', 'checked');
                    }
                }
            });

            $(document).on('click', '.form-check-input', function () {
                $.post({
                    url: "ajax/BlacklistAddDelete.php",
                    data: {
                        phone_num: phone_num,
                        firstname: firstname,
                        lastname: lastname,
                        patronymic: patronymic
                    },
                })
            });

            $('.juiceScoreModal').on('click', function (e) {
                e.preventDefault();

                $('#juiceScoreModal').modal();
            });

            $('.equifaxScoreModal').on('click', function (e) {
                e.preventDefault();

                $('#equifaxScoreModal').modal();
            });

            $('.editLoanProfit').on('click', function () {
                $('#editLoanProfitModal').modal();
            });

            $('.saveEditLoanProfit').on('click', function () {
                let form = $(this).closest('form').serialize();

                $.ajax({
                    method: 'POST',
                    data: form,
                    success: function () {
                        location.reload();
                    }
                });
            });

            $('.add_pay').on('click', function () {
                $('#addPayModal').modal();
            });
        })
    </script>
    <script>
        function show_changes() {
            var x = document.getElementById("myDIV");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
{/capture}

{capture name='page_styles'}
    <link href="theme/{$settings->theme|escape}/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css"
          rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/css/suggestions.min.css" rel="stylesheet"/>
    <!--link href="theme/{$settings->theme|escape}/assets/plugins/fancybox3/dist/jquery.fancybox.css?v=1.03" rel="stylesheet" /-->
    <style>
        .js-open-popup-image .label {
            position: absolute;
            bottom: 2px;
            left: 2px;
        }

        .js-fancybox-approve.btn-success {
            background: #55ce63;
            border: 1px solid #55ce63;
        }

        .js-fancybox-approve.btn-outline-success {
            color: #55ce63;
            background-color: transparent;
            border-color: #55ce63
        }

        .js-fancybox-reject.btn-danger {
            background: #f62d51;
            border: 1px solid #f62d51
        }

        .js-fancybox-reject.btn-outline-danger {
            color: #f62d51;
            background-color: transparent;
            border-color: #f62d51;
        }
    </style>
{/capture}

{function name='penalty_button'}

    {if in_array('add_penalty', $manager->permissions)}
        {*
        {if !$penalties[$penalty_block]}
            <button type="button" class="pb-0 pt-0 mr-2 btn btn-sm btn-danger waves-effect js-add-penalty "
                    data-block="{$penalty_block}">
                <i class="fas fa-ban"></i>
                <span>Штраф</span>
            </button>
        {elseif $penalties[$penalty_block] && in_array($penalties[$penalty_block]->status, [1,2])}
            <button type="button" class="pb-0 pt-0 mr-2 btn btn-sm btn-primary waves-effect js-reject-penalty "
                    data-penalty="{$penalties[$penalty_block]->id}">
                <i class="fas fa-ban"></i>
                <span>Отменить</span>
            </button>
            <button type="button" class="pb-0 pt-0 mr-2 btn btn-sm btn-warning waves-effect js-strike-penalty "
                    data-penalty="{$penalties[$penalty_block]->id}">
                <i class="fas fa-ban"></i>
                <span>Страйк</span>
            </button>
        {/if}
        {if in_array($penalties[$penalty_block]->status, [4])}
            <span class="label label-warning">Страйк ({$penalties[$penalty_block]->cost} руб)</span>
        {/if}
    {elseif $penalties[$penalty_block]->manager_id == $manager->id}
        {if in_array($penalties[$penalty_block]->status, [1])}
            <button class="pb-0 pt-0 mr-2 btn btn-sm btn-primary js-correct-penalty"
                    data-penalty="{$penalties[$penalty_block]->id}" type="button">Исправить
            </button>
        {/if}
        {if in_array($penalties[$penalty_block]->status, [4])}
            <span class="label label-warning">Страйк ({$penalties[$penalty_block]->cost} руб)</span>
        {/if}
        *}
    {/if}
{/function}

<div class="page-wrapper js-event-add-load" data-event="1" data-manager="{$manager->id}" data-order="{$order->order_id}"
     data-user="{$order->user_id}">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    {if in_array($contract->status, [2,4]) && !in_array('collectors', $manager->permissions) && $contract->sold == 1}
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="text-themecolor mb-0 mt-0"><i class="mdi mdi-animation"></i> Заявка №{$order->order_id}
                    </h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Главная</a></li>
                        <li class="breadcrumb-item"><a href="orders">Заявки</a></li>
                        <li class="breadcrumb-item active">Заявка №{$order->order_id}</li>
                    </ol>
                </div>
            </div>
            <div class="row" id="order_wrapper">
                <div class="view-block" style="width: 300px;">
                    <h5>
                        <a href="client/{$order->user_id}" title="Перейти в карточку клиента">
                            {$order->lastname|escape}
                            {$order->firstname|escape}
                            {$order->patronymic|escape}
                        </a>
                    </h5>
                    <h3>
                        <span>{$order->phone_mobile|escape}</span>
                    </h3>
                    <h5>
                        <span>Договор: {$contract->number}</span><br><br>
                        <span>Дата заявки: {$order->date|date} {$order->date|time}</span>
                    </h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1">
                        <label class="form-check-label" for="flexCheckDefault">
                            Находится в ч/с
                        </label>
                    </div>
                </div>
                <div style="text-align: center; width: 30%; margin-left: 200px; background-color: rgba(255,0,0,0.6); border-radius: 6px;">
                    <h5 style="text-align: center; color: white; margin:50px">Право требования задолженности по договору
                        уступлено в ООО "Юридическая компания № 1"
                        Адрес 443093, г. Самара, ул. Мориса Тореза, д. 1А, офис 513 , тел.8-800-222-76-69</h5>
                </div>
            </div>
        </div>
    {else}
        <div class="container-fluid">

            <div class="row page-titles">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="text-themecolor mb-0 mt-0"><i class="mdi mdi-animation"></i> Заявка №{$order->order_id}
                    </h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Главная</a></li>
                        <li class="breadcrumb-item"><a href="orders">Заявки</a></li>
                        <li class="breadcrumb-item active">Заявка №{$order->order_id}</li>
                    </ol>
                </div>
                <div class="col-md-6 col-4 align-self-center">
                    <h1 class="text-right p-1" id="ordertimer">
                        {if $ordertimer->last_time}
                            <div class="text-primary js-ordertimer text-center float-right" style="width:150px"
                                 data-time="{$ordertimer->last_time}"></div>
                        {/if}
                    </h1>
                </div>
            </div>

            {if $alert}
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-danger text-center">
                            Внимание!<br/>
                            У данного клиента зафиксирована задублированная оплата<br/>
                            Не производите никаких действий до решения проблемы!<br/>
                            Ориентировочное время решения 20:00 МСК
                        </h1>
                    </div>
                </div>
            {/if}

            <div class="row" id="order_wrapper">
                <div class="col-lg-12">
                    <div class="card card-outline-info">

                        <div class="card-body">

                            <div class="form-body">
                                <div class="row">
                                    <div class="col-4 col-md-3 col-lg-2">
                                        <h4 class="form-control-static">
                                            {if $order->client_status}
                                                {if $order->client_status == 'pk'}
                                                    <span class="label label-success"
                                                          title="Клиент уже имеет погашенные займы">ПК</span>
                                                {elseif $order->client_status == 'crm'}
                                                    <span class="label label-primary"
                                                          title="Клиент уже имеет погашенные займы в CRM">ПК CRM</span>
                                                {elseif $order->client_status == 'rep'}
                                                    <span class="label label-warning"
                                                          title="Клиент уже подавал ранее заявки">Повтор</span>
                                                {elseif $order->client_status == 'nk'}
                                                    <span class="label label-info" title="Новый клиент">Новая</span>
                                                {/if}
                                            {else}
                                                {if $order->have_crm_closed}
                                                    <span class="label label-primary"
                                                          title="Клиент уже имеет погашенные займы в CRM">ПК CRM</span>
                                                {elseif $order->first_loan}
                                                    <span class="label label-info" title="Новый клиент">Новая</span>
                                                {else}
                                                    <span class="label label-success"
                                                          title="Клиент уже имеет погашенные займы">ПК</span>
                                                {/if}
                                            {/if}
                                        </h4>
                                    </div>
                                    <div class="col-8 col-md-3 col-lg-3">
                                        <h5 class="form-control-static float-left">
                                            дата заявки: {$order->date|date} {$order->date|time}
                                        </h5>
                                        {if $order->penalty_date}
                                            <h5 class="form-control-static float-left">
                                                дата решения: {$order->penalty_date|date} {$order->penalty_date|time}
                                            </h5>
                                        {/if}
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-2 ">
                                        <h5 class="form-control-static">
                                            Источник:
                                            {if $order->utm_source}
                                                {$order->utm_source|escape} {if !empty($order->webmaster_id)}({$order->webmaster_id|escape}){/if}
                                            {else}
                                                не определен
                                            {/if}
                                        </h5>
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-2 ">
                                        {if $looker_link && !$order->offline}
                                            <a href="{$looker_link}" target="_blank" class="btn btn-info float-right"><i
                                                        class=" fas fa-address-book"></i> Смотреть ЛК</a>
                                        {/if}
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3 ">
                                        <h5 class="js-order-manager text-right">
                                            {if in_array($manager->role, ['developer', 'admin', 'big_user'])}
                                                <select class="js-order-manager form-control"
                                                        data-order="{$order->order_id}" name="manager_id">
                                                    <option value="0" {if !$order->manager_id}selected="selected"{/if}>
                                                        Не принята
                                                    </option>
                                                    {foreach $managers as $m}
                                                        <option value="{$m->id}"
                                                                {if $m->id == $order->manager_id}selected="selected"{/if}>{$m->name|escape}</option>
                                                    {/foreach}
                                                </select>
                                            {else}
                                                {if $order->manager_id}
                                                    {$managers[$order->manager_id]->name|escape}
                                                {/if}
                                            {/if}
                                        </h5>
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-12 col-md-4 col-lg-3">
                                        <form action="{url}" class="js-order-item-form " id="fio_form">

                                            <input type="hidden" name="action" value="fio"/>
                                            <input type="hidden" name="order_id" value="{$order->order_id}"/>
                                            <input type="hidden" name="user_id" value="{$order->user_id}"/>

                                            <div class="border p-2 view-block">
                                                <h5>
                                                    <a href="client/{$order->user_id}"
                                                       title="Перейти в карточку клиента">
                                                        {$order->lastname|escape}
                                                        {$order->firstname|escape}
                                                        {$order->patronymic|escape}
                                                    </a>
                                                </h5>
                                                <h3>
                                                    <span>{$order->phone_mobile|escape}</span>
                                                    <button class="js-mango-call mango-call js-event-add-click"
                                                            data-phone="{$order->phone_mobile|escape}"
                                                            title="Выполнить звонок" data-event="60"
                                                            data-manager="{$manager->id}"
                                                            data-order="{$order->order_id}"
                                                            data-user="{$order->user_id}">
                                                        <i class="fas fa-mobile-alt"></i>
                                                    </button>
                                                    <button class="js-open-sms-modal mango-call {if $order->contract->sold}js-yuk{/if}"
                                                            data-user="{$order->user_id}"
                                                            data-order="{$order->order_id}">
                                                        <i class=" far fa-share-square"></i>
                                                    </button>
                                                </h3>
                                                <a href="javascript:void(0);"
                                                   class="text-info js-edit-form edit-amount js-event-add-click"
                                                   data-event="30" data-manager="{$manager->id}"
                                                   data-order="{$order->order_id}" data-user="{$order->user_id}"><i
                                                            class=" fas fa-edit"></i></a>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Находится в ч/с
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="edit-block hide">
                                                <div class="form-group mb-1">
                                                    <input type="text" name="lastname" value="{$order->lastname|escape}"
                                                           class="form-control" placeholder="Фамилия"/>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input type="text" name="firstname"
                                                           value="{$order->firstname|escape}" class="form-control"
                                                           placeholder="Имя"/>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input type="text" name="patronymic"
                                                           value="{$order->patronymic|escape}" class="form-control"
                                                           placeholder="Отчество"/>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input type="text" name="phone_mobile"
                                                           value="{$order->phone_mobile|escape}" class="form-control"
                                                           placeholder="Телефон"/>
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-success js-event-add-click"
                                                            data-event="40" data-manager="{$manager->id}"
                                                            data-order="{$order->order_id}"
                                                            data-user="{$order->user_id}"><i class="fa fa-check"></i>
                                                        Сохранить
                                                    </button>
                                                    <button type="button" class="btn btn-inverse js-cancel-edit">
                                                        Отмена
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        {if $order->status == 5}
                                            <br>
                                            <div class="mt-3 card card-danger mb-2 text-center">
                                                <form id="send_short_link" action="/ajax/send_short_link.php" title=""
                                                      method="POST">
                                                    <div style="padding-top: 10px;padding-bottom: 10px;">
                                                        <label id="result" class="title text-white">Короткая ссылка на
                                                            оплату</label>
                                                        <br>
                                                        <input type="hidden" name="userId" value="{$order->user_id}">
                                                        <input type="text" id="short_link" name="short_link"
                                                               value="{$short_link}" size="21" readonly>
                                                        <input type="text" id="phone_short_link" name="phone"
                                                               value="{$order->phone_mobile}" size="9">
                                                        <input type="submit" id="submit_short_link"
                                                               name="submit_short_link" value="Отправить смс">
                                                        <br>
                                                    </div>
                                                </form>
                                            </div>
                                            <br>
                                        {/if}
                                    </div>
                                    <div class="col-12 col-md-8 col-lg-6">
                                        <form action="{url}" class="mb-3 p-2 border js-order-item-form js-check-amount"
                                              id="amount_form">

                                            <input type="hidden" name="action" value="amount"/>
                                            <input type="hidden" name="order_id" value="{$order->order_id}"/>
                                            <input type="hidden" name="user_id" value="{$order->user_id}"/>
                                            {if $amount_error}
                                                <div class="text-danger pt-3">
                                                    <ul>
                                                        {foreach $amount_error as $er}
                                                            <li>{$er}</li>
                                                        {/foreach}
                                                    </ul>
                                                </div>
                                            {/if}
                                            <div class="row view-block ">
                                                <div class="col-6 text-center">
                                                    <h5>Сумма</h5>
                                                    <h3 class="text-primary">{$order->amount} руб</h3>
                                                </div>
                                                <div class="col-6 text-center">
                                                    <h5>Срок</h5>
                                                    <h3 class="text-primary">{$order->period} {$order->period|plural:"день":"дней":"дня"}</h3>
                                                </div>
                                                {if $order->antirazgon_amount}
                                                    <div class="col-12 text-center">
                                                        <h4 class="text-danger">Максимальная
                                                            сумма: {$order->antirazgon_amount} руб</h4>
                                                    </div>
                                                {/if}
                                                {if $order->status <= 2 || in_array($manager->role, ['admin','developer'])}
                                                    <a href="javascript:void(0);"
                                                       class="text-info js-edit-form edit-amount js-event-add-click"
                                                       data-event="31" data-manager="{$manager->id}"
                                                       data-order="{$order->order_id}" data-user="{$order->user_id}"><i
                                                                class=" fas fa-edit"></i></a>
                                                    </h3>
                                                {/if}
                                            </div>

                                            <div class="row edit-block hide">
                                                <div class="col-6 col-md-3 text-center">
                                                    <h5>Сумма</h5>
                                                    <input type="text" class="form-control" name="amount"
                                                           value="{$order->amount}"/>
                                                </div>
                                                <div class="col-6 col-md-3 text-center">
                                                    <h5>Период</h5>
                                                    <input type="text" class="form-control" name="period"
                                                           value="{$order->period}"/>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-actions">
                                                        <h5>&nbsp;</h5>
                                                        <button type="submit" class="btn btn-success js-event-add-click"
                                                                data-event="41" data-manager="{$manager->id}"
                                                                data-order="{$order->order_id}"
                                                                data-user="{$order->user_id}"><i
                                                                    class="fa fa-check"></i> Сохранить
                                                        </button>
                                                        <button type="button" class="btn btn-inverse js-cancel-edit">
                                                            Отмена
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3">
                                        {if !$order->manager_id && $order->status == 0}
                                            <div class="pt-3 js-accept-order-block">
                                                <button class="btn btn-info btn-lg btn-block js-accept-order js-event-add-click"
                                                        data-event="10" data-manager="{$manager->id}"
                                                        data-order="{$order->order_id}" data-user="{$order->user_id}">
                                                    <i class="fas fa-hospital-symbol"></i>
                                                    <span>Принять</span>
                                                </button>
                                            </div>
                                        {/if}

                                        {if $order->status == 1 && $order->manager_id != $manager->id}
                                            <div class="pt-1 pb-2 js-accept-order-block">
                                                <button class="btn btn-info btn-block js-accept-order js-event-add-click"
                                                        data-event="11" data-user="{$order->user_id}"
                                                        data-order="{$order->order_id}" data-manager="{$manager->id}">
                                                    <i class="fas fa-hospital-symbol"></i>
                                                    <span>Перепринять</span>
                                                </button>
                                            </div>
                                        {/if}

                                        {if $order->status == 1}
                                            <div class="js-approve-reject-block {if !$order->manager_id}hide{/if}">
                                                <button class="btn btn-success btn-block js-approve-order js-event-add-click"
                                                        data-event="12" data-user="{$order->user_id}"
                                                        data-order="{$order->order_id}" data-manager="{$manager->id}">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>Одобрить</span>
                                                </button>
                                                <button class="btn btn-danger btn-block js-reject-order js-event-add-click"
                                                        data-event="13" data-user="{$order->user_id}"
                                                        data-order="{$order->order_id}" data-manager="{$manager->id}">
                                                    <i class="fas fa-times-circle"></i>
                                                    <span>Отказать</span>
                                                </button>
                                            </div>
                                        {/if}

                                        <div class="js-order-status">
                                            {if $order->status == 2}
                                                <div class="card card-success mb-1">
                                                    <div class="box text-center">
                                                        <h3 class="text-white mb-0">Одобрена</h3>
                                                    </div>
                                                </div>
                                                <button class="btn btn-danger btn-block js-reject-order js-event-add-click"
                                                        data-event="13" data-user="{$order->user_id}"
                                                        data-order="{$order->order_id}" data-manager="{$manager->id}">
                                                    <i class="fas fa-times-circle"></i>
                                                    <span>Отказать</span>
                                                </button>
                                                <form class=" pt-1 js-confirm-contract">
                                                    <div class="input-group">
                                                        <input type="hidden" name="contract_id" class="js-contract-id"
                                                               value="{$order->contract_id}"/>
                                                        <input type="hidden" name="phone" class="js-contract-phone"
                                                               value="{$order->phone_mobile|escape}"/>
                                                        <input type="text" class="form-control js-contract-code"
                                                               placeholder="SMS код"
                                                               value="{if $is_developer}{$contract->accept_code}{/if}"/>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-info js-event-add-click"
                                                                    type="submit" data-event="14"
                                                                    data-user="{$order->user_id}"
                                                                    data-order="{$order->order_id}"
                                                                    data-manager="{$manager->id}">Подтвердить
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <a href="javascript:void(0);" class="js-sms-send"
                                                       data-contract="{$order->contract_id}">
                                                        <span>Отправить смс код</span>
                                                        <span class="js-sms-timer"></span>
                                                    </a>
                                                </form>
                                            {/if}
                                            {if $order->status == 3}
                                                <div class="card card-danger">
                                                    <div class="box text-center">
                                                        <h3 class="text-white">Отказ</h3>
                                                        <small title="Причина отказа">
                                                            <i>{$reject_reasons[$order->reason_id]->admin_name}</i>
                                                        </small>
                                                        {if $order->antirazgon_date}
                                                            <br/>
                                                            <strong class="text-white">
                                                                <small>Мараторий
                                                                    до {$order->antirazgon_date|date}</small>
                                                            </strong>
                                                        {/if}
                                                    </div>
                                                </div>
                                            {/if}
                                            {if $order->status == 4}
                                                <div class="card card-primary">
                                                    <div class="box text-center">
                                                        <h3 class="text-white">Подписан</h3>
                                                        <h6>Договор {$contract->number}</h6>
                                                    </div>
                                                </div>
                                                {if $contract->status != 9}
                                                    <button class="btn btn-danger btn-block js-reject-order js-event-add-click"
                                                            data-event="13" data-user="{$order->user_id}"
                                                            data-order="{$order->order_id}"
                                                            data-manager="{$manager->id}">
                                                        <i class="fas fa-times-circle"></i>
                                                        <span>Отказать</span>
                                                    </button>
                                                {/if}
                                            {/if}
                                            {if $order->status == 5}
                                                {if $contract->status == 4}
                                                    <div class="card card-danger mb-1">
                                                        <div class="box text-center">
                                                            <h3 class="text-white">Просрочен</h3>
                                                            <h6>Договор {$contract->number}</h6>
                                                            <h6 class="text-center text-white">
                                                                Погашение: {$contract->loan_body_summ+$contract->loan_percents_summ+$contract->loan_charge_summ+$contract->loan_peni_summ}
                                                                руб
                                                            </h6>
                                                            <h6 class="text-center text-white">
                                                                Продление:
                                                                {if $contract->prolongation > 0 && !$contract->sold}
                                                                    {$settings->prolongation_amount+$contract->loan_percents_summ+$contract->loan_charge_summ} руб
                                                                {else}
                                                                    {$contract->loan_percents_summ+$contract->loan_charge_summ} руб
                                                                {/if}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                {elseif $contract->status == 10}
                                                    <div class="card card-danger mb-1">
                                                        <div class="box text-center">
                                                            <h3 class="text-white">Суд 1С</h3>
                                                            <h6>Договор {$contract->number}</h6>
                                                            <h6 class="text-center text-white">
                                                                Погашение: {$contract->loan_body_summ+$contract->loan_percents_summ+$contract->loan_charge_summ+$contract->loan_peni_summ}
                                                                руб
                                                            </h6>
                                                            <h6 class="text-center text-white">
                                                                Продление:
                                                                {if $contract->prolongation > 0}
                                                                    {$settings->prolongation_amount+$contract->loan_percents_summ} руб
                                                                {else}
                                                                    {$contract->loan_percents_summ} руб
                                                                {/if}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                {else}
                                                    <div class="card card-primary mb-1">
                                                        <div class="box text-center">
                                                            <h3 class="text-white">Выдан</h3>
                                                            <h6>Договор {$contract->number}</h6>
                                                            <h6 class="text-center text-white">
                                                                Погашение: {$contract->loan_body_summ+$contract->loan_percents_summ+$contract->loan_charge_summ+$contract->loan_peni_summ}
                                                                руб
                                                            </h6>
                                                            <h6 class="text-center text-white">
                                                                Продление:
                                                                {if $contract->prolongation > 0}
                                                                    {$settings->prolongation_amount+$contract->loan_percents_summ} руб
                                                                {else}
                                                                    {$contract->loan_percents_summ} руб
                                                                {/if}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                {/if}
                                                {if in_array($contract->status, [2,4])}
                                                    <div data-order="{$order->order_id}"
                                                         class="btn btn-block btn-success editLoanProfit">
                                                        Скорректировать долг/Остановить начисления
                                                    </div>
                                                {/if}
                                                {if in_array('close_contract', $manager->permissions)}
                                                    <button class="btn btn-danger btn-block js-open-close-form js-event-add-click"
                                                            data-event="15" data-user="{$order->user_id}"
                                                            data-order="{$order->order_id}"
                                                            data-manager="{$manager->id}">Закрыть договор
                                                    </button>
                                                {/if}
                                                {if $is_developer}
                                                    <button class="btn btn-info btn-block js-open-correct-form "
                                                            data-event="15" data-user="{$order->user_id}"
                                                            data-order="{$order->order_id}"
                                                            data-manager="{$manager->id}">Корректировка
                                                    </button>
                                                {/if}
                                                <br>
                                                <button class="btn btn-info btn-block add_pay">
                                                    <span>Провести платеж</span>
                                                </button>
                                            {/if}
                                            {if $order->status == 6}
                                                <div class="card card-danger mb-1">
                                                    <div class="box text-center">
                                                        <h3 class="text-white">Не удалось выдать</h3>
                                                        <h6>Договор {$contract->number}</h6>
                                                        {if $p2p->response_xml}
                                                            {if $p2p->response_xml->message}
                                                                <i>
                                                                    <small>B2P: {$p2p->response_xml->message}</small>
                                                                </i>
                                                            {elseif $p2p->response_xml->description}
                                                                <i>
                                                                    <small>
                                                                        B2P: {$p2p->response_xml->description}</small>
                                                                </i>
                                                            {/if}
                                                        {else}
                                                            <i>
                                                                <small>Нет ответа от B2P. <br/>Если повторить выдачу,
                                                                    это может привести к двойной выдаче!
                                                                </small>
                                                            </i>
                                                        {/if}
                                                    </div>
                                                </div>
                                                {if $have_newest_order}
                                                    <div class="text-center">
                                                        <a href="order/{$have_newest_order}"><strong
                                                                    class="text-danger text-center">У клиента есть новая
                                                                заявка</strong></a>
                                                    </div>
                                                {else}
                                                    {if in_array('repay_button', $manager->permissions)}
                                                        <button type="button"
                                                                class="btn btn-primary btn-block js-repay-contract js-event-add-click"
                                                                data-event="16" data-user="{$order->user_id}"
                                                                data-order="{$order->order_id}"
                                                                data-manager="{$manager->id}"
                                                                data-contract="{$contract->id}">Повторить выдачу
                                                        </button>
                                                    {/if}
                                                {/if}
                                            {/if}

                                            {if $order->status == 7}
                                                <div class="card card-primary">
                                                    <div class="box text-center">
                                                        <h3 class="text-white">Погашен</h3>
                                                        <h6>Договор #{$contract->number}</h6>
                                                    </div>
                                                </div>
                                            {/if}
                                            {if $order->status == 8}
                                                <div class="card card-danger">
                                                    <div class="box text-center">
                                                        <h3 class="text-white">Отказ клиента</h3>
                                                        <small title="Причина отказа">
                                                            <i>{$reject_reasons[$order->reason_id]->admin_name}</i>
                                                        </small>
                                                    </div>
                                                </div>
                                            {/if}

                                            {if $contract->status == 9}
                                                <div class="card border border-danger">
                                                    <div class="box text-center">
                                                        <h3 class="text-danger">Ошибка выдачи</h3>
                                                        <button class="btn btn-outline-warning js-cancel-contract"
                                                                data-contract="{$contract->id}" type="button">Отменить
                                                            заявку
                                                        </button>
                                                    </div>
                                                </div>
                                            {/if}

                                            {if $contract->accept_code}
                                                <h4 class="text-danger mb-0">АСП: {$contract->accept_code}</h4>
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <ul class="mt-2 nav nav-tabs" role="tablist" id="order_tabs">
                                <li class="nav-item">
                                    <a class="nav-link active js-event-add-click" data-toggle="tab" href="#info"
                                       role="tab" aria-selected="false" data-event="20" data-user="{$order->user_id}"
                                       data-order="{$order->order_id}" data-manager="{$manager->id}">
                                        <span class="hidden-sm-up"><i class="ti-home"></i></span>
                                        <span class="hidden-xs-down">Персональная информация</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-event-add-click" data-toggle="tab" href="#comments" role="tab"
                                       aria-selected="false" data-event="21" data-user="{$order->user_id}"
                                       data-order="{$order->order_id}" data-manager="{$manager->id}">
                                        <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                        <span class="hidden-xs-down">
                                            Комментарии {if $comments|count > 0}<span
                                                    class="label label-rounded label-primary">{$comments|count}</span>{/if}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-event-add-click" data-toggle="tab" href="#documents"
                                       role="tab" aria-selected="true" data-event="22" data-user="{$order->user_id}"
                                       data-order="{$order->order_id}" data-manager="{$manager->id}">
                                        <span class="hidden-sm-up"><i class="ti-layers"></i></span>
                                        <span class="hidden-xs-down">Документы</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-event-add-click" data-toggle="tab" href="#logs" role="tab"
                                       aria-selected="true" data-event="23" data-user="{$order->user_id}"
                                       data-order="{$order->order_id}" data-manager="{$manager->id}">
                                        <span class="hidden-sm-up"><i class="ti-server"></i></span>
                                        <span class="hidden-xs-down">Логирование</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-event-add-click" data-toggle="tab" href="#operations"
                                       role="tab" aria-selected="true" data-event="24" data-user="{$order->user_id}"
                                       data-order="{$order->order_id}" data-manager="{$manager->id}">
                                        <span class="hidden-sm-up"><i class="ti-list-ol"></i></span>
                                        <span class="hidden-xs-down">Операции</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-event-add-click" data-toggle="tab" href="#history" role="tab"
                                       aria-selected="true" data-event="25" data-user="{$order->user_id}"
                                       data-order="{$order->order_id}" data-manager="{$manager->id}">
                                        <span class="hidden-sm-up"><i class="ti-save-alt"></i></span>
                                        <span class="hidden-xs-down">Кредитная история</span>
                                    </a>
                                </li>
                                <li class="nav-item js-event-add-click">
                                    <a class="nav-link" data-toggle="tab" href="#connexions" role="tab"
                                       aria-selected="true" data-event="25" data-user="{$order->user_id}"
                                       data-order="{$order->order_id}" data-manager="{$manager->id}">
                                        <span class="hidden-sm-up"><i class="ti-email"></i></span>
                                        <span class="hidden-xs-down">Связанные лица</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link js-event-add-click" data-toggle="tab" href="#communications"
                                       role="tab" aria-selected="true" data-event="25" data-user="{$order->user_id}"
                                       data-order="{$order->order_id}" data-manager="{$manager->id}">
                                        <span class="hidden-sm-up"><i class="ti-mobile"></i></span>
                                        <span class="hidden-xs-down">Коммуникации</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link js-event-add-click js-open-problem_loan-form"
                                            data-order_id="{$order->order_id}" data-user_id="{$order->user_id}"
                                            data-action="add_problem_loan"
                                    >
                                        <span class="hidden-xs-down">Создать документы проблемного заемщика</span>
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content tabcontent-border" id="order_tabs_content">
                                <div class="tab-pane active" id="info" role="tabpanel">
                                    <div class="form-body p-2 pt-3">

                                        <div class="row">
                                            <div class="col-md-8 ">

                                                <!-- Контакты -->
                                                <form action="{url}"
                                                      class="mb-3 border js-order-item-form {if $penalties['personal'] && $penalties['personal']->status!=3}card-outline-danger{/if}"
                                                      id="personal_data_form">

                                                    <input type="hidden" name="action" value="contactdata"/>
                                                    <input type="hidden" name="order_id" value="{$order->order_id}"/>
                                                    <input type="hidden" name="user_id" value="{$order->user_id}"/>

                                                    <h5 class="card-header card-success">
                                                        <span class="text-white ">Контакты</span>
                                                        <span class="float-right"> 
                                                            {penalty_button penalty_block='personal'}
                                                            <a href="javascript:void(0);"
                                                               class=" text-white js-edit-form js-event-add-click"
                                                               data-event="32" data-manager="{$manager->id}"
                                                               data-order="{$order->order_id}"
                                                               data-user="{$order->user_id}"><i
                                                                        class=" fas fa-edit"></i></a></h3>
                                                        </span>
                                                    </h5>

                                                    <div class="row pt-2 view-block {if $contactdata_error}hide{/if}">

                                                        {if $penalties['personal'] && (in_array($manager->permissions, ['add_penalty']) || $penalties['personal']->manager_id==$manager->id)}
                                                            <div class="col-md-12">
                                                                <div class="alert alert-danger m-2">
                                                                    <h5 class="text-danger mb-1">{$penalty_types[$penalties['personal']->id]->name}</h5>
                                                                    <small>{$penalties['personal']->comment}</small>
                                                                </div>
                                                            </div>
                                                        {/if}

                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Email:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">{$order->email|escape}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Дата
                                                                    рождения:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">
                                                                        {$order->birth|escape}
                                                                        <small class="label label-primary">{$order->age}</small>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Место
                                                                    рождения:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">{$order->birth_place|escape}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Паспорт:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">{$order->passport_serial|escape} {$order->subdivision_code|escape}
                                                                        , от {$order->passport_date|escape}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Кем выдан:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">{$order->passport_issued|escape}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group row m-0">
                                                                <label class="control-label col-md-4">Соцсети:</label>
                                                                <div class="col-md-8">
                                                                    <ul class="list-unstyled form-control-static pl-0">
                                                                        {if $order->social}
                                                                            <li>
                                                                                <a target="_blank"
                                                                                   href="{$order->social|escape}">{$order->social|escape}</a>
                                                                            </li>
                                                                        {/if}
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row p-2 edit-block {if !$contactdata_error}hide{/if}">
                                                        {if $contactdata_error}
                                                            <div class="col-md-12">
                                                                <ul class="alert alert-danger">
                                                                    {if in_array('empty_email', (array)$contactdata_error)}
                                                                        <li>Укажите Email!</li>
                                                                    {/if}
                                                                    {if in_array('empty_birth', (array)$contactdata_error)}
                                                                        <li>Укажите Дату рождения!</li>
                                                                    {/if}
                                                                    {if in_array('empty_passport_serial', (array)$contactdata_error)}
                                                                        <li>Укажите серию и номер паспорта!</li>
                                                                    {/if}
                                                                    {if in_array('empty_passport_date', (array)$contactdata_error)}
                                                                        <li>Укажите дату выдачи паспорта!</li>
                                                                    {/if}
                                                                    {if in_array('empty_subdivision_code', (array)$contactdata_error)}
                                                                        <li>Укажите код подразделения выдавшего
                                                                            паспорт!
                                                                        </li>
                                                                    {/if}
                                                                    {if in_array('empty_passport_issued', (array)$contactdata_error)}
                                                                        <li>Укажите кем выдан паспорт!</li>
                                                                    {/if}
                                                                </ul>
                                                            </div>
                                                        {/if}

                                                        <div class="col-md-6">
                                                            <div class="form-group mb-1 {if in_array('empty_email', (array)$contactdata_error)}has-danger{/if}">
                                                                <label class="control-label">Email</label>
                                                                <input type="text" name="email"
                                                                       value="{$order->email|escape}"
                                                                       class="form-control" placeholder=""/>
                                                                {if in_array('empty_email', (array)$contactdata_error)}
                                                                    <small class="form-control-feedback">Укажите
                                                                        Email!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-1 {if in_array('empty_birth', (array)$contactdata_error)}has-danger{/if}">
                                                                <label class="control-label">Дата рождения</label>
                                                                <input type="text" name="birth"
                                                                       value="{$order->birth|escape}"
                                                                       class="form-control" placeholder=""
                                                                       required="true"/>
                                                                {if in_array('empty_birth', (array)$contactdata_error)}
                                                                    <small class="form-control-feedback">Укажите дату
                                                                        рождения!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-2">
                                                                <label class="control-label">Соцсети</label>
                                                                <input type="text" class="form-control" name="social"
                                                                       value="{$order->social|escape}" placeholder=""/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-2 {if in_array('empty_birth_place', (array)$contactdata_error)}has-danger{/if}">
                                                                <label class="control-label">Место рождения</label>
                                                                <input type="text" name="birth_place"
                                                                       value="{$order->birth_place|escape}"
                                                                       class="form-control" placeholder=""
                                                                       required="true"/>
                                                                {if in_array('empty_birth_place', (array)$contactdata_error)}
                                                                    <small class="form-control-feedback">Укажите место
                                                                        рождения!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <div class="form-group mb-1 {if in_array('empty_passport_serial', (array)$contactdata_error)}has-danger{/if}">
                                                                <label class="control-label">Серия и номер
                                                                    паспорта</label>
                                                                <input type="text" class="form-control"
                                                                       name="passport_serial"
                                                                       value="{$order->passport_serial|escape}"
                                                                       placeholder="" required="true"/>
                                                                {if in_array('empty_passport_serial', (array)$contactdata_error)}
                                                                    <small class="form-control-feedback">Укажите серию и
                                                                        номер паспорта!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-1 {if in_array('empty_passport_date', (array)$contactdata_error)}has-danger{/if}">
                                                                <label class="control-label">Дата выдачи</label>
                                                                <input type="text" class="form-control"
                                                                       name="passport_date"
                                                                       value="{$order->passport_date|escape}"
                                                                       placeholder="" required="true"/>
                                                                {if in_array('empty_passport_date', (array)$contactdata_error)}
                                                                    <small class="form-control-feedback">Укажите дату
                                                                        выдачи паспорта!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-1 {if in_array('empty_subdivision_code', (array)$contactdata_error)}has-danger{/if}">
                                                                <label class="control-label">Код подразделения</label>
                                                                <input type="text" class="form-control"
                                                                       name="subdivision_code"
                                                                       value="{$order->subdivision_code|escape}"
                                                                       placeholder="" required="true"/>
                                                                {if in_array('empty_subdivision_code', (array)$contactdata_error)}
                                                                    <small class="form-control-feedback">Укажите код
                                                                        подразделения выдавшего паспорт!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group {if in_array('empty_passport_issued', (array)$contactdata_error)}has-danger{/if}">
                                                                <label class="control-label">Кем выдан</label>
                                                                <input type="text" class="form-control"
                                                                       name="passport_issued"
                                                                       value="{$order->passport_issued|escape}"
                                                                       placeholder="" required="true"/>
                                                                {if in_array('empty_passport_issued', (array)$contactdata_errors)}
                                                                    <small class="form-control-feedback">Укажите кем
                                                                        выдан паспорт!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>


                                                        <div class="col-md-12">
                                                            <div class="form-actions">
                                                                <button type="submit"
                                                                        class="btn btn-success js-event-add-click"
                                                                        data-event="42" data-manager="{$manager->id}"
                                                                        data-order="{$order->order_id}"
                                                                        data-user="{$order->user_id}"><i
                                                                            class="fa fa-check"></i> Сохранить
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-inverse js-cancel-edit">Отмена
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- / Контакты-->

                                                <!-- Старые контакты-->
                                                {if $changelogs }

                                                    {foreach $changelogs as $changelog}
                                                        {if $changelog->type == 'contactdata'}
                                                            {assign var="contactdata_is_changed" value="1"}
                                                        {/if}
                                                    {/foreach}
                                                    {if $contactdata_is_changed}
                                                        <div class="mb-3 border">
                                                            <h5 class="card-header card-success"
                                                                onclick="show_changes()">
                                                                <span class="text-white ">Посмотреть предыдущие паспортные данные</span>
                                                            </h5>
                                                            <div id="myDIV" style="display:none">
                                                                {foreach $changelogs as $changelog}
                                                                    {if $changelog->type == 'contactdata'}
                                                                        <div class="row pt-2 view-block {if $contactdata_error}hide{/if}">
                                                                            <div class="col-md-12">
                                                                                <label class="control-label col-md-4"><span>{$changelog->created|date}</span></label>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group row m-0">

                                                                                    {foreach $changelog->old_values as $field => $old_value}
                                                                                        {if ($field == 'passport_date' || $field == 'subdivision_code' || $field == 'passport_serial')}
                                                                                            <label class="control-label col-md-4">Паспорт:</label>
                                                                                            <div class="col-md-8">
                                                                                                <p class="form-control-static">
                                                                                                    {if $field == 'passport_serial'}  {$old_value|escape}{else}{$order->passport_serial|escape}{/if}
                                                                                                    {if $field == 'subdivision_code'} {$old_value|escape}{else}{$order->subdivision_code|escape}{/if}
                                                                                                    , от
                                                                                                    {if $field == 'passport_date'}    {$old_value|escape}{else}{$order->passport_date|escape}{/if}</p>
                                                                                            </div>
                                                                                        {/if}

                                                                                    {/foreach}

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group row m-0">

                                                                                    {foreach $changelog->old_values as $field => $old_value}

                                                                                        {if $field == 'passport_issued'}
                                                                                            <label class="control-label col-md-4">Кем
                                                                                                выдан:</label>
                                                                                            <div class="col-md-8">
                                                                                                <p class="form-control-static">{$old_value|escape}</p>
                                                                                            </div>
                                                                                        {/if}
                                                                                    {/foreach}

                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    {/if}
                                                                {/foreach}
                                                            </div>
                                                            <div class="row p-2 edit-block {if !$contactdata_error}hide{/if}">
                                                            </div>
                                                        </div>
                                                    {/if}
                                                {/if}
                                                <!-- / Старые контакты-->

                                                <!-- /Контактные лица -->
                                                <form action="{url}"
                                                      class="js-order-item-form mb-3 border {if $penalties['contactpersons'] && $penalties['contactpersons']->status!=3}card-outline-danger{/if}"
                                                      id="contact_persons_form">

                                                    <input type="hidden" name="action" value="contacts"/>
                                                    <input type="hidden" name="order_id" value="{$order->order_id}"/>
                                                    <input type="hidden" name="user_id" value="{$order->user_id}"/>

                                                    <h5 class="card-header">
                                                        <span class="text-white">Контактные лица</span>
                                                        <span class="float-right">

                                                            {penalty_button penalty_block='contactpersons'}
                                                            <a href="javascript:void(0);"
                                                               class="text-white js-edit-form js-event-add-click"
                                                               data-event="33" data-manager="{$manager->id}"
                                                               data-order="{$order->order_id}"
                                                               data-user="{$order->user_id}"><i
                                                                        class=" fas fa-edit"></i></a></h3>
                                                        </span>
                                                    </h5>

                                                    <div class="row view-block m-0 {if $contacts_error}hide{/if}">
                                                        <table class="table table-hover mb-0">
                                                            <tr>
                                                                <td>{$order->contact_person_name|escape}</td>
                                                                <td>{$order->contact_person_relation|escape}</td>
                                                                <td class="text-right">{$order->contact_person_phone|escape}</td>
                                                                <td>
                                                                    <button class="js-mango-call mango-call js-event-add-click"
                                                                            data-phone="{$order->contact_person_phone|escape}"
                                                                            title="Выполнить звонок" data-event="61"
                                                                            data-manager="{$manager->id}"
                                                                            data-order="{$order->order_id}"
                                                                            data-user="{$order->user_id}">
                                                                        <i class="fas fa-mobile-alt"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{$order->contact_person2_name|escape}</td>
                                                                <td>{$order->contact_person2_relation|escape}</td>
                                                                <td class="text-right">{$order->contact_person2_phone|escape}</td>
                                                                <td>
                                                                    <button class="js-mango-call mango-call js-event-add-click"
                                                                            data-event="61"
                                                                            data-manager="{$manager->id}"
                                                                            data-order="{$order->order_id}"
                                                                            data-user="{$order->user_id}"
                                                                            data-phone="{$order->contact_person2_phone}"
                                                                            title="Выполнить звонок">
                                                                        <i class="fas fa-mobile-alt"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <div class="row m-0 pt-2 pb-2 edit-block {if !$contacts_error}hide{/if}">
                                                        {if $contacts_error}
                                                            <div class="col-md-12">
                                                                <ul class="alert alert-danger">
                                                                    {if in_array('empty_contact_person_name', (array)$contacts_error)}
                                                                        <li>Укажите ФИО контакного лица!</li>
                                                                    {/if}
                                                                    {if in_array('empty_contact_person_phone', (array)$contacts_error)}
                                                                        <li>Укажите тел. контакного лица!</li>
                                                                    {/if}
                                                                    {if in_array('empty_contact_person2_name', (array)$contacts_error)}
                                                                        <li>Укажите ФИО контакного лица 2!</li>
                                                                    {/if}
                                                                    {if in_array('empty_contact_person2_phone', (array)$contacts_error)}
                                                                        <li>Укажите тел. контакного лица 2!</li>
                                                                    {/if}
                                                                </ul>
                                                            </div>
                                                        {/if}
                                                        <div class="col-md-4">
                                                            <div class="form-group {if in_array('empty_contact_person_name', (array)$contacts_error)}has-danger{/if}">
                                                                <label class="control-label">ФИО контакного лица</label>
                                                                <input type="text" class="form-control"
                                                                       name="contact_person_name"
                                                                       value="{$order->contact_person_name|escape}"
                                                                       placeholder="" required="true"/>
                                                                {if in_array('empty_contact_person_name', (array)$contacts_error)}
                                                                    <small class="form-control-feedback">Укажите ФИО
                                                                        контакного лица!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group {if in_array('empty_contact_person_relation', (array)$contacts_error)}has-danger{/if}">
                                                                <label class="control-label">Кем приходится</label>
                                                                <select class="form-control custom-select"
                                                                        name="contact_person_relation">
                                                                    <option value=""
                                                                            {if $order->contact_person_relation == ''}selected=""{/if}>
                                                                        Выберите значение
                                                                    </option>
                                                                    <option value="мать/отец"
                                                                            {if $order->contact_person_relation == 'мать/отец'}selected=""{/if}>
                                                                        мать/отец
                                                                    </option>
                                                                    <option value="муж/жена"
                                                                            {if $order->contact_person_relation == 'муж/жена'}selected=""{/if}>
                                                                        муж/жена
                                                                    </option>
                                                                    <option value="сын/дочь"
                                                                            {if $order->contact_person_relation == 'сын/дочь'}selected=""{/if}>
                                                                        сын/дочь
                                                                    </option>
                                                                    <option value="коллега"
                                                                            {if $order->contact_person_relation == 'коллега'}selected=""{/if}>
                                                                        коллега
                                                                    </option>
                                                                    <option value="друг/сосед"
                                                                            {if $order->contact_person_relation == 'друг/сосед'}selected=""{/if}>
                                                                        друг/сосед
                                                                    </option>
                                                                    <option value="иной родственник"
                                                                            {if $order->contact_person_relation == 'иной родственник'}selected=""{/if}>
                                                                        иной родственник
                                                                    </option>
                                                                </select>
                                                                {if in_array('empty_contact_person_relation', (array)$contacts_error)}
                                                                    <small class="form-control-feedback">Укажите кем
                                                                        приходится контакное лицо!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group {if in_array('empty_contact_person_phone', (array)$contacts_error)}has-danger{/if}">
                                                                <label class="control-label">Тел. контакного
                                                                    лица</label>
                                                                <input type="text" class="form-control"
                                                                       name="contact_person_phone"
                                                                       value="{$order->contact_person_phone|escape}"
                                                                       placeholder="" required="true"/>
                                                                {if in_array('empty_contact_person_phone', (array)$contacts_error)}
                                                                    <small class="form-control-feedback">Укажите тел.
                                                                        контакного лица!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>


                                                        <div class="col-md-4">
                                                            <div class="form-group {if in_array('empty_contact_person2_name', (array)$contacts_error)}has-danger{/if}">
                                                                <label class="control-label">ФИО контакного лица
                                                                    2</label>
                                                                <input type="text" class="form-control"
                                                                       name="contact_person2_name"
                                                                       value="{$order->contact_person2_name|escape}"
                                                                       placeholder="" required="true"/>
                                                                {if in_array('empty_contact_person2_name', (array)$contacts_error)}
                                                                    <small class="form-control-feedback">Укажите ФИО
                                                                        контакного лица!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group {if in_array('empty_contact_person_relation', (array)$contacts_error)}has-danger{/if}">
                                                                <label class="control-label">Кем приходится</label>
                                                                <select class="form-control custom-select"
                                                                        name="contact_person2_relation">
                                                                    <option value=""
                                                                            {if $order->contact_person2_relation == ''}selected=""{/if}>
                                                                        Выберите значение
                                                                    </option>
                                                                    <option value="мать/отец"
                                                                            {if $order->contact_person2_relation == 'мать/отец'}selected=""{/if}>
                                                                        мать/отец
                                                                    </option>
                                                                    <option value="муж/жена"
                                                                            {if $order->contact_person2_relation == 'муж/жена'}selected=""{/if}>
                                                                        муж/жена
                                                                    </option>
                                                                    <option value="сын/дочь"
                                                                            {if $order->contact_person2_relation == 'сын/дочь'}selected=""{/if}>
                                                                        сын/дочь
                                                                    </option>
                                                                    <option value="коллега"
                                                                            {if $order->contact_person2_relation == 'коллега'}selected=""{/if}>
                                                                        коллега
                                                                    </option>
                                                                    <option value="друг/сосед"
                                                                            {if $order->contact_person2_relation == 'друг/сосед'}selected=""{/if}>
                                                                        друг/сосед
                                                                    </option>
                                                                    <option value="иной родственник"
                                                                            {if $order->contact_person2_relation == 'иной родственник'}selected=""{/if}>
                                                                        иной родственник
                                                                    </option>
                                                                </select>
                                                                {if in_array('empty_contact_person_relation', (array)$contacts_error)}
                                                                    <small class="form-control-feedback">Укажите кем
                                                                        приходится контакное лицо!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group {if in_array('empty_contact_person2_phone', (array)$contacts_error)}has-danger{/if}">
                                                                <label class="control-label">Тел. контакного лица
                                                                    2</label>
                                                                <input type="text" class="form-control"
                                                                       name="contact_person2_phone"
                                                                       value="{$order->contact_person2_phone|escape}"
                                                                       placeholder=""/>
                                                                {if in_array('empty_contact_person2_phone', (array)$contacts_error)}
                                                                    <small class="form-control-feedback">Укажите тел.
                                                                        контакного лица!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>


                                                        <div class="col-md-12">
                                                            <div class="form-actions">
                                                                <button type="submit"
                                                                        class="btn btn-success js-event-add-click"
                                                                        data-event="43" data-manager="{$manager->id}"
                                                                        data-order="{$order->order_id}"
                                                                        data-user="{$order->user_id}"><i
                                                                            class="fa fa-check"></i> Сохранить
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-inverse js-cancel-edit">Отмена
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                <form action="{url}"
                                                      class="js-order-item-form mb-3 border">

                                                    <input type="hidden" name="action" value="addresses"/>
                                                    <input type="hidden" name="order_id" value="{$order->order_id}"/>
                                                    <input type="hidden" name="user_id" value="{$order->user_id}"/>
                                                    <input type="hidden" name="faktaddr_id" value="{$faktaddress->id}"/>
                                                    <input type="hidden" name="regaddr_id" value="{$regaddress->id}"/>

                                                    <h5 class="card-header">
                                                        <span class="text-white">Адрес</span>
                                                        <span class="float-right">
                                                            {penalty_button penalty_block='addresses'}
                                                            <a href="javascript:void(0);"
                                                               class="text-white js-edit-form js-event-add-click"
                                                               data-event="34" data-manager="{$manager->id}"
                                                               data-order="{$order->order_id}"
                                                               data-user="{$order->user_id}"><i
                                                                        class=" fas fa-edit"></i></a></h3>
                                                        </span>
                                                    </h5>

                                                    <div class="row view-block {if $addresses_error}hide{/if}">
                                                        <div class="col-md-12">
                                                            <table class="table table-hover mb-0">
                                                                <tr>
                                                                    <td>Адрес прописки</td>
                                                                    <td>{$regaddress->adressfull}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Адрес проживания</td>
                                                                    <td>{$faktaddress->adressfull}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="edit-block m-0 {if !$addresses_error}hide{/if}">
                                                        <br>
                                                        <div class="form_group -fs-18 js-dadata-address">
                                                            <div class="form_group-title -gil-m ml-1">Адрес
                                                                регистрации
                                                            </div>
                                                            <br>
                                                            <input class="form-control casing-upper-mask Regadress"
                                                                   style="width: 700px; margin-left: 25px"
                                                                   placeholder="Поиск">
                                                            <br><br>
                                                            <input class="form-control casing-upper-mask"
                                                                   name="Regadressfull"
                                                                   style="width: 700px; margin-left: 25px" type="text"
                                                                   value="{$regaddress->adressfull}" readonly/>
                                                            <input style="display: none" class="Registration"
                                                                   name="Regadress"/>
                                                        </div>
                                                        <br>
                                                        <div class="form_group -fs-18 js-dadata-address js-dadata-okato">
                                                            <div class="form_group-title -gil-m ml-1">Адрес места
                                                                жительства
                                                            </div>
                                                            <br>
                                                            <div class="js-regaddress-block">
                                                                <input class="form-control casing-upper-mask Faktaddress"
                                                                       style="width: 700px; margin-left: 25px"
                                                                       placeholder="Поиск">
                                                                <br><br>
                                                                <input class="form-control casing-upper-mask"
                                                                       style="width: 700px; margin-left: 25px;"
                                                                       name="Faktadressfull"
                                                                       value="{$faktaddress->adressfull}" readonly>
                                                                <input style="display: none" class="Fakt_adress"
                                                                       name="Fakt_adress"/>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row m-0 mt-2 mb-2">
                                                            <div class="col-md-12">
                                                                <div class="form-actions">
                                                                    <button type="submit"
                                                                            class="btn btn-success saveAddress"><i
                                                                                class="fa fa-check"></i> Сохранить
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-inverse js-cancel-edit">
                                                                        Отмена
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>


                                                <!-- Данные о работе -->
                                                <form action="{url}"
                                                      class="border js-order-item-form mb-3 {if $penalties['work'] && $penalties['work']->status!=3}card-outline-danger{/if}"
                                                      id="work_data_form">

                                                    <input type="hidden" name="action" value="work"/>
                                                    <input type="hidden" name="order_id" value="{$order->order_id}"/>
                                                    <input type="hidden" name="user_id" value="{$order->user_id}"/>

                                                    <h5 class="card-header">
                                                        <span class="text-white">Данные о работе</span>
                                                        <span class="float-right">
                                                            {penalty_button penalty_block='work'}
                                                            <a href="javascript:void(0);"
                                                               class="text-white float-right js-edit-form js-event-add-click"
                                                               data-event="35" data-manager="{$manager->id}"
                                                               data-order="{$order->order_id}"
                                                               data-user="{$order->user_id}"><i
                                                                        class=" fas fa-edit"></i></a>
                                                        </span>
                                                    </h5>

                                                    <div class="row m-0 pt-2 view-block {if $work_error}hide{/if}">
                                                        {if $order->workplace || $order->workphone}
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-0  row">
                                                                    <label class="control-label col-md-4">Название
                                                                        организации:</label>
                                                                    <div class="col-md-8">
                                                                        <p class="form-control-static">
                                                                        <span class="clearfix">
                                                                            <span class="float-left">
                                                                                {$order->workplace|escape}
                                                                            </span>
                                                                            <span class="float-right">
                                                                                {$order->workphone|escape}
                                                                                <button class="js-mango-call mango-call js-event-add-click"
                                                                                        data-event="62"
                                                                                        data-manager="{$manager->id}"
                                                                                        data-order="{$order->order_id}"
                                                                                        data-user="{$order->user_id}"
                                                                                        data-phone="{$order->workphone|escape}"
                                                                                        title="Выполнить звонок">
                                                                                    <i class="fas fa-mobile-alt"></i>
                                                                                </button>
                                                                            </span>
                                                                        </span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        {/if}
                                                        {if $order->workaddress}
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-0 row">
                                                                    <label class="control-label col-md-4">Адрес:</label>
                                                                    <div class="col-md-8">
                                                                        <p class="form-control-static">
                                                                            {$order->workaddress|escape}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        {/if}
                                                        {if $order->profession}
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-0 row">
                                                                    <label class="control-label col-md-4">Должность:</label>
                                                                    <div class="col-md-8">
                                                                        <p class="form-control-static">
                                                                            {$order->profession|escape}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        {/if}
                                                        <div class="col-md-12">
                                                            <div class="form-group  mb-0 row">
                                                                <label class="control-label col-md-4">Руководитель:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">
                                                                        {$order->chief_name|escape}
                                                                        , {$order->chief_position|escape}
                                                                        <br/>
                                                                        {$order->chief_phone|escape}
                                                                        <button class="js-mango-call mango-call js-event-add-click"
                                                                                data-event="63"
                                                                                data-manager="{$manager->id}"
                                                                                data-order="{$order->order_id}"
                                                                                data-user="{$order->user_id}"
                                                                                data-phone="{$order->chief_phone|escape}"
                                                                                title="Выполнить звонок">
                                                                            <i class="fas fa-mobile-alt"></i>
                                                                        </button>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group  mb-0 row">
                                                                <label class="control-label col-md-4">Доход:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">
                                                                        {$order->income|escape}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group  mb-0 row">
                                                                <label class="control-label col-md-4">Расход:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static">
                                                                        {$order->expenses|escape}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {if $order->workcomment}
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-0 row">
                                                                    <label class="control-label col-md-4">Комментарий к
                                                                        работе:</label>
                                                                    <div class="col-md-8">
                                                                        <p class="form-control-static">
                                                                            {$order->workcomment|escape}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        {/if}
                                                    </div>

                                                    <div class="row m-0 pt-2 edit-block js-dadata-address {if !$work_error}hide{/if}">
                                                        {if $work_error}
                                                            <div class="col-md-12">
                                                                <ul class="alert alert-danger">

                                                                    {if in_array('empty_workplace', (array)$work_error)}
                                                                        <li>Укажите название организации!</li>
                                                                    {/if}
                                                                    {if in_array('empty_profession', (array)$work_error)}
                                                                        <li>Укажите должность!</li>
                                                                    {/if}
                                                                    {if in_array('empty_workphone', (array)$work_error)}
                                                                        <li>Укажите рабочий телефон!</li>
                                                                    {/if}
                                                                    {if in_array('empty_income', (array)$work_error)}
                                                                        <li>Укажите доход!</li>
                                                                    {/if}
                                                                    {if in_array('empty_expenses', (array)$work_error)}
                                                                        <li>Укажите расход!</li>
                                                                    {/if}
                                                                    {if in_array('empty_chief_name', (array)$work_error)}
                                                                        <li>Укажите ФИО начальника!</li>
                                                                    {/if}
                                                                    {if in_array('empty_chief_position', (array)$work_error)}
                                                                        <li>Укажите Должность начальника!</li>
                                                                    {/if}
                                                                    {if in_array('empty_chief_phone', (array)$work_error)}
                                                                        <li>Укажите Телефон начальника!</li>
                                                                    {/if}

                                                                </ul>
                                                            </div>
                                                        {/if}
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-0 {if in_array('empty_workplace', (array)$work_error)}has-danger{/if}">
                                                                <label class="control-label">Название
                                                                    организации</label>
                                                                <input type="text" class="form-control" name="workplace"
                                                                       value="{$order->workplace|escape}" placeholder=""
                                                                       required="true"/>
                                                                {if in_array('empty_workplace', (array)$work_error)}
                                                                    <small class="form-control-feedback">Укажите
                                                                        название организации!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-0 {if in_array('empty_profession', (array)$work_error)}has-danger{/if}">
                                                                <label class="control-label">Должность</label>
                                                                <input type="text" class="form-control"
                                                                       name="profession"
                                                                       value="{$order->profession|escape}"
                                                                       placeholder="" required="true"/>
                                                                {if in_array('empty_profession', (array)$work_error)}
                                                                    <small class="form-control-feedback">Укажите
                                                                        должность!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-0">
                                                                <label class="control-label">Адрес</label>
                                                                <input type="text" class="form-control"
                                                                       name="workaddress"
                                                                       value="{$order->workaddress|escape}"
                                                                       placeholder="" required="true"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 {if in_array('empty_workphone', (array)$work_error)}has-danger{/if}">
                                                                <label class="control-label">Pабочий телефон</label>
                                                                <input type="text" class="form-control" name="workphone"
                                                                       value="{$order->workphone|escape}" placeholder=""
                                                                       required="true"/>
                                                                {if in_array('empty_workphone', (array)$work_error)}
                                                                    <small class="form-control-feedback">Укажите рабочий
                                                                        телефон!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 {if in_array('empty_income', (array)$work_error)}has-danger{/if}">
                                                                <label class="control-label">Доход</label>
                                                                <input type="text" class="form-control" name="income"
                                                                       value="{$order->income|escape}" placeholder=""
                                                                       required="true"/>
                                                                {if in_array('empty_income', (array)$work_error)}
                                                                    <small class="form-control-feedback">Укажите
                                                                        доход!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 {if in_array('empty_expenses', (array)$work_error)}has-danger{/if}">
                                                                <label class="control-label">Расход</label>
                                                                <input type="text" class="form-control" name="expenses"
                                                                       value="{$order->expenses|escape}" placeholder=""
                                                                       required="true"/>
                                                                {if in_array('empty_expenses', (array)$work_error)}
                                                                    <small class="form-control-feedback">Укажите
                                                                        расход!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 {if in_array('empty_chief_name', (array)$work_error)}has-danger{/if}">
                                                                <label class="control-label">ФИО начальника</label>
                                                                <input type="text" class="form-control"
                                                                       name="chief_name"
                                                                       value="{$order->chief_name|escape}"
                                                                       placeholder="" required="true"/>
                                                                {if in_array('empty_chief_name', (array)$work_error)}
                                                                    <small class="form-control-feedback">Укажите ФИО
                                                                        начальника!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 {if in_array('empty_chief_position', (array)$work_error)}has-danger{/if}">
                                                                <label class="control-label">Должность
                                                                    начальника</label>
                                                                <input type="text" class="form-control"
                                                                       name="chief_position"
                                                                       value="{$order->chief_position|escape}"
                                                                       placeholder="" required="true"/>
                                                                {if in_array('empty_chief_position', (array)$work_error)}
                                                                    <small class="form-control-feedback">Укажите
                                                                        Должность начальника!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-0 {if in_array('empty_chief_phone', (array)$work_error)}has-danger{/if}">
                                                                <label class="control-label">Телефон начальника</label>
                                                                <input type="text" class="form-control"
                                                                       name="chief_phone"
                                                                       value="{$order->chief_phone|escape}"
                                                                       placeholder=""/>
                                                                {if in_array('empty_chief_phone', (array)$work_error)}
                                                                    <small class="form-control-feedback">Укажите Телефон
                                                                        начальника!
                                                                    </small>
                                                                {/if}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group mb-0">
                                                                <label class="control-label">Комментарий к
                                                                    работе</label>
                                                                <input type="text" class="form-control"
                                                                       name="workcomment"
                                                                       value="{$order->workcomment|escape}"
                                                                       placeholder=""/>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 pb-2 mt-2">
                                                            <div class="form-actions">
                                                                <button type="submit"
                                                                        class="btn btn-success js-event-add-click"
                                                                        data-event="45" data-manager="{$manager->id}"
                                                                        data-order="{$order->order_id}"
                                                                        data-user="{$order->user_id}"><i
                                                                            class="fa fa-check"></i> Сохранить
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-inverse js-cancel-edit">Отмена
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- /Данные о работе -->


                                                <!--
                                                <h3 class="box-title mt-5">UTM-метки</h3>
                                                <hr>
                                                -->
                                            </div>
                                            <div class="col-md-4 ">

                                                {if $order->autoretry_result}
                                                    <div class="card mb-1 {if $order->autoretry_summ}card-success{else}card-danger{/if}">
                                                        <div class="box ">
                                                            <h5 class="card-title mb-0 text-white text-center">
                                                                Авторешение</h5>
                                                            <div class="text-white text-center">
                                                                <small class="text-white">
                                                                    {$order->autoretry_result}
                                                                </small>
                                                            </div>
                                                            {if $order->autoretry_summ && $order->status == 1}
                                                                <button data-order="{$order->order_id}"
                                                                        class="mt-2 btn btn-block btn-info btn-sm js-autoretry-accept js-event-add-click"
                                                                        data-event="17" data-manager="{$manager->id}"
                                                                        data-order="{$order->order_id}"
                                                                        data-user="{$order->user_id}">
                                                                    Выдать {$order->autoretry_summ} руб
                                                                </button>
                                                            {/if}
                                                        </div>
                                                    </div>
                                                {/if}

                                                <div class="mb-3 border  {if $penalties['scorings'] && $penalties['scorings']->status!=3}card-outline-danger{/if}">
                                                    <h5 class=" card-header">
                                                        <span class="text-white ">Скоринги</span>
                                                        <span class="float-right">
                                                            {penalty_button penalty_block='scorings'}
                                                            {if ($order->status == 1 && ($manager->id == $order->manager_id)) || $is_developer}
                                                                <a class="text-white js-run-scorings" data-type="all"
                                                                   data-order="{$order->order_id}"
                                                                   href="javascript:void(0);">
                                                                <i class="far fa-play-circle"></i>
                                                            </a>
                                                            {/if}
                                                        </span>
                                                    </h5>
                                                    <div class="message-box js-scorings-block {if $need_update_scorings}js-need-update{/if}"
                                                         data-order="{$order->order_id}">

                                                        {foreach $scoring_types as $scoring_type}
                                                            <div class="pl-2 pr-2 {if $scorings[$scoring_type->name]->status == 'new'}bg-light-warning{elseif $scorings[$scoring_type->name]->success}bg-light-success{else}bg-light-danger{/if}">
                                                                <div class="row {if !$scoring_type@last}border-bottom{/if}">
                                                                    <div class="col-12 col-sm-12 pt-2">
                                                                        <h5 class="float-left">
                                                                            {$scoring_type->title}
                                                                        </h5>

                                                                        {if $scorings[$scoring_type->name]->status == 'new'}
                                                                            <span class="label label-warning float-right">Ожидание</span>
                                                                        {elseif $scorings[$scoring_type->name]->status == 'process'}
                                                                            <span class="label label-info label-sm float-right">Выполняется</span>
                                                                        {elseif $scorings[$scoring_type->name]->status == 'error'}
                                                                            <span class="label label-danger label-sm float-right">Ошибка</span>
                                                                        {elseif $scorings[$scoring_type->name]->status == 'stopped'}
                                                                            <span class="label label-warning label-sm float-right">Остановлен</span>
                                                                        {elseif $scorings[$scoring_type->name]->status == 'completed'}
                                                                            {if $scorings[$scoring_type->name]->success == 1}
                                                                                <span class="label label-success label-sm float-right">Пройден</span>
                                                                            {else}
                                                                                <span class="label label-danger float-right">Не пройден</span>
                                                                            {/if}
                                                                        {/if}
                                                                    </div>
                                                                    <div class="col-8 col-sm-8 pb-2">
                                                                        <span class="mail-desc"
                                                                              title="{$scorings[$scoring_type->name]->string_result}">
                                                                            {$scorings[$scoring_type->name]->string_result}
                                                                        </span>
                                                                        {if $scoring_type->name == 'nbki'}
                                                                            {assign var=number_of_active value=$scorings[$scoring_type->name]->body['number_of_active'][0]}

                                                                            {if ($number_of_active >= 1 && $number_of_active <= 5)}
                                                                                {assign var=recommended_amount value=$scoring_type->params['recommended_amount_1_5']}
                                                                            {elseif ($number_of_active >= 6 && $number_of_active <= 10)}
                                                                                {assign var=recommended_amount value=$scoring_type->params['recommended_amount_6_10']}
                                                                            {elseif ($number_of_active >= 11 && $number_of_active <= 29)}
                                                                                {assign var=recommended_amount value=$scoring_type->params['recommended_amount_11_29']}
                                                                            {elseif ($number_of_active >= 30)}
                                                                                {assign var=recommended_amount value=$scoring_type->params['recommended_amount_30_']}
                                                                            {else}
                                                                                {assign var=recommended_amount value='???'}
                                                                            {/if}
                                                                            <span class="mail-desc"
                                                                                  title="{$scorings[$scoring_type->name]->body['number_of_active'][1]} - {$scorings[$scoring_type->name]->body['number_of_active'][0]}">
                                                                                    Рекомендуемая сумма: <b>{$recommended_amount}</b>
                                                                                </span>
                                                                            <span class="mail-desc"
                                                                                  title="{$number_of_active}">
                                                                                    Количество активных займов: <b>{$number_of_active}</b>
                                                                                </span>
                                                                        {/if}
                                                                        <span class="time">
                                                                            {if $scoring_type->name == 'whatsapp'}
                                                                                {if isset($scorings[$scoring_type->name]->body['status'])}
                                                                                    <span>{$scorings[$scoring_type->name]->body['status']}</span>
                                                                                    <br>
                                                                                {/if}
                                                                                {if isset($scorings[$scoring_type->name]->body['statusDate'])}
                                                                                <span>{$scorings[$scoring_type->name]->body['statusDate']}</span>
                                                                                <br>
                                                                            {/if}
                                                                                {if isset($scorings[$scoring_type->name]->body['image']) && $scorings[$scoring_type->name]->body['image'] != 'Ссылка на фото: Аватар скрыт'}
                                                                                <a href="{$scorings[$scoring_type->name]->body['image']}"
                                                                                   target="_blank">Ссылка на фото</a>
                                                                                <br>



{else}



                                                                                <span>Аватар: Скрыт</span>
                                                                                <br>
                                                                            {/if}
                                                                            {/if}
                                                                            {if $scoring_type->name == 'addresses'}
                                                                                {if !empty($scorings[$scoring_type->name]->body)}
                                                                                    {foreach $scorings[$scoring_type->name]->body as $id => $fio}
                                                                                        <a href="client/{$id}">{$fio}</a>
                                                                                        <br>
                                                                                    {/foreach}
                                                                                {/if}
                                                                            {/if}
                                                                            {if $scoring_type->name == 'fssp'}
                                                                                <span>Сумма долга: {$scorings[$scoring_type->name]->body['amount']}</span>
                                                                                <br>







{if isset($scorings[$scoring_type->name]->body['badArticles'])}
                                                                                <span>{$scorings[$scoring_type->name]->body['badArticles']}</span>
                                                                                <br>
                                                                            {/if}
                                                                            {/if}
                                                                            {if $scoring_type->name == 'contact'}
                                                                                <span>{$scorings[$scoring_type->name]->body['name']}</span>
                                                                                <br>
                                                                                <span>{$scorings[$scoring_type->name]->body['tags']}</span>
                                                                                <br>
                                                                            {/if}
                                                                            {if $scoring_type->name == 'juicescore'}
                                                                                <a href="#juicescore"
                                                                                   class="juiceScoreModal">Подробнее</a>
                                                                                <br>
                                                                            {/if}
                                                                            {if $scoring_type->name == 'equifax'}
                                                                                <a href="#equifaxScore"
                                                                                   class="equifaxScoreModal">Подробнее</a>
                                                                                <br>
                                                                            {/if}
                                                                            {if $scorings[$scoring_type->name]->created}
                                                                                {$scorings[$scoring_type->name]->created|date} {$scorings[$scoring_type->name]->created|time}
                                                                            {/if}
                                                                            {if $scoring_type->name == 'fssp2'}
                                                                                <a href="/ajax/show_fssp2.php?id={$scorings[$scoring_type->name]->id}&password=Hjkdf8d"
                                                                                   target="_blank">Подробнее</a>
                                                                            {/if}
                                                                            {if $scoring_type->name == 'efrsb' && $scorings[$scoring_type->name]->body}
                                                                                {foreach $scorings[$scoring_type->name]->body as $efrsb_link}
                                                                                    <a href="{$efrsb_link}"
                                                                                       target="_blank"
                                                                                       class="float-right">Подробнее</a>
                                                                                {/foreach}
                                                                            {/if}
                                                                            {if $scoring_type->name == 'nbki'}
                                                                                <a href="http://{$settings->nbki_ip}/nal-plus-nbki/{$scorings[$scoring_type->name]->id}?api=F1h1Hdf9g_h"
                                                                                   target="_blank">Подробнее</a>
                                                                            {/if}
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-4 col-sm-4 pb-2">
                                                                        {if $order->status < 2 || $is_developer}
                                                                            {if $scorings[$scoring_type->name]->status == 'new' || $scorings[$scoring_type->name]->status == 'process' }
                                                                                <a class="btn-load text-info run-scoring-btn float-right"
                                                                                   data-type="{$scoring_type->name}"
                                                                                   data-order="{$order->order_id}"
                                                                                   href="javascript:void(0);">
                                                                                    <div class="spinner-border text-info"
                                                                                         role="status"></div>
                                                                                </a>
                                                                            {elseif $scorings[$scoring_type->name]}
                                                                                <a class="btn-load text-info js-run-scorings run-scoring-btn float-right"
                                                                                   data-type="{$scoring_type->name}"
                                                                                   data-order="{$order->order_id}"
                                                                                   href="javascript:void(0);">
                                                                                    <i class="fas fa-undo"></i>
                                                                                </a>
                                                                            {else}
                                                                                <a class="btn-load {if in_array($scoring_type->name, $audit_types)}loading{/if} text-info js-run-scorings run-scoring-btn float-right"
                                                                                   data-type="{$scoring_type->name}"
                                                                                   data-order="{$order->order_id}"
                                                                                   href="javascript:void(0);">
                                                                                    <i class="far fa-play-circle"></i>
                                                                                </a>
                                                                            {/if}
                                                                        {/if}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        {/foreach}
                                                    </div>
                                                </div>

                                                <form action="{url}"
                                                      class="mb-3 border js-order-item-form {if $penalties['services'] && $penalties['services']->status!=3}card-outline-danger{/if}"
                                                      id="services_form">

                                                    <input type="hidden" name="action" value="services"/>
                                                    <input type="hidden" name="order_id" value="{$order->order_id}"/>
                                                    <input type="hidden" name="user_id" value="{$order->user_id}"/>


                                                    <h5 class="card-header text-white">
                                                        <span>Услуги</span>
                                                        <span class="float-right ">
                                                            {penalty_button penalty_block='services'}
                                                            <a href="javascript:void(0);"
                                                               class="js-edit-form text-white js-event-add-click"
                                                               data-event="36" data-manager="{$manager->id}"
                                                               data-order="{$order->order_id}"
                                                               data-user="{$order->user_id}"><i
                                                                        class=" fas fa-edit"></i></a>
                                                        </span>
                                                    </h5>

                                                    <div class="row view-block p-2 {if $services_error}hide{/if}">
                                                        <div class="col-md-12">
                                                            {*}
                                                            <div class="form-group mb-0 row">
                                                                <label class="control-label col-md-8 col-7">Смс информирование:</label>
                                                                <div class="col-md-4 col-5">
                                                                    <p class="form-control-static text-right">
                                                                        {if $order->service_sms}
                                                                            <span class="label label-success">Вкл</span>
                                                                        {else}
                                                                            <span class="label label-danger">Выкл</span>
                                                                        {/if}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            {*}
                                                            <div class="form-group mb-0 row">
                                                                <label class="control-label col-md-8 col-7">Причина
                                                                    отказа:</label>
                                                                <div class="col-md-4 col-5">
                                                                    <p class="form-control-static text-right">
                                                                        {if $order->service_reason}
                                                                            <span class="label label-success">Вкл</span>
                                                                        {else}
                                                                            <span class="label label-danger">Выкл</span>
                                                                        {/if}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-0 row">
                                                                <label class="control-label col-md-8 col-7">
                                                                    Страхование:
                                                                    {if $contract_insurance->protection}
                                                                        <span class="label label-custom">Z</span>
                                                                        {if $contract->insurance_returned}
                                                                            <small class="text-danger">Страховка
                                                                                возвращена
                                                                            </small>
                                                                        {else}
                                                                            <button class="btn btn-xs btn-danger js-return-insure"
                                                                                    data-contract="{$contract->id}"
                                                                                    type="button">Вернуть
                                                                            </button>
                                                                        {/if}
                                                                    {/if}
                                                                </label>
                                                                <div class="col-md-4 col-5">
                                                                    <p class="form-control-static text-right">
                                                                        {if $order->service_insurance}
                                                                            <span class="label label-success">Вкл</span>
                                                                        {else}
                                                                            <span class="label label-danger">Выкл</span>
                                                                        {/if}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row p-2 edit-block {if !$services_error}hide{/if}">
                                                        <div class="col-md-12">
                                                            {*}
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" name="service_sms" id="service_sms" value="1" {if $order->service_sms}checked="true"{/if} />
                                                                    <label class="custom-control-label" for="service_sms">Смс информирование</label>
                                                                </div>
                                                            </div>
                                                            {*}
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           name="service_reason" id="service_reason"
                                                                           value="1"
                                                                           {if $order->service_reason}checked="true"{/if} />
                                                                    <label class="custom-control-label"
                                                                           for="service_reason">Причина отказа</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           name="service_insurance"
                                                                           id="service_insurance" value="1"
                                                                           {if $order->service_insurance}checked="true"{/if} />
                                                                    <label class="custom-control-label"
                                                                           for="service_insurance">Страхование</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-actions">
                                                                <button type="submit"
                                                                        class="btn btn-success js-event-add-click"
                                                                        data-event="46" data-manager="{$manager->id}"
                                                                        data-order="{$order->order_id}"
                                                                        data-user="{$order->user_id}"><i
                                                                            class="fa fa-check"></i> Сохранить
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-inverse js-cancel-edit">Отмена
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </form>

                                                <form action="{url}"
                                                      class="mb-3 border js-order-item-form {if $penalties['cards'] && $penalties['cards']->status!=3}card-outline-danger{/if}"
                                                      id="cards_form">

                                                    <input type="hidden" name="action" value="cards"/>
                                                    <input type="hidden" name="order_id" value="{$order->order_id}"/>
                                                    <input type="hidden" name="user_id" value="{$order->user_id}"/>


                                                    <h5 class="card-header text-white">
                                                        <span>Карта</span>
                                                        <span class="float-right">
                                                            {penalty_button penalty_block='cards'}
                                                            {if !in_array($order->status, [3,4,5,7,8])}
                                                                <a href="javascript:void(0);"
                                                                   class="js-edit-form text-white js-event-add-click"
                                                                   data-event="37" data-manager="{$manager->id}"
                                                                   data-order="{$order->order_id}"
                                                                   data-user="{$order->user_id}"><i
                                                                            class=" fas fa-edit"></i></a>
                                                            {/if}
                                                        </span>
                                                    </h5>

                                                    <div class="row view-block p-2 {if $card_error}hide{/if}">
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-0 row">
                                                                <label class="control-label col-md-8 col-7">
                                                                    {$cards[$order->card_id]->pan}
                                                                    <p>{$cards[$order->card_id]->bin_issuer}</p>
                                                                    {if $cards[$order->card_id]->deleted}(карта удалена){/if}
                                                                </label>
                                                                <div class="col-md-4 col-5">
                                                                    <p class="form-control-static text-right">
                                                                        {$cards[$order->card_id]->expdate}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row p-2 edit-block {if !$card_error}hide{/if}">
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-4 {if in_array('empty_card', (array)$card_error)}has-danger{/if}">
                                                                <select class="form-control" name="card_id">
                                                                    {foreach $cards as $card}
                                                                        <option value="{$card->id}"
                                                                                {if $card->id == $order->card_id}selected{/if}>
                                                                            {$card->pan|escape} {$card->expdate}
                                                                            {if $card->base_card}(основная){/if}
                                                                            {if $card->deleted}(карта удалена){/if}
                                                                        </option>
                                                                    {/foreach}
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-actions">
                                                                <button type="submit"
                                                                        class="btn btn-success js-event-add-click"
                                                                        data-event="47" data-manager="{$manager->id}"
                                                                        data-order="{$order->order_id}"
                                                                        data-user="{$order->user_id}"><i
                                                                            class="fa fa-check"></i> Сохранить
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-inverse js-cancel-edit">Отмена
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </form>

                                                <form class="mb-4 border">
                                                    <h6 class="card-header text-white">
                                                        <span>ПДН</span>
                                                    </h6>
                                                    <div class="row view-block p-2 snils-front">
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-0 row">
                                                                <label class="control-label col-md-8 col-7 snils-number">{$order->pdn}
                                                                    %</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                        <!-- -->

                                        <form action="{url}"
                                              class="border js-order-item-form mb-3 js-check-images {if $penalties['images'] && $penalties['images']->status!=3}card-outline-danger{/if}"
                                              id="images_form" data-user="{$order->user_id}">

                                            <input type="hidden" name="action" value="images"/>
                                            <input type="hidden" name="order_id" value="{$order->order_id}"/>
                                            <input type="hidden" name="user_id" value="{$order->user_id}"/>

                                            <h5 class="card-header">
                                                <span class="text-white">Фотографии</span>
                                                <span class="float-right">
                                                    {penalty_button penalty_block='images'}
                                                </span>
                                            </h5>

                                            <div class="row p-2 view-block {if $socials_error}hide{/if}">
                                                <ul class="col-md-12 list-inline order-images-list">
                                                    {foreach $files as $file}
                                                        {if $file->status == 0}
                                                            {$item_class="border-warning"}
                                                            {$ribbon_class="ribbon-warning"}
                                                            {$ribbon_icon="fas fa-question"}
                                                        {elseif $file->status == 1}
                                                            {$item_class="border-primary"}
                                                            {$ribbon_class="ribbon-primary"}
                                                            {$ribbon_icon="fas fa-clock"}
                                                        {elseif $file->status == 2}
                                                            {$item_class="border-success border border-bg"}
                                                            {$ribbon_class="ribbon-success"}
                                                            {$ribbon_icon="fa fa-check-circle"}
                                                        {elseif $file->status == 3}
                                                            {$item_class="border-danger border"}
                                                            {$ribbon_class="ribbon-danger"}
                                                            {$ribbon_icon="fas fa-times-circle"}
                                                        {elseif $file->status == 4}
                                                            {$item_class="border-info border"}
                                                            {$ribbon_class="ribbon-info"}
                                                            {$ribbon_icon="fab fa-cloudversify"}
                                                        {/if}
                                                        <li class="order-image-item ribbon-wrapper rounded-sm border {$item_class} js-image-item"
                                                            data-status="{$file->status}" id="file_{$file->id}"
                                                            data-id="{$file->id}" data-status="{$file->status}">
                                                            <a class="js-open-popup-image image-popup-fit-width js-event-add-click"
                                                               data-event="50" data-manager="{$manager->id}"
                                                               data-order="{$order->order_id}"
                                                               data-user="{$order->user_id}" data-fancybox="user_image"
                                                               href="{$config->front_url}/files/users/{$file->name}">
                                                                <div class="ribbon ribbon-corner {$ribbon_class}"><i
                                                                            class="{$ribbon_icon}"></i></div>
                                                                <img src="{$config->front_url}/files/users/{$file->name}"
                                                                     alt="" class="img-responsive" style=""/>
                                                                <span class="label label-primary  image-label" style="">
                                                                {if $file->type == 'passport1'}Паспорт1
                                                                {elseif $file->type == 'passport2'}Паспорт2
                                                                {elseif $file->type == 'card'}Карта
                                                                {elseif $file->type == 'face'}Селфи
                                                                {else}Нет типа{/if}
                                                            </span>
                                                                {if !empty($file->sent_date)}
                                                                    <span class="label label-danger"
                                                                          style="bottom: -25px;">
                                                                    {$file->sent_date|date_format:"%d.%m.%Y в %H:%M"}
                                                                </span>
                                                                {/if}
                                                            </a>
                                                            {if $order->status == 1 && ($manager->id == $order->manager_id)}
                                                                <div class="order-image-actions">
                                                                    <div class="dropdown mr-1 show ">
                                                                        <button type="button"
                                                                                class="btn {if $file->status==2}btn-success{elseif $file->status==3}btn-danger{else}btn-secondary{/if} dropdown-toggle"
                                                                                id="dropdownMenuOffset"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="true">
                                                                            {if $file->status == 2}Принят
                                                                            {elseif $file->status == 3}Отклонен
                                                                            {else}Статус
                                                                            {/if}
                                                                        </button>
                                                                        <div class="dropdown-menu"
                                                                             aria-labelledby="dropdownMenuOffset"
                                                                             x-placement="bottom-start">
                                                                            <div class="p-1 dropdown-item">
                                                                                <button class="btn btn-sm btn-block btn-outline-success js-image-accept js-event-add-click"
                                                                                        data-event="51"
                                                                                        data-manager="{$manager->id}"
                                                                                        data-order="{$order->order_id}"
                                                                                        data-user="{$order->user_id}"
                                                                                        data-id="{$file->id}"
                                                                                        type="button">
                                                                                    <i class="fas fa-check-circle"></i>
                                                                                    <span>Принять</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="p-1 dropdown-item">
                                                                                <button class="btn btn-sm btn-block btn-outline-danger js-image-reject js-event-add-click"
                                                                                        data-event="52"
                                                                                        data-manager="{$manager->id}"
                                                                                        data-order="{$order->order_id}"
                                                                                        data-user="{$order->user_id}"
                                                                                        data-id="{$file->id}"
                                                                                        type="button">
                                                                                    <i class="fas fa-times-circle"></i>
                                                                                    <span>Отклонить</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="p-1 pt-3 dropdown-item">
                                                                                <button class="btn btn-sm btn-block btn-danger js-image-remove js-event-add-click"
                                                                                        data-event="53"
                                                                                        data-manager="{$manager->id}"
                                                                                        data-order="{$order->order_id}"
                                                                                        data-user="{$order->user_id}"
                                                                                        data-user="{$order->user_id}"
                                                                                        data-id="{$file->id}"
                                                                                        type="button">
                                                                                    <i class="fas fa-trash"></i>
                                                                                    <span>Удалить</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {/if}
                                                        </li>
                                                    {/foreach}
                                                </ul>
                                            </div>

                                            <div class="row edit-block {if !$images_error}hide{/if}">
                                                {foreach $files as $file}
                                                    <div class="col-md-4 col-lg-3 col-xlg-3">
                                                        <div class="card card-body">
                                                            <div class="row">
                                                                <div class="col-md-6 col-lg-8">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Статус</label>
                                                                        <input type="text" class="js-file-status"
                                                                               id="status_{$file->id}"
                                                                               name="status[{$file->id}]"
                                                                               value="{$file->status}"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {/foreach}
                                                <div class="col-md-12">
                                                    <div class="form-actions">
                                                        <button type="submit" class="btn btn-success"><i
                                                                    class="fa fa-check"></i> Сохранить
                                                        </button>
                                                        <button type="button" class="btn btn-inverse js-cancel-edit">
                                                            Отмена
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- -->
                                        <form method="POST" enctype="multipart/form-data">

                                            <div class="form_file_item">
                                                <input type="file" name="new_file" id="new_file"
                                                       data-user="{$order->user_id}" value="" style="display:none"/>
                                                <label for="new_file" class="btn btn-large btn-primary">
                                                    <i class="fa fa-plus-circle"></i>
                                                    <span>Добавить</span>
                                                </label>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                                <!-- Комментарии -->
                                <div class="tab-pane p-3" id="comments" role="tabpanel">

                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="float-left">Комментарии к клиенту</h4>
                                            <button class="btn float-right hidden-sm-down btn-success js-open-comment-form">
                                                <i class="mdi mdi-plus-circle"></i>
                                                Добавить
                                            </button>
                                        </div>
                                        <hr class="m-3"/>
                                        <div class="col-12">
                                            {if $contract->premier && $manager->role == 'user'}
                                                <h1 class="text-danger">ДОГОВОР ПРОДАН в КА "Премьер".</h1>
                                            {elseif  $contract->sold && $manager->role == 'user'}
                                                <h1 class="text-danger">ДОГОВОР ПРОДАН в КА "ЮК1".</h1>
                                            {else}
                                                {if $comments}
                                                    <div class="message-box">
                                                        <div class="message-widget">
                                                            {foreach $comments as $comment}
                                                                <a href="javascript:void(0);">
                                                                    <div class="user-img">
                                                                        <span class="round">{$comment->letter|escape}</span>
                                                                    </div>
                                                                    <div class="mail-contnet">
                                                                        <div class="clearfix">
                                                                            <h5>{$managers[$comment->manager_id]->name|escape}</h5>
                                                                            {if $comment->official}
                                                                                <span class="label label-success">Оффициальный</span>
                                                                            {/if}
                                                                            {if $comment->organization=='mkk'}
                                                                                <span class="label label-info">МКК</span>
                                                                            {/if}
                                                                            {if $comment->organization=='yuk'}
                                                                                <span class="label label-danger">ЮК</span>
                                                                            {/if}
                                                                        </div>
                                                                        <span class="mail-desc">
                                                                {$comment->text|nl2br}
                                                            </span>
                                                                        <span class="time">{$comment->created|date} {$comment->created|time}</span>
                                                                    </div>

                                                                </a>
                                                            {/foreach}
                                                        </div>
                                                    </div>
                                                {/if}

                                                {if $comments_1c}
                                                    <h3>Комментарии из 1С</h3>
                                                    <table class="table">
                                                        <tr>
                                                            <th>Дата</th>
                                                            <th>Блок</th>
                                                            <th>Комментарий</th>
                                                        </tr>
                                                        {foreach $comments_1c as $comment}
                                                            <tr>
                                                                <td>{$comment->created|date} {$comment->created|time}</td>
                                                                <td>{$comment->block|escape}</td>
                                                                <td>{$comment->text|nl2br}</td>
                                                            </tr>
                                                        {/foreach}
                                                    </table>
                                                {/if}

                                                {if !$comments && !$comments_1c}
                                                    <h4>Нет комментариев</h4>
                                                {/if}
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                                <!-- /Комментарии -->

                                <!-- Документы -->
                                <div class="tab-pane p-3" id="documents" role="tabpanel">
                                    {if $documents}
                                        <table class="table">
                                            {foreach $documents as $document}
                                                <tr>
                                                    <td class="text-info">
                                                        <a target="_blank"
                                                           href="{$config->front_url}/document/{$document->user_id}/{$document->id}">
                                                            <i class="fas fa-file-pdf fa-lg"></i>&nbsp;
                                                            {$document->name|escape}
                                                        </a>
                                                    </td>
                                                    <td class="text-right">
                                                        {$document->created|date}
                                                        {$document->created|time}
                                                    </td>
                                                </tr>
                                            {/foreach}
                                        </table>
                                    {else}
                                        <h4>Нет доступных документов</h4>
                                    {/if}
                                </div>
                                <!-- /Документы -->


                                <div class="tab-pane p-3" id="logs" role="tabpanel">

                                    <ul class="nav nav-pills mt-4 mb-4">
                                        <li class=" nav-item"><a href="#eventlogs" class="nav-link active"
                                                                 data-toggle="tab" aria-expanded="false">События</a>
                                        </li>
                                        <li class="nav-item"><a href="#changelogs" class="nav-link" data-toggle="tab"
                                                                aria-expanded="false">Данные</a></li>
                                    </ul>

                                    <div class="tab-content br-n pn">
                                        <div id="eventlogs" class="tab-pane active">
                                            <h3>События</h3>
                                            {if $eventlogs}
                                                <table class="table table-hover ">
                                                    <tbody>
                                                    {foreach $eventlogs as $eventlog}
                                                        <tr class="">
                                                            <td>
                                                                <span>{$eventlog->created|date}</span>
                                                                {$eventlog->created|time}
                                                            </td>
                                                            <td>
                                                                {$events[$eventlog->event_id]|escape}
                                                            </td>
                                                            <td>
                                                                <a href="manager/{$eventlog->manager_id}">{$managers[$eventlog->manager_id]->name|escape}</a>
                                                            </td>
                                                        </tr>
                                                    {/foreach}
                                                    </tbody>
                                                </table>
                                                <a href="http://45.147.176.183/get/html_to_sheet?name={$order->order_id}&code=3Tfiikdfg6">...</a>
                                            {else}
                                                Нет записей
                                            {/if}

                                        </div>

                                        <div id="changelogs" class="tab-pane">
                                            <h3>Изменение данных</h3>
                                            {if $changelogs}
                                                <table class="table table-hover ">
                                                    <tbody>
                                                    {foreach $changelogs as $changelog}
                                                        <tr class="">
                                                            <td>
                                                                <div class="button-toggle-wrapper">
                                                                    <button class="js-open-order button-toggle"
                                                                            data-id="{$changelog->id}" type="button"
                                                                            title="Подробнее"></button>
                                                                </div>
                                                                <span>{$changelog->created|date}</span>
                                                                {$changelog->created|time}
                                                            </td>
                                                            <td>
                                                                {if $changelog_types[$changelog->type]}{$changelog_types[$changelog->type]}
                                                                {else}{$changelog->type|escape}{/if}
                                                            </td>
                                                            <td>
                                                                <a href="manager/{$changelog->manager->id}">{$changelog->manager->name|escape}</a>
                                                            </td>
                                                            <td>
                                                                <a href="client/{$changelog->user->id}">
                                                                    {$changelog->user->lastname|escape}
                                                                    {$changelog->user->firstname|escape}
                                                                    {$changelog->user->patronymic|escape}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr class="order-details" id="changelog_{$changelog->id}"
                                                            style="display:none">
                                                            <td colspan="4">
                                                                <div class="row">
                                                                    <ul class="dtr-details col-md-6 list-unstyled">
                                                                        {foreach $changelog->old_values as $field => $old_value}
                                                                            <li>
                                                                                <strong>{$field}: </strong>
                                                                                <span>{$old_value}</span>
                                                                            </li>
                                                                        {/foreach}
                                                                    </ul>
                                                                    <ul class="col-md-6 dtr-details list-unstyled">
                                                                        {foreach $changelog->new_values as $field => $new_value}
                                                                            <li>
                                                                                <strong>{$field}: </strong>
                                                                                <span>{$new_value}</span>
                                                                            </li>
                                                                        {/foreach}
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    {/foreach}
                                                    </tbody>
                                                </table>
                                            {else}
                                                Нет записей
                                            {/if}

                                        </div>

                                    </div>

                                </div>

                                <div class="tab-pane p-3" id="operations" role="tabpanel">
                                    {if $contract_operations}
                                        <table class="table table-hover table-condense">
                                            <tbody>
                                            <tr>
                                                <th>Дата</th>
                                                <th>Операция</th>
                                                <th>Сумма</th>
                                                <th>ОД</th>
                                                <th>Проц-ты</th>
                                                <th>Отв-ть</th>
                                                <th>Пени</th>
                                                <th>Остаток</th>
                                            </tr>
                                            {foreach $contract_operations as $operation}
                                                <tr class="
                                                    {if in_array($operation->type, ['PAY'])}table-success{/if}
                                                    {if in_array($operation->type, ['PAY-REC'])}table-success{/if}
                                                    {if in_array($operation->type, ['PERCENTS', 'CHARGE', 'PENI'])}table-danger{/if} 
                                                    {if in_array($operation->type, ['P2P'])}table-info{/if} 
                                                    {if in_array($operation->type, ['INSURANCE'])}table-warning{/if}
                                                    {if in_array($operation->type, ['CORRECT'])}table-primary{/if}
                                                ">
                                                    <td>
                                                        {*}                                               
                                                        <div class="button-toggle-wrapper">
                                                            <button class="js-open-order button-toggle" data-id="{$changelog->id}" type="button" title="Подробнее"></button>
                                                        </div>
                                                        {*}
                                                        <span>{$operation->created|date}</span>
                                                        {$operation->created|time}
                                                    </td>
                                                    <td>
                                                        {if $operation->type == 'P2P'}Выдача займа{/if}
                                                        {if $operation->type == 'PAY'}
                                                            {if $operation->transaction->prolongation}
                                                                Пролонгация
                                                            {else}
                                                                Оплата займа
                                                            {/if}
                                                        {/if}
                                                        {if $operation->type == 'RECURRENT'}Оплата займа{/if}
                                                        {if $operation->type == 'PAY-REC'}Реккурентное списание{/if}
                                                        {if $operation->type == 'PERCENTS'}Начисление процентов{/if}
                                                        {if $operation->type == 'INSURANCE'}Страховка{/if}
                                                        {if $operation->type == 'CHARGE'}Ответственность{/if}
                                                        {if $operation->type == 'PENI'}Пени{/if}
                                                        {if $operation->type == 'CORRECT'}Корректировка{/if}
                                                    </td>
                                                    <td>
                                                        <strong>{$operation->amount} руб</strong>
                                                    </td>
                                                    <td>{$operation->loan_body_summ}</td>
                                                    <td>{$operation->loan_percents_summ}</td>
                                                    <td>{$operation->loan_charge_summ}</td>
                                                    <td>{$operation->loan_peni_summ}</td>
                                                    <td>
                                                        <strong>{$operation->loan_body_summ+$operation->loan_percents_summ+$operation->loan_charge_summ+$operation->loan_peni_summ}</strong>
                                                    </td>
                                                </tr>
                                            {/foreach}
                                            </tbody>
                                        </table>
                                    {else}
                                        <h4>Нет операций</h4>
                                    {/if}
                                </div>

                                <div id="history" class="tab-pane" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            {*}
                                            <ul class="nav nav-pills mt-4 mb-4">
                                                <li class=" nav-item"> <a href="#navpills-orders" class="nav-link active" data-toggle="tab" aria-expanded="false">Заявки</a> </li>
                                                <li class="nav-item"> <a href="#navpills-loans" class="nav-link" data-toggle="tab" aria-expanded="false">Кредиты</a> </li>
                                            </ul>
                                            {*}
                                            <div class="tab-content br-n pn">
                                                <div id="navpills-orders" class="tab-pane active">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h3>Заявки</h3>
                                                            <table class="table">
                                                                <tr>
                                                                    <th>Дата</th>
                                                                    <th>Заявка</th>
                                                                    <th>Договор</th>
                                                                    <th class="text-center">Сумма</th>
                                                                    <th class="text-center">Период</th>
                                                                    <th class="text-right">Статус</th>
                                                                </tr>
                                                                {foreach $orders as $o}
                                                                    {if $o->contract->type != 'onec'}
                                                                        <tr>
                                                                            <td>{$o->date|date} {$o->date|time}</td>
                                                                            <td>
                                                                                <a href="order/{$o->order_id}"
                                                                                   target="_blank">{$o->order_id}</a>
                                                                            </td>
                                                                            <td>
                                                                                {$o->contract->number}
                                                                            </td>
                                                                            <td class="text-center">{$o->amount}</td>
                                                                            <td class="text-center">{$o->period}</td>
                                                                            <td class="text-right">
                                                                                {if $o->contract->status==10}
                                                                                    <span class="label label-danger">Суд 1С</span>
                                                                                {else}
                                                                                    {$order_statuses[$o->status]}
                                                                                {/if}
                                                                                {if $o->contract->status==3}
                                                                                    <br/>
                                                                                    <small>{$o->contract->close_date|date} {$o->contract->close_date|time}</small>{/if}
                                                                            </td>
                                                                        </tr>
                                                                    {/if}
                                                                {/foreach}
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="navpills-loans" class="tab-pane active">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h3>Кредитная история 1С</h3>
                                                            {if $client->loan_history|count > 0}
                                                                <table class="table">
                                                                    <tr>
                                                                        <th>Дата</th>
                                                                        <th>Договор</th>
                                                                        <th class="text-right">Статус</th>
                                                                        <th class="text-center">Сумма</th>
                                                                        <th class="text-center">Остаток ОД</th>
                                                                        <th class="text-right">Остаток процентов</th>
                                                                        <th>&nbsp;</th>
                                                                    </tr>
                                                                    {foreach $client->loan_history as $loan_history_item}
                                                                        <tr>
                                                                            <td>
                                                                                {$loan_history_item->date|date}
                                                                            </td>
                                                                            <td>
                                                                                {$loan_history_item->number}
                                                                            </td>
                                                                            <td class="text-right">
                                                                                {if $loan_history_item->sud}
                                                                                    <span class="label label-danger">Суд</span>
                                                                                {else}
                                                                                    {if $loan_history_item->loan_percents_summ > 0 || $loan_history_item->loan_body_summ > 0}
                                                                                        <span class="label label-danger">Активный</span>
                                                                                    {else}
                                                                                        <span class="label label-success">Закрыт</span>
                                                                                    {/if}
                                                                                {/if}
                                                                            </td>
                                                                            <td class="text-center">{$loan_history_item->amount}</td>
                                                                            <td class="text-center">{$loan_history_item->loan_body_summ}</td>
                                                                            <td class="text-right">{$loan_history_item->loan_percents_summ}</td>
                                                                            <td>
                                                                                <button type="button"
                                                                                        class="btn btn-xs btn-info js-get-movements"
                                                                                        data-number="{$loan_history_item->number}">
                                                                                    Операции
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    {/foreach}
                                                                </table>
                                                            {else}
                                                                <h4>Нет кредитов</h4>
                                                            {/if}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane p-3" id="connexions" role="tabpanel">
                                    <div class="row pb-2">
                                        <div class="col-6">
                                            <h3>Связанные лица</h3>
                                        </div>
                                        <div class="col-6 text-right">
                                            <button class="btn btn-loading btn-info js-run-connexions"
                                                    data-user="{$order->user_id}" type="button">
                                                <i class="fas fa-search"></i>
                                                <span>Искать Совпадения</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="js-app-connexions" data-user="{$order->user_id}">

                                    </div>
                                </div>


                                <div class="tab-pane p-3" id="communications" role="tabpanel">

                                    <h3>Коммуникации с клиентом</h3>
                                    {if $communications}
                                        <table class="table table-hover table-bordered">
                                            <tbody>
                                            <tr class="table-success">
                                                <th>Дата</th>
                                                <th>Договор</th>
                                                <th>Тип</th>
                                                <th>Пользователь</th>
                                                <th>Орг-я</th>
                                                <th>Номер</th>
                                                <th>Исходящий</th>
                                                <th>Содержание</th>
                                            </tr>
                                            {foreach $communications as $communication}
                                                <tr class="communication-{$communication->order_id}">
                                                    <td>
                                                        <small>{$communication->created|date}</small>
                                                        <br/>
                                                        <small>{$communication->created|time}</small>
                                                    </td>
                                                    <td class="text-center">
                                                        {if $communication->order}
                                                            <a href="order/{$communication->order_id}" target="_blank">
                                                                <small>{$communication->order->order_id}</small>
                                                            </a>
                                                        {/if}
                                                    </td>
                                                    <td>
                                                        {if $communication->type == 'sms'}Смс{/if}
                                                        {if $communication->type == 'zvonobot'}Звонобот{/if}
                                                        {if $communication->type == 'call'}Звонок{/if}
                                                    </td>
                                                    <td>
                                                        {$managers[$communication->manager_id]->name|escape}
                                                    </td>
                                                    <td>
                                                        {if $communication->yuk}
                                                            <span class="label label-info">ЮК</span>
                                                        {else}
                                                            <span class="label label-success">МКК</span>
                                                        {/if}
                                                    </td>
                                                    <td>
                                                        {$communication->to_number}
                                                    </td>
                                                    <td>
                                                        {$communication->from_number}
                                                    </td>
                                                    <td>
                                                        {$communication->content}
                                                    </td>
                                                </tr>
                                            {/foreach}
                                            </tbody>
                                        </table>
                                    {else}
                                        <h4>Нет коммуникаций</h4>
                                    {/if}
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    {/if}
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

    {include file='footer.tpl'}

</div>


<div id="modal_reject_reason" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Отказать в выдаче кредита?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">


                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#reject_mko" role="tab"
                                   aria-controls="home5" aria-expanded="true" aria-selected="true">
                                    <span class="hidden-sm-up"><i class="ti-home"></i></span>
                                    <span class="hidden-xs-down">Отказ МКО</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#reject_client" role="tab"
                                   aria-controls="profile" aria-selected="false">
                                    <span class="hidden-sm-up"><i class="ti-user"></i></span>
                                    <span class="hidden-xs-down">Отказ клиента</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content tabcontent-border p-3" id="myTabContent">
                            <div role="tabpanel" class="tab-pane fade active show" id="reject_mko"
                                 aria-labelledby="home-tab">
                                <form class="js-reject-form">
                                    <input type="hidden" name="order_id" value="{$order->order_id}"/>
                                    <input type="hidden" name="action" value="reject_order"/>
                                    <input type="hidden" name="status" value="3"/>
                                    <div class="form-group">
                                        <label for="admin_name" class="control-label">Выберите причину отказа:</label>
                                        <select name="reason" class="form-control">
                                            {foreach $reject_reasons as $reject_reason}
                                                {if $reject_reason->type == 'mko'}
                                                    <option value="{$reject_reason->id|escape}">{$reject_reason->admin_name|escape}</option>
                                                {/if}
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="form-action clearfix">
                                        <button type="button" class="btn btn-danger btn-lg float-left waves-effect"
                                                data-dismiss="modal">Отменить
                                        </button>
                                        <button type="submit"
                                                class="btn btn-success btn-lg float-right waves-effect waves-light">Да,
                                            отказать
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="reject_client" role="tabpanel" aria-labelledby="profile-tab">
                                <form class="js-reject-form">
                                    <input type="hidden" name="order_id" value="{$order->order_id}"/>
                                    <input type="hidden" name="action" value="reject_order"/>
                                    <input type="hidden" name="status" value="8"/>
                                    <div class="form-group">
                                        <label for="admin_name" class="control-label">Выберите причину отказа:</label>
                                        <select name="reason" class="form-control">
                                            {foreach $reject_reasons as $reject_reason}
                                                {if $reject_reason->type == 'client'}
                                                    <option value="{$reject_reason->id|escape}">{$reject_reason->admin_name|escape}</option>
                                                {/if}
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="form-action clearfix">
                                        <button type="button" class="btn btn-danger btn-lg float-left waves-effect"
                                                data-dismiss="modal">Отменить
                                        </button>
                                        <button type="submit"
                                                class="btn btn-success btn-lg float-right waves-effect waves-light">Да,
                                            отказать
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal_add_comment" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Добавить комментарий</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_add_comment" action="order/{$order->order_id}">

                    <input type="hidden" name="order_id" value="{$order->order_id}"/>
                    <input type="hidden" name="user_id" value="{$order->user_id}"/>
                    <input type="hidden" name="block" value=""/>
                    <input type="hidden" name="action" value="add_comment"/>

                    <div class="alert" style="display:none"></div>

                    <div class="form-group">
                        <label for="name" class="control-label">Комментарий:</label>
                        <textarea class="form-control" name="text"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mr-sm-2 mb-3">
                            <input class="custom-control-input" type="checkbox" name="official" value="1"
                                   id="official"/>
                            <label for="official" class="custom-control-label">Оффициальный:</label>
                        </div>
                    </div>
                    <div class="form-action">
                        <button type="button" class="btn btn-danger waves-effect js-event-add-click" data-event="70"
                                data-manager="{$manager->id}" data-order="{$order->order_id}"
                                data-user="{$order->user_id}" data-dismiss="modal">Отмена
                        </button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_close_contract" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Закрыть договор</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_close_contract" action="order/{$order->order_id}">

                    <input type="hidden" name="order_id" value="{$order->order_id}"/>
                    <input type="hidden" name="user_id" value="{$order->user_id}"/>
                    <input type="hidden" name="action" value="close_contract"/>

                    <div class="alert" style="display:none"></div>

                    <div class="form-group">
                        <label for="close_date" class="control-label">Дата закрытия:</label>
                        <input type="text" class="form-control" name="close_date" required="" placeholder="ДД.ММ.ГГГГ"
                               value="{''|date}"/>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="control-label">Комментарий:</label>
                        <textarea class="form-control" id="comment" name="comment" required=""></textarea>
                    </div>
                    <div class="form-action">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_correct" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header bg-info">
                <h3 class="modal-title text-white text-center">Корректировка</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_correct" action="order/{$order->order_id}">

                    <input type="hidden" name="order_id" value="{$order->order_id}"/>
                    <input type="hidden" name="user_id" value="{$order->user_id}"/>
                    <input type="hidden" name="action" value="correct"/>

                    <div class="alert" style="display:none"></div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="close_date" class="control-label">ОД:</label>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" name="od" required=""
                                       value="{$contract->loan_body_summ}"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="close_date" class="control-label">Проценты:</label>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" name="percents" required=""
                                       value="{$contract->loan_percents_summ}"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="close_date" class="control-label">Отв-ть:</label>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" name="charge" required=""
                                       value="{$contract->loan_charge_summ}"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="close_date" class="control-label">Пени:</label>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" name="peni" required=""
                                       value="{$contract->loan_peni_summ}"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="control-label">Комментарий:</label>
                        <textarea class="form-control" id="comment" name="comment" required=""></textarea>
                    </div>
                    <div class="form-action">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_fssp_info" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Результаты проверки</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>Номер, дата</th>
                        <th>Документ</th>
                        <th>Производство</th>
                        <th>Департамент</th>
                        <th>Закрыт</th>
                    </tr>
                    <tbody class="js-fssp-info-result">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="loan_operations" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loan_operations_title">Операции по договору</h5>
                <button type="button" class="btn-close btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times text-white"></i>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div id="modal_add_penalty" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Оштрафовать</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_add_penalty" action="order/{$order->order_id}">

                    <input type="hidden" name="order_id" value="{$order->order_id}"/>
                    <input type="hidden" name="manager_id" value="{$order->manager_id}"/>
                    <input type="hidden" name="control_manager_id" value="{$manager->id}"/>
                    <input type="hidden" name="block" value=""/>
                    <input type="hidden" name="action" value="add_penalty"/>

                    <div class="alert" style="display:none"></div>

                    <div class="form-group">
                        <label for="close_date" class="control-label">Причина:</label>
                        <select name="type_id" class="form-control">
                            <option value=""></option>
                            {foreach $penalty_types as $t}
                                <option value="{$t->id}">{$t->name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="control-label">Комментарий:</label>
                        <textarea class="form-control" id="comment" name="comment"></textarea>
                    </div>
                    <div class="form-action">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_send_sms" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Отправить смс-сообщение?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">


                <div class="card">
                    <div class="card-body">

                        <div class="tab-content tabcontent-border p-3" id="myTabContent">
                            <div role="tabpanel" class="tab-pane fade active show" id="waiting_reason"
                                 aria-labelledby="home-tab">
                                <form class="js-sms-form">
                                    <input type="hidden" name="user_id" value=""/>
                                    <input type="hidden" name="order_id" value=""/>
                                    <input type="hidden" name="yuk" value=""/>
                                    <input type="hidden" name="action" value="send_sms"/>
                                    <div class="form-group">
                                        <label for="name" class="control-label">Выберите шаблон сообщения:</label>
                                        <select name="template_id" class="form-control">
                                            {foreach $sms_templates as $sms_template}
                                                <option value="{$sms_template->id}"
                                                        title="{$sms_template->template|escape}">
                                                    {$sms_template->name|escape} ({$sms_template->template})
                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="form-action clearfix">
                                        <button type="button" class="btn btn-danger btn-lg float-left waves-effect"
                                                data-dismiss="modal">Отменить
                                        </button>
                                        <button type="submit"
                                                class="btn btn-success btn-lg float-right waves-effect waves-light">Да,
                                            отправить
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="juiceScoreModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Информация по Джуси Скорингу</h4>
            </div>
            <div class="modal-body">
                <div class="form-group" style="display:flex; flex-direction: column">
                    <div class="form-group">
                        <label>Antifraud_score: {$juiceScore->body['AntiFraud score']}</label>
                    </div>
                    <div class="form-group">
                        <label>Device_id: {$juiceScore->body['Device id']}</label>
                    </div>
                    <div class="form-group">
                        <label>Exact_device_id: {$juiceScore->body['Exact Device id']}</label>
                    </div>
                    <div class="form-group">
                        <label>Browser_hash: {$juiceScore->body['Browser hash']}</label>
                    </div>
                    <div class="form-group">
                        <label>User_id: {$juiceScore->user_id}</label>
                    </div>
                    <div class="form-group">
                        <label>Success: {$juiceScore->body['Success']}</label>
                    </div>
                    <div class="form-group">
                        <label>Time: {$juiceScore->body['Time']}</label>
                    </div>
                    <div class="form-group">
                        <label>Predictors_idx1_stop_markers: {$juiceScore->body['Predictors']['IDX1 Stop Markers']}</label>
                    </div>
                    <div class="form-group">
                        <label>predictors_idx2_user_behaviour_markers: {$juiceScore->body['Predictors']['IDX2 User Behaviour Markers']}</label>
                    </div>
                    <div class="form-group">
                        <label>predictors_idx3_device_markers: {$juiceScore->body['Predictors']['IDX3 Device Markers']}</label>
                    </div>
                    <div class="form-group">
                        <label>predictors_idx5_device_quality: {$juiceScore->body['Predictors']['IDX5 Device Quality']}</label>
                    </div>
                    <div class="form-group">
                        <label>predictors_idx6_internet_infrastructure_quality: {$juiceScore->body['Predictors']['IDX6 Internet Infrastructure Quality']}</label>
                    </div>
                    <div class="form-group">
                        <label>predictors_idx10_ei_estimation: {$juiceScore->body['Predictors']['IDX10 EI Estimation']}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="equifaxScoreModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Информация по Еквифакс скорингу</h4>
            </div>
            <div class="modal-body">
                <div class="form-group" style="display:flex; flex-direction: column">
                    {if !empty($equifaxScore)}
                        {foreach $equifaxScore as $key => $score}
                            <div class="form-group">
                                <label>{$key}: {$score}</label>
                            </div>
                        {/foreach}
                    {else}
                        <div class="form-group">
                            <label>Скоринг пуст</label>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>
<div id="editLoanProfitModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Скорректировать долг / Остановить начисления</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="alert" style="display:none"></div>
                <form method="POST" id="editLoanProfitForm">
                    <input type="hidden" name="action" value="editLoanProfit">
                    <input type="hidden" name="contractId" value="{$contract->id}">
                    <div class="form-group">
                        <label class="control-label">Основной долг:</label>
                        <input type="text" class="form-control" name="body" value="{$contract->loan_body_summ}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Процент:</label>
                        <input type="text" class="form-control" name="prc" value="{$contract->loan_percents_summ}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Пени:</label>
                        <input type="text" class="form-control" name="peni" value="{$contract->loan_peni_summ}">
                    </div>
                    <div class="custom-control custom-checkbox mr-sm-2 mb-3">
                        <input type="checkbox" id="stopProfit" name="stopProfit" class="custom-control-input"
                               {if $contract->stop_profit == 1}checked{/if}>
                        <label class="custom-control-label" for="stopProfit">
                            Остановить начисления
                        </label>
                    </div>
                    <input type="button" class="btn btn-danger" data-dismiss="modal" value="Отмена">
                    <input type="button" class="btn btn-success saveEditLoanProfit" value="Сохранить">
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_add_problem_loan" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md md-comment">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Добавить докуемнты</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_add_problem_loan" action="order/{$order->order_id}">

                    <input type="hidden" name="order_id" value="{$order->order_id}"/>
                    <input type="hidden" name="user_id" value="{$order->user_id}"/>
                    <input type="hidden" name="block" value=""/>
                    <input type="hidden" name="action" value="add_problem_loan"/>

                    <div class="alert" style="display:none"></div>

                    <div class="form-group">
                        <label for="name" class="control-label">Выберите докуемнт для создания</label>
                        <!--<textarea class="form-control" name="text" rows="6"></textarea>-->
                    </div>
                    <!--<div class="custom-control custom-checkbox mr-sm-2 mb-3">
                        <input type="checkbox" name="official" class="custom-control-input" id="official_check"
                               value="1">
                        <label class="custom-control-label" for="official_check">Официальный</label>
                    </div>-->
                    <select class="form-control" style="    margin-bottom: 20px;" name="problem_loan_name"
                            aria-label="Default select example">
                        <option value="PRETRIAL_CLAIM" selected>Досудебная притензия</option>
                        <option value="NOTIFICATION_OF_DELAY_TO_THE_CLIENT">Уведомление о просрочке клиенту</option>
                        <option value="CERTIFICATE_OF_ABSENCE_OF_DEBT">Справка об отсутствии задолженности</option>
                        <option value="REFUSAL_TO_TERMINATE_THE_CONTRACT">Отказ расторжения договора</option>
                        <option value="REFUSAL_TO_TERMINATE_THE_CONTRACT">Отказ обработки персональных данных</option>
                    </select>
                    <div class="form-action">
                        <button type="button" class="btn btn-danger waves-effect js-event-add-click" data-event="70"
                                data-manager="{$manager->id}" data-order="{$order->order_id}"
                                data-user="{$order->user_id}" data-dismiss="modal">Отмена
                        </button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Создать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="addPayModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Провести платеж</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="alert" style="display:none"></div>
                <form method="POST" id="addPayForm">
                    <input type="hidden" name="action" value="addPay">
                    <input type="hidden" name="contractId" value="{$contract->id}">
                    <div class="form-group">
                        <label class="control-label">Дата платежа:</label>
                        <input type="text" class="form-control daterange" name="payDate">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Сумма платежа:</label>
                        <input type="text" class="form-control" name="paySum">
                    </div>
                    <input type="button" class="btn btn-danger" data-dismiss="modal" value="Отмена">
                    <input type="button" class="btn btn-success saveEditLoanProfit" value="Сохранить">
                </form>
            </div>
        </div>
    </div>
</div>