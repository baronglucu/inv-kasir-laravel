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
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Laporan</th>
                            <th>Nama Pelapor</th>
                            <th>Tgl Laporan</th>
                            <th>Kotama</th>
                            <th>Satuan</th>                            
                            <th>Telepon</th> 
                            <th>Nama Domain</th>
                            <th>Masalah</th>
                            <th>Penanganan</th>
                            <th>Status</th>                           
                            <th>Klasifikasi</th>
                            <th>Melalui</th>
                            <th>No Surat</th>  
                            <th>Tgl Surat</th>                         
                            <th>File Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alat as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->no_lapor }}</td>
                                <td>{{ $item->nama_pelapor }}</td>
                                <td>{{ date('d-m-Y', strtotime( $item->tgl_laporan )) }}</td>
                                <td>{{ $item->ur_ktm }}</td>
                                <td>{{ $item->ur_smkl }}</td>
                                <td>{{ $item->no_telp }}</td>
                                <td>{{ $item->nama_domain }}</td>
                                <td>{{ $item->masalah }}</td>
                                <td>{{ $item->solusi }}</td>
                                <td>
                                  @if ($item->status == '1')
                                    <span class="badge badge-success"> Finish </span>
                                  @endif
                                  @if ($item->status == '2')
                                    <span class="badge badge-info"> Process </span>
                                  @endif
                                  @if ($item->status == '3')
                                    <span class="badge badge-warning"> Pending </span>
                                  @endif
                                  @if ($item->status == '4')
                                    <span class="badge badge-danger"> Suspend </span>
                                  @endif

                                  {{-- <div class="timeline">
                                    <div class="time-label">
                                      <span class="bg-yellow"> Pending </span>
                                    </div>
                                  </div> --}}
                                </td>
                                <td>
                                  @if ($item->klasifikasi == 'u')
                                    <span class="badge badge-success"> Urgent </span>
                                  @endif
                                  @if ($item->klasifikasi == 'i')
                                    <span class="badge badge-warning"> Important </span>
                                  @endif
                                </td>
                                <td>{{ $item->melalui }}</td>
                                <td>{{ $item->no_surat }}</td>
                                <td>{{ date('d-m-Y', strtotime( $item->tgl_surat )) }}</td>
                                <td align="center">
                                   @if ($item->file_surat)
                                    <button class="btn btn-primary btn-view-file" data-file-url="{{ asset('storage/files/'.$item->file_surat) }}">
                                      <i class="fas fa-file"></i>
                                    </button>
                                  @else
                                    <span class="text-muted">Tidak ada file</span>
                                  @endif
                                 </td>
                                <td class="text-right">
                                  <div class="btn-group">
                                    <a href="javascript:void(0)" id="showDetail" data-url="{{ route('pengaduan.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-detail" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                    &nbsp;
                                    <a href="javascript:void(0)" id="viewMessage" data-url="{{ route('pengaduan.show', $item->id) }}" data-bs-toggle="modal" data-bs-target="#modal-update" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></a>
                                    &nbsp;
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('pengaduan.destroy', $item->id) }}" method="POST">
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
  {{-- <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" > --}}
  <div id="modal-tambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content bg-secondary">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-create-adu" name="form-create-adu" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">                    
                    <div class="col-md-12 mb-0">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <span>&nbsp;</span>
                                </div>
                                <div class="input-group col-md-6">
                                    <label class="form-label">Nomor Laporan : </label>&nbsp;
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">LP- </span>
                                      </div>
                                    <input type="text" id="no_lapor" name="no_lapor" class="form-control" data-no_lapor="'mask': ['9999/X/9999']" data-mask required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/Pusta</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <span>&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>                    
                  <div class="col-md-6">
                        <div class="form-group">  
                            <label class="form-label" for="nama_pelapor">Nama Pelapor</label>
                            <div class="input-group">
                            <input type="text" class="form-control" name="nama_pelapor" id="nama_pelapor" placeholder="Pkt/Corps/Nama" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>No Telepon</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="no_telp" name="no_telp" data-no_telp="'mask': ['999-999-9999']" data-mask>
                                    </div>
                                </div>
                                <div class="col-md-6">    
                                    <label>Tanggal Lapor</label>
                                    <input type="date" class="form-control @error('tgl_laporan') is-invalid @enderror" id="tgl_laporan" name="tgl_laporan" data-date-format="dd/mm/yyyy" value="{{ old('tgl_laporan') }}" required>
                                    @error('tgl_laporan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <label class="form-label">Kotama</label>
                            <select class="form-control select2" id="kotama" name="kotama">
                                <option value="" selected="selected">-- Pilih Kotama --</option>
                                @foreach ($kotama as $kot)
                                <option value="{{$kot->kd_ktm}}">{{$kot->ur_ktm}}</option>
                                @endforeach
                            </select>
                            <label>Satuan</label>
                            <select class="form-control select2" id="satuan" name="satuan">
                                <option value="" selected="selected">-- Pilih Satuan--</option>
                            </select>
                                                        
                            <label>Nama Domain</label>
                            <select class="form-control select2" style="width: 100%;" id="id_domain" name="id_domain" >
                                <option value="">-- Pilih Domain --</option>
                                @foreach ($domain as $dom)
                                <option value="{{$dom->id}}">{{$dom->nama_domain}}</option>
                                @endforeach
                            </select>                                
                            <label>Masalah</label>
                            <textarea class="form-control" id="masalah" name="masalah" rows="3" placeholder="Kendala yang dihadapi"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">                            
                            <label>Penanganan</label>
                            <textarea class="form-control" id="solusi" name="solusi" rows="3" placeholder="Tindakan yang dilaksanakan"></textarea>                            
                            <label>Status</label>
                                <div class="card card-light card-outline mt-1 mb-1">
                                    <div class="card-body">                            
                                    <div class="custom-control custom-radio d-inline col-md-3">
                                      <input class="custom-control-input custom-control-input-success" type="radio" id="s1" name="status" value="1" checked>
                                      <label for="s1" class="custom-control-label col-md-2">Finish</label>
                                    </div>
                                    <div class="custom-control custom-radio d-inline col-md-3">
                                      <input class="custom-control-input custom-control-input-info" type="radio" id="s2" name="status" value="2">
                                      <label for="s2" class="custom-control-label col-md-2">Process</label>
                                    </div>
                                    <div class="custom-control custom-radio d-inline col-md-3">
                                      <input class="custom-control-input custom-control-input-warning" type="radio" id="s3" name="status" value="3">
                                      <label for="s3" class="custom-control-label col-md-2">Pending</label>
                                    </div>
                                    <div class="custom-control custom-radio d-inline col-md-3">
                                      <input class="custom-control-input custom-control-input-danger" type="radio" id="s4" name="status" value="4">
                                      <label for="s4" class="custom-control-label col-md-2">Suspend</label>
                                    </div>
                                  </div>                              
                                </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label>Klasifikasi</label>
                                    <select class="form-control" style="width: 100%;" id="klasifikasi" name="klasifikasi" >
                                        <option value="">-- Pilih Klasifikasi --</option>
                                        <option value="u">Urgent/Mendesak</option>
                                        <option value="i">Important/Penting</option>
                                    </select>     
                                </div>
                                <div class="col-md-6">
                                    <label>Melalui</label>
                                    <select class="form-control" style="width: 100%;" id="melalui" name="melalui" >
                                        <option value="surat">Surat</option>
                                        <option value="chat">Chatting</option>
                                        <option value="telp">Telepon</option>
                                    </select>  
                                </div>                              
                            </div> 
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label for="no_surat">Nomor Surat</label>                 
                                    <input type="text" class="form-control" id="no_surat" name="no_surat" min="1">
                                </div>
                                <div class="col-md-6">
                                    <label for="tgl_surat">Tanggal Surat</label>
                                    <input type="date" class="form-control @error('tgl_surat') is-invalid @enderror" id="tgl_surat" name="tgl_surat" data-date-format="dd/mm/yyyy" value="{{ old('tgl_surat') }}" >
                                    @error('tgl_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror                                  
                                </div>                                                                
                            </div>
                          <div class="custom-file mt-1">
                         
                          <div class="custom-file">
                              <label for="file_surat">Pilih File : </label>
                              <input type="file" name="file_surat" id="file_surat" accept=".pdf">
                              <div class="invalid-feedback">File harus berformat PDF</div>
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

  <!-- /.modal update data -->
 <div class="modal fade" id="modal-update" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-xl">
      <div class="modal-content bg-info">
        <div class="modal-header">
          <h4 class="modal-title">Update Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <span id="coba"></span>
        <div class="modal-body">
          <form id="form-update-adu" method="PUT">
            <div class="card-body">
                <div class="row">
                  <div class="col-md-12 mb-0">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-3">
                            <span>&nbsp;</span>
                          </div>
                          <div class="input-group col-md-6">
                            <label class="form-label">Nomor Laporan : </label>&nbsp;
                            <div class="input-group-prepend">
                              <input type="text" id="no_lapor" name="no_lapor" class="form-control" readonly>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <span>&nbsp;</span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" value="" name="id" id="id" />  
                            <label class="form-label">Nama Pelapor</label>
                            <div class="input-group">
                            <input type="text" class="form-control" name="nama_pelapor" id="nama_pelapor">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="no_telp">No Telepon</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="no_telp" name="no_telp" data-no_telp="'mask': ['999-999-9999']" data-mask>
                                    </div>
                                </div>
                                <div class="col-md-6">    
                                    <label>Tanggal Lapor</label>
                                    <input type="date" class="form-control @error('tgl_laporan') is-invalid @enderror" id="tgl_laporan" name="tgl_laporan" data-date-format="dd/mm/yyyy" value="{{ old('tgl_laporan') }}" required>
                                    @error('tgl_laporan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <label for="kotama">Kotama</label>
                            <select class="form-control select2" id="kotama" name="kotama">
                                <option value="" selected="selected">-- Pilih Kotama --</option>
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
                                                        
                            <label for="id_domain">Nama Domain</label>
                            <select class="form-control select2" style="width: 100%;" id="id_domain" name="id_domain" >
                                <option value="">-- Pilih Domain --</option>
                                @foreach ($domain as $dom)
                                <option value="{{$dom->id}}">{{$dom->nama_domain}}</option>
                                @endforeach
                            </select>                                
                            <label for="masalah">Masalah</label>
                            <textarea class="form-control" id="masalah" name="masalah" rows="3" placeholder="Kendala yang dihadapi"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">                            
                            <label aria-labelledby="solusi">Penanganan</label>
                            <textarea class="form-control" id="solusi" name="solusi" rows="3" placeholder="Tindakan yang dilaksanakan"></textarea>
                            <label aria-labelledby="status">Status</label>
                            <div class="card card-light card-outline mb-1">
                              <div class="card-body">
                                <div class="custom-control custom-radio d-inline col-md-3">
                                  <input class="custom-control-input custom-control-input-danger" type="radio" id="s1" name="status" value="1">
                                  <label aria-labelledby="1" class="custom-control-label col-md-2">Suspend</label>
                                </div>
                                <div class="custom-control custom-radio d-inline col-md-3">
                                    <input class="custom-control-input custom-control-input-warning" type="radio" id="s2" name="status" value="2">
                                    <label aria-labelledby="2" class="custom-control-label col-md-2">Pending</label>
                                </div>
                                <div class="custom-control custom-radio d-inline col-md-3">
                                  <input class="custom-control-input custom-control-input-success" type="radio" id="s3" value="3" name="status">
                                  <label aria-labelledby="3" class="custom-control-label col-md-2">Proses</label>
                                </div>
                                <div class="custom-control custom-radio d-inline col-md-3">
                                  <input class="custom-control-input custom-control-input-info" type="radio" id="s4" value="4" name="status">
                                  <label aria-labelledby="4" class="custom-control-label col-md-2">Selesai</label>
                                </div>
                              </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label aria-labelledby="klasifikasi">Klasifikasi</label>
                                    <select class="form-control" style="width: 100%;" id="klasifikasi" name="klasifikasi" >
                                        <option value="">-- Pilih Klasifikasi --</option>
                                        <option value="u">Urgent/Mendesak</option>
                                        <option value="i">Important/Penting</option>
                                    </select>     
                                </div>
                                <div class="col-md-6">
                                    <label aria-labelledby="melalui">Melalui</label>
                                    <select class="form-control" style="width: 100%;" id="melalui" name="melalui" >
                                        <option value="surat">Surat</option>
                                        <option value="chat">Chatting</option>
                                        <option value="telp">Telepon</option>
                                    </select>  
                                </div>                              
                            </div> 
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label aria-labelledby="no_surat">Nomor Surat</label>                 
                                    <input type="text" class="form-control" id="no_surat" name="no_surat" min="1">
                                </div>
                                <div class="col-md-6">
                                    <label aria-labelledby="tgl_surat">Tanggal Surat</label>
                                    <input type="date" class="form-control @error('tgl_surat') is-invalid @enderror" id="tgl_surat" name="tgl_surat" data-date-format="dd/mm/yyyy" value="{{ old('tgl_surat') }}" >
                                    @error('tgl_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror                                  
                                </div>
                            </div>
                            <label aria-labelledby="file_surat">File Surat</label>
                            <input type="file" class="form-control" id="file_surat" name="file_surat" accept=".pdf">
                            @error('file_surat')
                                <div class="invalid-feedback">{{ $message }}</div>      
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-3" >
                    <button type="submit" class="btn btn-outline-light float-sm-right" id="simpanEdit"><i class="fas fa-save"></i> Simpan</button>
                    <button type="button" id="btnClear" class="btn btn-outline-light"><i class="fa fa-eraser"></i> Batal</button>
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
  <!-- /.modal-hapus -->

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

<!-- /.modal-detail -->
<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Pengaduan</h4>
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
                      <label for="" class="col-md-4">No. Pengaduan</label>
                      <input type="text" class="form-control col-md-7" id="no_lapor" name="no_lapor" value="" disabled>
                    </div>
                    <div class="row mt-1">  
                      <label for="" class="col-md-4">Dari Kotama</label>
                      <input type="text" class="form-control col-md-7" id="kotama" name="kotama" value="" disabled>
                    </div>
                    <div class="row mt-1">  
                      <label for="" class="col-md-4">Dari Satuan</label>
                      <input type="text" class="form-control col-md-7" id="satuan" name="satuan" value="" disabled>
                    </div>
                    <div class="row mt-1">                    
                      <label for="nm_domain" class="col-md-4">Nama Domain</label>
                      <input type="text" class="form-control col-md-7" id="nm_domain" name="nm_domain" value="" disabled> 
                    </div>
                    <div class="row mt-1">                               
                      <label for="masalah" class="col-md-4">Masalah</label>
                      <textarea class="form-control col-md-7" id="masalah" name="masalah" rows="3" placeholder="Kendala yang dihadapi" disabled></textarea>
                    </div>
                    <div class="row mt-1">
                      <label for="solusi" class="col-md-4">Penanganan</label>
                      <textarea class="form-control col-md-7" id="solusi" name="solusi" rows="3" disabled></textarea>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group"> 
                    <div class="row mt-1">                   
                      <label aria-labelledby="status" class="col-md-4">Status</label>
                      <div class="card card-light card-outline col-md-12">
                        <div class="card-body">
                          <div class="custom-control custom-radio d-inline col-md-4">
                            <input class="custom-control-input custom-control-input-danger" type="radio" id="s1" name="status" value="1">
                            <label aria-labelledby="1" class="custom-control-label col-md-2">Suspend</label>
                          </div>
                          <div class="custom-control custom-radio d-inline col-md-4">
                            <input class="custom-control-input custom-control-input-warning" type="radio" id="s2" name="status" value="2">
                            <label aria-labelledby="2" class="custom-control-label col-md-2">Pending</label>
                          </div>
                          <div class="custom-control custom-radio d-inline col-md-4">
                            <input class="custom-control-input custom-control-input-success" type="radio" id="s3" value="3" name="status">
                            <label aria-labelledby="3" class="custom-control-label col-md-2">Proses</label>
                          </div>
                          <div class="custom-control custom-radio d-inline col-md-4">
                            <input class="custom-control-input custom-control-input-info" type="radio" id="s4" value="4" name="status">
                            <label aria-labelledby="4" class="custom-control-label col-md-2">Selesai</label>
                          </div>
                        </div>
                      </div>
                      <div class="row g-3 align-items-center mt-1">
                        
                          <label for="klasifikasi" class="col-md-2">Klasifikasi</label>
                          <input type="text" class="form-control col-md-4" id="klasifikasi" name="klasifikasi" value="" disabled> 
                          <label for="melalui" class="col-md-2">Melalui</label>
                          <input type="text" class="form-control col-md-4" id="melalui" name="melalui" value="" disabled>  
                                                       
                        </div> 
                      <div class="row g-3 align-items-center mt-1">
                          
                          <label for="" class="col-md-2">No. Surat</label>
                          <input type="text" class="form-control col-md-4" id="no_surat" name="no_surat" value="" disabled>
                          <label for="" class="col-md-2">Tgl Surat</label>
                          <input type="text" class="form-control col-md-4" id="tgl_surat" name="tgl_surat" value="" disabled>
                        
                      </div>
                      <div class="row g-2 col-md-12 align-items-center mt-1">
                        <label class="col-md-2">File Surat</label>
                        <input type="text" class="form-control col-md-10" id="file_surat" name="file_surat" disabled>
                      </div>
                    <div class="card card-light card-outline mb-1 mt-2 col-md-12">
                        <div class="card-body">
                          <div class="row mt-1">
                            <label for="" class="col-md-4">Posisi WHM</label>
                            <input type="text" class="form-control col-md-7" id="nama_whm" name="nama_whm" value="" disabled>
                          </div>
                          <div class="row mt-1">
                            <label for="" class="col-md-4">IP Address</label>
                            <input type="text" class="form-control col-md-7" id="ip_address" name="ip_address" value="" disabled>
                          </div>
                          <div class="row mt-1">
                            <label for="" class="col-md-4">Nama Rak</label>
                            <input type="text" class="form-control col-md-7" id="namaRak" name="namaRak" value="" disabled>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>          
        </div>
      </div>
      </div>
    <!-- /.modal-content -->
    </div>
  <!-- /.modal-dialog -->
  </div>
</div>
<!-- /.modal -->

<!-- Modal for Viewing File -->
<div class="modal fade" id="modal-dokumen" tabindex="-1" role="dialog" aria-labelledby="modalDokumenLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Dokumen Pengaduan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <span id="namafile"></span>
      <div class="modal-body">
        <!-- File Viewer -->
        <iframe id="fileViewer" src="" style="width: 100%; height: 600px;" frameborder="0"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
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
<script src="{{ asset('')}}plugins/moment/moment.min.js"></script>
<script src="{{ asset('')}}plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="{{ asset('')}}plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="{{ asset('')}}plugins/sweetalert2/sweetalert2.min.js"></script>

<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "columnDefs": [{ "visible": false, "targets": [3, 5, 6, 10, 11, 13, 14] }]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
<script>
    // Example: Attach the function to a button click
  $(document).on('click', '.btn-view-file', function () {
      const fileUrl = $(this).data('file-url'); // Get the file URL from the button's data attribute
      if (fileUrl) {
          viewFile(fileUrl);
      } else {
          alert('No file URL provided.');
      } 
      // viewFile(fileUrl);
  });

  $('#modal-tambah .select2').each(function() {  
    var $p = $(this).parent(); 
    $(this).select2({  
      dropdownParent: $p  
    });  
  });

  function viewFile(fileUrl) {
    const fileExtension = fileUrl.split('.').pop().toLowerCase();
    if (fileExtension === 'pdf') { 
      $('#fileViewer').attr('src', fileUrl);
      $('#modal-dokumen').modal('show');
      var span = document.getElementById('namafile');
      if ('textContent' in span) {
        span.textContent = fileUrl;
      } else {
        span.innerText = fileUrl;
      }
    } else {
      alert('File type not supported for preview. Downloading file...');
      window.open(fileUrl, '_blank');
    }
  }    
        // Tutup modal ketika diklik di luar
  $('#viewModal').on('click', function(e) {
    if (e.target === this) {
      $(this).modal('hide');
    }
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
            document.getElementById('delete-form-' + id).submit(); // Submit form delete
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
          window.location.href = "{{ route('pengaduan.index') }}"; // Redirect setelah OK ditekan
      });
  @endif
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
    $(document).on('click', '#showDetail', function(){
      let idwhm = $(this).data('id');
      var editURL = $(this).data('url');
        $.get(editURL, function(data){
            console.log(data);
            var sta = data[0].status;
            const tgllap = data[0].tgl_laporan;
            const tglakt = data[0].tgl_aktif;
            var options = { year: "numeric", month: "numeric", day: "numeric" };
            const ftglap = new Date(tgllap).toLocaleDateString('es-CL', options); 
            const ftglak = new Date(tglakt).toLocaleDateString('es-CL', options);
            // alert(sta);
            var kla = data[0].klasifikasi;
            var mel = data[0].melalui;
            $('#modal-detail').modal('show');
            $('#modal-detail #ip_address').val(data[0].ip_address);
            $('#modal-detail #nama_whm').val(data[0].nama_whm);
            $('#modal-detail #namaRak').val(data[0].namaRak);

            $('#modal-detail #id').val(data[0].id);
            $('#modal-detail #no_lapor').val(data[0].no_lapor);
            $('#modal-detail #nama_pelapor').val(data[0].nama_pelapor);
            $('#modal-detail #tgl_laporan').val(ftglap);
            $('#modal-detail #kotama').val(data[0].ur_ktm);
            $('#modal-detail #satuan').val(data[0].ur_smkl);
            $('#modal-detail #no_telp').val(data[0].no_telp);
            $('#modal-detail #nm_domain').val(data[0].nama_domain);
            $('#modal-detail #masalah').val(data[0].masalah);          
            $('#modal-detail #solusi').val(data[0].solusi);
            if(sta == '1'){
              $("#modal-detail #s1").prop("checked",true);
            }else if(sta == '2'){
              $("#modal-detail #s2").prop("checked",true);
            }else if(sta == '3'){
              $("#modal-detail #s3").prop("checked",true);
            }else{
              $("#modal-detail #s4").prop("checked",true);
            }
            
            if(kla == 'u'){
              $('#modal-detail #klasifikasi').val('Urgent/Mendesak');
            }else{
              $('#modal-detail #klasifikasi').val('Important/Penting');
            }

            $('#modal-detail #tgl_aktif').val(ftglak);

            if(mel == 'surat'){
              $('#modal-detail #melalui').val('Surat');
            }else if(mel == 'chat'){
              $('#modal-detail #melalui').val('Chatting');
            }else{
              $('#modal-detail #melalui').val('Telepon');
            }            
            
            $('#modal-detail #no_surat').val(data[0].no_surat);
            $('#modal-detail #tgl_surat').val(data[0].tgl_surat);
            $('#modal-detail #file_surat').val(data[0].file_surat);
            $('#modal-detail #dataTemp').val(JSON.stringify(data[0]));
        })      

    });

</script>
<script>
  $(document).ready(function() {
      $('#form-create-adu').submit(function(e) {
          e.preventDefault();

      //     $.ajax({
      //         type: 'POST',
      //         url: "{{ route('pengaduan.store') }}",
      //         data: dataForm,
      //         dataType: 'json',
      //         success: function(response) {
      //             if(response.status == 200) {
      //                 Swal.fire({
      //                     icon: 'success',
      //                     title: 'Sukses!',
      //                     text: '{{ session('response.message') }}',
      //                     confirmButtonText: 'OK'
      //                   }).then(() => {
      //                       window.location.href = "{{ route('pengaduan.index') }}"; // Redirect setelah OK ditekan
      //                   });
      //             } else {
      //                 alert(response.message);
      //                 $('#nama_pelapor').val('');
      //             }
      //         },
      //         error: function(xhr) {
      //             if(xhr.status == 500) {
      //                 let errors = xhr.responseJSON.errors;
      //                 let errorMessage = '';
      //                 $.each(errors, function(key, value) {
      //                     errorMessage += value[0] + '\n';
      //                 });
      //                 alert(errorMessage);
      //             } else {
      //                 alert('Terjadi kesalahan!, Silakan coba lagi.');
      //             }
      //         }
      //     });
      // });
          // var dataForm1 = $(this).serialize() + "&_token={{ csrf_token() }}";
          // var dataForm2 = $('input[name="file_surat"]').val();
          var formData = new FormData(this);
          // alert(formData);

                $.ajax({
                    url: "{{ route('pengaduan.store') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // console.log('Data:', response);
                        $('#modal-tambah').modal('hide');
                        if (response.status === 200) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Gagal upload:', textStatus);
                    }
                });
            });

      $('#btnClear').click(function() {
      // Reset semua input dalam form          
        //   $('#ip_address').val('');
        //   $('#nama_whm').val('');
        //   $('#kodeRak').val('');
        //   $('#kapasitas').val('');
        //   $('#tgl_aktif').val('');
        //   $('#tgl_akhir').val('');
        //   $('#kondisi').val('');
        //   $('#lama_ssl').val('');
        //   $('#keterangan').val('');
      });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('click', '#viewMessage', function(){
        var editURL = $(this).data('url');
        $.get(editURL, function(data){
            console.log(data);
            var sta = data[0].status;
            // alert(sta);
            var kla = data[0].klasifikasi;
            $('#modal-update').modal('show');
            $('#modal-update #id').val(data[0].id);
            $('#modal-update #no_lapor').val(data[0].no_lapor);
            $('#modal-update #nama_pelapor').val(data[0].nama_pelapor);
            $('#modal-update #tgl_laporan').val(data[0].tgl_laporan);
            $('#modal-update #kotama').val(data[0].kd_ktm);
            $('#modal-update #satuan').val(data[0].kd_smkl).trigger('change');
            $('#modal-update #no_telp').val(data[0].no_telp);
            $('#modal-update #id_domain').val(data[0].id_domain);  
            $('#modal-update #masalah').val(data[0].masalah);          
            $('#modal-update #solusi').val(data[0].solusi);
            if(sta == '1'){
              $("#modal-update #s1").prop("checked",true);
            }else if(sta == '2'){
              $("#modal-update #s2").prop("checked",true);
            }else if(sta == '3'){
              $("#modal-update #s3").prop("checked",true);
            }else{
              $("#modal-update #s4").prop("checked",true);
            }
            $('#modal-update #klasifikasi').val(data[0].klasifikasi);
            $('#modal-update #tgl_aktif').val(data[0].tgl_aktif);
            $('#modal-update #melalui').val(data[0].melalui);
            $('#modal-update #no_surat').val(data[0].no_surat);
            $('#modal-update #tgl_surat').val(data[0].tgl_surat);
            $('#modal-update #file_surat').val(data[0].file_surat);
            $('#modal-update #dataTemp').val(JSON.stringify(data[0]));
        })
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#modal-update').on('click', '#simpanEdit', function(e){
          e.preventDefault();
          var nid = $('#modal-update #id').val();
          dataForm = $('#modal-update').serialize() + "&_token={{ csrf_token() }}";
          // alert(dataForm);    
          $.ajax({
              type: 'PUT',
              url: "{{ route('pengaduan.update', ':id') }}".replace(':id', nid),
              data: dataForm,
              dataType: 'json',
              success: function(response) {
                    if(response.status == 200) {
                        alert(response.pesan);
                        window.location.href = "{{ route('pengaduan.index') }}";
                    } else {
                        alert('berhasil, tapi tidak tersimpan');
                    }
              },
              error: function(response) {
                    if(response.status == 500) {
                        alert('GAGAL dan tidak tersimpan');
                    } else {
                        alert('Terjadi kesalahan! Cek Ulang Data, Silakan coba lagi.');
                    }
                }
          });
    });
  });
</script>
@endsection
