@extends('layouts.app')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-1">
            <div class="col-sm-6">
                <h4 class="m-0">Dashboard</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><span id="txtTotalCPCL">0</span></h3>

                    <p>Total CPCL</p>
                </div>
                <div class="icon">
                    <i class="ion ion-people"></i>
                </div>
                <a href="{{ route('kelompok_anggota') }}" class="small-box-footer">View Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><span id="txtTotalTPS">0</span></h3>

                    <p>Total TPS</p>
                </div>
                <div class="icon">
                    <i class="ion ion-people"></i>
                </div>
                <a href="{{ route('tps') }}" class="small-box-footer">View Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3><span id="txtTotalProposal">0</span></h3>

                    <p>Total Proposal</p>
                </div>
                <div class="icon">
                    <i class="ion ion-people"></i>
                </div>
                <a href="{{ route('proposal') }}" class="small-box-footer">View Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><span id="txtTotalNonProposal">0</span></h3>

                    <p>Total Non Proposal</p>
                </div>
                <div class="icon">
                    <i class="ion ion-people"></i>
                </div>
                <a href="{{ route('proposal') }}" class="small-box-footer">View Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Proposal vs Non Proposal</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">CPCL Per Kementrian</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>

            <!-- <div class="card">
                <div class="card-header">CPCL Per Kementrian</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th nowrap>No</th>
                                <th nowrap>Kementrian</th>
                                <th nowrap>Proposal</th>
                                <th nowrap>Non Proposal</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div> -->

        </div>
        <div class="col-lg-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">CPCL Per Kabupaten/Kota</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="barChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>

            <!-- <div class="card">
                <div class="card-header">CPCL Per Kementrian</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th nowrap>No</th>
                                <th nowrap>Kementrian</th>
                                <th nowrap>Proposal</th>
                                <th nowrap>Non Proposal</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div> -->

        </div>

        <!-- <div class="col-lg-4">
            <div class="card">
                <div class="card-header">CPCL Per Kabupaten/Kota</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th nowrap>No</th>
                                <th nowrap>Kabupaten/Kota</th>
                                <th nowrap>Proposal</th>
                                <th nowrap>Non Proposal</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Ranking Dukungan Per TPS</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-primary">
                                <th nowrap>No</th>
                                <th nowrap>TPS</th>
                                <th nowrap>Wilayah</th>
                                <th nowrap>Persentase Dukungan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div> -->
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Timeline {{ $tahun }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div id="divTimeline"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    $(function() {
        let donutData;
        totalCPCL();
        totalProposal('Y');
        totalProposal('N');
        loadChartProposalVsNonProposal();
        loadChartKementrian();
        loadChartKota();
        totalTPS();
        showTimeline();


    });

    function loadChartProposalVsNonProposal() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url;
        url = "/data_proposal";
        $.ajax({
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            // contentType: false,
            // processData: false,
            // enctype: "multipart/form-data",
            beforeSend: function() {
                // $('#pieChart').html('');
            },
            success: function(data) {
                let label_arr = [];
                let data_arr = [];
                let bg_arr = [];
                $.each(data, function(key, value) {
                    label_arr.push(value.status_proposal);
                    data_arr.push(value.total);
                    bg_arr.push(value.bg_chart);
                });
                donutData = {
                    labels: label_arr,
                    datasets: [{
                        data: data_arr,
                        backgroundColor: bg_arr,
                    }]
                }
                // setTimeout(() => {
                    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                    var pieData = donutData;
                    var pieOptions = {
                        maintainAspectRatio: false,
                        responsive: true,
                        animation: true,
                    }
                    new Chart(pieChartCanvas, {
                        type: 'pie',
                        data: pieData,
                        options: pieOptions
                    })
                // }, 5000);
            },
            error: function(response) {
                // $('#pieChart').html('');
            },
        });
    }

    function loadChartKementrian() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url;
        url = "/data_proposal_per_kementrian";
        $.ajax({
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            // contentType: false,
            // processData: false,
            // enctype: "multipart/form-data",
            beforeSend: function() {
                // $('#pieChart').html('');
            },
            success: function(data) {
                // let label_arr = [];
                // let data_arr = [];
                // let bg_arr = [];
                // $.each(data, function(key, value) {
                //     label_arr.push(value.singkatan);
                //     data_arr.push(value.total);
                //     bg_arr.push(value.bg_chart);
                // });
                // donutData = {
                //     labels: label_arr,
                //     datasets: [{
                //         data: data_arr,
                //         backgroundColor: bg_arr,
                //     }]
                // }
                // setTimeout(() => {
                    var barChartCanvas = $('#barChart').get(0).getContext('2d')
                    // var barChartData = $.extend(true, {}, areaChartData)
                    // var temp0 = areaChartData.datasets[0]
                    // var temp1 = areaChartData.datasets[1]
                    // barChartData.datasets[0] = temp1
                    // barChartData.datasets[1] = temp0

                    // var barChartOptions = {
                    //     responsive: true,
                    //     maintainAspectRatio: false,
                    //     datasetFill: false
                    // }

                    new Chart(barChartCanvas, {
                        type: 'bar',
                        data: {
                            labels: data.label,
                            datasets: [{
                                    label: 'Proposal',
                                    data: data.dataY,
                                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                                },
                                {
                                    label: 'Non Proposal)',
                                    data: data.dataN,
                                    backgroundColor: 'rgba(255, 99, 132, 0.7)'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                }
                            },
                            scales: {
                                x: {
                                    stacked: false // ubah ke true kalau mau stacked
                                },
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    })
                // }, 5000);
            },
            error: function(response) {
                // $('#pieChart').html('');
            },
        });
    }

    function loadChartKota() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url;
        url = "/data_proposal_per_kota";
        $.ajax({
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            // contentType: false,
            // processData: false,
            // enctype: "multipart/form-data",
            beforeSend: function() {
                // $('#pieChart').html('');
            },
            success: function(data) {
                // let label_arr = [];
                // let data_arr = [];
                // let bg_arr = [];
                // $.each(data, function(key, value) {
                //     label_arr.push(value.singkatan);
                //     data_arr.push(value.total);
                //     bg_arr.push(value.bg_chart);
                // });
                // donutData = {
                //     labels: label_arr,
                //     datasets: [{
                //         data: data_arr,
                //         backgroundColor: bg_arr,
                //     }]
                // }
                // setTimeout(() => {
                    var barChartCanvas = $('#barChart2').get(0).getContext('2d')
                    // var barChartData = $.extend(true, {}, areaChartData)
                    // var temp0 = areaChartData.datasets[0]
                    // var temp1 = areaChartData.datasets[1]
                    // barChartData.datasets[0] = temp1
                    // barChartData.datasets[1] = temp0

                    // var barChartOptions = {
                    //     responsive: true,
                    //     maintainAspectRatio: false,
                    //     datasetFill: false
                    // }

                    new Chart(barChartCanvas, {
                        type: 'bar',
                        data: {
                            labels: data.label,
                            datasets: [{
                                    label: 'Proposal',
                                    data: data.dataY,
                                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                                },
                                {
                                    label: 'Non Proposal)',
                                    data: data.dataN,
                                    backgroundColor: 'rgba(255, 99, 132, 0.7)'
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                }
                            },
                            scales: {
                                x: {
                                    stacked: false // ubah ke true kalau mau stacked
                                },
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    })
                // }, 5000);
            },
            error: function(response) {
                // $('#pieChart').html('');
            },
        });
    }

    function showTimeline() {
        var tahun = '<?= $tahun ?>';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url;
        url = "/kegiatan_timeline_process_view";
        $.ajax({
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            data: {
                tahun: tahun,
                type: 'view'
            },
            // contentType: false,
            // processData: false,
            // enctype: "multipart/form-data",
            beforeSend: function() {
                $('#divTimeline').html('<i class="fa fa-spinner fa-spin"></i> Processing...');
            },
            success: function(data) {
                console.log(data);
                $('#divTimeline').html(data.html['original']);
            },
            error: function(response) {
                $('#divTimeline').html('');
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    alert('Something went wrong. Please try again.');
                }
            },
        });
    }

    function totalCPCL() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url;
        url = "/total_cpcl";
        $.ajax({
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            // contentType: false,
            // processData: false,
            // enctype: "multipart/form-data",
            beforeSend: function() {
                $('#txtTotalCPCL').text('0');
            },
            success: function(data) {
                console.log(data);
                $('#txtTotalCPCL').text(data);
            },
            error: function(response) {
                $('#txtTotalCPCL').text('0');
            },
        });
    }

    function totalTPS() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url;
        url = "/total_tps";
        $.ajax({
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            // contentType: false,
            // processData: false,
            // enctype: "multipart/form-data",
            beforeSend: function() {
                $('#txtTotalTPS').text('0');
            },
            success: function(data) {
                console.log(data);
                $('#txtTotalTPS').text(data);
            },
            error: function(response) {
                $('#txtTotalTPS').text('0');
            },
        });
    }

    function totalProposal(status) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url;
        // url = "/total_proposal";
        url = "{{ route('total_proposal', ':status') }}";
        url = url.replace(':status', status);
        $.ajax({
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            // contentType: false,
            // processData: false,
            // enctype: "multipart/form-data",
            beforeSend: function() {
                if (status == 'Y') {
                    $('#txtTotalProposal').text('0');
                } else {
                    $('#txtTotalNonProposal').text('0');
                }
            },
            success: function(data) {
                if (status == 'Y') {
                    $('#txtTotalProposal').text(data);
                } else {
                    $('#txtTotalNonProposal').text(data);
                }
            },
            error: function(response) {
                if (status == 'Y') {
                    $('#txtTotalProposal').text('0');
                } else {
                    $('#txtTotalNonProposal').text('0');
                }
            },
        });
    }
</script>
@endsection