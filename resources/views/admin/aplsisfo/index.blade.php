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
                            <th>HW</th>
                            <th>Nama Aplikasi</th>
                            <th>IP Address</th>
                            <th>Nama Domain</th>    
                            <th>Thn P'ada</th> 
                            <th>Tgl Aktif</th> 
                            <th>Status</th> 
                            <th>Kotama</th>
                            <th>Satuan</th> 
                            <th>Bin LKT</th>   
                            <th>Layanan Jaringan</th>    
                            <th>Fungsi</th>   
                            <th>Mitra</th>
                            {{-- <th>Jml HW</th>              --}}
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataapl as $item)
                            <tr data-idapl="{{ $item->id_apl }}">
                                <td>{{ $loop->iteration }}</td>
                                <td class="details-control"><i class="fa fa-plus"></i>  {{ $item->jml }}</td>
                                <td>{{ $item->nama_apl }}</td>
                                <td>{{ $item->ip_add }}</td>
                                <td>{{ $item->nm_dom }}</td>
                                <td>{{ $item->thn_ada }}</td> 
                                <td>{{ date('d-m-Y', strtotime( $item->tgl_aktif )) }}</td>
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
                                <td>{{ $item->ur_ktm }}</td>
                                <td>{{ $item->ur_smkl }}</td>     
                                <td>{{ $item->lkt }}</td>
                                <td>{{ $item->jaringan }}</td>   
                                <td>{{ $item->fungsi }}</td>
                                <td>{{ $item->nama_mitra }}</td>  
                                {{-- <td></td>                  --}}
                                <td>{{ $item->keterangan }}</td>
                                <td class="text-right">
                                  <div class="btn-group">
                                    <a href="javascript:void(0)" id="showDetail" data-url="{{ route('aplsisfo.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-detail" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                    &nbsp;
                                    <a href="javascript:void(0)" id="showUpdate" data-url="{{ route('aplsisfo.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-update" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></a>
                                    &nbsp;
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('aplsisfo.destroy', $item->id) }}" method="POST">
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
                            <label for="id_apl">ID Apl/Sisfo</label>
                            <input type="text" class="form-control" name="id_apl" id="id_apl" required>
                            <label for="nama_apl">Nama Apl/Sisfo</label>
                            <input type="text" id="nama_apl" name="nama_apl" class="form-control" required>
                            <div class="form-group">
                                <div class="row">                                    
                                    <div class="col-md-6">
                                      <label for="ip_add">IP Address</label>
                                      <input type="text" id="ip_add" name="ip_add" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" style="width: 100%;">
                                            <option value="E" selected="selected">Error</option>
                                            <option value="R">Running</option>
                                            <option value="M">Maintenance</option>
                                            <option value="S">Suspended</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <label for="nm_dom">Nama Domain</label>
                            <input type="text" id="nm_dom" name="nm_dom" class="form-control">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                      <label for="thn_ada">Thn Pengadaan</label>
                                      {{-- <select id="thn_ada" name="thn_ada" class="form-control"></select> --}}
                                      <input type="number" class="form-control @error('thn_ada') is-invalid @enderror" id="thn_ada" name="thn_ada" min="1999" max="2030" step="1" value="{{ old('thn_ada') }}" placeholder="1999" required>
                                    {{-- <input type="text" class="form-control id="thn_ada" name="thn_ada" required> --}}
                                      @error('thn_ada')
                                        <div class="invalid-feedback">
                                                {{ $message }}
                                        </div>
                                       @enderror
                                    </div>
                                    <div class="col-md-6">
                                      <label for="tgl_aktif">Tanggal Aktif</label>
                                      <input type="date" class="form-control @error('tgl_aktif') is-invalid @enderror" id="tgl_aktif" name="tgl_aktif" data-date-format="dd/mm/yyyy" value="{{ old('tgl_aktif') }}" required>
                                    
                                      @error('tgl_aktif')
                                        <div class="invalid-feedback">
                                                {{ $message }}
                                        </div>
                                       @enderror
                                    </div>
                                </div>
                            </div>
                            <label for="fungsi">Peruntukan</label>
                            <input type="text" id="fungsi" name="fungsi" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
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
                            <label for="lkt">Bin LKT</label>
                            <input type="text" id="lkt" name="lkt" class="form-control">
                            <label for="jaringan">Layanan Jarkomta</label>
                            <input type="text" id="jaringan" name="jaringan" class="form-control" required>
                            <label for="id_mitra">Mitra/Pengembang</label>
                            <select class="form-control select2" id="id_mitra" name="id_mitra">
                                <option value="" selected="selected"></option>
                                @foreach ($mitra as $mit)
                                <option value="{{$mit->id_mitra}}">{{$mit->nama_mitra}}</option>2
                                @endforeach
                            </select> 
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
          <form id="form-detail" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"> 
                            <label for="id_apl">ID Apl/Sisfo</label>
                            <input type="text" class="form-control" name="id_apl" id="id_apl" disabled>
                            <label for="nama_apl">Nama Apl/Sisfo</label>
                            <input type="text" id="nama_apl" name="nama_apl" class="form-control" disabled>
                            <div class="form-group">
                                <div class="row">                                    
                                    <div class="col-md-6">
                                      <label for="ip_add">IP Address</label>
                                      <input type="text" id="ip_add" name="ip_add" class="form-control" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status">Status</label>
                                        <input type="text" id="status" name="status" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>
                            <label for="nm_dom">Nama Domain</label>
                            <input type="text" id="nm_dom" name="nm_dom" class="form-control" disabled>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                      <label for="thn_ada">Thn Pengadaan</label>
                                      <input type="number" class="form-control" name="thn_ada" id="thn_ada" disabled>
                                    </div>
                                    <div class="col-md-6">
                                      <label for="tgl_aktif">Tanggal Aktif</label>
                                      <input type="text" class="form-control" id="tgl_aktif" name="tgl_aktif" disabled>
                                    </div>
                                </div>
                            </div>
                            <label for="fungsi">Peruntukan</label>
                            <input type="text" id="fungsi" name="fungsi" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="kotama">Kotama</label>
                            <input type="text" id="kotama" name="kotama" class="form-control" disabled>
                            <label for="satuan">Satuan</label>
                            <input type="text" id="satuan" name="satuan" class="form-control" disabled>
                            <label for="lkt">Bin LKT</label>
                            <input type="text" id="lkt" name="lkt" class="form-control" disabled>
                            <label for="jaringan">Layanan Jarkomta</label>
                            <input type="text" id="jaringan" name="jaringan" class="form-control" disabled>
                            <label for="id_mitra">Mitra/Pengembang</label>
                            <input type="text" id="nama_mitra" name="nama_mitra" class="form-control" disabled> 
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
          <form id="form-update-aplsisfo" method="PUT">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group"> 
                      <input type="hidden" value="" name="id" id="id" />
                      <label for="id_apl">ID Apl/Sisfo</label>
                      <input type="text" class="form-control" name="id_apl" id="id_apl" required>
                      <label for="nama_apl">Nama Apl/Sisfo</label>
                      <input type="text" id="nama_apl" name="nama_apl" class="form-control" required>
                      <div class="form-group">
                        <div class="row">                                    
                          <div class="col-md-6">
                            <label for="ip_add">IP Address</label>
                            <input type="text" id="ip_add" name="ip_add" class="form-control" required>
                          </div>
                          <div class="col-md-6">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" style="width: 100%;">
                              <option value="E" selected="selected">Error</option>
                              <option value="R">Running</option>
                              <option value="M">Maintenance</option>
                              <option value="S">Suspended</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <label for="nm_dom">Nama Domain</label>
                      <input type="text" id="nm_dom" name="nm_dom" class="form-control">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-6">
                            <label for="thn_ada">Thn Pengadaan</label>
                              <input type="number" class="form-control @error('thn_ada') is-invalid @enderror" id="thn_ada" name="thn_ada" min="1999" max="2030" step="1" value="{{ old('thn_ada') }}" placeholder="1999" required>
                                    {{-- <input type="text" class="form-control id="thn_ada" name="thn_ada" required> --}}
                                      @error('thn_ada')
                                        <div class="invalid-feedback">
                                                {{ $message }}
                                        </div>
                                       @enderror
                            </div>
                            <div class="col-md-6">
                              <label for="tgl_aktif">Tanggal Aktif</label>
                              <input type="date" class="form-control @error('tgl_aktif') is-invalid @enderror" id="tgl_aktif" name="tgl_aktif" data-date-format="dd/mm/yyyy" value="{{ old('tgl_aktif') }}" required>
                                    
                                      @error('tgl_aktif')
                                        <div class="invalid-feedback">
                                                {{ $message }}
                                        </div>
                                       @enderror
                            </div>
                          </div>
                        </div>
                        <label for="fungsi">Peruntukan</label>
                        <input type="text" id="fungsi" name="fungsi" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-0">
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
                      <label for="lkt">Bin LKT</label>
                      <input type="text" id="lkt" name="lkt" class="form-control">
                      <label for="jaringan">Layanan Jarkomta</label>
                      <input type="text" id="jaringan" name="jaringan" class="form-control" required>
                      <label for="id_mitra">Mitra/Pengembang</label>
                      <select class="form-control select2" id="id_mitra" name="id_mitra">
                        <option value="" selected="selected"></option>
                                @foreach ($mitra as $mit)
                        <option value="{{$mit->id_mitra}}">{{$mit->nama_mitra}}</option>2
                                @endforeach
                      </select> 
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

<script type="text/javascript">
    // $(function () {
    //   $("#example1").DataTable({
    //     "responsive": true, "lengthChange": false, "autoWidth": false, "dom": 'Bfrtip',
    //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    //     "columnDefs": [{ "visible": false, "targets": [ 4, 8, 9, 11, 12, 14] }]
    //   }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    // });
</script>

<script>
function formatChild(id_apl) {
    // Data perangkat dari PHP (Blade ke JS)
    var perangkat = @json($perangkat);

    var rows = '';
    if (perangkat[id_apl]) {
        perangkat[id_apl].forEach(function(item, idx) {
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
                    <td>${item.namaRak}</td>
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
                    <th>Posisi Rak</th>
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
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        columnDefs: [
        { "visible": false, "targets": [4, 5, 8, 10, 11, 12, 15] }
      ]
    });

    $('#example1 tbody').on('click', 'td.details-control', function () {
        var tr      = $(this).closest('tr');
        var row     = table.row(tr);
        var id_apl = tr.data('idapl');
        var icon    = $(this).find('i');

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            icon.removeClass('fa-minus').addClass('fa-plus');
        } else {
            row.child(formatChild(id_apl)).show();
            tr.addClass('shown');
            icon.removeClass('fa-plus').addClass('fa-minus');
        }
    });
});
</script>

<script type="text/javascript">
  // let thnmulai = 2000;
  // let thnakhir = new Date().getFullYear();
  // for (i=thnakhir; i > thnmulai; i--)
  // {
  //   $('#modal-tambah #thn_ada').append(('<option/>').val(i).html(i));
  // }
  $(document).ready(function() {
    $("#modal-tambah #thn_ada").datepicker({
      formmat: "yyyy",
      viewMode: "years",
      minViewMode: "years",
      auticlose: true
    });
  });
</script>
<script>
$(document).ready(function() {
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
});

$(document).ready(function() {
    // $('#modal-tambah').on('shown.bs.modal', function () {
    //     $('#modal-tambah .select2').select2('destroy').select2({
    //         theme: 'bootstrap4',
    //         dropdownParent: $('#modal-tambah')
    //     });
    // });
    // $('#modal-update').on('shown.bs.modal', function () {
    //     $('#modal-update .select2').select2('destroy').select2({
    //         theme: 'bootstrap4',
    //         dropdownParent: $('#modal-update')
    //     });
    // });
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
          window.location.href = "{{ route('aplsisfo.index') }}"; // Redirect setelah OK ditekan
      });
  @endif
</script>
<script>
  
    $(document).on('click', '#showDetail', function(){
      let id = $(this).data('id');
      var editURL = $(this).data('url');
      // alert(editURL);
      $.get(editURL, function(data){
          const tglakt = data[0]['tgl_aktif'];
          var options = { year: "numeric", month: "numeric", day: "numeric" };
          const ftglaktif = new Date(tglakt).toLocaleDateString('es-CL', options);
            console.log(data);
            $('#modal-detail').modal('show');
            $('#modal-detail #id').val(data[0]['id']);
            $('#modal-detail #id_apl').val(data[0]['id_apl']);
            $('#modal-detail #nama_apl').val(data[0]['nama_apl']);
            $('#modal-detail #ip_add').val(data[0]['ip_add']);  
            $('#modal-detail #nm_dom').val(data[0]['nm_dom']);
            $('#modal-detail #status').val(data[0]['status'] == 'E' ? 'Error' : data[0]['status'] == 'R' ? 'Running' : data[0]['status'] == 'M' ? 'Maintenance' : data[0]['status'] == 'S' ? 'Suspend' : 'Unknown');         
            $('#modal-detail #thn_ada').val(data[0]['thn_ada']);
            $('#modal-detail #tgl_aktif').val(ftglaktif);
            $('#modal-detail #kotama').val(data[0]['ur_ktm']);
            $('#modal-detail #satuan').val(data[0]['ur_smkl']);
            $('#modal-detail #lkt').val(data[0]['lkt']);
            $('#modal-detail #jaringan').val(data[0]['jaringan']);
            $('#modal-detail #fungsi').val(data[0]['fungsi']);
            $('#modal-detail #nama_mitra').val(data[0]['nama_mitra']);
            $('#modal-detail #keterangan').val(data[0]['keterangan']);
        })
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
              url: "{{ route('aplsisfo.store') }}",
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
                            window.location.href = "{{ route('aplsisfo.index') }}"; // Redirect setelah OK ditekan
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
          $('#id_apl').val('');
          $('#nama_apl').val('');
          $('#ip_add').val('');
          $('#status').val('');
          $('#nm_dom').val('');
          $('#thn_ada').val('');
          $('#tgl_aktif').val('');
          $('#kotama').val('');
          $('#satuan').val('');
          $('#lkt').val('');
          $('#jaringan').val('');
          $('#fungsi').val('');
          $('#id_mitra').val('');
          $('#keterangan').val('');
      });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('click', '#showUpdate', function(){
        var editURL = $(this).data('url');
      
      $.get(editURL, function(data){         
            console.log(data);
            $('#modal-update').modal('show');
            $('#modal-update #id').val(data[0].id);
            $('#modal-update #id_apl').val(data[0].id_apl);
            $('#modal-update #nama_apl').val(data[0].nama_apl);
            $('#modal-update #nm_dom').val(data[0].nm_dom);
            $('#modal-update #ip_add').val(data[0].ip_add);  
            $('#modal-update #status').val(data[0].status);         
            $('#modal-update #thn_ada').val(data[0].thn_ada);
            $('#modal-update #tgl_aktif').val(data[0].tgl_aktif);
            $('#modal-update #kotama').val(data[0].kd_ktm);
            $('#modal-update #satuan').val(data[0].kd_smkl).trigger('change');
            $('#modal-update #lkt').val(data[0].lkt);
            $('#modal-update #jaringan').val(data[0].jaringan);
            $('#modal-update #fungsi').val(data[0].fungsi);
            $('#modal-update #id_mitra').val(data[0].id_mitra);
            $('#modal-update #keterangan').val(data[0].keterangan);
            $('#modal-update #dataTemp').val(JSON.stringify(data));
        })
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#form-update-aplsisfo').on('click', '#simpanEdit', function(e){
          e.preventDefault();
          var nid = $('#form-update-aplsisfo #id').val();
          dataForm = $('#form-update-aplsisfo').serialize() + "&_token={{ csrf_token() }}";
          console.log(dataForm);    
          $.ajax({
              type: 'PUT',
              url: "{{ route('aplsisfo.update', ':id') }}".replace(':id', nid),
              data: dataForm,
              dataType: 'json',
              success: function(response) {
                    if(response.status == 200) {
                        alert(response.pesan);
                        window.location.href = "{{ route('aplsisfo.index') }}";
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
        // $('#modal-update #nama_domain').val(myObject['nama_domain']);
        // $('#modal-update #hosting').val(myObject['hosting']);
        // $("#modal-update #framework").val(myObject['framework']);  
        // $('#modal-update #status').val(myObject['status']);          
        // $('#modal-update #id_whm').val(myObject['id_whm']);
        // $("#modal-update #tgl_aktif").val(myObject['tgl_aktif']);
        // $('#modal-update #kotama').val(myObject['kd_ktm']);
        // $('#modal-update #satuan').val(myObject['kd_smkl']);
        // $('#modal-update #keterangan').val(myObject['keterangan']);
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
