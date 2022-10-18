;function WorkTimeApp()
{
    var app = this;
    
    app.update = function(){
        setInterval(function(){
            $.get('/ajax/worktime.php?action=update');
        }, 60000);        
    }
    
    app.init_open_point = function(){
        $('.js-open-offline-point').click(function(){
            var $this = $(this);
            
            if ($this.hasClass('loading'))
                return false;
            
            Swal.fire({
                title: 'Вы действительно хотите открыть оффлайн-отделение?',
                text: $this.data('name'),
                type: 'question',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Отменить',
                confirmButtonText: 'Да, открыть'
            }).then((result) => {
                if (result.value) {    
                    $.ajax({
                        url: 'ajax/worktime.php',
                        data: {
                            action: 'open_offline_point',
                            offline_point_id: $this.data('point')
                        },
                        beforeSend: function(){
                            $this.addClass('loading');
                        },
                        success: function(resp){
                            if (!!resp.success)
                            {
                                var _footer = '<div class="text-center">';
                                if (!!resp.penalty_ip)
                                    _footer += '<h5 class="text-danger">'+resp.penalty_ip+'</h5>';
                                if (!!resp.penalty_time)
                                    _footer += '<h5 class="text-danger">'+resp.penalty_time+'</h5>';
                                _footer += '</div>';

                                Swal.fire({
                                    title: 'Отделение открыто',
                                    text: $this.data('name'),
                                    type: 'success',
                                    footer: _footer
                                });
                            }
                            else if (!!resp.error)
                            {
                                Swal.fire({
                                    title: 'Ошибка',
                                    text: resp.error,
                                    type: 'error'
                                });
                            }
                            
                            $this.remove();
                        }
                    })
                }
            });
    
        });
        
    }
    
    app.init_close_point = function(){
        $('.js-close-offline-point').click(function(){
            var $this = $(this);
            
            if ($this.hasClass('loading'))
                return false;
        
            Swal.fire({
                title: 'Вы действительно хотите закрыть оффлайн-отделение?',
                text: $this.data('name'),
                type: 'question',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Отменить',
                confirmButtonText: 'Да, закрыть'
            }).then((result) => {
                if (result.value) {    
                    $.ajax({
                        url: 'ajax/worktime.php',
                        data: {
                            action: 'close_offline_point',
                            offline_point_id: $this.data('point')
                        },
                        beforeSend: function(){
                            $this.addClass('loading');
                        },
                        success: function(resp){
                            if (!!resp.success)
                            {
                                var _footer = '<div class="text-center">';
                                if (!!resp.penalty_ip)
                                    _footer += '<h5 class="text-danger">'+resp.penalty_ip+'</h5>';
                                _footer += '</div>';
                                
                                Swal.fire({
                                    title: 'Отделение закрыто',
                                    text: $this.data('name'),
                                    type: 'success',
                                    footer: _footer
                                });
                            }
                            else if (!!resp.error)
                            {
                                Swal.fire({
                                    title: 'Ошибка',
                                    text: resp.error,
                                    type: 'error'
                                });
                            }
                            
                            $this.remove();
                        }
                    })
                }
            });
                
        });            
    };

    ;(function(){
        
        app.update();
        app.init_open_point();
        app.init_close_point();
        
    })();
}
$(function(){
    new WorkTimeApp();
});