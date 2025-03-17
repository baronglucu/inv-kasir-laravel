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
                <h3 class="card-title">{{ $title }}</h3>
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
                            <th>Alamat Ip</th>
                            <th>Nama WHM</th>
                            <th>Posisi Rak</th>
                            <th>Kapasitas</th>                            
                            <th>Tgl Aktif cPanel</th> 
                            <th>Tgl Berlaku cPanel</th>
                            <th>Lama Aktif SSL</th>
                            <th>Status</th>
                            <th>Kondisi</th>                           
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($panel as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->ip_address }}</td>
                                <td>{{ $item->nama_whm }}</td>
                                <td>{{ $item->namaRak }}</td>
                                <td>{{ $item->kapasitas }}</td>
                                <td>{{ $item->tgl_aktif }}</td>
                                <td>{{ $item->tgl_akhir }}</td>
                                <td>{{ $item->lama_ssl }} tahun</td>
                                <td>
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
                                <td>
                                    {{-- {{ now()->toDateTimeLocalString() }} 
                                    {{ date('Y-m-d')}} --}}
                                   
                                    @if ( date('Y-m-d' > $item->tgl_akhir ))
                                        <span class="badge badge-primary"> Aktif </span>
                                    @endif
                                    @if ( date('Y-m-d' < $item->tgl_akhir ))
                                        <span class="badge badge-danger"> Non Aktif </span>
                                    @endif
                                </td>
                                <td>{{ $item->keterangan }}</td>
                                <td class="text-right">
                                  <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary" tooltip="Show" id="showDetail" data-id_whm="{{ $item->id }}"><i class="fas fa-eye"></i></button>
                                    &nbsp;
                                    <a href="javascript:void(0)" id="viewMessage" data-url="{{ route('whm.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-update" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></a>
                                    &nbsp;
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('whm.destroy', $item->id) }}" method="POST">
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
          <form id="form-create-whm" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">  
                            <label class="form-label">IP Address</label>
                            <input type="text" class="form-control" name="ip_address" id="ip_address" minlength="7" maxlength="15" size="15" pattern="^(?>(\d|[1-9]\d{2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?1)$" placeholder="000.000.000.000" required>                               
                            <label for="nama_whm">Nama WHM</label>
                            <input type="text" id="nama_whm" name="nama_whm" class="form-control" required>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label for="nama_whm">Posisi Rak</label>
                                    <select class="form-control select2" style="width: 100%;" id="kodeRak" name="kodeRak" >
                                      <option value="">-- Pilih Posisi --</option>
                                        @foreach ($datarak as $rak)
                                          <option value="{{$rak->kodeRak}}">
                                            {{$rak->namaRak}}
                                          </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="kapasitas">Kapasitas</label>
                                    <input type="number" id="kapasitas" name="kapasitas" min="1" class="form-control" required>
                                </div>
                            </div>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Tanggal Aktif</label>
                                    <input type="date" class="form-control @error('tgl_aktif') is-invalid @enderror" id="tgl_aktif" name="tgl_aktif" data-date-format="dd/mm/yyyy" value="{{ old('tgl_aktif') }}" required>
                                
                                    @error('tgl_aktif')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" class="form-control @error('tgl_akhir') is-invalid @enderror" id="tgl_akhir" name="tgl_akhir" data-date-format="dd/mm/yyyy" value="{{ old('tgl_akhir') }}" required>
                                
                                    @error('tgl_akhir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <label for="lama_ssl">Lama berlaku SSL</label>
                            <div class="input-group">                                
                                <input type="number" class="form-control" id="lama_ssl" name="lama_ssl" min="1" required>
                                <div class="input-group-append">
                                  <span class="input-group-text">Tahun</span>
                                </div>
                            </div>                   
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="5"></textarea>
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
          <form id="form-update-whm" method="PUT">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" value="" name="id" id="id" />
                            <label for="ip_address">Alamat Ip</label>
                            <input type="ipaddress" id="ip_address" name="ip_address" class="form-control" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" required>

                          <label for="nama_whm">Nama WHM</label>
                          <input type="text" id="nama_whm" name="nama_whm" value="" class="form-control" required>
                          <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                <label for="nama_whm">Posisi Rak</label>
                                <select class="form-control select2" style="width: 100%;" id="kodeRak" name="kodeRak" >
                                  <option value="">-- Pilih Posisi --</option>
                                    @foreach ($datarak as $rak)
                                      <option value="{{$rak->kodeRak}}">
                                        {{$rak->namaRak}}
                                      </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="kapasitas">Kapasitas</label>
                                <input type="number" id="kapasitas" name="kapasitas" min="1" class="form-control" required>
                            </div>
                        </div>
                          <label for="kondisi">Kondisi</label>
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
                        <div class="row">
                            <div class="col-md-6">
                                <label>Tanggal Aktif</label>
                                <input type="date" class="form-control @error('tgl_aktif') is-invalid @enderror" id="tgl_aktif" name="tgl_aktif" data-date-format="dd/mm/yyyy" value="{{ old('tgl_aktif') }}" required>
                                @error('tgl_aktif')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Tanggal Akhir</label>
                                <input type="date" class="form-control @error('tgl_akhir') is-invalid @enderror" id="tgl_akhir" name="tgl_akhir" data-date-format="dd/mm/yyyy" value="{{ old('tgl_akhir') }}" required>
                                @error('tgl_akhir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <label for="lama_ssl">Lama berlaku SSL</label>
                            <div class="input-group">                                
                                <input type="number" class="form-control" id="lama_ssl" name="lama_ssl" min="1" required>
                                <div class="input-group-append">
                                  <span class="input-group-text">Tahun</span>
                                </div>
                            </div> 
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" value="" rows="5"></textarea>
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
          window.location.href = "{{ route('whm.index') }}"; // Redirect setelah OK ditekan
      });
  @endif
