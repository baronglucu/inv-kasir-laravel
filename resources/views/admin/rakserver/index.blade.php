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
    td.details-control {
      background: url('{{ asset('images/details_open.png') }}') no-repeat center center;
      cursor: pointer;
    }
    tr.shown td.details-control {
      background: url('{{ asset('images/details_close.png') }}') no-repeat center center;
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
                            <th>HW</th>
                            <th>Kode Rak</th>
                            <th>Nama Rak</th>
                            <th>Jenis Rak</th>
                            <th>Model Rak</th>
                            <th>Kapasitas</th>
                            <th>Jml Perangkat</th>
                            <th>Keterangan</th>  
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datarak as $item)
                            <tr data-koderak="{{ $item->kodeRak }}">
                                <td>{{ $loop->iteration }}</td>
                                <td class="details-control"><i class="fa fa-plus"></i></td>
                                <td>{{ $item->kodeRak }}</td>
                                <td>{{ $item->namaRak }}</td>                                
                                <td>{{ $item->namaJenis }}</td>
                                <td>{{ $item->namaModel }}</td>
                                <td>{{ $item->kapasitas }}</td>
                                <td>{{ $item->jml }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td class="text-right">
                                  <div class="btn-group">
                                    <a href="javascript:void(0)" id="showDetail" data-url="{{ route('rakserver.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-detail" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                    &nbsp;
                                    <a href="javascript:void(0)" id="viewMessage" data-url="{{ route('rakserver.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-update" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></a>
                                    &nbsp;
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('rakserver.destroy', $item->id) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})"><i class="fas fa-trash" value="Hapus Item"></i></button>
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
                    <div class="col-md-6">
                        <div class="form-group"> 
                            <label for="kodeRak">Kode Rak</label>
                            <input type="text" class="form-control" name="kodeRak" id="kodeRak" oninput="this.value = this.value.toUpperCase()" required>
                            <label for="namaRak">Nama Rak</label>
                            <input type="text" id="namaRak" name="namaRak" class="form-control" required>
                            <div class="form-group">
                              <div class="row">
                                  <div class="col-md-6">
                                    <label for="kdjenis">Jenis Rak</label>
                                    <select class="form-control select2" style="width: 100%;" id="kdjenis" name="kdjenis" >
                                        <option value="">-- Pilih Jenis --</option>
                                        @foreach ($jnsrak as $jenis)
                                        <option value="{{$jenis->kdjenis}}">
                                          {{$jenis->namaJenis}}
                                        </option>
                                        @endforeach
                                    </select>
                                  </div>
                                  <div class="col-md-6">
                                    <label for="kapasitas">Kapasitas</label>
                                    <input type="number" id="kapasitas" name="kapasitas" min="1" class="form-control" required>
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"> 
                          <label for="kdmodel">Model Rak</label>
                          <select class="form-control select2" style="width: 100%;" id="kdmodel" name="kdmodel" >
                              <option value="">-- Pilih Model --</option>
                                @foreach ($modrak as $mrak)
                              <option value="{{$mrak->kdmodel}}">
                                {{$mrak->namaModel}}
                              </option>
                                 @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
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

  <!-- /.modal-detail -->
  <div class="modal fade" id="modal-detail" tabindex="-1" data-focus="false" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-detail-rak" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"> 
                            <label for="kodeRak">Kode Rak</label>
                            <input type="text" class="form-control" name="kodeRak" id="kodeRak" oninput="this.value = this.value.toUpperCase()" disabled>
                            <label for="namaRak">Nama Rak</label>
                            <input type="text" id="namaRak" name="namaRak" class="form-control" disabled>
                            <div class="form-group">
                              <div class="row">
                                  <div class="col-md-6">
                                    <label for="kdjenis">Jenis Rak</label>
                                    <input type="text" id="kdjenis" name="kdjenis" class="form-control" disabled>
                                  </div>
                                  <div class="col-md-6">
                                    <label for="kapasitas">Kapasitas</label>
                                    <input type="number" id="kapasitas" name="kapasitas" min="1" class="form-control" disabled>
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"> 
                          
                                <label for="kdmodel">Model Rak</label>
                                <input type="text" id="kdmodel" name="kdmodel" class="form-control" disabled>
                        </div>
                              
                        
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" disabled></textarea>
                        </div>
                    </div>
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

  <!-- /.modal update data -->
  <div class="modal fade" id="modal-update" tabindex="-1" data-focus="false"  role="dialog" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-info">
        <div class="modal-header">
          <h4 class="modal-title">Update Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <span id="coba"></span>
        <div class="modal-body">
          <form id="form-update-rak" method="PUT">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"> 
                          <input type="hidden" value="" name="id" id="id" />
                            <label for="kodeRak">Kode Rak</label>
                            <input type="text" class="form-control" name="kodeRak" id="kodeRak" readonly>
                            <label for="namaRak">Nama Rak</label>
                            <input type="text" id="namaRak" name="namaRak" class="form-control" required>
                            <div class="form-group">
                              <div class="row">
                                  <div class="col-md-6">
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
                                  <div class="col-md-6">
                                    <label for="kapasitas">Kapasitas</label>
                                    <input type="number" id="kapasitas" name="kapasitas" min="1" class="form-control" required>
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"> 
                          <label for="model">Model Rak</label>
                          <select class="form-control select2" style="width: 100%;" id="kdmodel" name="kdmodel" >
                            <option value="">-- Pilih Model-- --</option>
                                @foreach ($modrak as $mod)
                            <option value="{{$mod->kdmodel}}">
                                {{$mod->namaModel}}
                            </option>
                                @endforeach
                          </select>                          
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-3" >
                  <button type="submit" class="btn btn-outline-light float-sm-right" id="simpanEdit"><i class="fas fa-save"></i> Simpan</button>
                    <button type="button" id="btnBatal" class="btn btn-outline-light"><i class="fa fa-eraser"></i> Batal</button>
                </div>               
            </div>
          </form>
          <input type="hidden" name="dataTemp" id="dataTemp" value="">
        </div>          
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


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
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": false,
        "dom": 'Bfrtip',
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
function formatChild(kodeRak) {
    // Data perangkat dari PHP (Blade ke JS)
    var perangkat = @json($perangkat);

    var rows = '';
    if (perangkat[kodeRak]) {
        perangkat[kodeRak].forEach(function(item, idx) {
          let statusText = item.status === 'A' ? 'Aktif' : 'Non Aktif';
            rows += `
                <tr>
                    <td>${idx+1}</td>
                    <td>${item.serialNumber}</td>
                    <td>${item.merk}</td>
                    <td>${item.model}</td>
                    <td>${item.kapasitas}</td>
                    <td>${item.ip_address}</td>
                    <td>${item.sistemOperasi}</td>
                    <td>${statusText}</td>
                </tr>
            `;
        });
    } else {
        rows = `<tr><td colspan="8" class="text-center"><code>Tidak ada perangkat</code></td></tr>`;
    }

    return `
        <table class="table table-sm table-bordered mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Serial Number</th>
                    <th>Merk</th>
                    <th>Model</th>
                    <th>Kapasitas</th>
                    <th>IP Address</th>
                    <th>Sistem Operasi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                ${rows}
            </tbody>
        </table>
    `;
}

