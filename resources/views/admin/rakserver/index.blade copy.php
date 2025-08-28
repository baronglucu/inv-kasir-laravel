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
            <div class="card-header">
                <h3 class="card-title">{{ $subtitle }}</h3>
                <button type="button" class="btn btn-sm btn-primary float-sm-right" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah </button>
            </div>
            <div class="card-body">
                {{-- @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif --}}
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Rak</th>
                            <th>Nama Rak</th>
                            <th>Model Rak</th>
                            <th>Jenis Rak</th>
                            <th>Kapasitas</th>
                            <th>Keterangan</th>  
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datarak as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kodeRak }}</td>
                                <td>{{ $item->namaRak }}</td>
                                <td>{{ $item->model }}</td>
                                <td>{{ $item->namaJenis }}</td>
                                <td>{{ $item->kapasitas }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td class="text-right">
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary" tooltip="Show" id="showDetail" data-id_rak="{{ $item->id }}"><i class="fas fa-eye"></i></button>
                                    &nbsp;
                                    {{-- <a href="javascript:void(0)" id="viewMessage" data-url="{{ route('rakserver.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-update" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></a> --}}
                                    <button type="button" class="btn btn-sm btn-primary float-sm-right" data-toggle="modal" data-target="#modal-ubah"><i class="fas fa-pencil-alt"></i></button>
                                    &nbsp;
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('rakserver.destroy', $item->id) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">Hapus</button>
                                    </form>
                                  </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>        
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.modal tambah data -->
  <div class="modal fade" id="modal-tambah" tabindex="-1" data-focus="false" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-create-rak" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kodeRak">Kode Rak</label>
                                        <input type="text" class="form-control" name="kodeRak" id="kodeRak" oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="namaRak">Nama Rak</label>
                                        <input type="text" id="namaRak" name="namaRak" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="model">Model Rak</label>
                                        <input type="text" id="model" name="model" class="form-control" placeholder="Closed Rack, Open Rack, Wallmount Rack" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kdjenis">Jenis Rak</label>
                                        <select class="form-control select2" style="width: 100%;" id="kdjenis" name="kdjenis" >
                                            <option value="">-- Pilih Jenis-- --</option>
                                                @foreach ($jnsrak as $rak)
                                                <option value="{{$rak->kdjenis}}">
                                                    {{$rak->namaJenis}}
                                                </option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="kapasitas">Kapasitas</label>
                                        <input type="number" id="kapasitas" name="kapasitas" min="1" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
                                    </div>
                                </div>  
                            </div>
                              
                        </div>
                    </div>            
                <div class="mt-3" >
                    <button type="submit" class="btn btn-outline-light float-sm-right"><i class="fas fa-save"></i> Simpan</button>
                    <button type="button" id="btnClear" class="btn btn-outline-light"><i class="fa fa-eraser"></i> Kosongkan</button>
                </div>               
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal tambah data -->

<div class="modal fade" id="confirm" tabindex="-1" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content bg-warning">
      <div class="modal-header">
        <h4 class="modal-title">Modal Hapus</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin hapus?
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete">Ya</button>
        <button type="button" data-dismiss="modal" class="btn btn-primary">Tidak</button>
      </div>
    </div>
  </div>
</div>

  <!-- /.modal ubah data -->
  <div class="modal fade" id="modal-ubah" tabindex="-1" data-focus="false" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Update Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-update-rak" method="PUT">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kodeRak">Kode Rak</label>
                                        <input type="text" class="form-control" name="kodeRak" id="kodeRak" oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="namaRak">Nama Rak</label>
                                        <input type="text" id="namaRak" name="namaRak" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="model">Model Rak</label>
                                        <input type="text" id="model" name="model" class="form-control" placeholder="Closed Rack, Open Rack, Wallmount Rack" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kdjenis">Jenis Rak</label>
                                        <select class="form-control select2" style="width: 100%;" id="kdjenis" name="kdjenis" >
                                            <option value="">-- Pilih Jenis-- --</option>
                                                @foreach ($jnsrak as $rak)
                                                <option value="{{$rak->kdjenis}}">
                                                    {{$rak->namaJenis}}
                                                </option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="kapasitas">Kapasitas</label>
                                        <input type="number" id="kapasitas" name="kapasitas" min="1" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
                                    </div>
                                </div>  
                            </div>
                              
                        </div>
                    </div>            
                <div class="mt-3" >
                    <button type="submit" class="btn btn-outline-light float-sm-right"><i class="fas fa-save"></i> Simpan</button>
                    <button type="button" id="btnClear" class="btn btn-outline-light"><i class="fa fa-eraser"></i> Kosongkan</button>
                </div>               
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal tambah data -->

@endsection  

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('')}}plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('')}}plugins/select2/js/select2.full.min.js"></script>
<script src="{{ asset('')}}plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('')}}plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('')}}plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('')}}plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="{{ asset('')}}plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="{{ asset('')}}plugins/sweetalert2/sweetalert2.min.js"></script>

<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
<script>

    $('#modal-tambah .select2').each(function() {  
        var $p = $(this).parent(); 
        $(this).select2({  
            dropdownParent: $p  
        });  
    });
    
