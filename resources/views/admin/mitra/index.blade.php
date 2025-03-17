@extends('admin.template.master')

@section('css')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('')}}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('')}}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('')}}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
                <h3 class="card-title">{{ $title }}</h3>
                <button type="button" class="btn btn-sm btn-primary float-sm-right" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah </button>
            </div>
            <div class="card-body">
                <table id="example1" name='example1' class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mitra</th>
                            <th>Alamat Kantor</th>
                            <th>Kota</th>
                            <th>Provinsi</th>
                            <th>No Telp</th>
                            <th>e-Mail</th>                            
                            <th>Nama Pimpinan</th>
                            <th>No Telp Pimp</th>
                            <th>e-Mail Pimp</th>
                            <th>NPWP</th>
                            <th>SIUP</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datamitra as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_mitra }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->kota }}</td>
                                <td>{{ $item->provinsi }}</td>
                                <td>{{ $item->notelp }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->nama_pimpinan }}</td>
                                <td>{{ $item->nohp_pimpinan }}</td>
                                <td>{{ $item->email_pimpinan }}</td>
                                <td>{{ $item->npwp }}</td>
                                <td>{{ $item->siup }}</td>
                                <td>{{ $item->Keterangan }}</td>
                                <td class="text-right">
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary" tooltip="Show" id="showDetail" data-id_mitra="{{ $item->id }}"><i class="fas fa-eye"></i></button>
                                    &nbsp;
                                    <a href="javascript:void(0)" id="viewMessage" data-url="{{ route('mitra.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-update" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></a>
                                    &nbsp;
                                    <form class="delete" action="{{ route('mitra.destroy',$item->id) }}" method="POST">
                                      <input type="hidden" name="_method" value="DELETE">
                                      {{ csrf_field() }}
                                      <button class='btn btn-sm btn-danger' type="submit" name="remove_levels" value="delete"><i class="fas fa-trash" value="Hapus Item"></i></button>
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
                    {{-- <div class="col-md-12" align="center">
                        <div class="input-group row mb-3">
                            <label for="id_mitra" class="col-sm-2 col-form-label">ID Mitra</label>
                            <div class="col-sm-4">
                              <input type="text" id="id_mitra" name="id_mitra" class="form-control" required>
                            </div>                            
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="form-group">    
                            <label for="id_mitra">Id Mitra</label>
                            <input type="text" id="id_mitra" name="id_mitra" class="form-control" required>                        
                            <label for="nama_mitra">Nama Mitra</label>
                            <input type="text" id="nama_mitra" name="nama_mitra" class="form-control" required>
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="4"></textarea>
                            <label for="kota">Kota</label>
                            <input type="text" id="kota" name="kota" class="form-control" required>
                            <label for="provinsi">Provinsi</label>
                            <input type="text" id="provinsi" name="provinsi" class="form-control" required>
                            <label for="notelp">No Telp</label>
                            <input type="text" id="notelp" name="notelp" class="form-control" required>
                            <label for="email">e-Mail</label>
                            <input type="text" id="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">     
                            <label for="alamat_web">Alamat Web</label>
                            <input type="text" id="alamat_web" name="alamat_web" class="form-control" >                       
                            <label for="nama_pimpinan">Nama Pimpinan</label>
                            <input type="text" id="nama_pimpinan" name="nama_pimpinan" class="form-control" required>
                            <label for="nohp_pimpinan">No Telp Pimpinan</label>
                            <input type="text" id="nohp_pimpinan" name="nohp_pimpinan" class="form-control">
                            <label for="email_pimpinan">e-Mail Pimpinan</label>
                            <input type="text" id="email_pimpinan" name="email_pimpinan" class="form-control">
                            <label for="npwp">NPWP</label>
                            <input type="text" id="npwp" name="npwp" class="form-control">     
                            <label for="siup">SIUP</label>
                            <input type="text" id="siup" name="siup" class="form-control"> 
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="4"></textarea>
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
          <form id="form-update-mitra" method="PUT">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">    
                          <label for="id_mitra">Id Mitra</label>
                          <input type="text" id="id_mitra" name="id_mitra" class="form-control" readonly>                        
                          <label for="nama_mitra">Nama Mitra</label>
                          <input type="text" id="nama_mitra" name="nama_mitra" class="form-control">
                          <label for="alamat">Alamat</label>
                          <textarea class="form-control" id="alamat" name="alamat" rows="4"></textarea>
                          <label for="kota">Kota</label>
                          <input type="text" id="kota" name="kota" class="form-control">
                          <label for="provinsi">Provinsi</label>
                          <input type="text" id="provinsi" name="provinsi" class="form-control">
                          <label for="notelp">No Telp</label>
                          <input type="text" id="notelp" name="notelp" class="form-control">
                          <label for="email">e-Mail</label>
                          <input type="text" id="email" name="email" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">     
                          <label for="alamat_web">Alamat Web</label>
                          <input type="text" id="alamat_web" name="alamat_web" class="form-control" >                       
                          <label for="nama_pimpinan">Nama Pimpinan</label>
                          <input type="text" id="nama_pimpinan" name="nama_pimpinan" class="form-control">
                          <label for="nohp_pimpinan">No Telp Pimpinan</label>
                          <input type="text" id="nohp_pimpinan" name="nohp_pimpinan" class="form-control">
                          <label for="email_pimpinan">e-Mail Pimpinan</label>
                          <input type="text" id="email_pimpinan" name="email_pimpinan" class="form-control">
                          <label for="npwp">NPWP</label>
                          <input type="text" id="npwp" name="npwp" class="form-control">     
                          <label for="siup">SIUP</label>
                          <input type="text" id="siup" name="siup" class="form-control"> 
                          <label for="keterangan">Keterangan</label>
                          <textarea class="form-control" id="keterangan" name="keterangan" rows="4"></textarea>
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
<script src="{{ asset('')}}plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('')}}plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('')}}plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('')}}plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('')}}plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "columnDefs": [{ "visible": false, "targets": [6, 7, 8, 9, 10, 11, 12] }]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
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

    $(document).on('click', '#showDetail', function(){
      let id_produk = $(this).data('id_mitra');
      alert(id_produk);
    });

</script>
<script>
  $(document).ready(function() {
      $('#form-create-produk').submit(function(e) {
          e.preventDefault();
          dataForm = $(this).serialize() + "&_token={{ csrf_token() }}";  
          $.ajax({
              type: 'POST',
              url: "{{ route('mitra.store') }}",
              data: dataForm,
              dataType: 'json',
              success: function(response) {
                  if(response.status == 200) {
                      alert(response.message);
                      window.location.href = "{{ route('mitra.index') }}";
                  } else {
                      alert(response.message);
                      $('#id_mitra').val('');
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
                      alert('Terjadi kesalahan! ID MITRA ada yang sama, Silakan coba lagi.');
                  }
              }
          });
      });

      $('#btnClear').click(function() {
      // Reset semua input dalam form
          $('#id_mitra').val('');
          $('#nama_mitra').val('');
          $('#alamat').val('');
          $('#kota').val('');
          $('#provinsi').val('');
          $('#notelp').val('');
          $('#email').val('');
          $('#alamat_web').val('');
          $('#nama_pimpinan').val('');
          $('#nohp_pimpinan').val('');
          $('#email_pimpinan').val('');
          $('#npwp').val('');
          $('#siup').val('');
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
            $('#form-update-mitra #id').val(data.id);
            $('#form-update-mitra #id_mitra').val(data.id_mitra);
            $('#form-update-mitra #nama_mitra').val(data.nama_mitra);
            $("#form-update-mitra #alamat").val(data.alamat);
            $("#form-update-mitra #kota").val(data.kota);
            $("#form-update-mitra #provinsi").val(data.provinsi);
            $('#form-update-mitra #notelp').val(data.notelp);
            $('#form-update-mitra #email').val(data.email);
            $("#form-update-mitra #alamat_web").val(data.alamat_web);
            $('#form-update-mitra #nama_pimpinan').val(data.nama_pimpinan);
            $("#form-update-mitra #nohp_pimpinan").val(data.nohp_pimpinan);
            $("#form-update-mitra #email_pimpinan").val(data.email_pimpinan);
            $("#form-update-mitra #npwp").val(data.npwp);
            $("#form-update-mitra #siup").val(data.siup);
            $("#form-update-mitra #keterangan").val(data.keterangan);
            // $('input[name=dataTemp]').val(data);
            $('#modal-update #dataTemp').val(JSON.stringify(data));
        })
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#form-update-mitra').on('click', '#simpanEdit', function(e){
          e.preventDefault();
          var nid = $('#form-update-mitra #id').val();
          dataForm = $('#form-update-mitra').serialize() + "&_token={{ csrf_token() }}";
          // alert(dataForm);    
          $.ajax({
              type: 'PUT',
              url: "{{ route('mitra.update', ':id') }}".replace(':id', nid),
              data: dataForm,
              dataType: 'json',
              success: function(response) {
                    if(response.status == 200) {
                        alert(response.pesan);
                        window.location.href = "{{ route('mitra.index') }}";
                    } else {
                        alert('berhasil, tapi tidak tersimpan');
                    }
              },
              error: function(response) {
                    if(response.status == 500) {
                        alert('GAGAL, dan tidak tersimpan');
                    } else {
                        alert('Terjadi kesalahan! Cek Ulang Data, Silakan coba lagi.');
                    }
                }
          });
    });    

    $('#btnBatal').click(function() {
      var myObject = JSON.parse( $('#modal-update #dataTemp').val());
      // alert(myObject['nama_mitra']);
          $('#form-update-mitra #nama_mitra').val(myObject['nama_mitra']);
          $("#form-update-mitra #alamat").val(myObject['alamat']);
          $("#form-update-mitra #kota").val(myObject['kota']);
          $("#form-update-mitra #provinsi").val(myObject['provinsi']);
          $('#form-update-mitra #notelp').val(myObject['notelp']);
          $('#form-update-mitra #email').val(myObject['email']);
          $("#form-update-mitra #alamat_web").val(myObject['alamat_web']);
          $('#form-update-mitra #nama_pimpinan').val(myObject['nama_pimpinan']);
          $("#form-update-mitra #nohp_pimpinan").val(myObject['nohp_pimpinan']);
          $("#form-update-mitra #email_pimpinan").val(myObject['email_pimpinan']);
          $("#form-update-mitra #npwp").val(myObject['npwp']);
          $("#form-update-mitra #siup").val(myObject['siup']);
          $("#form-update-mitra #keterangan").val(myObject['keterangan']);
      });
  });
</script>
@endsection
