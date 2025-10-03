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
                            <th>Serial Number</th>
                            <th>Merk</th>
                            <th>Model</th>
                            <th>Kapasitas</th>  
                            <th>Storage</th>
                            <th>Jenis</th>    
                            <th>Posisi Rak</th> 
                            <th>Ip Address</th>
                            <th>Tgl Aktif</th> 
                            <th>Kondisi</th>
                            <th>Sistem Operasi</th>
                            <th>Peruntukan</th>
                            <th>Kotama</th>
                            <th>Satuan</th>
                            <th>Status</th>
                            <th>Mitra</th>  
                            <th>Apl/Sisfo</th>                         
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alat as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->serialNumber }}</td>
                                <td>{{ $item->merk }}</td>
                                <td>{{ $item->model }}</td>
                                <td>{{ $item->kapasitas }}</td>
                                <td>{{ $item->storage }}</td>
                                <td>{{ $item->nama_jns }}</td>
                                <td>{{ $item->namaRak }}</td>
                                <td>{{ $item->ip_address }}</td>                                
                                <td>{{ date('d-m-Y', strtotime( $item->tgl_aktif )) }}</td>
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
                                <td>{{ $item->sistemOperasi }}</td>
                                <td>{{ $item->peruntukan }}</td>
                                <td>{{ $item->ur_ktm }}</td>
                                <td>{{ $item->ur_smkl }}</td>
                                <td>
                                    @if ( $item->status == 'A' )
                                        <span class="badge badge-primary"> Aktif </span>
                                    @endif
                                    @if (  $item->status == 'N' )
                                        <span class="badge badge-danger"> Non Aktif </span>
                                    @endif
                                </td>
                                <td>{{ $item->nama_mitra }}</td>  
                                <td>{{ $item->nama_apl }}</td>                           
                                <td>{{ $item->keterangan }}</td>
                                <td class="text-right">
                                  <div class="btn-group">
                                    <a href="javascript:void(0)" id="showDetail" data-url="{{ route('perangkat.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-detail" class="btn btn-sm  btn-primary"><i class="fas fa-eye"></i></button>
                                    &nbsp;
                                    <a href="javascript:void(0)" id="viewMessage" data-url="{{ route('perangkat.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-update" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></a>
                                    &nbsp;
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('perangkat.destroy', $item->id) }}" method="POST">
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
          <form id="form-create-perangkat" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">  
                            <label for="serialNumber">Serial Number</label>
                            <input type="text" class="form-control" name="serialNumber" id="serialNumber" required>
                            <label for="merk">Merk</label>
                            <input type="text" id="merk" name="merk" class="form-control" required>
                            <div class="form-group mb-1">
                                <div class="row">
                                  <div class="col-md-6">
                                      <label for="kapasitas">Kapasitas</label>
                                      <input type="text" id="kapasitas" name="kapasitas" class="form-control" required>
                                  </div>
                                  <div class="col-md-6">
                                      <label for="kapasitas">Storage</label>
                                      <input type="text" id="storage" name="storage" class="form-control" required>
                                  </div>                                    
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <div class="row">
                                    <div class="col-md-6">
                                      <label for="model">Model</label>
                                      <input type="text" id="model" name="model" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                      <label for="kodeRak">Posisi Rak</label>
                                      <select class="form-control select2" style="width: 100%;" id="kodeRak" name="kodeRak" >
                                        <option value="">-- Pilih Posisi --</option>
                                            @foreach ($datarak as $rak)
                                        <option value="{{$rak->kodeRak}}">
                                            {{$rak->namaRak}}
                                        </option>
                                            @endforeach
                                      </select>
                                    </div>                                
                                </div>
                            </div>
                            <label for="kodeRak">Jenis HW</label>
                            <select class="form-control select2" style="width: 100%;" id="kode_jns" name="kode_jns" >
                              <option value="">-- Pilih Jenis --</option>
                                @foreach ($jenis as $jns)
                              <option value="{{$jns->kode_jns}}">
                                {{$jns->nama_jns}}
                              </option>
                                @endforeach
                            </select>                            
                            <div class="form-group mt-1 mb-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="ip_address" class="form-label">IP Address</label>
                                        <input type="text" class="form-control" name="ip_address" id="ip_address" minlength="7" maxlength="15" size="15" pattern="^(?>(\d|[1-9]\d{2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?1)$" placeholder="000.000.000.000" required>
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
                                    <label for="sistemOperasi">Sistem Operasi</label>
                                    <input type="text" id="sistemOperasi" name="sistemOperasi" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" style="width: 100%;">
                                        <option value="A" selected="selected">Aktif</option>
                                        <option value="N">Non Aktif</option>
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-md-6"> --}}
                                    <label for="kotama">Kotama</label>
                                    <select class="form-control select2" id="kotama" name="kotama">
                                        <option value="" selected="selected"></option>
                                        @foreach ($kotama as $kot)
                                        <option value="{{$kot->kd_ktm}}">
                                            {{$kot->ur_ktm}}
                                        </option>
                                        @endforeach
                                        {{-- @foreach($kotama as $kot)
                                            <option value="{{ $kot->kd_ktm }}">{{ $kot->ur_ktm }}</option>
                                        @endforeach --}}
                                    </select>
                                {{-- </div>
                                <div class="col-md-6"> --}}
                                    <label for="satuan">Satuan</label>
                                    <select class="form-control select2" id="satuan" name="satuan">
                                        <option value="" selected="selected"></option>
                                        @foreach ($satuan as $sat)
                                        <option value="{{$sat->idsmkl}}">
                                            {{$sat->ur_smkl}}
                                        </option>
                                        @endforeach
                                    </select>
                                {{-- </div>
                            </div> --}}
                            <label for="peruntukan">Peruntukan</label>
                            <textarea class="form-control" id="peruntukan" name="peruntukan" rows="2"></textarea>   
                            <label for="id_mitra">Mitra</label>
                            <select class="form-control select2" style="width: 100%;" id="id_mitra" name="id_mitra" >
                              <option value="">-- Pilih Mitra --</option>
                              @foreach ($mitra as $mtr)
                                <option value="{{$mtr->id_mitra}}">{{$mtr->nama_mitra}}</option>
                              @endforeach
                            </select>     
                            <label for="id_apl">Apl/Sisfo</label>
                            <select class="form-control select2" style="width: 100%;" id="id_apl" name="id_apl" >
                              <option value="">-- Pilih Apl/Sisfo --</option>
                              @foreach ($aplsisfo as $sis)
                                <option value="{{$sis->id_apl}}">{{$sis->nama_apl}}</option>
                              @endforeach
                            </select>          
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
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

  <!-- /.modal detail data -->
  <div class="modal fade" id="modal-detail" tabindex="-1" data-focus="false" role="dialog" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-detail-perangkat" method="PUT">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">  
                            <label for="serialNumber">Serial Number</label>
                            <input type="text" class="form-control" name="serialNumber" id="serialNumber" readonly>
                            <label for="merk">Merk</label>
                            <input type="text" id="merk" name="merk" class="form-control" disabled>
                            <div class="form-group mb-1">
                                <div class="row">
                                  <div class="col-md-6">
                                      <label for="kapasitas">Kapasitas</label>
                                      <input type="text" id="kapasitas" name="kapasitas" class="form-control" disabled>
                                  </div>
                                  <div class="col-md-6">
                                      <label for="kapasitas">Storage</label>
                                      <input type="text" id="storage" name="storage" class="form-control" disabled>
                                  </div>                                    
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="model">Model</label>
                                      <input type="text" id="model" name="model" class="form-control" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="kodeRak">Posisi Rak</label>
                                        <select class="form-control select2" style="width: 100%;" id="kodeRak" name="kodeRak" disabled>
                                        <option value="">-- Pilih Posisi --</option>
                                            @foreach ($datarak as $rak)
                                            <option value="{{$rak->kodeRak}}">
                                                {{$rak->namaRak}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>                                
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="ip_address" class="form-label">IP Address</label>
                                        <input type="text" class="form-control" name="ip_address" id="ip_address" minlength="7" maxlength="15" size="15" pattern="^(?>(\d|[1-9]\d{2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?1)$" placeholder="000.000.000.000" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tgl_aktif">Tanggal Aktif</label>
                                        <input type="date" class="form-control @error('tgl_aktif') is-invalid @enderror" id="tgl_aktif" name="tgl_aktif" data-date-format="dd/mm/yyyy" value="{{ old('tgl_aktif') }}" disabled>
                                    
                                        @error('tgl_aktif')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <label for="kondisi">Kondisi</label>
                            <div class="card card-light card-outline mb-1">
                              <div class="card-body">
                                <div class="custom-control custom-radio d-inline col-md-3">
                                  <input class="custom-control-input custom-control-input-success" type="radio" id="bb" name="kondisi" value="bb">
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
                                    <label for="sistemOperasi">Sistem Operasi</label>
                                    <input type="text" id="sistemOperasi" name="sistemOperasi" class="form-control" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="status">Status</label>
                                    <input type="text" id="status" name="status" class="form-control" disabled>
                                </div>
                            </div>
                                    <label for="kotama">Kotama</label>
                                    <select class="form-control select2" id="kotama" name="kotama" disabled>
                                        <option value="" selected="selected"></option>
                                        @foreach ($kotama as $kot)
                                          <option value="{{$kot->kd_ktm}}">{{$kot->ur_ktm}}</option>
                                        @endforeach
                                    </select>
                                    <label for="satuan">Satuan</label>
                                    <select class="form-control select2" id="satuan" name="satuan" disabled>
                                        <option value="" selected="selected"></option>
                                        @foreach ($satuan as $sat)
                                          <option value="{{$sat->idsmkl}}">{{$sat->ur_smkl}}</option>
                                        @endforeach
                                    </select>
                            <label for="peruntukan">Peruntukan</label>
                            <textarea class="form-control" id="peruntukan" name="peruntukan" rows="2" disabled></textarea>   
                            <label for="kodeRak">Posisi Rak</label>
                            <select class="form-control select2" style="width: 100%;" id="id_mitra" name="id_mitra" disabled>
                              <option value="">-- Pilih Mitra --</option>
                              @foreach ($mitra as $mtr)
                              <option value="{{$mtr->id_mitra}}">{{$mtr->nama_mitra}}</option>
                              @endforeach
                            </select>               
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="2" disabled></textarea>
                        </div>
                    </div>
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

<!-- /.modal-update -->
<div class="modal fade" id="modal-update" tabindex="-1" data-focus="false" role="dialog" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-info">
        <div class="modal-header">
          <h4 class="modal-title">Update Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-update-perangkat" method="PUT">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">  
                            <label for="serialNumber">Serial Number</label>
                            <input type="text" class="form-control" name="serialNumber" id="serialNumber" readonly>
                            <label for="merk">Merk</label>
                            <input type="text" id="merk" name="merk" class="form-control" required>
                            <div class="form-group mb-1">
                                <div class="row">
                                  <div class="col-md-6">
                                      <label for="kapasitas">Kapasitas</label>
                                      <input type="text" id="kapasitas" name="kapasitas" class="form-control" required>
                                  </div>
                                  <div class="col-md-6">
                                      <label for="kapasitas">Storage</label>
                                      <input type="text" id="storage" name="storage" class="form-control" required>
                                  </div>                                    
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="model">Model</label>
                                      <input type="text" id="model" name="model" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="kodeRak">Posisi Rak</label>
                                        <select class="form-control select2" style="width: 100%;" id="kodeRak" name="kodeRak" >
                                        <option value="">-- Pilih Posisi --</option>
                                            @foreach ($datarak as $rak)
                                            <option value="{{$rak->kodeRak}}">
                                                {{$rak->namaRak}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>                                
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="ip_address" class="form-label">IP Address</label>
                                        <input type="text" class="form-control" name="ip_address" id="ip_address" minlength="7" maxlength="15" size="15" pattern="^(?>(\d|[1-9]\d{2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(?1)$" placeholder="000.000.000.000" required>
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
                            <label for="kondisi">Kondisi</label>
                            <div class="card card-light card-outline mb-1">
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
                                    <label for="sistemOperasi">Sistem Operasi</label>
                                    <input type="text" id="sistemOperasi" name="sistemOperasi" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="status">Status</label>
                                    <select class="form-control select2" id="status" name="status" style="width: 100%;">
                                        <option value="A" selected="selected">Aktif</option>
                                        <option value="N">Non Aktif</option>
                                    </select>
                                </div>
                            </div>
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
                            <label for="peruntukan">Peruntukan</label>
                            <textarea class="form-control" id="peruntukan" name="peruntukan" rows="2"></textarea>   
                            <label for="kodeRak">Posisi Rak</label>
                            <select class="form-control select2" style="width: 100%;" id="id_mitra" name="id_mitra" >
                              <option value="">-- Pilih Mitra --</option>
                              @foreach ($mitra as $mtr)
                              <option value="{{$mtr->id_mitra}}">{{$mtr->nama_mitra}}</option>
                              @endforeach
                            </select>               
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
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
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "columnDefs": [{ "visible": false, "targets": [3, 9, 10, 11, 12, 14] }]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
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
          window.location.href = "{{ route('perangkat.index') }}"; // Redirect setelah OK ditekan
      });
  @endif