</script>
<script>
  $('button[name="remove_levels"]').on('click', function(e) {
      var $form = $(this).closest('form');
      e.preventDefault();
      $('#confirm').modal({
          backdrop: 'static',
          keyboard: false
      })
      .on('click', '#delete', function(e) {
          $form.trigger('submit');
        });
      $("#cancel").on('click',function(e){
       e.preventDefault();
       $('#confirm').modal.model('hide');
      });
    });

</script>
<script>
  function confirmDelete(id) {
    // alert(kodeRak);
      Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Data yang dihapus tidak dapat dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
      }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit(); // Lanjutkan form submission setelah OK ditekan
          }
      });
  }
</script>
<script>
  @if(session('swal'))
      Swal.fire({
          icon: '{{ session('swal')['icon'] }}',
          title: '{{ session('swal')['title'] }}',
          text: '{{ session('swal')['text'] }}',
          confirmButtonText: 'OK'
      }).then(() => {
          window.location.href = "{{ route('rakserver.index') }}"; // Redirect setelah OK ditekan
      });
  @endif
</script>
<script>
  
    $(document).on('click', '#showDetail', function(){
      let idrak = $(this).data('id_rak');
      alert(idrak);
    });

</script>
<script>
  $(document).ready(function() {
      $('#form-create-rak').submit(function(e) {
          e.preventDefault();
          dataForm = $(this).serialize() + "&_token={{ csrf_token() }}";  
          // alert(dataForm);
          $.ajax({
              type: 'POST',
              url: "{{ route('rakserver.store') }}",
              data: dataForm,
              dataType: 'json',
              success: function(response) {
                  if(response.status == 200) {
                      //alert(response.message);
                      Swal.fire({
                          icon: 'success',
                          title: 'Sukses!',
                          text: '{{ session('response.message') }}',
                          confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "{{ route('rakserver.index') }}"; // Redirect setelah OK ditekan
                        });
                  } else {
                      alert(response.message);
                      $('#kodeRak').val('');
                  }
              },
              error: function(xhr) {
                  if(xhr.status == 500) {
                      let errors = xhr.responseJSON.errors;
                      let errorMessage = '';
                      $.each(errors, function(key, value) {
                          errorMessage += value[0] + '\n';
                      });
                      alert(errorMessage);
                  } else {
                      alert('Terjadi kesalahan! Kode Rak ada yang sama, Silakan coba lagi.');
                  }
              }
          });
      });

      $('#btnClear').click(function() {
      // Reset semua input dalam form
          $('#kodeRak').val('');
          $('#namaRak').val('');
          $('#model').val('');
          $('#kdjenis').val('');
          $('#kapasitas').val('');
          $('#keterangan').val('');
      });
  });
</script>

<script type="text/javascript">
  // $(document).ready(function(){
  //   $('body').on('click', '#viewMessage', function(){
  //     var editURL = $(this).data('url');
  //       $.get(editURL, function(data){
  //           console.log(data);
  //           $('#modal-ubah').modal('show');
            // $('#form-update-rak #id').val(data.id);
            // $('#form-update-rak #kodeRak').val(data.kodeRak);
            // $('#form-update-rak #namaRak').val(data.namaRak);
            // $('#form-update-rak #model').val(data.model);
            // $('#form-update-rak #kdjenis').val(data.kdjenis);
            // $('#form-update-rak #kapasitas').val(data.kapasitas);
            // $('#form-update-rak #keterangan').val(data.keterangan);
            // $('#modal-update #dataTemp').val(JSON.stringify(data));
  //       })
  //   });
  // });

  $(document).ready(function(){
    $('body').on('click', '#viewMessage', function(){
        var editURL = $(this).data('url');
        alert(editURL);
        // $.get(editURL, function(data){
        //     // console.log(data);
            // $('#modal-ubah').modal('show');
            // alert(data.namaRak);
        // })
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#form-update-rak').on('click', '#simpanEdit', function(e){
          e.preventDefault();
          var nid = $('#form-update-rak #id').val();
          dataForm = $('#form-update-rak').serialize() + "&_token={{ csrf_token() }}";
        //   alert(dataForm);    
          $.ajax({
              type: 'PUT',
              url: "{{ route('rakserver.update', ':id') }}".replace(':id', nid),
              data: dataForm,
              dataType: 'json',
              success: function(response) {
                    if(response.status == 200) {
                        alert(response.pesan);
                        window.location.href = "{{ route('rakserver.index') }}";
                    } else {
                        // alert(response.pesan);
                        alert('berhasil, tapi tidak tersimpan');
                    }
              },
              error: function(response) {
                    if(response.status == 500) {
                        // alert(response.pesan);
                        alert('GAGAL, dan tidak tersimpan');
                    } else {
                        alert('Terjadi kesalahan! Cek Ulang Data, Silakan coba lagi.');
                    }
                }
          });
    });

    $('#btnBatal').click(function() {
      // var myObject = JSON.parse( $('#modal-update #dataTemp').val());
      // alert(myObject['serialNumber']);
        // $('#modal-update').modal('show');
        // $('#form-update-rak #kodeRak').val(myObject['kodeRak']);
        // $('#form-update-rak #namaRak').val(myObject['namaRak']);
        // $('#form-update-rak #model').val(myObject['model']);
        // $('#form-update-rak #kapasitas').val(myObject['kapasitas']);
        // $('#form-update-rak #kdjenis').val(myObject['kdjenis']);
        // $('#form-update-rak #keterangan').val(myObject['keterangan']);
      });
  });
</script>

@endsection
