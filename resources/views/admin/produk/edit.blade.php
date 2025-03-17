@extends('admin.template.master')

@section('css')

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
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
                <a href="{{ route('produk.index') }}" class="btn btn-sm btn-warning float-sm-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                
                  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Penambahan Produk</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
            
            <form id="form-update-produk" method="PUT">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="serialNumber">Serial Number</label>
                                <input type="text" id="serialNumber" name="serialNumber" value="{{ $produks->serialNumber }}" class="form-control" readonly>
                                <label for="namaProduk">Nama Produk</label>
                                <input type="text" id="namaProduk" name="namaProduk" value="{{ $produks->namaProduk }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_pengadaan">Tanggal Pengadaan</label>
                                <input type="date" 
                                    class="form-control @error('tgl_pengadaan') is-invalid @enderror" 
                                    id="tgl_pengadaan" name="tgl_pengadaan" data-date-format="dd/mm/yyyy" 
                                    value="{{ $produks->tgl_pengadaan }}" 
                                    required>
                                    
                                @error('tgl_pengadaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label for="deskripsi">Deskripsi Produk</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" value="" rows="3">{{ $produks->deskripsi }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <button type="button" id="btnClear" class="btn btn-outline-light"><i class="fa fa-undo"></i> Batal</button>
                    </div>               
                </div>
            </form>
        </div>        
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
    
  </div>
  <!-- /.content-wrapper -->

@endsection  

@section('js')
<script>
    function formatDate(input) {
        const date = new Date(input.value);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        input.value = `${day}-${month}-${year}`;
    }
</script>
<script>
    $(document).ready(function() {
        $('#form-update-produk').submit(function(e) {
            e.preventDefault();
            dataForm = $(this).serialize() + "&_token={{ csrf_token() }}"+"&id={{ $produks->id }}";

            $.ajax({
                type: 'PUT',
                url: "{{ route('produk.update', ':id') }}".replace(':id', {{ $produks->id}}),
                data: dataForm,
                dataType: 'json',
                success: function(response) {
                    if(response.status == 200) {
                        alert(response.pesan);
                        window.location.href = "{{ route('produk.index') }}";
                    } else {
                        alert(response.pesan);
                    }
                },
                error: function(response) {
                    // console.log(response);
                    if(response.status == 500) {
                        alert(response.pesan);
                    } else {
                        alert('Terjadi kesalahan! Cek Ulang Data, Silakan coba lagi.');
                    }
                }
            });
        });

        $('#btnClear').click(function() {
        // Undo semua input dalam form
        //    $('#serialNumber').val('{{ $produks->serialNumber }}');
            $('#namaProduk').val('{{ $produks->namaProduk }}');
            $('#deskripsi').val('{{ $produks->deskripsi }}');
            $('#tgl_pengadaan').val('{{ $produks->tgl_pengadaan }}');
        });
    });
</script>
@endsection