</script>
<script>
  
    $(document).on('click', '#showDetail', function(){
      let id = $(this).data('id');
      alert(id);
    });

</script>
<script>
  $(document).ready(function() {
      $('#form-create-whm').submit(function(e) {
          e.preventDefault();
          dataForm = $(this).serialize() + "&_token={{ csrf_token() }}";  
        //   alert(dataForm);
          $.ajax({
              type: 'POST',
              url: "{{ route('whm.store') }}",
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
                            window.location.href = "{{ route('whm.index') }}"; // Redirect setelah OK ditekan
                        });
                  } else {
                      alert(response.message);
                      $('#ip_address').val('');
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
                      alert('Terjadi kesalahan! Nama WHM ada yang sama, Silakan coba lagi.');
                  }
              }
          });
      });

      $('#btnClear').click(function() {
      // Reset semua input dalam form          
          $('#ip_address').val('');
          $('#nama_whm').val('');
          $('#kodeRak').val('');
          $('#kapasitas').val('');
          $('#tgl_aktif').val('');
          $('#tgl_akhir').val('');
          $('#kondisi').val('');
          $('#lama_ssl').val('');
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
            $('#form-update-whm #id').val(data.id);
            $('#form-update-whm #ip_address').val(data.ip_address);
            $('#form-update-whm #nama_whm').val(data.nama_whm);
            $("#form-update-whm #kodeRak").val(data.kodeRak);            
            $('#form-update-whm #kapasitas').val(data.kapasitas);
            $("#form-update-whm #tgl_aktif").val(data.tgl_aktif);
            $("#form-update-whm #tgl_akhir").val(data.tgl_akhir);
            $('#form-update-whm #lama_ssl').val(data.lama_ssl);
            if(cek == 'bb'){
              $("#form-update-whm #bb1").prop("checked",true);
            }else if(cek == 'rr'){
              $("#form-update-whm #rr1").prop("checked",true);
            }else if(cek == 'rb'){
              $("#form-update-whm #rb1").prop("checked",true);
            } 
            $('#form-update-whm #keterangan').val(data.keterangan);
        })
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#form-update-whm').on('click', '#simpanEdit', function(e){
          e.preventDefault();
          var nid = $('#form-update-whm #id').val();
          dataForm = $('#form-update-whm').serialize() + "&_token={{ csrf_token() }}";
        //   alert(dataForm);    
          $.ajax({
              type: 'PUT',
              url: "{{ route('whm.update', ':id') }}".replace(':id', nid),
              data: dataForm,
              dataType: 'json',
              success: function(response) {
                    if(response.status == 200) {
                        alert(response.pesan);
                        window.location.href = "{{ route('whm.index') }}";
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
