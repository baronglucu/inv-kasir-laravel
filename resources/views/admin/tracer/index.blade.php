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
    #loading {
            display: none;
            margin: 20px 0;
            text-align: center;
        }
        #results {
            margin-top: 20px;
        }
        .status-indicator {
            margin-bottom: 10px;
        }
  </style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0">{{ $title }}</h1>
        <p>{{ $subtitle }}</p>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-4">IP Domain Tracer</h2>
            </div>
            <div class="card-body">
                <form id="traceForm">
                    @csrf
                    <div class="mb-3">
                        <label for="target" class="form-label">Target (Domain/IP)</label>
                        <input type="text" id="target" name="target" class="form-control" placeholder="Contoh: google.com atau 8.8.8.8" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tracer</button>
                </form>
                <div id="loading" class="mt-3" style="display:none;">
                    <div class="spinner-border text-primary" role="status"></div>
                    <span>Menelusuri...</span>
                </div>
                <div id="results" class="mt-4"></div>
            </div>
        </div>
      </div>
    </section>
</div>
@endsection

@section('js')
<script>
// document.getElementById('traceForm').addEventListener('submit', function(e) {
//     e.preventDefault();
//     const target = document.getElementById('target').value.trim();
//     const resultsDiv = document.getElementById('results');
//     const loading = document.getElementById('loading');
//     resultsDiv.innerHTML = '';
//     if(!target) return;

//     loading.style.display = 'block';

//     fetch("{{ route('tracer.check') }}", {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': '{{ csrf_token() }}'
//         },
//         body: JSON.stringify({ target: target })
//     })
//     .then(res => res.json())
//     .then(data => {
//         loading.style.display = 'none';
//         if(data.success) {
//             resultsDiv.innerHTML = '<pre class="bg-dark text-light p-3 rounded">${data.output}</pre>';
//         } else {
//             resultsDiv.innerHTML = '<div class="alert alert-danger">Traceroute gagal atau target tidak ditemukan.</div>';
//         }
//     })
//     .catch(() => {
//         loading.style.display = 'none';
//         resultsDiv.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan saat melakukan traceroute.</div>';
//     });
// });

document.getElementById('traceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const target = document.getElementById('target').value.trim();
    const resultsDiv = document.getElementById('results');
    const loading = document.getElementById('loading');
    resultsDiv.innerHTML = '';
    if(!target) return;

    loading.style.display = 'block';

    fetch("{{ route('tracer.check') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ target: target })
    })
    .then(res => res.json())
        .then(data => {
        loading.style.display = 'none';
        if(data.success) {
            let html = `<pre class="bg-dark text-light p-3 rounded">${data.output}</pre>`;
            if(data.geo && Object.keys(data.geo).length > 0) {
                html += `<h5 class="mt-3">Lokasi IP Hop:</h5><ul>`;
                Object.entries(data.geo).forEach(([ip, lokasi]) => {
                    html += `<li><b>${ip}</b>: ${lokasi}</li>`;
                });
                html += `</ul>`;
            }
            resultsDiv.innerHTML = html;
        } else {
            resultsDiv.innerHTML = `<div class="alert alert-danger">${data.error ?? 'Traceroute gagal atau target tidak ditemukan.'}</div>`;
        }
    })
    .catch(() => {
        loading.style.display = 'none';
        resultsDiv.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan saat melakukan traceroute.</div>';
    });
});
</script>
@endsection
