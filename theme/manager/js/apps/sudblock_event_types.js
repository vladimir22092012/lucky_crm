$(function () {

    $(document).on('click', '.js-edit-item', function (e) {
        e.preventDefault();

        var $item = $(this).closest('.js-item');

        $item.find('.js-visible-view').hide();
        $item.find('.js-visible-edit').fadeIn();
    });

    $(document).on('click', '.js-open-add-modal', function (e) {
        e.preventDefault();

        $('#modal_add_item').find('.alert').hide();
        $('#modal_add_item').find('[name=name]').val('');

        $('#modal_add_item').modal();

        $('#modal_add_item').find('[name=name]').focus();
    });

    $(document).on('click', '.js-cancel-edit-item', function(e){
        e.preventDefault();

        var $item = $(this).closest('.js-item');

        $item.find('.js-visible-edit').hide();
        $item.find('.js-visible-view').fadeIn();
    });

    $(document).on('submit', '#form_add_item', function (e) {
        e.preventDefault();

        $.ajax({
           method: 'POST',
           data: $(this).serialize(),
           success: function (resp) {
               if (!!resp.error)
               {
                   $form.find('.alert').removeClass('alert-success').addClass('alert-danger').html(resp.error).fadeIn();
               }
               else
               {

                   let new_row = '<tr class="js-item" id="'+resp.id+'">';
                   new_row += '<td>'+resp.id+'</td>';
                   new_row += '<td><div class="js-visible-view js-text-name">'+resp.name+'</div>';
                   new_row += '<div><div class="js-visible-edit" style="display: none">';
                   new_row += '<input type="hidden" name="id" value="'+resp.id+'"/>';
                   new_row += '<input type="text" class="form-control" name="name" value="'+resp.name+'"/> </div></div></td>';
                   new_row += '<td><div class="js-visible-view js-text-count_days">'+resp.count_days+'</div>';
                   new_row += '<div class="js-visible-edit" style="display:none">';
                   new_row += '<input type="text" class="form-control" name="count_days" value="'+resp.count_days+'"/></div></td>';
                   new_row += '<td class="text-right"><div class="js-visible-view">';
                   new_row += '<a href="#" class="text-info js-edit-item" title="Редактировать"><i class=" fas fa-edit"></i></a>';
                   new_row += '<a href="#" data-id="'+resp.id+'" class="text-danger js-delete-item" title="Удалить"><i class="far fa-trash-alt"></i></a></div>';
                   new_row += '<div class="js-visible-edit" style="display:none"><a href="#" class="text-success js-confirm-edit-item" title="Сохранить"><i class="fas fa-check-circle"></i></a>';
                   new_row += '<a href="#" class="text-danger js-cancel-edit-item" title="Отменить"><i class="fas fa-times-circle"></i></a></div></td></tr>';

                   $('#table-body').append(new_row);
                   $('#modal_add_item').modal('hide');
                   Swal.fire({
                       timer: 5000,
                       text: 'Событие успешно добавлено!',
                       type: 'success',
                   });
               }
           }
        });
    });

    $(document).on('click', '.js-delete-item', function(e){
        e.preventDefault();

        let id = $(this).attr('data-id');

        Swal.fire({
            text: "Вы действительно хотите удалить событие ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Да, удалить!",
            cancelButtonText: "Отмена",
            showLoaderOnConfirm: true,
            preConfirm: () => {
            },
            allowOutsideClick: () => !Swal.isLoading()

        }).then((result) => {

            if (result.value)
            {
                $.ajax({
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    success: function(){

                        $('tr[id="'+id+'"]').remove();

                        Swal.fire({
                            timer: 5000,
                            text: 'Событие удалено!',
                            type: 'success',
                        });
                    }
                })
            }
        });
    });

    // Сохранение редактируемой записи
    $(document).on('click', '.js-confirm-edit-item', function(e){
        e.preventDefault();

        let $item = $(this).closest('.js-item');

        let id = $item.find('[name=id]').val();
        let name = $item.find('[name=name]').val();
        let count_days = $item.find('[name=count_days]').val();

        $.ajax({
            type: 'POST',
            data: {
                action: 'update',
                id: id,
                name: name,
                count_days: count_days
            },
            success: function(resp){
                if (!!resp.error)
                {
                    Swal.fire({
                        text: resp.error,
                        type: 'error',
                    });

                }
                else
                {
                    $item.find('[name=name]').val(resp.name);
                    $item.find('.js-text-name').html(resp.name);
                    $item.find('[name=count_days]').val(resp.count_days);
                    $item.find('.js-text-count_days').html(resp.count_days);

                    $item.find('.js-visible-edit').hide();
                    $item.find('.js-visible-view').fadeIn();

                }
            }
        });

    });
});