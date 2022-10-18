{$meta_title = 'Справочник оффлайн отделений' scope=parent}

{capture name='page_styles'}
<link href="theme/manager/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="theme/manager/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="theme/manager/assets/plugins/datatables.net-bs4/css/responsive.dataTables.min.css">
<style>
    .js-text-admin-name,
    .js-text-client-name {
//        max-width:300px
    }
</style>
{/capture}

{capture name='page_scripts'}

    <script src="theme/manager/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="theme/manager/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="theme/manager/assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    
    <script>
    
function OfflinePointsApp()
{
    var app = this;            
    
    var _init_events = function(){
        
        // редактирование записи
        $(document).on('click', '.js-edit-item', function(e){
            e.preventDefault();
            
            var $item = $(this).closest('.js-item');
            
            $item.find('.js-visible-view').hide();
            $item.find('.js-visible-edit').fadeIn();
        });
        
        // Удаление записи
        $(document).on('click', '.js-delete-item', function(e){
            e.preventDefault();
            
            var $item = $(this).closest('.js-item');
            
            var _id = $item.find('[name=id]').val();
            var _name = $item.find('[name=address]').val();
            
            Swal.fire({
                text: "Вы действительно хотите удалить "+_name+"?",
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
                            id: _id
                        },
                        success: function(){

                            $item.remove();

                            Swal.fire({
                              timer: 5000,
                              text: 'Отделение удалено!',
                              type: 'success',
                            });                                
                        }
                    })
                }
            });
        });
    };
    
    ;(function(){
        _init_events();
    })();
};
$(function(){
    new OfflinePointsApp();
})

    </script>
    
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
                <h3 class="text-themecolor mb-0 mt-0">Справочник оффлайн отделений</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Главная</a></li>
                    <li class="breadcrumb-item active">Справочник оффлайн отделений</li>
                </ol>
            </div>
            <div class="col-md-6 col-4 align-self-center">
                <button class="btn float-right hidden-sm-down btn-success js-open-add-modal">
                    <i class="mdi mdi-plus-circle"></i> Добавить
                </button>
                
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
            
            <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"></h4>
                        <h6 class="card-subtitle"></h6>
                        <div class="table-responsive m-t-40">
                            <div class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">    
                                <table id="config-table" class="table display table-striped dataTable">
                                    <thead>
                                        <tr>
                                            <th class="text-left">ID</th>
                                            <th class="text-left">Код</th>
                                            <th class="text-center">Организация</th>
                                            <th  class="text-center">Город</th>
                                            <th class="text-left">Адрес</th>
                                            {if in_array('point_cash', $manager->permissions)}
                                            <th class="text-right">Баланс</th>
                                            {/if}
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        
                                        {foreach $offline_points as $point}
                                        <tr class="js-item">
                                            <td class="text-left">
                                                <div class="js-text-id">
                                                    <a href="offline_point/{$point->id}">
                                                    {$point->id}
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                <div class="js-visible-view js-text-name">
                                                    {$point->code|escape}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="js-visible-view js-text-name">
                                                    {$organizations[$point->organization_id]->name|escape}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="js-visible-view js-text-name">
                                                    <a href="offline_point/{$point->id}">
                                                    {$point->city|escape}
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                <div class="js-visible-view js-text-cost">
                                                    <a href="offline_point/{$point->id}">
                                                    {$point->address|escape}
                                                    </a>
                                                </div>
                                            </td>
                                            {if in_array('point_cash', $manager->permissions)}
                                            <td class="text-right">
                                                <strong>{$point->balance}</strong>
                                            </td>
                                            {/if}
                                            <td class="text-right">
                                                <div class="js-visible-view">
                                                    <a href="offline_point/{$point->id}" class="text-info " title="Редактировать"><i class=" fas fa-edit"></i></a>
                                                    <a href="#" class="text-danger js-delete-item" title="Удалить"><i class="far fa-trash-alt"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        {/foreach}
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>

    {include file='footer.tpl'}

</div>

<div id="modal_add_item" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">Добавить отделение</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form_add_item">
                
                    <div class="alert" style="display:none"></div>
                    
                    <div class="form-group">
                        <label for="city" class="control-label">Город:</label>
                        <input type="text" class="form-control" name="city" id="city" value="" />
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Адрес:</label>
                        <input type="text" class="form-control" name="address" id="address" value="" />
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