</script>
<script>
    $(document).on('click', '#showDetail', function(){
        let idsvr = $(this).data('id');
        var editURL = $(this).data('url');
        $.get(editURL, function(data){
            console.log(data);
            var cek = data[0].kondisi;
            var sta = '';
            // alert(data[0].serialNumber);
            $('#modal-detail').modal('show');
            $('#modal-detail #id').val(data[0].id);
            $('#modal-detail #serialNumber').val(data[0].serialNumber);
            $('#modal-detail #ip_address').val(data[0].ip_address);
            $('#modal-detail #merk').val(data[0].merk);
            $('#modal-detail #model').val(data[0].model);
            $("#modal-detail #kodeRak").val(data[0].kodeRak);            
            $('#modal-detail #kapasitas').val(data[0].kapasitas);
            $('#modal-detail #storage').val(data[0].storage);
            $("#modal-detail #tgl_aktif").val(data[0].tgl_aktif);
            $('#modal-detail #sistemOperasi').val(data[0].sistemOperasi);
            if(data[0].status === 'A' ? sta = "Aktif" : sta ="Non Aktif");
            $('#modal-detail #status').val(sta);
            $('#modal-detail #peruntukan').val(data[0].peruntukan);
            $('#modal-detail #kotama').val(data[0].kd_ktm);
            $('#modal-detail #satuan').val(data[0].kd_smkl);
            $('#modal-detail #id_mitra').val(data[0].id_mitra);
            if(cek == 'bb'){
              $("#modal-detail #bb").prop("checked",true);
            }else if(cek == 'rr'){
              $("#modal-detail #rr").prop("checked",true);
            }else if(cek == 'rb'){
              $("#modal-detail #rb").prop("checked",true);
            } 
            $('#modal-detail #keterangan').val(data[0].keterangan);
            $('#modal-detail #dataTemp').val(JSON.stringify(data));
        })
    });
