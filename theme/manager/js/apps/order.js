;function OrderApp()
{
    var app = this;    
    
    app.sms_timer;
    
    app.image_deg = 0;
    app.ordertimer;
    
    var _init_upload_file = function(){
        $(document).on('change', '#new_file', function(){
            app.upload(this);
        });

    };
    
    app.upload = function(input){
        
        var $this = $(input);
        
        var $fileblock = $this.closest('.form_file_item');
        var _type = $this.data('type');
        
        var form_data = new FormData();
                    
        form_data.append('file', input.files[0])
        form_data.append('user_id', $this.data('user'))
        form_data.append('type', 'document');        
        form_data.append('action', 'add');        
        form_data.append('notreplace', '1');        

        $.ajax({
            url: _front_url+'/ajax/upload.php',
            data: form_data,
            type: 'POST',
            dataType: 'json',
            processData : false,
            contentType : false, 
            beforeLoad: function(){
                $fileblock.addClass('loading');
            },
            success: function(resp){
                if (!!resp.error)
                {
                    var error_text = '';
                    if (resp.error == 'max_file_size')
                        error_text = 'Превышен максимально допустимый размер файла.';
                    else if (resp.error == 'error_uploading')
                        error_text = 'Файл не удалось загрузить, попробуйте еще.';
                    else
                        error_text = resp.error;
                        
                    $fileblock.append('<div class="error_text">'+error_text+'</div>');
                }
                else
                {
                    $fileblock.find('.error_text').remove();

                    app.update_page();
                }
                
            }
        });                
    };
    
    var _init_return_insure = function(){
        $(document).on('click', '.js-return-insure', function(e){
            e.preventDefault();
            
            var $btn = $(this);
            var contract_id = $(this).data('contract');
            
            if ($btn.hasClass('loading'))
                return false;
            
            Swal.fire({
                title: 'Вернуть страховку клиенту?',
                text: "",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Отменить',
                confirmButtonText: 'Да, вернуть'
            }).then((result) => {
                if (result.value) {
                    
                    $.ajax({
                        type: 'POST',
                        data: {
                            action: 'return_insure',
                            contract_id: contract_id,
                        },
                        beforeSend: function(){
                            $btn.addClass('loading')
                        },
                        success: function(resp){
                            $btn.removeClass('loading');
        
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
                                    title: 'Успешно!',
                                    text: 'Запрос на возврат страховки отправлен',
                                    type: 'success',
                                });
                                
                                app.update_page();
        
                            }
                        },
                    })        
                }
            });

        })
    }
    
    var _init_fssp_info = function(){
        $(document).on('click', '.js-get-fssp-info', function(e){
            e.preventDefault();
            
            var $this = $(this);
            
            if ($this.hasClass('loading'))
                return false;
            
            $.ajax({
                url: 'ajax/get_info.php',
                data: {
                    action: 'fssp',
                    'scoring_id': $this.data('scoring')
                },
                beforeSend: function(){
                    $this.addClass('loading');
                },
                success: function(resp){
                    $this.removeClass('loading');
                    
                    
                    if (!!resp.body.result[0].result)
                    {
                        var _html = '';
                        $.each(resp.body.result[0].result, function(k, item){
                            var _row = '<tr>';
                            _row += '<td>'+item.exe_production+'</td>';
                            _row += '<td>'+item.details+'</td>';
                            _row += '<td>'+item.subject+'</td>';
                            _row += '<td>'+item.department+'</td>';
                            _row += '<td>'+item.ip_end+'</td>';
                            _row += '</tr>';
                            
                            _html += _row;
                        })
                    }
                    else
                    {
                        var _html = '<h4>Производства не найдены</h4>';
                    }
                    
                    $('.js-fssp-info-result').html(_html);
                    
                    $('#modal_fssp_info').modal();
console.info(resp);
                }
            })
        });
    };
    
    var _init_open_image_popup = function(){

        $.fancybox.defaults.btnTpl.rotate_left = '<button tabindex="-1" class="js-fancybox-rotate-left fancybox-button " ><i class="mdi mdi-rotate-left"></i></button>';
        $.fancybox.defaults.btnTpl.rotate_right = '<button tabindex="-1" class="js-fancybox-rotate-right fancybox-button " ><i class="mdi mdi-rotate-right"></i></button>';
        
        $.fancybox.defaults.btnTpl.approve_file = '<button tabindex="-1" class="js-fancybox-approve fancybox-button btn-outline-success btn" data-status="2"><i class="fas fa-check-circle"></i></button>';
        $.fancybox.defaults.btnTpl.reject_file = '<button tabindex="-1" class="js-fancybox-reject fancybox-button btn-outline-danger btn" data-status="3"><i class="fas fa-times-circle"></i></button>';
        $.fancybox.defaults.btnTpl.label_file = '<div class="js-fancybox-label" style="width:80px;display:inline-block"></div>';
        
        var _image_items = [];
        $('.order-images-list .js-image-item').each(function(){
            var $this = $(this);
            
            var _item = {
                id: $this.data('id'),
                status: $this.data('status'),
                $label: $this.find('.label-primary').clone().removeClass('image-label')
            };
            _image_items.push(_item);
        })

        $.extend($.fancybox.defaults, {
            buttons: [
                "label_file",
                "approve_file",
                "reject_file",
                "zoom",
                "rotate_right",
                "rotate_left",
                "close",
            ],
            afterShow: function(obj){
                var current_item = _image_items[obj.currIndex]

                $('.js-fancybox-approve').data('id', current_item.id);
                $('.js-fancybox-reject').data('id', current_item.id);

                if (current_item.status == 0)
                {
                    $('.js-fancybox-approve').addClass('btn-outline-success').removeClass('btn-success');
                    $('.js-fancybox-reject').removeClass('btn-danger').addClass('btn-outline-danger');
                }
                if (current_item.status == 2)
                {
                    $('.js-fancybox-approve').removeClass('btn-outline-success').addClass('btn-success');
                    $('.js-fancybox-reject').removeClass('btn-danger').addClass('btn-outline-danger');
                }
                if (current_item.status == 3)
                {
                    $('.js-fancybox-reject').removeClass('btn-outline-danger').addClass('btn-danger')
                    $('.js-fancybox-approve').removeClass('btn-success').addClass('btn-outline-success')
                }
                
                $('.js-fancybox-label').html(current_item.$label)

            }
        });
        $('.js-open-popup-image').fancybox({
            loop: true,
            hideScrollbar: false,
            autoFocus: false,
            hash: false,
            touch: false,
              
        });
        
        $(document).on('click', '.js-fancybox-approve, .js-fancybox-reject', function(e){
            e.preventDefault();
            
            var $this = $(this);
            var $form = $('.js-check-images');
            
            var _id = $this.data('id');
            var _status = $this.data('status');
            
            $('#status_'+_id).val(_status);

            $form.submit();            
            
            if ($this.hasClass('js-fancybox-approve'))
            {
                $('.js-fancybox-reject').removeClass('btn-danger').addClass('btn-outline-danger')
                $('.js-fancybox-approve').removeClass('btn-outline-success').addClass('btn-success')                
            }
            if ($this.hasClass('js-fancybox-reject'))
            {
                $('.js-fancybox-reject').removeClass('btn-outline-danger').addClass('btn-danger')
                $('.js-fancybox-approve').removeClass('btn-success').addClass('btn-outline-success')                
            }
        });
        
        app.image_deg = 0
        $(document).on('click', '.js-fancybox-rotate-left', function(e){
            e.preventDefault();
            
            var $img = $('.fancybox-content img');
            
            new_deg = app.image_deg == 360 ? 0 : app.image_deg - 90;
            $img.css({'transform':'rotate('+new_deg+'deg)'})

            app.image_deg = new_deg
            //$img.attr('data-deg', new_deg);
        });
        $(document).on('click', '.js-fancybox-rotate-right', function(e){
            e.preventDefault();
            
            var $img = $('.fancybox-content img');

            new_deg = app.image_deg == 270 ? 0 : app.image_deg + 90;
            $img.css({'transform':'rotate('+new_deg+'deg)'})

            app.image_deg = new_deg
        });
    }
    
    var _init_confirm_contract = function(){
        
        var _set_timer = function(_seconds){
            app.sms_timer = setInterval(function(){
                _seconds--;
                if (_seconds > 0)
                {
                    $('.js-sms-timer').text(_seconds+'сек');
                    $('.js-sms-send').addClass('disable');
                }
                else
                {
                    $('.js-sms-timer').text('');                
                    $('.js-sms-send').removeClass('disable');
                    clearInterval(app.sms_timer);
                }
            }, 1000);

        };
        
        $(document).on('click', '.js-sms-send', function(e){
            e.preventDefault();
            
            if ($(this).hasClass('disable'))
                return false;
            
            var _contract_id = $(this).data('contract');
            
            $.ajax({
                url: 'ajax/sms_code.php',
                data: {
                    action: 'send_accept_code',
                    contract_id: _contract_id
                },
                success: function(resp){
                    if (!!resp.error)
                    {
                        if (resp.error == 'sms_time')
                            _set_timer(resp.time_left);
                        else
                            console.log(resp);
                    }
                    else
                    {
                        _set_timer(resp.time_left);
                        app.sms_sent = 1;                        
                        
                        
                    }
                    if (!!resp.developer_code)
                    {
                        $('.js-contract-code').val(resp.developer_code);
                    }
                }
            });


        })
        
        $(document).on('submit', '.js-confirm-contract', function(e){
            e.preventDefault();
            
            var $form = $(this);
            
            if ($form.hasClass('loading'))
                return false;
            
            var contract_id = $form.find('.js-contract-id').val();
            var phone = $form.find('.js-contract-phone').val();
            var code = $form.find('.js-contract-code').val();
            
            $.ajax({
                type: 'POST',
                data: {
                    action: 'confirm_contract',
                    contract_id: contract_id,
                    phone: phone,
                    code: code,
                },
                beforeSend: function(){
                    $form.addClass('loading');
                },
                success: function(resp){
                    $form.removeClass('loading');
                    if (!!resp.error)
                    {
                        Swal.fire({
                            title: 'Ошибка!',
                            text: resp.error,
                            type: 'error',
                        });
                    }
                    else if (!!resp.success)
                    {
                        app.update_page();
console.log(resp);
                    }
                    else
                    {
                        console.error(resp);
                    }
                    
                }
            })
        });
    };
    
    var _init_accept_order = function(){
        $(document).on('click', '.js-accept-order', function(e){
            e.preventDefault();

            var $btn = $(this);            
            if ($btn.hasClass('loading'))
                return false;
            
            var order_id = $(this).data('order');
            
            $.ajax({
                type: 'POST',
                data: {
                    action: 'accept_order',
                    order_id: order_id,
                }, 
                beforeSend: function(){
                    $btn.addClass('loading')
                },
                success: function(resp){
                    $btn.removeClass('loading');

                    if (!!resp.error)
                    {
                        Swal.fire({
                            timer: 5000,
                            title: 'Ошибка!',
                            text: resp.error,
                            type: 'error',
                        });
                        setTimeout(function(){
                            location.href = 'orders';
                        }, 5000);
                    }
                    else if (!!resp.success)
                    {
                        $('.js-order-manager').html(resp.manager);
                        $('.js-accept-order-block').remove();
                        $('.js-approve-reject-block').removeClass('hide');                        
                    
                        app.update_page();
                    }
                    else
                    {
                        console.error(resp);
                    }
                },
            })
        });        
    };
    
    var _init_approve_order = function(){
        $(document).on('click', '.js-approve-order', function(e){
            e.preventDefault();

            var $btn = $(this);            
            if ($btn.hasClass('loading'))
                return false;
            
            var order_id = $(this).data('order');
            
            
            // проверяем фото
            var files_ready = 1;
            $('.js-file-status').each(function(){
                if ($(this).val() != 2 && $(this).val() != 4)
                    files_ready = 0;
            });
            
            if (!files_ready)
            {
                
                Swal.fire({
                    timer: 5000,
                    type: 'error',
                    title: 'Ошибка!',
                    text: 'Необходимо принять файлы клиента!',
                    onClose: () => {
                        $('html, body').animate({
                            scrollTop: $("#images_form").offset().top-100  // класс объекта к которому приезжаем
                        }, 1000);
                    }
                });
                
                return false;
            }
            
            
            Swal.fire({
                title: 'Одобрить выдачу кредита?',
                text: "",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Отменить',
                confirmButtonText: 'Да, одобрить'
            }).then((result) => {
                if (result.value) {
                    
                    $.ajax({
                        type: 'POST',
                        data: {
                            action: 'approve_order',
                            order_id: order_id,
                        },
                        beforeSend: function(){
                            $btn.addClass('loading')
                        },
                        success: function(resp){
                            $btn.removeClass('loading');
        
                            if (!!resp.error)
                            {
                                Swal.fire({
                                    timer: 5000,
                                    title: 'Ошибка!',
                                    text: resp.error,
                                    type: 'error',
                                });
                                setTimeout(function(){
                                    location.href = 'orders';
                                }, 5000);
                            }
                            else
                            {
                                app.update_page();
        
                            }
                        },
                    })        
                }
            });
        });        
    };
    
    var _init_reject_order = function(){
        $(document).on('click', '.js-reject-order', function(e){
            e.preventDefault();

            $('#modal_reject_reason').modal();
        });
        
        $(document).on('submit', '.js-reject-form', function(e){
            e.preventDefault();
            
            var $form = $(this);
            
            if ($form.hasClass('loading'))
                return false;
            
            $.ajax({
                type: 'POST',
                data: $form.serialize(),
                beforeSend: function(){
                    $form.addClass('loading')
                },
                success: function(resp){
                    $form.removeClass('loading');
                    $('#modal_reject_reason').modal('hide');
                    
                    if (!!resp.error)
                    {
                        Swal.fire({
                            timer: 5000,
                            title: 'Ошибка!',
                            text: resp.error,
                            type: 'error',
                        });
                        setTimeout(function(){
                            location.href = 'orders';
                        }, 5000);
                    }
                    else
                    {
                        app.update_page();

                    }
                },
            })        
        });
    };



    var _init_change_status = function(){
        $(document).on('change', '.js-status-select', function(e){
            
            var $this = $(this);
            var $option = $this.find('option:selected');
            
            var order_id = $this.data('order');
            var status = $option.val();
            
            $.ajax({
                type: 'POST',
                data: {
                    action: 'status',
                    order_id: order_id,
                    status: status
                },
                beforeSend: function(){
                    $this.attr('disabled', true);
                }, 
                success: function(resp){
                    $this.removeAttr('disabled');
                    if (!!resp.error)
                    {
                        Swal.fire({
                            timer: 5000,
                            title: 'Ошибка!',
                            text: resp.error,
                            type: 'error',
                        });
                    }
                    
                }
            })
            
        });
    }
    
    var _init_take_order = function(){
        $(document).on('click', '.js-take-order', function(e){
            e.preventDefault();

            var $btn = $(this);            
            if ($btn.hasClass('loading'))
                return false;
            
            var order_id = $(this).data('order');
            
            $.ajax({
                type: 'POST',
                data: {
                    action: 'status',
                    order_id: order_id,
                    status: 1 
                }, 
                beforeSend: function(){
                    $btn.addClass('loading')
                },
                success: function(resp){
                    $btn.removeClass('loading');
                    
                    if (!!resp.error)
                    {
                        Swal.fire({
                            timer: 5000,
                            title: 'Ошибка!',
                            text: resp.error,
                            type: 'error',
                        });
                        setTimeout(function(){
                            location.href = 'orders';
                        }, 5000);
                    }
                    else
                    {
                        $btn.remove();
                        $('.js-status-select-wrapper').removeClass('hide');                        
                        
                        app.update_page();
                    }
                    
                    
                }
            })
        });
    };
    
    var _init_autoretry_accept = function(){
        $(document).on('click', '.js-autoretry-accept', function(e){
            e.preventDefault();

            var $btn = $(this);            
            if ($btn.hasClass('loading'))
                return false;
            
            var order_id = $(this).data('order');
            
            $.ajax({
                type: 'POST',
                data: {
                    action: 'autoretry_accept',
                    order_id: order_id,
                    status: 1 
                }, 
                beforeSend: function(){
                    $btn.addClass('loading')
                },
                success: function(resp){
                    $btn.removeClass('loading');
                    
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
                        app.update_page();
                    }
                    
                    
                }
            })
        });
    };
    


    var _init_toggle_form = function(){
        
        // редактирование формы
        $(document).on('click', '.js-edit-form', function(e){
            e.preventDefault();
            
            var $form = $(this).closest('form');
            $form.find('.view-block').addClass('hide');
            $form.find('.edit-block').removeClass('hide');
        });
        
        // отмена редактирования
        $('.js-cancel-edit').click(function(e){
            e.preventDefault();

            var $form = $(this).closest('form');
            $form.find('.edit-block').addClass('hide');
            $form.find('.view-block').removeClass('hide');
            
            $('.js-check-amount .check-amount-info').remove();
        });
    };
    
    var _init_open_order = function(){
        $(document).on('click', '.js-open-order', function(e){
            e.preventDefault();
            
            var _id = $(this).data('id');
            
            if ($(this).hasClass('open'))
            {
                $(this).removeClass('open');
                $('.order-details').fadeOut();
            }
            else
            {
                $('.js-open-order.open').removeClass('open')
                $(this).addClass('open')

                $('.order-details').hide();                
                $('#changelog_'+_id).fadeIn();
            }
        })
    };

    var _init_mango_call = function(){
        
        $(document).on('click', '.js-mango-call', function(e){
            e.preventDefault();
        
            var _phone = $(this).data('phone');
            var _yuk = $(this).hasClass('js-yuk') ? 1 : 0;
            
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
                            yuk: _yuk
                        },
                        beforeSend: function(){
                            
                        },
                        success: function(resp){
                            if (!!resp.error)
                            {
                                if (resp.error == 'empty_mango')
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


    var _init_submit_form = function(){
        $(document).on('submit', '.js-order-item-form', function(e){
            e.preventDefault();
            
            var $form = $(this);
            var _id = $form.attr('id');
            
            if ($form.hasClass('js-check-amount'))
            {
                if (!_check_amount())
                    return false;
            }
            
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                beforeSend: function(){
                    $form.addClass('loading');
                },
                success: function(resp){
                    
                    var $content = $(resp).find('#'+_id).html();
                    
                    $form.html($content);
                    
                    $form.removeClass('loading');

                    $('#ordertimer').html($(resp).find('#ordertimer').html());
                    app.run_ordertimer();
                                       
                    _init_toggle_form();
 
                }
            })
        });
    }
    
    var _check_amount = function(){
        var amount = parseInt($('[name=amount]').val())
        
        /*if (amount > 15000)
        {
            $('.js-check-amount').append('<div class="check-amount-info"><small class="text-danger">Максимальная сумма 15000 руб!</small></div>')
            return false;
        }*/
        
        $('.js-check-amount .check-amount-info').remove();
        return true;
    };
    
    var _init_change_image_status = function(){
        
        $(document).on('click', '.js-image-reject, .js-image-accept', function(e){
            var _id = $(this).data('id');
            if ($(this).hasClass('js-image-reject'))
                var _status = 3;
            else if ($(this).hasClass('js-image-accept'))
                var _status = 2;
            
            $('#status_'+_id).val(_status);

            $(this).closest('form').submit();
        });
        
        $(document).on('click', '.js-image-remove', function(e){
            var _id = $(this).data('id');            
            var _user_id = $(this).data('user');            
            $.ajax({
                url: _front_url+'/ajax/upload.php',
                data: {
                    action: 'remove',
                    id: _id,
                    user_id: _user_id
                },
                type: 'POST',
                beforeSend: function(){
                    
                },
                success: function(resp){
                    app.update_page();
                }
            });
//            $(this).closest('form').submit();
        });
        
    };
    
    var _init_change_manager = function(){
        $(document).on('change', '.js-order-manager', function(){
            var manager_id = $(this).val();
            var order_id = $(this).data('order');
            
            $.ajax({
                type: 'POST',
                data: {
                    action: 'change_manager',
                    manager_id: manager_id,
                    order_id: order_id
                },
                success: function(resp){
                    if (!!resp.error)
                    {
                        Swal.fire({
                            text: resp.error,
                            type: 'error',
                        });
                    }
                }
            })
        });
    }
    
    var _init_comment_form = function(){
        
        $(document).on('click', '.js-open-comment-form', function(e){
            e.preventDefault();
            
            $('#modal_add_comment [name=text]').text('')
            $('#modal_add_comment').modal();
        });

        $(document).on('submit', '#form_add_comment', function(e){
            e.preventDefault();
            
            var $form = $(this);
            
            $.ajax({
                url: $form.attr('action'),
                data: $form.serialize(),
                type: 'POST',
                success: function(resp){
                    if (resp.success)
                    {
                        $('#modal_add_comment').modal('hide');
                        $form.find('[name=text]').val('')
            
                        app.update_page('comments');
                        
                        Swal.fire({
                            timer: 5000,
                            title: 'Комментарий добавлен.',
                            type: 'success',
                        });
                    }
                    else
                    {
                        Swal.fire({
                            text: resp.error,
                            type: 'error',
                        });
                        
                    }
                }
            })
        })
    }
    
    app.update_page = function(active_tab){
        $.ajax({
            success: function(resp){

                $('#order_wrapper').html($(resp).find('#order_wrapper').html());
                if (!!active_tab)
                {
                    $('#order_tabs .active').removeClass('active');
                    $('#order_tabs [href="#'+active_tab+'"]').addClass('active');
                
                    $('#order_tabs_content .tab-pane').removeClass('active');
                    $('#order_tabs_content').find('#'+active_tab).addClass('active');
                    
                }           
                     
                if ($('.js-dadata-address').length > 0)
                {

                    $('.js-dadata-address').each(function(){
                        new DadataAddressApp($(this));
                    });
                }
                if ($('.js-dadata-work').length > 0)
                {
                    $('.js-dadata-work').each(function(){
                        new DadataWorkApp($(this));
                    });
                }
                
                $('#ordertimer').html($(resp).find('#ordertimer').html());
                app.run_ordertimer();

            }

        })
    }
    
    app.run_ordertimer = function(){
        
        if ($('.js-ordertimer').length == 0)
            return false;
        
        var _start_time = $('.js-ordertimer').data('time');

        if (!!app.ordertimer)
            clearInterval(app.ordertimer);
        
        if (_start_time > 0)
        {
            app.ordertimer = setInterval(function(){
                if (_start_time > 0)
                {
                    var result = getTimeRemaining(_start_time);
                    $('.js-ordertimer').html(result);
                    _start_time--;
                }
                else
                {
                    location.reload();
                }
            }, 1000);
        }
    }
    
    function getTimeRemaining(t) {
        var seconds = Math.floor((t) % 60);
        var minutes = Math.floor((t/ 60) % 60);

        str_minutes = minutes > 9 ? minutes : '0' + minutes;
        str_seconds = seconds > 9 ? seconds : '0' + seconds;
        
        return str_minutes + ':' + str_seconds;
    }

    var _init_add_problem_loan = function(){

        $(document).on('click', '.js-open-problem_loan-form', function(e){
            e.preventDefault();
            $('#modal_add_problem_loan [name=text]').text('')
            $('#modal_add_problem_loan').modal();
        });

        $(document).on('submit', '#form_add_problem_loan', function(e){
            e.preventDefault();

            var $form = $(this);

            $.ajax({
                url: $form.attr('action'),
                data: $form.serialize(),
                type: 'POST',
                success: function(resp){
                    if (resp.success)
                    {
                        $('#modal_add_problem_loan').modal('hide');
                        $form.find('[name=text]').val('')

                        app.update_page();

                        Swal.fire({
                            timer: 5000,
                            title: 'Документ добавлен.',
                            type: 'success',
                        });
                    }
                    else
                    {
                        Swal.fire({
                            text: resp.error,
                            type: 'error',
                        });

                    }
                }
            })
        })
    }

    var _init_close_contract = function(){
        $(document).on('click', '.js-open-close-form', function(e){
            e.preventDefault();
            
            $('#modal_add_comment [name=comment]').text('')
            $('#modal_close_contract').modal();
        });

        $(document).on('submit', '#form_close_contract', function(e){
            e.preventDefault();
            
            var $form = $(this);
            
            $.ajax({
                url: $form.attr('action'),
                data: $form.serialize(),
                type: 'POST',
                success: function(resp){
                    if (resp.success)
                    {
                        $('#modal_close_contract').modal('hide');
                        $form.find('[name=comment]').val('')
            
                        app.update_page();
                        
                        Swal.fire({
                            timer: 5000,
                            title: 'Договор успешно закрыт.',
                            type: 'success',
                        });
                    }
                    else
                    {
                        Swal.fire({
                            text: resp.error,
                            type: 'error',
                        });
                        
                    }
                }
            })
        })

    };
    
    var _init_correct_contract = function(){
        $(document).on('click', '.js-open-correct-form', function(e){
            e.preventDefault();
            
            $('#modal_correct [name=comment]').text('')
            $('#modal_correct').modal();
        });

        $(document).on('submit', '#form_correct', function(e){
            e.preventDefault();
            
            var $form = $(this);
            
            $.ajax({
                url: $form.attr('action'),
                data: $form.serialize(),
                type: 'POST',
                success: function(resp){
                    if (resp.success)
                    {
                        $('#modal_correct').modal('hide');
                        $form.find('[name=comment]').val('')
            
                        app.update_page();
                        
                        Swal.fire({
                            timer: 5000,
                            title: 'Договор скорректирован.',
                            type: 'success',
                        });
                    }
                    else
                    {
                        Swal.fire({
                            text: resp.error,
                            type: 'error',
                        });
                        
                    }
                }
            })
        })

    };
    
    var _init_repay_contract = function(){
        $(document).on('click', '.js-repay-contract', function(e){
            e.preventDefault();
            var $button = $(this);
            
            var _contract = $(this).data('contract');
            
            if ($(this).hasClass('loading'))
                return false;
            
            Swal.fire({
                title: 'Повторить выдачу?',
                text: "Вы хотите повторить выдачу по договору",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Отменить',
                confirmButtonText: 'Да, повторить'
            }).then((result) => {
                if (result.value) {
                    
                    $.ajax({
                        type: 'POST',
                        data: {
                            action: 'repay',
                            contract_id: _contract
                        },
                        beforeSend: function(){
                            $button.addClass('loading');
                        },
                        success: function(resp){
                            if (!!resp.error)
                            {
                                Swal.fire(
                                    'Ошибка!',
                                    resp.error,
                                    'error'
                                )
                            }
                            else if (resp.success)
                            {
                                Swal.fire(
                                    'Успешно',
                                    'Договор поставлен в очередь на выдачу.',
                                    'success'
                                )
                                app.update_page();
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


        })
    }
    
    // перевод заявки в не удалось выдать
    var _init_cancel_contract = function(){
        $(document).on('click', '.js-cancel-contract', function(e){
            e.preventDefault();
            var $button = $(this);
            
            var _contract = $(this).data('contract');
            
            if ($(this).hasClass('loading'))
                return false;
            
            Swal.fire({
                title: 'Отменить заявку?',
                text: "При выдаче займа произошла ошибка!\nПроверьте в кабинете B2P операции по выдаче",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Закрыть',
                confirmButtonText: 'Да, отменить'
            }).then((result) => {
                if (result.value) {
                    
                    $.ajax({
                        type: 'POST',
                        data: {
                            action: 'cancel_contract',
                            contract_id: _contract
                        },
                        beforeSend: function(){
                            $button.addClass('loading');
                        },
                        success: function(resp){
                            if (!!resp.error)
                            {
                                Swal.fire(
                                    'Ошибка!',
                                    resp.error,
                                    'error'
                                )
                            }
                            else if (resp.success)
                            {
                                Swal.fire(
                                    'Успешно',
                                    'Заявка отменена.',
                                    'success'
                                )
                                app.update_page();
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


        })
    }
    
    var _init_penalty = function(){
        $(document).on('click', '.js-add-penalty', function(){
            var _block = $(this).data('block');
            
            $('#modal_add_penalty [name=block]').val(_block);
            
            $('#modal_add_penalty').modal();
        });
        
        $(document).on('submit', '#form_add_penalty', function(e){
            e.preventDefault();
            
            var $form = $(this);
            
            if ($form.hasClass('loading'))
                return false;
            
            $.ajax({
                url: '/penalties',
                data: $form.serialize(),
                type: 'POST',
                beforeSend: function(){
                    $form.addClass('loading');
                },
                success: function(resp){
                    if (resp.success)
                    {
                        $('#modal_add_penalty').modal('hide');
                        $form.find('[name=text]').val('')
            
                        app.update_page();
                        
                        Swal.fire({
                            timer: 5000,
                            title: 'Штраф добавлен.',
                            type: 'success',
                        });
                    }
                    else
                    {
                        Swal.fire({
                            text: resp.error,
                            type: 'error',
                        });
                        
                    }
                    $form.removeClass('loading');
                }
            })

        });

        $(document).on('click', '.js-strike-penalty', function(e){
            e.preventDefault();
            
            var _id = $(this).data('penalty');
            
            $.ajax({
                url : '/penalties',
                data: {
                    id: _id,
                    action: 'strike_penalty'
                },
                type: 'POST',
                success: function(resp){
                    if (resp.success)
                    {
                        app.update_page();
                        
                        Swal.fire({
                            timer: 5000,
                            title: 'Страйк добавлен.',
                            type: 'success',
                        });
                    }
                    else
                    {
                        Swal.fire({
                            text: resp.error,
                            type: 'error',
                        });
                        
                    }
                }
            })
        });

        $(document).on('click', '.js-reject-penalty', function(e){
            e.preventDefault();
            
            var _id = $(this).data('penalty');
            
            $.ajax({
                url : '/penalties',
                data: {
                    id: _id,
                    action: 'reject_penalty'
                },
                type: 'POST',
                success: function(resp){
                    if (resp.success)
                    {
                        app.update_page();
                        
                        Swal.fire({
                            timer: 5000,
                            title: 'Штраф отменен.',
                            type: 'success',
                        });
                    }
                    else
                    {
                        Swal.fire({
                            text: resp.error,
                            type: 'error',
                        });
                        
                    }
                }
            })
        });

        $(document).on('click', '.js-correct-penalty', function(e){
            e.preventDefault();
            
            var _id = $(this).data('penalty');
            
            $.ajax({
                url : '/penalties',
                data: {
                    id: _id,
                    action: 'correct_penalty'
                },
                type: 'POST',
                success: function(resp){
                    if (resp.success)
                    {
                        app.update_page();
                        
                        Swal.fire({
                            timer: 5000,
                            title: 'Изменения отправлены.',
                            type: 'success',
                        });
                    }
                    else
                    {
                        Swal.fire({
                            text: resp.error,
                            type: 'error',
                        });
                    }
                }
            })
        });

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
            
            var _user_id = $form.find('[name=user_id]').val();
            var _order_id = $form.find('[name=order_id]').val();
            
            if ($form.hasClass('loading'))
                return false;
            
            $.ajax({
                url: 'order/'+_order_id,
                type: 'POST',
                data: $form.serialize(),
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

        
    }
    
    var _init_copy_address = function(){
        app.$input = {}
        app.$input.equal_address = $('.js-equal-address');
        
        app.$input.regregion = $('[name=Regregion]');
        app.$input.regregion_type = $('[name=Regregion_shorttype]');
        app.$input.regdistrict = $('[name=Regdistrict]');
        app.$input.regdistrict_type = $('[name=Regdistrict_shorttype]');
        app.$input.regcity = $('[name=Regcity]');
        app.$input.regcity_type = $('[name=Regcity_shorttype]');
        app.$input.reglocality = $('[name=Reglocality]');
        app.$input.reglocality_type = $('[name=Reglocality_shorttype]');
        app.$input.regstreet = $('[name=Regstreet]');
        app.$input.regstreet_type = $('[name=Regstreet_shorttype]');
        app.$input.regindex = $('[name=Regindex]');
        app.$input.reghousing = $('[name=Reghousing]');
        app.$input.regbuilding = $('[name=Regbuiding]');
        app.$input.regroom = $('[name=Regroom]');

        app.$input.faktregion = $('[name=Faktregion]');
        app.$input.faktregion_type = $('[name=Faktregion_shorttype]');
        app.$input.faktdistrict = $('[name=Faktdistrict]');
        app.$input.faktdistrict_type = $('[name=Faktdistrict_shorttype]');
        app.$input.faktcity = $('[name=Faktcity]');
        app.$input.faktcity_type = $('[name=Faktcity_shorttype]');
        app.$input.faktlocality = $('[name=Faktlocality]');
        app.$input.faktlocality_type = $('[name=Faktlocality_shorttype]');
        app.$input.faktstreet = $('[name=Faktstreet]');
        app.$input.faktstreet_type = $('[name=Faktstreet_shorttype]');
        app.$input.faktindex = $('[name=Faktindex]');
        app.$input.fakthousing = $('[name=Fakthousing]');
        app.$input.faktbuilding = $('[name=Faktbuilding]');
        app.$input.faktroom = $('[name=Faktroom]');
        
        app.$input.equal_address.change(function(){
            if ($(this).is(':checked'))
            {
                copy_address();
            }
            else
            {
                rid_address();
            }
        })
    
        var rid_address = function(){
            app.$input.faktregion.removeAttr('readonly');
            app.$input.faktregion_type.removeAttr('readonly');
            app.$input.faktdistrict.removeAttr('readonly');
            app.$input.faktdistrict_type.removeAttr('readonly');
            app.$input.faktcity.removeAttr('readonly');
            app.$input.faktcity_type.removeAttr('readonly');
            app.$input.faktlocality.removeAttr('readonly');
            app.$input.faktlocality_type.removeAttr('readonly');
            app.$input.faktstreet.removeAttr('readonly');
            app.$input.faktstreet_type.removeAttr('readonly');
            app.$input.faktindex.removeAttr('readonly');
            app.$input.fakthousing.removeAttr('readonly');
            app.$input.faktbuilding.removeAttr('readonly');
            app.$input.faktroom.removeAttr('readonly');       
        };
        
        var copy_address = function(){
            app.$input.faktregion.val(app.$input.regregion.val()).attr('readonly', true);
            app.$input.faktregion_type.val(app.$input.regregion_type.val()).attr('readonly', true);
            app.$input.faktdistrict.val(app.$input.regdistrict.val()).attr('readonly', true);
            app.$input.faktdistrict_type.val(app.$input.regdistrict_type.val()).attr('readonly', true);
            app.$input.faktcity.val(app.$input.regcity.val()).attr('readonly', true);
            app.$input.faktcity_type.val(app.$input.regcity_type.val()).attr('readonly', true);
            app.$input.faktlocality.val(app.$input.reglocality.val()).attr('readonly', true);
            app.$input.faktlocality_type.val(app.$input.reglocality_type.val()).attr('readonly', true);
            app.$input.faktstreet.val(app.$input.regstreet.val()).attr('readonly', true);
            app.$input.faktstreet_type.val(app.$input.regstreet_type.val()).attr('readonly', true);
            app.$input.faktindex.val(app.$input.regindex.val()).attr('readonly', true);
            app.$input.fakthousing.val(app.$input.reghousing.val()).attr('readonly', true);
            app.$input.faktbuilding.val(app.$input.regbuilding.val()).attr('readonly', true);
            app.$input.faktroom.val(app.$input.regroom.val()).attr('readonly', true);
        }

    }
    
    ;(function(){
        
        _init_toggle_form();
        _init_submit_form();
        _init_open_image_popup();
        _init_mango_call();
        _init_open_order();
//        _init_take_order();
//        _init_change_status();
        _init_change_image_status();

        _init_accept_order();
        _init_approve_order();
        _init_reject_order();
        
        _init_confirm_contract();
        
        _init_comment_form();

        _init_add_problem_loan();

        _init_fssp_info();
        
        _init_upload_file();
        
        _init_autoretry_accept();
        
        _init_change_manager();
        
        _init_close_contract();
        _init_correct_contract();
        
        _init_repay_contract();
        _init_cancel_contract();
        
        _init_penalty();
        _init_sms();
        
        _init_return_insure();

        app.run_ordertimer();
        
        _init_copy_address()
    })();
};
new OrderApp();