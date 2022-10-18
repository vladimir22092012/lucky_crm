{$meta_title="Календарь" scope=parent}

{capture name='page_scripts'}
    <script src="theme/{$settings->theme|escape}/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="theme/{$settings->theme|escape}/assets/plugins/fancybox3/dist/jquery.fancybox.js"></script>
    <script src="theme/manager/assets/plugins/moment/moment.js"></script>
    <script src="theme/manager/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="theme/manager/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="theme/manager/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
        $(function () {
            $('.singledate').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD.MM.YYYY'
                },
            });
        })
    </script>
    <script type="text/javascript" src="theme/{$settings->theme|escape}/js/apps/sudblock_contract.app.js"></script>
    <script src="https://cdn.jsdelivr.net/combine/npm/fullcalendar@5.10.2,npm/fullcalendar@5.10.2/locales-all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridWeek',
                events: {json_encode($eventlist)},
                eventDidMount: function (info) {

                    let tooltip = 'н/д: '+info.event.extendedProps.contracts_number + '<br>';
                    tooltip += info.event.extendedProps.event_name + '<br>';
                    tooltip += info.event.extendedProps.date + '<br>';
                    tooltip += info.event.extendedProps.comment + '<br>';
                    tooltip += '<a href="/sudblock_contract/'+info.event.extendedProps.contract_id+'">Перейти к договору</a>';

                    $(info.el).popover({
                        html: true,
                        content: tooltip
                    });

                    if (info.event.extendedProps.status === 'undone') {

                        // Change background color of row
                        info.el.style.backgroundColor = 'red';
                    }

                    if (info.event.extendedProps.status === 'to-do') {

                        // Change background color of row
                        info.el.style.backgroundColor = '#5776FF';
                        info.el.style.border = '1px';
                        info.el.style.borderRadius = '5px';
                    }

                    if (info.event.extendedProps.status === 'done') {

                        // Change background color of row
                        info.el.style.backgroundColor = 'green';
                    }
                }
            });

            calendar.setOption('locale', 'ru');
            calendar.render();
        });
    </script>
{/capture}

{capture name='page_styles'}
    <link href="theme/manager/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Daterange picker plugins css -->
    <link href="theme/manager/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="theme/manager/assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="theme/{$settings->theme|escape}/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css"
          rel="stylesheet"/>
    <link href="theme/{$settings->theme|escape}/assets/plugins/fancybox3/dist/jquery.fancybox.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css">
    <style>
        .fc-daygrid-event {
            display: block !important;
            padding-left: 15px !important;
        }

        .fc-daygrid-event {
            white-space: normal !important;
            align-items: normal !important;
        }

        .fc-daygrid-event-dot {
            display: none;
        }

        .fc-event-time, .fc-event-title {
            display: inline;
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
                    <i class="mdi mdi-file-chart"></i>
                    <span>Календарь напоминаний</span>
                </h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Судблок</li>
                    <li class="breadcrumb-item active">Календарь напоминаний</li>
                </ol>
            </div>
        </div>

        <div class="row" id="order_wrapper">
            <div class="col-lg-12">
                <div class="card card-outline-info">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    {include file='footer.tpl'}
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>