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
    td.details-control .btn-expand {
      padding: 0;
      border: none;
      background: none;
      font-size: 1.2em;
    }
    .column-deskripsi {
      width: 40%;      /* Atur lebar sesuai kebutuhan */
      max-width: 50%;  /* Batasi lebar maksimal */
      white-space: wrap;
      overflow: hidden;
      text-overflow: ellipsis;
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
                <button type="button" class="btn btn-sm btn-primary float-sm-right" data-toggle="modal" data-target="#modal-tambah-parent"><i class="fa fa-plus"></i> Tambah </button>
            </div>
            <div class="card-body">
                {{-- @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif --}}
                <table id="parentTable" class="table table-bordered table-striped">
                  <thead>
                      <tr>
                          <th>#</th> <!-- Kolom expand/collapse -->
                          <th>No</th>
                          <th>Jenis Rak</th>
                          <th class="column-deskripsi">Keterangan</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($jenisRak as $jenis)
                      <tr data-id="{{ $jenis->kdjenis }}">
                          <td class="details-control text-center">
                            <button class="btn btn-link btn-expand">
                              <i class="fas fa-chevron-down"></i>
                            </button>
                          </td>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $jenis->namaJenis }}</td>
                          <td class="column-deskripsi">{{ $jenis->deskripsi }}</td>
                          <td>
                            <div class="btn-group">
                                <a href="javascript:void(0)" id="showDetail" data-url="{{ route('modelrak.getJenis', $jenis->kdjenis) }}" data-bs-toggle="modal" data-bs-target="#modal-detail-parent" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                &nbsp;
                                <a href="javascript:void(0)" id="viewMessage" data-url="{{ route('modelrak.getJenis', $jenis->kdjenis) }}" data-bs-toggle="modal" data-bs-target="#modal-update-parent" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></a>
                                &nbsp;
                                <form id="delete-form-{{ $jenis->id }}" action="{{ route('modelrak.destroy', $jenis->id) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $jenis->id }})"><i class="fas fa-trash" value="Hapus Item"></i></button>
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

 <!-- /.modal tambah data parent-->
  <div class="modal fade" id="modal-tambah-parent" tabindex="-1" data-focus="false" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-create-parent" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"> 
                            <div class="form-group">
                              <div class="row">
                                  <div class="col-md-6">
                                    <label for="kdjenis">Jenis Rak</label>
                                    <input type="text" class="form-control" name="kdjenis" id="kdjenis" required>
                                  </div>
                              </div>
                                <label for="namaJenis">Nama Jenis</label>
                                <input type="text" id="namaJenis" name="namaJenis" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
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

  <!-- /.modal-detail -->
  <div class="modal fade" id="modal-detail-parent" tabindex="-1" data-focus="false" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-detail-parent" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"> 
                            <div class="form-group">
                              <div class="row">
                                  <div class="col-md-6">
                                    <label for="kdjenis">Kode Jenis</label>
                                    <input type="text" class="form-control" name="kdjenis" id="kdjenis" readonly>
                                  </div>
                              </div>
                                <label for="namaJenis">Nama Jenis</label>
                                <input type="text" class="form-control" name="namaJenis" id="namaJenis" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
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

  <!-- /.modal update data parent -->
  <div class="modal fade" id="modal-update-parent" tabindex="-1" data-focus="false"  role="dialog" >
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
          <form id="form-update-parent" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"> 
                            <div class="form-group">
                              <div class="row">
                                  <div class="col-md-6">
                                    <label for="kdjenis">Jenis Rak</label>
                                    <input type="text" class="form-control" name="kdjenis" id="kdjenis" readonly>
                                  </div>
                              </div>
                                <label for="namaJenis">Nama Jenis</label>
                                <input type="text" id="namaJenis" name="namaJenis" class="form-control" required>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-3" >
                    <button type="submit" class="btn btn-outline-light float-sm-right"><i class="fas fa-save"></i> Simpan</button>
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

  <!-- /.modal tambah data child-->
  <div class="modal fade" id="modal-tambah-child" tabindex="-1" data-focus="false" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-create-child" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"> 
                            <div class="form-group">
                              <div class="row">
                                  <div class="col-md-6">
                                    <label for="kdjenis">Jenis Rak</label>
                                    <select class="form-control select2" style="width: 100%;" id="kdjenis" name="kdjenis" >
                                        <option value="">-- Pilih Jenis --</option>
                                        @foreach ($jenisRak as $jenis)
                                        <option value="{{$jenis->kdjenis}}">
                                          {{$jenis->namaJenis}}
                                        </option>
                                        @endforeach
                                    </select>
                                  </div>
                                  <div class="col-md-6">
                                    <label for="kdmodel">Kode Model</label>
                                    <input type="text" class="form-control" name="kdmodel" id="kdmodel" oninput="this.value = this.value.toUpperCase()" required>
                                  </div>
                              </div>
                                <label for="namaModel">Nama Model</label>
                                <input type="text" id="namaModel" name="namaModel" class="form-control" required>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
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

  <!-- /.modal-detail -->
  <div class="modal fade" id="modal-detail-child" tabindex="-1" data-focus="false" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-create-child" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"> 
                            <div class="form-group">
                              <div class="row">
                                  <div class="col-md-6">
                                    <label for="kdjenis">Jenis Rak</label>
                                    <input type="text" class="form-control" name="kdjenis" id="kdjenis" readonly>
                                  </div>
                                  <div class="col-md-6">
                                    <label for="kdmodel">Kode Model</label>
                                    <input type="text" class="form-control" name="kdmodel" id="kdmodel" readonly>
                                  </div>
                              </div>
                                <label for="namaModel">Nama Model</label>
                                <input type="text" id="namaModel" name="namaModel" class="form-control" readonly>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"></textarea>
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
  <div class="modal fade" id="modal-update-child" tabindex="-1" data-focus="false"  role="dialog" >
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
          <form id="form-update-child" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"> 
                            <div class="form-group">
                              <div class="row">
                                  <div class="col-md-6">
                                    <label for="kdjenis">Jenis Rak</label>
                                    <select class="form-control select2" style="width: 100%;" id="kdjenis" name="kdjenis" >
                                        <option value="">-- Pilih Jenis --</option>
                                        @foreach ($jenisRak as $jenis)
                                        <option value="{{$jenis->kdjenis}}">
                                          {{$jenis->namaJenis}}
                                        </option>
                                        @endforeach
                                    </select>
                                  </div>
                                  <div class="col-md-6">
                                    <label for="kdmodel">Kode Model</label>
                                    <input type="text" class="form-control" name="kdmodel" id="kdmodel" readonly>
                                  </div>
                              </div>
                                <label for="namaModel">Nama Model</label>
                                <input type="text" id="namaModel" name="namaModel" class="form-control" required>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-3" >
                    <button type="submit" class="btn btn-outline-light float-sm-right"><i class="fas fa-save"></i> Simpan</button>
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
function formatChild(kdjenis) {
    // Data child dari PHP ke JS
    var modelRak = @json($modelRak); // $modelRak = tbmodelraks::all()->groupBy('kdjenis')
    var rows = '';
    if (modelRak[kdjenis]) {
        modelRak[kdjenis].forEach(function(item, idx) {
            rows += `
                <tr>
                    <td>${idx+1}</td>
                    <td>${item.kdmodel}</td>
                    <td>${item.namaModel}</td>
                    <td class="column-deskripsi">${item.deskripsi}</td>
                    <td>
                        <button class="btn btn-sm btn-info btn-update-child" data-id="${item.kdmodel}">Update</button>
                        <button class="btn btn-sm btn-danger btn-hapus-child" data-id="${item.kdmodel}">Hapus</button>
                    </td>
                </tr>
            `;
        });
    } else {
        rows = `<tr><td colspan="5" class="text-center">Belum ada model rak</td></tr>`;
    }
    return `
    <button class="btn btn-sm btn-primary btn-tambah-child" data-parent-id="${kdjenis}">Tambah Model Rak</button>
        <table class="table table-sm table-bordered mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Model</th>
                    <th>Nama Model</th>
                    <th class="column-deskripsi">Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                ${rows}
            </tbody>
        </table>        
    `;
}

