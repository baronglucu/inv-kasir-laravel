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
                            <th>Nama Domain</th>
                            <th>Hosting</th>
                            <th>Framework</th>    
                            <th>cPanel/WHM</th> 
                            <th>Status</th> 
                            <th>Tgl Aktif</th> 
                            <th>Kotama</th>
                            <th>Satuan</th>                        
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alat as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_domain }}</td>
                                <td>{{ $item->hosting }}</td>
                                <td>{{ $item->framework }}</td>                                
                                <td>{{ $item->nama_whm }}</td> 
                                <td>
                                    @if ( $item->status == 'E' )
                                        <span class="badge badge-warning"> Error </span>
                                    @endif
                                    @if (  $item->status == 'R' )
                                        <span class="badge badge-primary"> Running </span>
                                    @endif
                                    @if (  $item->status == 'M' )
                                        <span class="badge badge-success"> Maintenance </span>
                                    @endif
                                    @if (  $item->status == 'S' )
                                    <span class="badge badge-danger"> Suspended </span>
                                @endif
                                </td>                               
                                <td>{{ date('d-m-Y', strtotime( $item->tgl_aktif )) }}</td>
                                {{-- <td>
                                    @if ( $item->posisi == '1' )
                                        <span> Dalam Pusat Data </span>
                                    @endif
                                    @if (  $item->posisi == '2' )
                                        <span> Luar Pusat Data </span>
                                    @endif
                                </td> --}}
                                <td>{{ $item->ur_ktm }}</td>
                                <td>{{ $item->ur_smkl }}</td>                           
                                <td>{{ $item->keterangan }}</td>
                                <td class="text-right">
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary" tooltip="Show" id="showDetail" data-id="{{ $item->id }}"><i class="fas fa-eye"></i></button>
                                    &nbsp;
                                    <a href="javascript:void(0)" id="viewMessage" data-url="{{ route('domain.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-update" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></a>
                                    &nbsp;
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('domain.destroy', $item->id) }}" method="POST">
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
          <form id="form-create-domain" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"> 
                            <label for="nama_domain">Nama Domain</label>
                            <input type="text" class="form-control" name="nama_domain" id="nama_domain" required>
                            
                                        <label for="hosting">Hosting</label>
                                        <input type="text" id="hosting" name="hosting" class="form-control" required>
                             
                                        <label for="framework">Framework</label>
                                        <input type="text" id="framework" name="framework" class="form-control" required>
                                 
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" style="width: 100%;">
                                            <option value="E" selected="selected">Error</option>
                                            <option value="R">Running</option>
                                            <option value="M">Maintenance</option>
                                            <option value="S">Suspended</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="id_whm">cPanel/WHM</label>
                                        <select class="form-control select2" style="width: 100%;" id="id_whm" name="id_whm" >
                                        <option value="">--- Pilih ---</option>
                                            @foreach ($whm as $w)
                                            <option value="{{$w->id}}">
                                                {{$w->nama_whm}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            {{-- <div class="row">
                                <div class="col-md-6"> --}}
                                        <label for="tgl_aktif">Tanggal Aktif</label>
                                        <input type="date" class="form-control @error('tgl_aktif') is-invalid @enderror" id="tgl_aktif" name="tgl_aktif" data-date-format="dd/mm/yyyy" value="{{ old('tgl_aktif') }}" required>
                                    
                                        @error('tgl_aktif')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    {{-- </div>
                                    <div class="col-md-6">
                                        <label for="posisi">Posisi/Tempat</label>
                                        <select class="form-control" style="width: 100%;" id="posisi" name="posisi" >
                                            <option value="">Pilih Posisi</option>
                                            <option value="1">Dalam Pusat Data</option>
                                            <option value="2">Luar Pusat Data</option>  
                                          </select>
                                    </div>
                                </div>
                            </div> --}}
                            
                            <label for="kotama">Kotama</label>
                            <select class="form-control select2" id="kotama" name="kotama">
                                <option value="" selected="selected"></option>
                                @foreach ($kotama as $kot)
                                <option value="{{$kot->kd_ktm}}">{{$kot->ur_ktm}}</option>
                                @endforeach
                            </select>
                            <label for="satuan">Satuan</label>
                            <select class="form-control select2" id="satuan" name="satuan">
                                <option value="" selected="selected"></option>
                            </select>            
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
          <form id="form-update-domain" method="PUT">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group"> 
                      <input type="hidden" value="" name="id" id="id" />
                        <label for="nama_domain">Nama Domain</label>
                        <input type="text" class="form-control" name="nama_domain" id="nama_domain" required>
                        <label for="hosting">Hosting</label>
                        <input type="text" id="hosting" name="hosting" class="form-control" required>
                        <label for="framework">Framework</label>
                        <input type="text" id="framework" name="framework" class="form-control" required>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" style="width: 100%;">
                                        <option value="E" selected="selected">Error</option>
                                        <option value="R">Running</option>
                                        <option value="M">Maintenance</option>
                                        <option value="S">Suspended</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="id_whm">cPanel/WHM</label>
                                    <select class="form-control select2" style="width: 100%;" id="id_whm" name="id_whm" >
                                    <option value="">--- Pilih ---</option>
                                        @foreach ($whm as $w)
                                        <option value="{{$w->id}}">
                                            {{$w->nama_whm}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label for="tgl_aktif">Tanggal Aktif</label>
                        <input type="date" class="form-control @error('tgl_aktif') is-invalid @enderror" id="tgl_aktif" name="tgl_aktif" data-date-format="dd/mm/yyyy" value="{{ old('tgl_aktif') }}" required>
                          @error('tgl_aktif')
                          <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        <label for="kotama">Kotama</label>
                         <select class="form-control select2" id="kotama" name="kotama">
                            <option value="" selected="selected"></option>
                            @foreach ($kotama as $kot)
                            <option value="{{$kot->kd_ktm}}">{{$kot->ur_ktm}}</option>
                            @endforeach
                        </select>
                        <label for="satuan">Satuan</label>
                        <select class="form-control select2" id="satuan" name="satuan">
                            <option value="" selected="selected"></option>
                            @foreach ($satuan as $sat)
                              <option value="{{$sat->idsmkl}}">{{$sat->ur_smkl}}</option>
                            @endforeach
                        </select> 
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
            
            // document.getElementById('delete-form-' + id).submit();
              // Swal.fire(
              //     'Dihapus!',
              //     'Data berhasil dihapus.',
              //     'success'
              // );
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
          window.location.href = "{{ route('domain.index') }}"; // Redirect setelah OK ditekan
      });
  @endif
