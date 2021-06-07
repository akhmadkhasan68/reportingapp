@extends('admin.layouts.master')

@section('title', 'Pengaduan')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-12 col-md-12 ">
            <div class="alert alert-info">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="font-weight-bold text-info text-uppercase mb-1">
                            Info</div>
                        <p class="text-default">
                            Halaman ini adalah data semua pengaduan yang terdata di sistem. <br>
                            Anda dapat memonitoring semua aktifitas pengaduan pengguna yang <br> terdaftar dan melakukan aksi dari setiap pengaduan yang ada.
                        </p>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-info-circle fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-12 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pengaduan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reports->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-12 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pengaduan Belum Diriview</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reports->where('status', '0')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-12 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pengaduan Diterima</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reports->where('status', '1')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-12 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Pengaduan <br> Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reports->where('status', '2')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row mb-3">
        <div class="col-xl-4 col-12">
            <label for="">Search Nama</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Search Nama">
        </div>
        <div class="col-xl-4 col-12">
            <label for="">Filter Status</label>
            <select name="status" id="status" class="form-control">
                <option value="">Filter Status</option>
                <option value="0">Belum diriview</option>
                <option value="1">Diterima</option>
                <option value="2">Ditolak</option>
            </select>
        </div>
        <div class="col-xl-4 col-12">
            <label for="">Urutkan Vote</label>
            <select name="order" id="order" class="form-control">
                <option value="">Urutkan Vote</option>
                <option value="desc">Tertinggi</option>
                <option value="asc">Terendah</option>
            </select>
        </div>
    </div>

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">Data Pengaduan</div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Total Vote</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script>
    const datatable = () => {
        new Promise((resolve, reject) => {
            let status = $("#status").val();
            let order = $("#order").val();
            let name = $("#name").val();

            $.ajaxSetup({
                headers:
                { 'X-CSRF-TOKEN': csrf}
            });

            $.ajax({
                url: `{{ route('api.report.datatable') }}`,
                method: "POST",
                data: {
                    status: status,
                    order: order,
                    name: name
                }
            })
            .then(res => {
                $("#table-body").html(res);
            })
            .catch(err => {
                alert('error');
            })
        })
    }

    datatable();

    $("#status").on('change', function(){
        datatable();
    });

    $("#order").on('change', function(){
        datatable();
    });

    $("#name").on('keyup', function(){
        datatable();
    });
</script>
@endsection