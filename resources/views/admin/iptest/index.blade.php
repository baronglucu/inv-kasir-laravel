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
  <!-- Content Wrapper. Contains page content -->
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
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
                        
        <div class="card">
            <h3>Test IP Address</h3>
            <form id="form-ping" class="form-inline mb-3">
                @csrf
                <i class="fa fa-laptop"></i>&nbsp;
                <input-mask alias="ip" class="form-control"name="host" id="host" required></input-mask>
                <button type="submit" class="btn btn-primary">Ping</button>
            </form>
            <div id="ping-result"></div>
        </div>        
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection  

@push('scripts')
<script>
// $(function(){
//     $('#form-ping').submit(function(e){
//         e.preventDefault();
//         $('#ping-result').html('Memproses...');
//         $.ajax({
//             url: "",
//             type: "POST",
//             data: $(this).serialize(),
//             success: function(res){
//                 let html = `<b>Host:</b> ${res.host}<br>`;
//                 html += `<b>Status:</b> ${res.reachable ? '<span class="text-success">Tersambung</span>' : '<span class="text-danger">Tidak Tersambung</span>'}<br>`;
//                 html += `<pre>${res.output}</pre>`;
//                 $('#ping-result').html(html);
//             },
//             error: function(xhr){
//                 $('#ping-result').html('<span class="text-danger">IP tidak valid atau terjadi error.</span>');
//             }
//         });
//     });
// });
</script>
@endpush