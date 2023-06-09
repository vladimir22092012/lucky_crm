function ClientsApp()
{
    var app = this;
    
    var _init_pagination = function(){
        $(document).on('click', '.jsgrid-pager a', function(e){
            e.preventDefault();
            
            var _url = $(this).attr('href');
            
            app.load(_url, true);
        });
    };
    
    var _init_sortable = function(){
        $(document).on('click', '.jsgrid-header-sortable a', function(e){
            e.preventDefault();
            
            var _url = $(this).attr('href');
            
            app.load(_url, true);
        });
    };
    
    var _init_filter = function(){
//        $(document).on('blur', '.jsgrid-filter-row input', app.filter);
        $(document).on('keyup', '.jsgrid-filter-row input', function(e){
            if (e.keyCode == 13){
                app.filter();
            }
        });
    };

    var _init_sms
    
    app.filter = function(){
        var $form = $('#search_form');
        var _sort = $form.find('[name=sort]').val()
        var _searches = {};
        $form.find('input[type=text], select').each(function(){
            if ($(this).val() != '')
            {
                _searches[$(this).attr('name')] = $(this).val();
            }
        });     
        $.ajax({
            data: {
                search: _searches,
                sort: _sort
            },
            beforeSend: function(){
            },
            success: function(resp){
                
                $('#basicgrid .jsgrid-grid-body').html($(resp).find('#basicgrid .jsgrid-grid-body').html());
                $('#basicgrid .jsgrid-pager-container').html($(resp).find('#basicgrid .jsgrid-pager-container').html());
                
                
            }
        })
    
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
                
                $('#basicgrid').html($(resp).find('#basicgrid').html());
                
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

    var _init_sms = function(){
            $(document).on('click', '.js-open-sms-modal', function(e){
                e.preventDefault();

                var _user_id = $(this).data('user');
                var _order_id = $(this).data('order');
                var _yuk = $(this).hasClass('is-yuk') ? 1 : 0;

                $('#modal_send_sms [name=user_id]').val(_user_id)
                $('#modal_send_sms [name=order_id]').val(_order_id)
                $('#modal_send_sms [name=yuk]').val(_yuk)
                $('#modal_send_sms').modal();
            });

            $(document).on('submit', '.js-sms-form', function(e){
                e.preventDefault();

                var $form = $(this);

                var user_id = $form.find('[name=user_id]').val();

                if ($form.hasClass('loading'))
                    return false;

                $.ajax({
                    url: 'missings/',
                    type: 'POST',
                    data: {action: 'send_sms', user_id: user_id},
                    beforeSend: function(){
                        $form.addClass('loading')
                    },
                    success: function(resp){
                        $form.removeClass('loading');
                        $('#modal_send_sms').modal('hide');

                        if (!!resp.error)
                        {
                            Swal.fire({
                                timer: 5000,
                                title: 'Ошибка!',
                                text: resp.error,
                                type: 'error',
                            });
                        }
                        else
                        {
                            Swal.fire({
                                timer: 5000,
                                title: '',
                                text: 'Сообщение отправлено',
                                type: 'success',
                            });
                        }
                    },
                })

            });
        };

    var _init_mango_call = function(){

        $(document).on('click', '.js-mango-call', function(e){
            e.preventDefault();

            var _phone = $(this).data('phone');

            Swal.fire({
                title: 'Выполнить звонок?',
                text: "Вы хотите позвонить на номер: "+_phone,
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Отменить',
                confirmButtonText: 'Да, позвонить'
            }).then((result) => {
                if (result.value) {

                    $.ajax({
                        url: 'ajax/mango_call.php',
                        data: {
                            phone: _phone,
                        },
                        beforeSend: function(){

                        },
                        success: function(resp){
                            if (!!resp.error)
                            {
                                if (resp.error == 'unknown_manager')
                                {
                                    Swal.fire(
                                        'Ошибка!',
                                        'Необходимо указать Ваш внутренний номер сотрудника Mango-office.',
                                        'error'
                                    )
                                }

                                if (resp.error == 'empty_mango')
                                {
                                    Swal.fire(
                                        'Ошибка!',
                                        'Не хватает прав на выполнение операции.',
                                        'error'
                                    )
                                }
                            }
                            else if (resp.success)
                            {
                                Swal.fire(
                                    '',
                                    'Выполняется звонок.',
                                    'success'
                                )
                            }
                            else
                            {
                                console.error(resp);
                                Swal.fire(
                                    'Ошибка!',
                                    '',
                                    'error'
                                )
                            }
                        }
                    })

                }
            })


        });

    };

    
    ;(function(){
        _init_pagination();
        _init_sortable();
        _init_filter();
        _init_sms();
        _init_mango_call();
    })();
}
new ClientsApp();