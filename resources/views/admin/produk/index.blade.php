@extends('admin.template.master')

@section('css')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('')}}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('')}}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('')}}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('')}}plugins/sweetalert2/sweetalert2.css">
  <link rel="stylesheet" href="{{ asset('')}}plugins/sweetalert2/sweetalert2.min.css">
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
                            <th>Serial Number</th>
                            <th>Model Produk</th>
                            <th>Tgl Pengadaan</th>
                            <th>Posisi Rak</th>
                            <th>Kondisi</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alat as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->serialNumber }}</td>
                                <td>{{ $item->namaProduk }}</td>
                                <td>{{ date('d-m-Y', strtotime( $item->tgl_pengadaan )) }}</td>
                                <td>{{ $item->namaRak }}</td>
                                <td style="align-content: center">
                                  @if ($item->kondisi == 'bb')
                                    <span class="badge badge-success"> Baik </span>
                                  @endif
                                  @if ($item->kondisi == 'rr')
                                    <span class="badge badge-warning"> Rusak Ringan </span>
                                  @endif
                                  @if ($item->kondisi == 'rb')
                                    <span class="badge badge-danger"> Rusak Berat </span>
                                  @endif
                                </td>
                                <td>{{ $item->deskripsi }}</td>
                                <td class="text-right">
                                  <div class="btn-group">
                                    <a href="javascript:void(0)" id="showDetail" data-url="{{ route('produk.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-detail" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                    &nbsp;
                                    <a href="javascript:void(0)" id="viewMessage" data-url="{{ route('produk.edit', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-update" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></a>
                                    &nbsp;
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('produk.destroy', $item->id) }}" method="POST">
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
  <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-create-produk" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="serialNumber">Serial Number</label>
                            <input type="text" id="serialNumber" name="serialNumber" class="form-control" required>
                            <label for="namaProduk">Model Produk</label>
                            <input type="text" id="namaProduk" name="namaProduk" class="form-control" required>
                            <label for="namaProduk">Posisi Rak</label>
                            <select class="form-control select2" style="width: 100%;" id="kodeRak" name="kodeRak" >
                              <option value="">-- Pilih Posisi --</option>
                                @foreach ($datarak as $rak)
                                  <option value="{{$rak->kodeRak}}">
                                    {{$rak->namaRak}}
                                  </option>
                                @endforeach
                            </select>
                            <label for="kondisi">Kondisi</label>
                            <div class="card card-light card-outline">
                              <div class="card-body">
                                <div class="custom-control custom-radio d-inline col-md-3">
                                  <input class="custom-control-input custom-control-input-success" type="radio" id="bb" name="kondisi" value="bb" checked>
                                  <label for="bb" class="custom-control-label">Baik</label>
                                </div>
                                <div class="custom-control custom-radio d-inline col-md-3">
                                  <input class="custom-control-input custom-control-input-warning" type="radio" id="rr" value="rr" name="kondisi">
                                  <label for="rr" class="custom-control-label">Rusak Ringan</label>
                                </div>
                                <div class="custom-control custom-radio d-inline col-md-3">
                                  <input class="custom-control-input custom-control-input-danger" type="radio" id="rb" value="rb" name="kondisi">
                                  <label for="rb" class="custom-control-label">Rusak Berat</label>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tgl_pengadaan">Tanggal Pengadaan</label>
                            <input type="date" 
                                class="form-control @error('tgl_pengadaan') is-invalid @enderror" 
                                id="tgl_pengadaan" name="tgl_pengadaan" data-date-format="dd/mm/yyyy" 
                                value="{{ old('tgl_pengadaan') }}" 
                                required>
                                
                            @error('tgl_pengadaan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <label for="deskripsi">Deskripsi Produk</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"></textarea>
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

  <!-- /.modal update data -->
  <div class="modal fade" id="modal-update" tabindex="-1" role="dialog" >
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
          <form id="form-update-produk" method="PUT">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <input type="hidden" value="" name="id" id="id" />
                          <label for="serialNumber">Serial Number</label>
                          <input type="text" id="serialNumber" name="serialNumber" value="" class="form-control" readonly>
                          <label for="namaProduk">Model Produk</label>
                          <input type="text" id="namaProduk" name="namaProduk" value="" class="form-control" required>
                          <label for="kodeRak">Posisi Rak</label>
                            <select class="form-control select2" style="width: 100%;" id="kodeRak" name="kodeRak" >
                              <option value="">-- Pilih Posisi --</option>
                                @foreach ($datarak as $rak)
                                  <option value="{{$rak->kodeRak}}">
                                    {{$rak->namaRak}}
                                  </option>
                                @endforeach
                            </select>
                          <label for="kondis">Kondisi</label>
                            <div class="card card-light card-outline">
                              <div class="card-body">                            
                              <div class="custom-control custom-radio d-inline col-md-3">
                                <input class="custom-control-input custom-control-input-success" type="radio" id="bb1" name="kondisi" value="bb">
                                <label for="bb1" class="custom-control-label">Baik</label>
                              </div>
                              <div class="custom-control custom-radio d-inline col-md-3">
                                <input class="custom-control-input custom-control-input-warning" type="radio" id="rr1" name="kondisi" value="rr">
                                <label for="rr1" class="custom-control-label">Rusak Ringan</label>
                              </div>
                              <div class="custom-control custom-radio d-inline col-md-3">
                                <input class="custom-control-input custom-control-input-danger" type="radio" id="rb1" name="kondisi" value="rb">
                                <label for="rb1" class="custom-control-label">Rusak Berat</label>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="tgl_pengadaan">Tanggal Pengadaan</label>
                        <input type="date" 
                            class="form-control @error('tgl_pengadaan') is-invalid @enderror" 
                            id="tgl_pengadaan" name="tgl_pengadaan" data-date-format="dd/mm/yyyy" 
                            value="" required>
                        <label for="deskripsi">Deskripsi Produk</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" value="" rows="3"></textarea>
                    </div>
                  </div>
                </div>
                <div class="mt-3" >
                    <button type="submit" class="btn btn-outline-light float-sm-right" id="simpanEdit"><i class="fas fa-save"></i> Simpan</button>
                    <button type="button" id="btnClear" class="btn btn-outline-light"><i class="fa fa-eraser"></i> Batal</button>
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

<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Data Produk</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Detail Data</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="row mt-1">
                      <label for="" class="col-md-4">Serial Number</label>
                      <input type="text" class="form-control col-md-7" id="serialNumber" name="serialNumber" value="" disabled>
                    </div>
                    <div class="row mt-1">  
                      <label for="" class="col-md-4">Nama Produk</label>
                      <input type="text" class="form-control col-md-7" id="namaProduk" name="namaProduk" value="" disabled>
                    </div>
                    <div class="row mt-1">  
                      <label for="" class="col-md-4">Posisi Rak</label>
                      <input type="text" class="form-control col-md-7" id="namaRak" name="namaRak" value="" disabled>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="row mt-1">  
                      <label for="" class="col-md-4">Kondisi</label>
                      <input type="text" class="form-control col-md-7" id="kondisi" name="kondisi" value="" disabled>
                    </div>
                    <div class="row mt-1"> 
                      <label for="" class="col-md-4">Tanggal Pengadaan</label>
                      <input type="text" class="form-control col-md-7" id="tgl_pengadaan" name="tgl_pengadaan" value="" disabled>
                    </div>
                    <div class="row mt-1"> 
                      <label for="" class="col-md-4">Deskripsi</label>
                      {{-- <input type="text" class="form-control col-md-7" id="deskripsi" name="deskripsi" value="" disabled> --}}
                      <textarea class="form-control col-md-7" id="deskripsi" name="deskripsi" rows="3" disabled></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Riwayat Data</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <label for="">Lisensi Produk</label>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>          
        </div>
      </div>
    <!-- /.modal-content -->
    </div>
  <!-- /.modal-dialog -->
  </div>
</div>
<!-- /.modal -->

@endsection  

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('')}}plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
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
              document.getElementById('delete-form-' + id).submit();
          Swal.fire(
              'Dihapus!',
              'Data berhasil dihapus.',
              'success'
          );
          }
      });
  }
