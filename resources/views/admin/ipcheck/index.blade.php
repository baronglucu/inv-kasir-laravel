@extends('admin.template.master')

@section('css')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('')}}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('')}}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('')}}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('')}}plugins/sweetalert2/sweetalert2.css">
  <link rel="stylesheet" href="{{ asset('')}}plugins/sweetalert2/sweetalert2.min.css">
  <style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #444;
      line-height: 38px;
    }
    .select2-container {
      width: 100% !important;
      z-index: 99999;
    }
      .select2-container--default .select2-selection--single {
          padding: 6px 15px;
          border: 1px solid #a4bbd3;
          height: 38px;
      }
  </style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $title }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ $title }}</a></li>
              <li class="breadcrumb-item active">{{ $subtitle }}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $subtitle }}</h3>
                <button type="button" class="btn btn-sm btn-primary float-sm-right" name="bersihkan" id="bersihkan"><i class="fa fa-eraser"></i> Clear </button>
            </div>
            <div class="card-body">
                <form action="{{ route('ipcheck.checkIp') }}" method="POST">
                    @csrf
                <div class="row">
                    <div class="col-md-6">      
                        <i class="fa fa-laptop"></i>&nbsp;                  
                        <label for="ip_address" class="form-label">Masukkan IP Address</label>
                        
                {{-- <input-mask alias="ip" class="form-control" type="text" class="form-control @error('ip_address') is-invalid @enderror" id="ip_address" name="ip_address" value="{{ old('ip_address') }}"></input-mask> --}}
                        <input type="text" class="form-control @error('ip_address') is-invalid @enderror" id="ip_address" name="ip_address" placeholder="Contoh: 192.168.1.1" value="{{ old('ip_address') }}">
                        @error('ip_address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="ping_count" class="form-label">Jumlah Ping Reply</label>
                        <input type="number" class="form-control" id="ping_count" name="ping_count" placeholder="Contoh: 4" value="{{ old('ping_count', 4) }}">
                    </div>    
                </div>
                 <div class="col-md-6 mt-3">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Periksa & Ping</button>
                    </div>
                </div>
                </form>
                <div id="ping-result">
                    @if(isset($ipAddress))
                        <div class="mt-4 p-3 bg-light border rounded">
                            <h5 class="mb-3">Hasil Pemeriksaan : </h5>
                            <p class="mb-1"><strong>IP Address : </strong> <code>{{ $ipAddress }}</code></p>
                            <p class="mb-0"><strong>Jenis : </strong> <span class="badge bg-success">{{ $ipVersion }}</span></p>

                            <h5 class="mt-4 mb-2">Hasil Ping:</h5>
                            <pre class="bg-dark text-white p-3 rounded"><code>{{ $pingResult }}</code></pre>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </section>
</div>
@endsection

@section('js')
  <script>
    $(document).on('click', '#bersihkan', function(){
        $('#ping-result').empty();
        $('#ip_address').val('');
        $('#ping_count').val(4);
    });
</script>
@endsection
