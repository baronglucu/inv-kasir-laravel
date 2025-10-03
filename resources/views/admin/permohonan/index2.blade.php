@extends('admin.template.master')

@section('css')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('')}}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('')}}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('')}}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 CSS -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
                <table id="example1" name='example1' class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Permohonan</th>
                            <th>Kotama</th>
                            <th>Satuan</th> 
                            <th>No Surat</th>
                            <th>Tgl Surat</th>
                            <th>Perihal</th>
                            <th>Utk Satuan</th>
                            <th>Usulan Domain</th>
                            <th>Status</th>
                            <th>Nama Domain</th>
                            <th>Klasifikasi</th>
                            <th>Melalui</th>
                            <th>File Surat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($alat as $data)
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $data->no_mohon }}</td>
                          <td>{{ $data->ur_ktm }}</td>
                          <td>{{ $data->ur_smkl }}</td>
                          <td>{{ $data->no_surat }}</td>
                          <td>{{ date('d-m-Y', strtotime( $data->tgl_surat )) }}</td>
                          <td>{{ $data->perihal }}</td>
                          <td>{{ $data->utk_smkl }}</td>
                          <td>{{ $data->nm_domain }}</td>
                          <td>
                            @if ($data->status == '1')
                                    <span class="badge badge-success"> Proses </span>
                                  @endif
                                  @if ($data->status == '2')
                                    <span class="badge badge-info"> Pending </span>
                                  @endif
                                  @if ($data->status == '3')
                                    <span class="badge badge-warning"> Selesai </span>
                                  @endif
                          </td>
                          <td>{{ $data->nama_domain }}</td>
                          <td>
                            @if ($data->klasifikasi == 'u')
                                <span class="badge badge-success"> Urgent </span>
                            @endif
                            @if ($data->klasifikasi == 'i')
                                <span class="badge badge-warning"> Important </span>
                            @endif
                          </td>
                          <td>{{ $data->melalui }}</td>
                          <td>
                            @if ($data->file_surat != '')
                              <button class="btn btn-primary btn-view-file" data-file-url="{{ asset('storage/files/' . $data->file_surat) }}">
                              <i class="fas fa-file"></i>
                              </button>
                            @endif
                          </td>
                          <td>
                            <div class="btn-group">
                                <a href="javascript:void(0)" id="showDetail" data-url="{{ route('permohonan.show', $data->id) }}" data-bs-toggle="modal" data-bs-target="#modal-detail" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                    &nbsp;
                                <a href="javascript:void(0)" id="viewMessage" data-url="{{ route('permohonan.show', $data->id) }}" data-bs-toggle="modal" data-bs-target="#modal-update" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></a>
                                    &nbsp;
                                <form id="delete-form-{{ $data->id }}" action="{{ route('permohonan.destroy', $data->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $data->id }})"><i class="fas fa-trash" value="Hapus Item"></i></button>
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
                                    <label class="form-label">Nomor Permohonan : </label>&nbsp;
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">LPm- </span>
                                      </div>
                                    <input type="text" id="no_mohon" name="no_mohon" class="form-control" data-no_mohon="'mask': ['9999/X/9999']" data-mask required>
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
                            <div class="row">
                                <div class="col-md-6">
                                  <label class="form-label">Kotama</label>
                                  <select class="form-control select2" id="kotama" name="kotama">
                                      <option value="" selected="selected">-- Pilih Kotama --</option>
                                      @foreach ($kotama as $kot)
                                      <option value="{{$kot->kd_ktm}}">{{$kot->ur_ktm}}</option>
                                      @endforeach
                                  </select>
                                </div>
                                <div class="col-md-6"> 
                                  <label>Satuan</label>
                                  <select class="form-control select2" id="satuan" name="satuan">
                                      <option value="" selected="selected">-- Pilih Satuan--</option>
                                  </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>No Surat</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="no_surat" name="no_surat" data-no_surat="'mask': ['B/     /   /2025']" data-mask>
                                    </div>
                                </div>
                                <div class="col-md-6">    
                                    <label>Tanggal Surat</label>
                                    <input type="date" class="form-control @error('tgl_surat') is-invalid @enderror" id="tgl_surat" name="tgl_surat" data-date-format="dd/mm/yyyy" value="{{ old('tgl_surat') }}" required>
                                    @error('tgl_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <label>Perihal</label>
                            <textarea class="form-control" id="perihal" name="perihal" rows="3" placeholder="Perihal Surat"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">                            
                                                        
                            <label>Status</label>
                            <div class="card card-light card-outline mt-1 mb-1">
                              <div class="card-body">                            
                                <div class="custom-control custom-radio d-inline col-md-3">
                                  <input class="custom-control-input custom-control-input-success" type="radio" id="s1" name="status" value="1" checked>
                                    <label for="s1" class="custom-control-label col-md-2">Proses</label>
                                </div>
                                <div class="custom-control custom-radio d-inline col-md-3">
                                  <input class="custom-control-input custom-control-input-info" type="radio" id="s2" name="status" value="2">
                                  <label for="s2" class="custom-control-label col-md-2">Pending</label>
                                </div>
                                <div class="custom-control custom-radio d-inline col-md-3">
                                  <input class="custom-control-input custom-control-input-warning" type="radio" id="s3" name="status" value="3">
                                  <label for="s3" class="custom-control-label col-md-2">Selesai</label>
                                </div>
                              </div>                              
                            </div>
                            
                            <div class="row g-3 align-items-center">
                              <div class="col-md-6">
                                <label for="utk_satuan">Untuk Satuan</label>                 
                                <select class="form-control select2" id="utk_satuan" name="utk_satuan">
                                  <option value="" selected="selected">-- Pilih Satuan--</option>
                                </select>
                              </div>
                              <div class="col-md-6">
                                <label for="nm_domain">Usulan Nama Domain</label>
                                <input type="text" class="form-control" id="nm_domain" name="nm_domain" min="1"> 
                                {{-- <select class="form-control select2" id="nm_domain" name="nm_domain">
                                  <option value="" selected="selected"> </option>
                                </select>                                   --}}
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
                                    <label class="form-label">Nomor Permohonan : </label>&nbsp;                                    
                                    <input type="text" id="no_mohon" name="no_mohon" class="form-control" data-no_mohon="'mask': ['9999/X/9999']" data-mask disabled>
                                </div>
                                <div class="col-md-3">
                                    <span>&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>                    
                  <div class="col-md-6">
                        <div class="form-group"> 
                            <div class="row">
                                <div class="col-md-6">
                                  <label class="form-label">Kotama</label>
                                  <select class="form-control select2" id="kotama" name="kotama">
                                      <option value="" selected="selected">-- Pilih Kotama --</option>
                                      @foreach ($kotama as $kot)
                                      <option value="{{$kot->kd_ktm}}">{{$kot->ur_ktm}}</option>
                                      @endforeach
                                  </select>
                                </div>
                                <div class="col-md-6"> 
                                  <label>Satuan</label>
                                  <select class="form-control select2" id="satuan" name="satuan">
                                      <option value="" selected="selected"></option>
                                      @foreach ($satuan as $sat)
                                      <option value="{{$sat->idsmkl}}">{{$sat->ur_smkl}}</option>
                                      @endforeach
                                  </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>No Surat</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="no_surat" name="no_surat" data-no_surat="'mask': ['B/     /   /2025']" data-mask>
                                    </div>
                                </div>
                                <div class="col-md-6">    
                                    <label>Tanggal Surat</label>
                                    <input type="date" class="form-control @error('tgl_surat') is-invalid @enderror" id="tgl_surat" name="tgl_surat" data-date-format="dd/mm/yyyy" value="{{ old('tgl_surat') }}" required>
                                    @error('tgl_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <label>Perihal</label>
                            <textarea class="form-control" id="perihal" name="perihal" rows="3" placeholder="Perihal Surat"></textarea>
                        </div>
                        <label>Status</label>
                            <div class="card card-light card-outline">
                              <div class="card-body">                            
                                <div class="custom-control custom-radio d-inline col-md-3">
                                  <input class="custom-control-input custom-control-input-success" type="radio" id="s1" name="status" value="1" checked>
                                    <label for="s1" class="custom-control-label col-md-2">Proses</label>
                                </div>
                                <div class="custom-control custom-radio d-inline col-md-3">
                                  <input class="custom-control-input custom-control-input-info" type="radio" id="s2" name="status" value="2">
                                  <label for="s2" class="custom-control-label col-md-2">Pending</label>
                                </div>
                                <div class="custom-control custom-radio d-inline col-md-3">
                                  <input class="custom-control-input custom-control-input-warning" type="radio" id="s3" name="status" value="3">
                                  <label for="s3" class="custom-control-label col-md-2">Selesai</label>
                                </div>
                              </div>                              
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"> 
                            <div class="row g-3 align-items-center">
                              <div class="col-md-6">
                                <label for="utk_satuan">Untuk Satuan</label>                 
                                <select class="form-control select2" id="utk_satuan" name="utk_satuan">
                                  <option value="" selected="selected"></option>
                                      @foreach ($satuan as $sat)
                                      <option value="{{$sat->idsmkl}}">{{$sat->ur_smkl}}</option>
                                      @endforeach
                                </select>
                              </div>
                              <div class="col-md-6">
                                <label for="nm_domain">Usulan Nama Domain</label>
                                <input type="text" class="form-control" id="nm_domain" name="nm_domain" min="1"> 
                              </div>
                            </div>
                            {{-- <div class="col-md-6"> --}}
                                <label for="nm_domain">Nama Domain</label>
                                <select class="form-control select2" id="id_domain" name="id_domain">
                                  <option value="" selected="selected"> </option>
                                    @foreach ($domain as $dom)
                                      <option value="{{$dom->id}}">{{$sat->nama_domain}}</option>
                                    @endforeach
                                </select>                                 
                              {{-- </div> --}}

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
                            <label>Dokumen : </label>
                            <div id="file_lama">
                              {{-- <button class="btn btn-primary btn-view-file" data-file-url="{{ asset('storage/files/' . $data->file_surat) }}">
                              <i class="fas fa-file"></i>
                              </button> --}}
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


<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Permohonan</h4>
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
                      <label for="" class="col-md-4">Nomor Permohonan</label>
                      <input type="text" class="form-control col-md-7" id="no_mohon" name="no_mohon" value="" disabled>
                    </div>
                    <div class="row mt-1">  
                      <label for="" class="col-md-4">Kotama</label>
                      <input type="text" class="form-control col-md-7" id="kotama" name="kotama" value="" disabled>
                    </div>
                    <div class="row mt-1">  
                      <label for="" class="col-md-4">Satuan</label>
                      <input type="text" class="form-control col-md-7" id="satuan" name="satuan" value="" disabled>
                    </div>
                    <div class="row mt-1">  
                      <label for="" class="col-md-4">Nomor Surat</label>
                      <input type="text" class="form-control col-md-3" id="no_surat" name="no_surat" value="" disabled>
                      <label for="" class="col-md-2">Tgl Surat</label>
                      <input type="text" class="form-control col-md-2" id="tgl_surat" name="tgl_surat" value="" disabled>
                    </div>
                    <div class="row mt-1">
                      <label for="" class="col-md-4">Perihal</label>
                      <textarea class="form-control col-md-7" id="perihal" name="perihal" value="" rows="3" disabled></textarea>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">                    
                    <div class="row mt-1">  
                      <label for="" class="col-md-4">Untuk Satuan</label>
                      <input type="text" class="form-control col-md-7" id="utk_satuan" name="utk_satuan" value="" disabled>
                    </div>                    
                    <div class="row mt-1"> 
                      <label for="" class="col-md-4">Nama Domain</label>
                      <input type="text" class="form-control col-md-7" id="nm_domain" name="nm_domain" value="" disabled>
                    </div>
                    <div class="row mt-1"> 
                      <label for="" class="col-md-4">Status</label>
                      <input type="text" class="form-control col-md-7" id="status" name="status" value="" disabled>
                    </div>
                    <div class="row mt-1">
                      <label for="" class="col-md-4">Klasifikasi</label>
                      <input type="text" class="form-control col-md-7" id="klasifikasi" name="klasifikasi" value="" disabled></input>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Rekapitulasi Status Domain</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <div class="row mt-1">
                    <label for="" class="col-md-6 text-danger text-right">Error :</label>
                    <input type="text" class="form-control col-md-4" id="eror" name="eror" value="" disabled>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <div class="row mt-1">
                    <label for="" class="col-md-6 text-success text-right">Running :</label>
                    <input type="text" class="form-control col-md-4" id="run" name="run" value="" disabled>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <div class="row mt-1">
                    <label for="" class="col-md-6 text-warning text-right">Maintenance :</label>
                    <input type="text" class="form-control col-md-4" id="main" name="main" value="" disabled>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <div class="row mt-1">
                    <label for="" class="col-md-6 text-muted text-right">Suspend :</label>
                    <input type="text" class="form-control col-md-4" id="suspen" name="suspen" value="" disabled>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div> --}}
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