</script>
<script>
  
    $(document).on('click', '#showDetail', function(){
      let idx = $(this).data('id');
      alert(idx);
    });

</script>
<script>
  $(document).ready(function() {
      $('#form-create-domain').submit(function(e) {
          e.preventDefault();
          dataForm = $(this).serialize() + "&_token={{ csrf_token() }}";  
          // alert(dataForm);
          $.ajax({
              type: 'POST',
              url: "{{ route('domain.store') }}",
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
                            window.location.href = "{{ route('domain.index') }}"; // Redirect setelah OK ditekan
                        });
                  } else {
                      alert(response.message);
                      $('#ip_domain').val('');
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
                      alert('Terjadi kesalahan! Nama Domain ada yang sama, Silakan coba lagi.');
                  }
              }
          });
      });

      $('#btnClear').click(function() {
      // Reset semua input dalam form
          $('#nama_domain').val('');
          $('#hosting').val('');
          $('#framework').val('');
          $('#status').val('');
          $('#id_whm').val('');
          $('#tgl_aktif').val('');
          $('#kotama').val('');
          $('#satuan').val('');
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
            var cek = data.kondisi;
            $('#modal-update').modal('show');
            $('#modal-update #id').val(data.id);
            $('#modal-update #nama_domain').val(data.nama_domain);
            $('#modal-update #hosting').val(data.hosting);
            $('#modal-update #framework').val(data.framework);  
            $('#modal-update #status').val(data.status);          
            $('#modal-update #id_whm').val(data.id_whm);
            $('#modal-update #tgl_aktif').val(data.tgl_aktif);
            $('#modal-update #kotama').val(data.kd_ktm);
            $('#modal-update #satuan').val(data.kd_smkl).trigger('change');
            $('#modal-update #keterangan').val(data.keterangan);
            $('#modal-update #dataTemp').val(JSON.stringify(data));
        })
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#form-update-domain').on('click', '#simpanEdit', function(e){
          e.preventDefault();
          var nid = $('#form-update-domain #id').val();
          dataForm = $('#form-update-domain').serialize() + "&_token={{ csrf_token() }}";
          // alert(dataForm);    
          $.ajax({
              type: 'PUT',
              url: "{{ route('domain.update', ':id') }}".replace(':id', nid),
              data: dataForm,
              dataType: 'json',
              success: function(response) {
                    if(response.status == 200) {
                        alert(response.pesan);
                        window.location.href = "{{ route('domain.index') }}";
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
      // alert(myObject['serialNumber']);
        $('#modal-update').modal('show');
        $('#modal-update #nama_domain').val(myObject['nama_domain']);
        $('#modal-update #hosting').val(myObject['hosting']);
        $("#modal-update #framework").val(myObject['framework']);  
        $('#modal-update #status').val(myObject['status']);          
        $('#modal-update #id_whm').val(myObject['id_whm']);
        $("#modal-update #tgl_aktif").val(myObject['tgl_aktif']);
        $('#modal-update #kotama').val(myObject['kd_ktm']);
        $('#modal-update #satuan').val(myObject['kd_smkl']);
        $('#modal-update #keterangan').val(myObject['keterangan']);
      });
  });
</script>

<script>
    $(document).ready(function () {
        $('#kotama').change(function () {
            var kdktm = $(this).val();
            // console.log(kdktm);
            if (kdktm) {
                $.ajax({
                    url: '/get-satuan/' + kdktm,
                    type: "GET",
                    data: { kd_ktm: kdktm },
                    success: function (data) {
                        // console.log(data);
                        $('#satuan').empty();
                        $('#satuan').append('<option value="">Pilih Satuan</option>');
                        $.each(data, function (key, value) {
                            $('#satuan').append('<option value="' + value.idsmkl + '">' + value.ur_smkl + '</option>');
                        });
                    }
                });
            } else {
                $('#satuan').empty();
                $('#satuan').append('<option value="">Pilih Satuan</option>');
            }
        });
    });
</script>

<script>
  $(document).ready(function () {
      $('#modal-update #kotama').change(function () {
          var kdktm = $(this).val();
          // console.log(kdktm);
          if (kdktm) {
              $.ajax({
                  url: '/get-satuan/' + kdktm,
                  type: "GET",
                  data: { kd_ktm: kdktm },
                  success: function (data) {
                      // console.log(data);
                      $('#modal-update #satuan').empty();
                      $('#modal-update #satuan').append('<option value="">Pilih Satuan</option>');
                      $.each(data, function (key, value) {
                          $('#modal-update #satuan').append('<option value="' + value.idsmkl + '">' + value.ur_smkl + '</option>');
                      });
                  }
              });
          } else {
              $('#modal-update #satuan').empty();
              $('#modal-update #satuan').append('<option value="">Pilih Satuan</option>');
          }
      });
  });
</script>
@endsection