</script>
<script>
  // $('button[name="remove_levels"]').on('click', function(e) {
  //     var $form = $(this).closest('form');
  //     e.preventDefault();
  //     $('#confirm').modal({
  //         backdrop: 'static',
  //         keyboard: false
  //     })
  //     .on('click', '#delete', function(e) {
  //         $form.trigger('submit');
  //       });
  //     $("#cancel").on('click',function(e){
  //      e.preventDefault();
  //      $('#confirm').modal.model('hide');
  //     });
  //   });

    $(document).on('click', '#showDetail', function(){
      let id_produk = $(this).data('id_produk');
      var editURL = $(this).data('url');
        $.get(editURL, function(data){
            // console.log(data);
            var cek = data[0]['kondisi'];
            const tgl = data[0]['tgl_pengadaan'];
            var options = { year: "numeric", month: "numeric", day: "numeric" };
            const formattgl = new Date(tgl).toLocaleDateString('es-CL', options);  
            $('#modal-detail').modal('show');
            $('#modal-detail #serialNumber').val(data[0]['serialNumber']);
            $('#modal-detail #namaProduk').val(data[0]['namaProduk']);
            $("#modal-detail #namaRak").val(data[0]['namaRak']);
            $("#modal-detail #tgl_pengadaan").val(formattgl);
            $("#modal-detail #deskripsi").val(data[0]['deskripsi']);
            if(cek == 'bb'){
              $("#modal-detail #kondisi").val("Baik");
            }else if(cek == 'rr'){
              $("#modal-detail #kondisi").val("Rusak Ringan");
            }else if(cek == 'rb'){
              $("#modal-detail #kondisi").val("Rusak Berat");
            } 
        })      

    });