<!-- Modal for Viewing File -->
<div class="modal fade" id="modal-dokumen" tabindex="-1" role="dialog" aria-labelledby="modalDokumenLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Dokumen Permohonan</h4>
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
        "columnDefs": [{ "visible": false, "targets": [ 10, 11, 12] }]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    // Example: Attach the function to a button click
  $(document).on('click', '.btn-view-file', function () {
      const fileUrl = $(this).data('file-url'); // Get the file URL from the button's data attribute
      viewFile(fileUrl);
  });

    $('#modal-tambah .select2').each(function() {  
        var $p = $(this).parent(); 
        $(this).select2({  
            dropdownParent: $p  
        });  
    });

    $('#modal-update .select2').each(function() {  
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
    $(document).on('click', '#showDetail', function(){
      
      let id = $(this).data('id');
      var editURL = $(this).data('url');
      // alert(editURL);
      $.get(editURL, function(data){
            // const ipa = JSON.stringify(data);
          var cek = data[0]['no_surat'];
            console.log(data);
            
          const tglsrt = data[0]['tgl_surat'];
          var options = { year: "numeric", month: "numeric", day: "numeric" };
          const ftglsurat = new Date(tglsrt).toLocaleDateString('es-CL', options); 

          $('#modal-detail').modal('show');
          $('#modal-detail #no_mohon').val(data[0]['no_mohon']);
          $('#modal-detail #kotama').val(data[0]['ur_ktm']);
          $('#modal-detail #satuan').val(data[0]['ur_smkl']);
          $('#modal-detail #no_surat').val(data[0]['no_surat']);
          $('#modal-detail #tgl_surat').val(ftglsurat);
          $('#modal-detail #perihal').val(data[0]['perihal']);
          $('#modal-detail #utk_satuan').val(data[0]['utk_smkl']);
          $('#modal-detail #nm_domain').val(data[0]['nm_domain']);
          $('#modal-update #id_domain').val(data[0]['id_domain']);
        //   if(data[0].file_surat) {
        //     $('#modal-update #file_lama').html(
        //         '<button class="btn btn-primary btn-view-file" data-file-url="{{ asset('storage/files/') }}/'+data[0].file_surat+'"><i class="fas fa-file"></i></button>'
        //     );
        // } else {
        //     $('#modal-update #file_lama').html('Tidak ada file');
        // }

          // $('#modal-detail #file_lama').append('<button class="btn btn-primary btn-view-file" data-file-url="{{ asset('storage/files/') }}/'+data[0]['file_surat']+'"><i class="fas fa-file"></i></button>');
          if(data[0]['sts'] == '1'){
            $('#modal-detail #status').val('Proses');
          } else if(data[0]['sts'] == '2'){
            $('#modal-detail #status').val('Selesai');
          } else {
            $('#modal-detail #status').val('Unknown');
          }
          $('#modal-detail #klasifikasi').val(data[0]['klasifikasi'] == 'u' ? 'Urgent/Mendesak' : (data[0]['klasifikasi'] == 'i' ? 'Important/Penting' : ''));        
      })  
    });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('click', '#viewMessage', function(){
        var editURL = $(this).data('url');
        $.get(editURL, function(data){
            console.log(data);
            var sts = data[0].status;
            // alert(sta);
          $('#modal-update').modal('show');
          $('#modal-update #no_mohon').val(data[0].no_mohon);
          $('#modal-update #kotama').val(data[0].kd_ktm);
          $('#modal-update #satuan').val(data[0].kd_smkl).trigger('change');
          $('#modal-update #no_surat').val(data[0].no_surat);
          $('#modal-update #tgl_surat').val(data[0].tgl_surat);
          $('#modal-update #perihal').val(data[0].perihal);
          $('#modal-update #utk_satuan').val(data[0].utk_satuan).trigger('change');
          $('#modal-update #nm_domain').val(data[0].nm_domain);
          $('#modal-update #id_domain').val(data[0].id_domain);
          if(data[0].file_surat) {
            $('#modal-update #file_lama').html(
                '<button class="btn btn-primary btn-view-file" data-file-url="{{ asset('storage/files/') }}/'+data[0].file_surat+'"><i class="fas fa-file"></i></button> '+data[0].file_surat
            );
          } else {
              $('#modal-update #file_lama').html('Tidak ada file');
          }
          if(data[0].status == '1'){
              $("#modal-update #s1").prop("checked",true);
          }else if(data[0].status == '2'){
              $("#modal-update #s2").prop("checked",true);
          }else{
              $("#modal-update #s3").prop("checked",true);
          }
          $('#modal-update #klasifikasi').val(data[0].klasifikasi);
        })
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
          window.location.href = "{{ route('permohonan.index') }}whm"; // Redirect setelah OK ditekan
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
                        $('#utk_satuan').empty();
                        $('#utk_satuan').append('<option value="">Pilih Satuan</option>');
                        $.each(data, function (key, value) {
                            $('#utk_satuan').append('<option value="' + value.idsmkl + '">' + value.ur_smkl + '</option>');
                        });
                    }
                });
                $.ajax({
                    url: '/get-domain/' + kdktm,
                    type: "GET",
                    data: { kd_ktm: kdktm },
                    success: function (data) {
                        // console.log(data);
                        $('#domain').empty();                        
                        $('#domain').append('<option value=""> </option>');
                        $.each(data, function (key, value) {
                            $('#satuan').append('<option value="' + value.id + '">' + value.nama_domain + '</option>');
                        });
                    }
                });
            } else {
                $('#satuan').empty();
                $('#satuan').append('<option value="">Pilih Satuan</option>');
                $('#utk_satuan').empty();
                $('#utk_satuan').append('<option value="">Pilih Satuan</option>');
            }
        });

        $('#utk_satuan').change(function () {
            var id_smkl = $(this).val();
            // console.log(id_smkl);
            if (id_smkl) {
                $.ajax({
                    url: '/get-domain/' + id_smkl,
                    type: "GET",
                    data: { kd_smkl: id_smkl },
                    success: function (data) {
                        // console.log(data);
                        $('#nm_domain').empty();                        
                        $('#nm_domain').append('<option value=""> </option>');
                        $.each(data, function (key, value) {
                            $('#nm_domain').append('<option value="' + value.id + '">' + value.nama_domain + '</option>');
                        });
                    }
                });
            } else {
                $('#domain').empty();
                $('#domain').append('<option value="">Pilih Satuan</option>');
            }
        });
    });
    
    $(document).ready(function() {
      $('#form-create-adu').submit(function(e) {
          e.preventDefault();
          var formData = new FormData(this);
          // alert(formData);

                $.ajax({
                    url: "{{ route('permohonan.store') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Data:', response);
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
    $('#modal-update').on('click', '#simpanEdit', function(e){
          e.preventDefault();
          var nid = $('#modal-update #id').val();
          dataForm = $('#modal-update').serialize() + "&_token={{ csrf_token() }}";
          // alert(dataForm);    
          $.ajax({
              type: 'PUT',
              url: "{{ route('permohonan.update', ':id') }}".replace(':id', nid),
              data: dataForm,
              dataType: 'json',
              success: function(response) {
                    if(response.status == 200) {
                        alert(response.pesan);
                        window.location.href = "{{ route('permohonan.index') }}";
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
