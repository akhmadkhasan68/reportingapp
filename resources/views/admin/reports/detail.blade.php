@extends('admin.layouts.master')

@section('title', 'Detail Pengaduan '.ucwords($report->name))

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    @php 
        if($report->status == 0)
        {
            $note = 'Belum Diriview'; 
            $color = 'warning';
        }
        elseif($report->status == 1) {
            $note = 'Sudah Diriview'; 
            $color = 'success';
        }
        else{
            $note = 'Ditolak'; 
            $color = 'danger';
        }
    @endphp

    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-12 col-md-12 ">
            <div class="alert alert-{{ $color }}">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="font-weight-bold text-{{ $color }} text-uppercase mb-1">
                            Info</div>
                        <p class="text-default">
                            Data pelaporan ini dalam status <b>{{ $note }}</b>
                        </p>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-info-circle fa-2x text-{{ $color }}"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Voters</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $report->votes->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card mb-3">
                <div class="card-header">
                    Data Gambar
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th width="2%">No</th>
                                <th>Gambar</th>
                            </thead>
                            <tbody>
                                @php $no=1; @endphp
                                @foreach($report->images as $image)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td><a href="#">{{ $image->photo }}</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">@yield('title')</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama</th>
                                <td>{{ $report->name }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $report->description }}</td>
                            </tr>
                            <tr>
                                <th>Tempat Kejadian</th>
                                <td>
                                    {{ $report->address }}, {{ $report->village->name }}, {{ $report->district->name }}, {{ $report->regency->name }}, {{ $report->province->name }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if($report->status == 0)
        <div class="row mt-3">
            <div class="col-xl-6 col-12">
                <button class="btn btn-block btn-danger" onclick="changeStatus(2, `{{ $report->id }}`)"><i class="fa fa-times-circle"></i> Tolak</button>
            </div>
            <div class="col-xl-6 col-12">
                <button class="btn btn-block btn-success" onclick="changeStatus(1, `{{ $report->id }}`)"><i class="fa fa-check-circle"></i> Terima</button>
            </div>
        </div>
    @else
        <div class="row mt-3">
            <div class="col-xl-12 col-12">
                <a href="{{ route('reports.index') }}" class="btn btn-block btn-danger"><i class="fa fa-chevron-left"></i> Kembali</a>
            </div>
        </div>
    @endif
</div>
@endsection

@section('js')
<script>
    const changeStatus = (status, id) => {
        Swal.fire({
            title: 'Yakin?',
            text: "Ingin menghapus data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.value) {
                new Promise((resolve, reject) => {
                    let url = `{{ route('reports.update', ':id') }}`;
                    url = url.replace(':id', id);

                    $.ajaxSetup({
                        headers:
                        { 'X-CSRF-TOKEN': csrf}
                    });
        
                    $.ajax({
                        url: url,
                        method: "PATCH",
                        data: {
                            status: status
                        }
                    })
                    .then(res => {
                        if(res.success === false)
                        {
                            Object.entries(res.message)
                            .map(([, fieldErrors]) => 
                                fieldErrors.map(fieldError => toastr.error(`${fieldError}`, 'Gagal'))
                            )
                        }else
                        {
                            toastr.success(`Berhasil`, 'Sukses');
                            
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    })
                    .catch(err => {
                        alert('error');
                    })
                })
            }
        });
    }
</script>
@endsection