$(document).ready(function() {
    var table = $('#parentTable').DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        dom: 'Bfrtip',
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        columnDefs: [
          { width: "50%", targets: 3 } // Kolom ke-4 (index mulai dari 0)
        ]
    });

    $('#parentTable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var kdjenis = tr.data('id');
        var icon = $(this).find('i');

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        } else {
            row.child(formatChild(kdjenis)).show();
            tr.addClass('shown');
            icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        }
    });

    // Event tombol tambah, update, hapus parent dan child
    $('body').on('click', '.btn-tambah-parent', function() {
        var id = $(this).data('id');
        // Tampilkan modal tambah parent
        $('#modal-tambah-parent').modal('show');
        $('#modal-tambah-parent #kdjenis').val(id);
    });

    $('body').on('click', '.btn-update-parent', function() {
        var id = $(this).data('id');
        // Tampilkan modal update parent
        $('#modal-update-parent').modal('show');
        // AJAX get data by id, isi form/modal
    });

    $('body').on('click', '.btn-hapus-parent', function() {
        var id = $(this).data('id');
        // Konfirmasi hapus, lalu AJAX delete
        confirmDeleteParent(id);
    });

    $('body').on('click', '.btn-tambah-child', function() {
        var parentId = $(this).data('parent-id');
        // Tampilkan modal tambah child
        $('#modal-tambah-child').modal('show');
        $('#modal-tambah-child #kdjenis').val(parentId);
    });

    $('body').on('click', '.btn-update-child', function() {
        var id = $(this).data('id');
        // Tampilkan modal update child
        $('#modal-update-child').modal('show');
        // AJAX get data by id, isi form/modal
    });

    $('body').on('click', '.btn-hapus-child', function() {
        var id = $(this).data('id');
        // Konfirmasi hapus, lalu AJAX delete
        confirmDeleteChild(id);
    });
});
</script>
<script>
    $('#modal-tambah-child').on('shown.bs.modal', function() {  
        $('#modal-tambah .select2').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#modal-tambah')
        });
    });

    $('#modal-update-child').on('shown.bs.modal', function () {
        $('#modal-update .select2').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#modal-update')
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#modal-tambah-child #kdjenis').change(function () {
            var kdjen = $(this).val();
            if (kdjen) {
                $.ajax({
                    url: '/get-model/' + kdjen,
                    type: "GET",
                    data: { kdjenis: kdjen },
                    success: function (data) {
                        // console.log(data);
                        $('#modal-tambah-child #kdmodel').empty();
                        $('#modal-tambah-child #kdmodel').append('<option value="">Pilih Model</option>');
                        $.each(data, function (key, value) {
                            $('#modal-tambah-child #kdmodel').append('<option value="' + value.kdmodel + '">' + value.namaModel + '</option>');
                        });
                    }
                });
            } else {
                $('#modal-tambah-child #kdmodel').empty();
                $('#modal-tambah-child #kdmodel').append('<option value="">Pilih Model</option>');
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#modal-update-child #kdjenis').change(function () {
            var kdjen = $(this).val();
            if (kdjen) {
                $.ajax({
                    url: '/get-model/' + kdjen,
                    type: "GET",
                    data: { kdjenis: kdjen },
                    success: function (data) {
                        // console.log(data);
                        $('#modal-update-child #kdmodel').empty();
                        $('#modal-update-child #kdmodel').append('<option value="">Pilih Model</option>');
                        $.each(data, function (key, value) {
                            $('#modal-update-child #kdmodel').append('<option value="' + value.kdmodel + '">' + value.namaModel + '</option>');
                        });
                    }
                });
            } else {
                $('#modal-update-child #kdmodel').empty();
                $('#modal-update-child #kdmodel').append('<option value="">Pilih Model</option>');
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

<script type="text/javascript">
  $(document).ready(function() {
      $('#modal-tambah-parent #form-create-parent').submit(function(e) {
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
        $('#modal-tambah-parent #kdjenis').val('');
        $('#modal-tambah-parent #namaJenis').val('');
        $('#modal-tambah-parent #deskripsi').val('');
      });
  });

  $(document).ready(function(){
    $('body').on('click', '#showDetail', function(){
        var editURL = $(this).data('url');
        // alert(editURL);
        $.get(editURL, function(data){
            console.log(data);
            $('#modal-detail-parent').modal('show');
            $('#modal-detail-parent #id').val(data.id);            
            $('#modal-detail-parent #kdjenis').val(data.kdjenis);
            $('#modal-detail-parent #namaJenis').val(data.namaJenis);
            $('#modal-detail-parent #deskripsi').val(data.deskripsi);
        })
    });
  });

  $(document).ready(function(){
    $('body').on('click', '#viewMessage', function(){
        var editURL = $(this).data('url');
        // alert(editURL);
        $.get(editURL, function(data){
            console.log(data);
            $('#modal-update-parent').modal('show');
            $('#modal-update-parent #id').val(data.id);            
            $('#modal-update-parent #kdjenis').val(data.kdjenis);
            $('#modal-update-parent #namaJenis').val(data.namaJenis);
            $('#modal-update-parent #deskripsi').val(data.deskripsi);
        })
    });
  });

  $(document).ready(function() {
      $('#modal-update-parent #form-create-parent').submit(function(e) {
          e.preventDefault();
          dataForm = $(this).serialize() + "&_token={{ csrf_token() }}";  
          // alert(dataForm);
          $.ajax({
              type: 'POST',
              url: "{{ route('modelrak.store') }}",
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
                            window.location.href = "{{ route('modelrak.index') }}"; // Redirect setelah OK ditekan
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

      $('#modal-update-parent #btnBatal').click(function() {
      var myObject = JSON.parse( $('#modal-update-parent #dataTemp').val());
        $('#modal-update-parent').modal('show');
        $('#modal-update-parent #id').val(myObject['id']);
        $('#modal-update-parent #kdjenis').val(myObject['kdjenis']);
        $('#modal-update-parent #namaJenis').val(myObject['namaJenis']);
        $('#modal-update-parent #deskripsi').val(myObject['deskripsi']);
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
      $('#modal-tambah-child #form-create-child').submit(function(e) {
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
        $('#modal-tambah-child #kdjenis').val('');
        $('#modal-tambah-child #kdmodel').val('');
        $('#modal-tambah-child #namaModel').val('');
        $('#modal-tambah-child #deskripsi').val('');
      });
  });

  $(document).ready(function(){
    $('body').on('click', '#modal-detail-child #showDetail', function(){
        var editURL = $(this).data('url');
        $.get(editURL, function(data){
            console.log(data);
            $('#modal-detail-child').modal('show');
            $('#modal-detail-child #id').val(data[0].id);
            $('#modal-detail-child #kdjenis').val(data[0].kdjenis);
            $('#modal-detail-child #kdmodel').val(data[0].kdmodel);
            $('#modal-detail-child #namaModel').val(data[0].namaModel);
            $('#modal-detail-child #deskripsi').val(data[0].deskripsi);
        })
    });
  });

  $(document).ready(function(){
    $('#form-update-child').on('click', '#modal-detail-child #simpanEdit', function(e){
          e.preventDefault();
          var nid = $('#form-update-child #id').val();
          dataForm = $('#form-update-child').serialize() + "&_token={{ csrf_token() }}";
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

    $('#modal-update-child #btnBatal').click(function() {
      var myObject = JSON.parse( $('#modal-update-child #dataTemp').val());
        $('#modal-update-child').modal('show');
        $('#modal-update-child #id').val(myObject['id']);
        $('#modal-update-child #kdjenis').val(myObject['kdjenis']);
        $('#modal-update-child #kdmodel').val(myObject['kdmodel']);
        $('#modal-update-child #namaModel').val(myObject['namaModel']);
        $('#modal-update-child #deskripsi').val(myObject['deskripsi']);
    });
  });
  
</script>

@endsection