</script>
<script>
  $(document).ready(function() {
      $('#form-create-perangkat').submit(function(e) {
          e.preventDefault();
          dataForm = $(this).serialize() + "&_token={{ csrf_token() }}";  
          // alert(dataForm);
          $.ajax({
              type: 'POST',
              url: "{{ route('perangkat.store') }}",
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
                            window.location.href = "{{ route('perangkat.index') }}"; // Redirect setelah OK ditekan
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
                      alert('Terjadi kesalahan! No perangkat ada yang sama, Silakan coba lagi.');
                  }
              }
          });
      });

      $('#btnClear').click(function() {
      // Reset semua input dalam form
          $('#serialNumber').val('');          
          $('#ip_address').val('');
          $('#merk').val('');
          $('#model').val('');
          $('#kodeRak').val('');
          $('#kapasitas').val('');
          $('#tgl_aktif').val('');
          $('#kondisi').val('');
          $('#sistemOperasi').val('');
          $('#status').val('');
          $('#peruntukan').val('');
          $('#kotama').val('');
          $('#satuan').val('');
          $('#id_mitra').val('');
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
            var cek = data[0].kondisi;
            $('#modal-update').modal('show');
            $('#modal-update #id').val(data[0].id);
            $('#modal-update #serialNumber').val(data[0].serialNumber);
            $('#modal-update #ip_address').val(data[0].ip_address);
            $('#modal-update #merk').val(data[0].merk);
            $('#modal-update #model').val(data[0].model);
            $("#modal-update #kodeRak").val(data[0].kodeRak);            
            $('#modal-update #kapasitas').val(data[0].kapasitas);
            $('#modal-update #storage').val(data[0].storage);
            $("#modal-update #tgl_aktif").val(data[0].tgl_aktif);
            $('#modal-update #sistemOperasi').val(data[0].sistemOperasi);
            $('#modal-update #status').val(data[0].status);
            $('#modal-update #peruntukan').val(data[0].peruntukan);
            $('#modal-update #kotama').val(data[0].kd_ktm);
            $('#modal-update #satuan').val(data[0].kd_smkl);
            $('#modal-update #id_mitra').val(data[0].id_mitra);
            if(cek == 'bb'){
              $("#modal-update #bb").prop("checked",true);
            }else if(cek == 'rr'){
              $("#modal-update #rr").prop("checked",true);
            }else if(cek == 'rb'){
              $("#modal-update #rb").prop("checked",true);
            } 
            $('#modal-update #keterangan').val(data[0].keterangan);
            $('#modal-update #dataTemp').val(JSON.stringify(data));
        })
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#form-update-perangkat').on('click', '#simpanEdit', function(e){
          e.preventDefault();
          var nid = $('#form-update-perangkat #id').val();
          dataForm = $('#form-update-perangkat').serialize() + "&_token={{ csrf_token() }}";
          // alert(dataForm);    
          $.ajax({
              type: 'PUT',
              url: "{{ route('perangkat.update', ':id') }}".replace(':id', nid),
              data: dataForm,
              dataType: 'json',
              success: function(response) {
                    if(response.status == 200) {
                        alert(response.pesan);
                        window.location.href = "{{ route('perangkat.index') }}";
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
          $('#modal-update #merk').val(myObject['merk']);
          $("#modal-update #model").val(myObject['model']);          
          $("#modal-update #kapasitas").val(myObject['kapasitas']);
          $('#modal-update #storage').val(myObject['storage']);
          $("#modal-update #kodeRak").val(myObject['kodeRak']);
          $("#modal-update #ip_address").val(myObject['ip_address']);
          $("#modal-update #tgl_aktif").val(myObject['tgl_aktif']);
          $("#modal-update #kondisi").val(myObject['kondisi']);
          $("#modal-update #sistemOperasi").val(myObject['sistemOperasi']);
          $("#modal-update #status").val(myObject['status']);
          $("#modal-update #peruntukan").val(myObject['peruntukan']);
          $("#modal-update #kotama").val(myObject['kd_ktm']);
          $("#modal-update #satuan").val(myObject['kd_smkl']);
          $("#modal-update #id_mitra").val(myObject['id_mitra']);          
          $("#modal-update #keterangan").val(myObject['keterangan']);
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