</script>
<script>
  $(document).ready(function() {
      $('#form-create-produk').submit(function(e) {
          e.preventDefault();
          dataForm = $(this).serialize() + "&_token={{ csrf_token() }}";  
          $.ajax({
              type: 'POST',
              url: "{{ route('produk.store') }}",
              data: dataForm,
              dataType: 'json',
              success: function(response) {
                  if(response.status == 200) {
                      alert(response.message);
                      window.location.href = "{{ route('produk.index') }}";
                  } else {
                      alert(response.message);
                      $('#serialNumber').val('');
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
                      alert('Terjadi kesalahan! Serial Number ada yang sama, Silakan coba lagi.');
                  }
              }
          });
      });

      $('#btnClear').click(function() {
      // Reset semua input dalam form
          $('#serialNumber').val('');
          $('#namaProduk').val('');
          $('#kodeRak').val('');
          $('#deskripsi').val('');
          $('#tgl_pengadaan').val('');
          $('#kondisi').val('');
      });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('click', '#viewMessage', function(){
        var editURL = $(this).data('url');
        $.get(editURL, function(data){
            // console.log(data);
            var cek = data.kondisi;
            $('#modal-update').modal('show');
            $('#form-update-produk #id').val(data.id);
            $('#form-update-produk #serialNumber').val(data.serialNumber);
            $('#form-update-produk #namaProduk').val(data.namaProduk);
            $("#form-update-produk #kodeRak").val(data.kodeRak);
            $("#form-update-produk #tgl_pengadaan").val(data.tgl_pengadaan);
            $("#form-update-produk #deskripsi").val(data.deskripsi);
            if(cek == 'bb'){
              $("#form-update-produk #bb1").prop("checked",true);
            }else if(cek == 'rr'){
              $("#form-update-produk #rr1").prop("checked",true);
            }else if(cek == 'rb'){
              $("#form-update-produk #rb1").prop("checked",true);
            } 
        })
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#form-update-produk').on('click', '#simpanEdit', function(e){
          e.preventDefault();
          var nid = $('#form-update-produk #id').val();
          dataForm = $('#form-update-produk').serialize() + "&_token={{ csrf_token() }}";
          // alert(dataForm);    
          $.ajax({
              type: 'PUT',
              url: "{{ route('produk.update', ':id') }}".replace(':id', nid),
              data: dataForm,
              dataType: 'json',
              success: function(response) {
                    if(response.status == 200) {
                        alert(response.pesan);
                        window.location.href = "{{ route('produk.index') }}";
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
  });
</script>
@endsection