$(document).ready(function() {
    if ( $.fn.DataTable.isDataTable('#example1') ) {
            $('#example1').DataTable().destroy();
        }
    var table = $('#example1').DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        dom: 'Bfrtip',
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
    });

    $('#example1 tbody').on('click', 'td.details-control', function () {
        var tr      = $(this).closest('tr');
        var row     = table.row(tr);
        var kodeRak = tr.data('koderak');
        var icon    = $(this).find('i');

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            icon.removeClass('fa-minus').addClass('fa-plus');
        } else {
            row.child(formatChild(kodeRak)).show();
            tr.addClass('shown');
            icon.removeClass('fa-plus').addClass('fa-minus');
        }
    });
});
</script>
<script>
    $('#modal-tambah').on('shown.bs.modal', function() {  
        $('#modal-tambah .select2').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#modal-tambah')
        });
    });

    $('#modal-update').on('shown.bs.modal', function () {
        $('#modal-update .select2').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#modal-update')
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#kdjenis').change(function () {
            var kdjen = $(this).val();
            if (kdjen) {
                $.ajax({
                    url: '/get-model/' + kdjen,
                    type: "GET",
                    data: { kdjenis: kdjen },
                    success: function (data) {
                        // console.log(data);
                        $('#kdmodel').empty();
                        $('#kdmodel').append('<option value="">Pilih Model</option>');
                        $.each(data, function (key, value) {
                            $('#kdmodel').append('<option value="' + value.kdmodel + '">' + value.namaModel + '</option>');
                        });
                    }
                });
            } else {
                $('#kdmodel').empty();
                $('#kdmodel').append('<option value="">Pilih Model</option>');
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#modal-update #kdjenis').change(function () {
            var kdjen = $(this).val();
            if (kdjen) {
                $.ajax({
                    url: '/get-model/' + kdjen,
                    type: "GET",
                    data: { kdjenis: kdjen },
                    success: function (data) {
                        // console.log(data);
                        $('#modal-update #kdmodel').empty();
                        $('#modal-update #kdmodel').append('<option value="">Pilih Model</option>');
                        $.each(data, function (key, value) {
                            $('#modal-update #kdmodel').append('<option value="' + value.kdmodel + '">' + value.namaModel + '</option>');
                        });
                    }
                });
            } else {
                $('#modal-update #kdmodel').empty();
                $('#modal-update #kdmodel').append('<option value="">Pilih Model</option>');
            }
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
                      alert('Terjadi kesalahan! Nama Rak Server ada yang sama, Silakan coba lagi.');
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
  $(document).ready(function(){
    $('body').on('click', '#viewMessage', function(){
        var editURL = $(this).data('url');
        $.get(editURL, function(data){
            // console.log(data);
            $('#modal-update').modal('show');
            $('#modal-update #id').val(data[0].id);
            $('#modal-update #kodeRak').val(data[0].kodeRak);
            $('#modal-update #namaRak').val(data[0].namaRak);
            $('#modal-update #kdmodel').val(data[0].kdmodel);
            $('#modal-update #kapasitas').val(data[0].kapasitas);
            $('#modal-update #kdjenis').val(data[0].kdjenis);
            $('#modal-update #keterangan').val(data[0].keterangan);
            $('#modal-update #dataTemp').val(JSON.stringify(data));
        })
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('click', '#showDetail', function(){
        var editURL = $(this).data('url');
        $.get(editURL, function(data){
            console.log(data);
            $('#modal-detail').modal('show');
            $('#modal-detail #id').val(data[0].id);
            $('#modal-detail #kodeRak').val(data[0].kodeRak);
            $('#modal-detail #namaRak').val(data[0].namaRak);
            $('#modal-detail #kdmodel').val(data[0].namaModel);
            $('#modal-detail #kapasitas').val(data[0].kapasitas);
            $('#modal-detail #kdjenis').val(data[0].namaJenis);
            $('#modal-detail #keterangan').val(data[0].keterangan);
        })
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#form-update-rak').on('click', '#simpanEdit', function(e){
          e.preventDefault();
          var nid = $('#form-update-rak #id').val();
          dataForm = $('#form-update-rak').serialize() + "&_token={{ csrf_token() }}";
          // alert(dataForm);    
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
      var myObject = JSON.parse( $('#modal-update #dataTemp').val());
        $('#modal-update').modal('show');
        $('#modal-update #kodeRak').val(myObject['kodeRak']);
        $('#modal-update #namaRak').val(myObject['namaRak']);
        $('#modal-update #model').val(myObject['model']);
        $('#modal-update #kapasitas').val(myObject['kapasitas']);
        $('#modal-update #kdjenis').val(myObject['kdjenis']);
        $('#modal-update #keterangan').val(myObject['keterangan']);
      });
  });
</script>

@endsection
