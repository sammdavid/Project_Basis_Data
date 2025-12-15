@extends('layouts.app')

@section('content')
<div class="container-fluid animate-fade-in">

  <!-- ================= HEADER ================= -->
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="fw-bold mb-2">Visualisasi Data</h2>
      <p class="text-muted">Analisis dan statistik pengaduan dalam bentuk grafik</p>
    </div>
  </div>

  <!-- ================= OVERVIEW ================= -->
  <div class="row g-4 mb-4 justify-content-center">
    <div class="col-lg-6 col-md-6">
      <div class="card border-0 shadow-sm h-100"
           style="background: linear-gradient(135deg, #6B21A8, #7C3AED);">
        <div class="card-body p-4 text-white">
          <h6 class="mb-3 opacity-75">Total Pengaduan</h6>
          <h2 class="fw-bold mb-2" id="totalPengaduan">0</h2>
          <small class="opacity-75">Data dari Data Warehouse</small>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-6">
      <div class="card border-0 shadow-sm h-100"
           style="background: linear-gradient(135deg, #f59e0b, #d97706);">
        <div class="card-body p-4 text-white">
          <h6 class="mb-3 opacity-75">Rata-rata Waktu Proses</h6>
          <h2 class="fw-bold mb-2" id="avgWaktu">—</h2>
          <small class="opacity-75">Hari</small>
        </div>
      </div>
    </div>
  </div>

<!-- ================= ROW 1 ================= -->
<div class="row g-4 mb-4">
  <div class="col-lg-6">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-white border-0 p-4">
        <h5 class="fw-bold mb-0">Tren Pengaduan Bulanan</h5>
        <small class="text-muted">Berdasarkan waktu</small>
      </div>
      <div class="card-body p-4">
        <canvas id="monthlyTrendChart" height="120"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-white border-0 p-4">
        <h5 class="fw-bold mb-0">Perbandingan Waktu Respon</h5>
        <small class="text-muted">Rata-rata per kategori (hari)</small>
      </div>
      <div class="card-body p-4">
        <canvas id="responseTimeChart" height="120"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- ================= ROW 2 ================= -->
<div class="row g-4 mb-4">
  <div class="col-lg-6">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-white border-0 p-4">
        <h5 class="fw-bold mb-0">Kategori Pengaduan</h5>
        <small class="text-muted">Distribusi berdasarkan jenis</small>
      </div>
      <div class="card-body p-4">
        <canvas id="categoryPieChart"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-white border-0 p-4">
        <h5 class="fw-bold mb-0">Status Pengaduan</h5>
        <small class="text-muted">Distribusi status</small>
      </div>
      <div class="card-body p-4">
        <canvas id="statusChart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Charts Row 3 -->
<div class="row g-4 mb-4">
  <div class="col-lg-12">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-0 p-4">
        <h5 class="fw-bold mb-0">Performa Admin Bulanan</h5>
        <small class="text-muted">Total tiket ditangani per admin (berdasarkan data warehouse)</small>
      </div>
      <div class="card-body p-4">
        <div class="chart-box-lg">
          <canvas id="adminPerformanceChart"></canvas>
        </div>
        
      </div>

    </div>
  </div>
</div>


</div>

<!-- ================= STYLE ================= -->
<style>
.animate-fade-in {
  animation: fadeIn 0.6s ease-out;
}
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

<style>
  .chart-box-lg{
    position: relative;
    height: 380px;   /* coba 320-520 sesuai selera */
    width: 100%;
  }
</style>

</style>

<!-- ================= SCRIPT ================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {

  // TOTAL
  const summary = await fetch('/api/visualisasi/summary').then(r => r.json());
  document.getElementById('totalPengaduan').innerText = summary.total_pengaduan;

  // KATEGORI
  const kategori = await fetch('/api/visualisasi/kategori').then(r => r.json());
  new Chart(categoryPieChart, {
    type: 'doughnut',
    data: {
      labels: kategori.map(x => x.label),
      datasets: [{
        data: kategori.map(x => x.value),
        backgroundColor: ['#6B21A8','#0ea5f0','#ef4444','#f59e0b','#8b5cf6']
      }]
    },
    options: { plugins: { legend: { position: 'bottom' } } }
  });

  // STATUS
  const status = await fetch('/api/visualisasi/status').then(r => r.json());
  new Chart(statusChart, {
    type: 'pie',
    data: {
      labels: status.map(x => x.label),
      datasets: [{
        data: status.map(x => x.value),
        backgroundColor: ['#10b981','#f59e0b','#ef4444']
      }]
    },
    options: { plugins: { legend: { position: 'bottom' } } }
  });

  // =========================
// ADMIN PERFORMANCE (BULANAN)
// =========================
try {
  const res = await fetch('/api/visualisasi/performa-admin-bulanan');
  const rows = await res.json();

  // bikin label bulan: 2025-12, 2026-01 dst
  const monthKey = (r) => `${r.tahun}-${String(r.bulan).padStart(2,'0')}`;

  // list bulan unik urut
  const labels = [...new Set(rows.map(monthKey))];

  // list admin unik
  const admins = [...new Set(rows.map(r => r.admin))];

  // dataset per admin (bar stacked atau line; ini bar biasa)
  const datasets = admins.map((admin) => {
    const data = labels.map((lbl) => {
      const hit = rows.find(r => r.admin === admin && monthKey(r) === lbl);
      return hit ? Number(hit.total) : 0;
    });
    return {
      label: admin,
      data,
      borderWidth: 1
    };
  });

  new Chart(document.getElementById('adminPerformanceChart'), {
    type: 'bar',
    data: { labels, datasets },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'bottom' }
      },
      scales: {
        y: { beginAtZero: true, title: { display: true, text: 'Jumlah Tiket' } }
      }
    }
  });
} catch (e) {
  console.warn('Performa admin bulanan gagal', e);
}


  // RESPONSE TIME
  const rt = await fetch('/api/visualisasi/response-time').then(r => r.json());
  new Chart(responseTimeChart, {
    type: 'bar',
    data: {
      labels: rt.map(x => x.label),
      datasets: [{
        data: rt.map(x => Number(x.value)),
        backgroundColor: 'rgba(107,33,168,0.8)'
      }]
    },
    options: {
      scales: { y: { beginAtZero: true } },
      plugins: { legend: { display: false } }
    }
  });

   // =========================
  // MONTHLY TREND (REAL)
  // =========================
  try {
    const rows = await fetch('/api/visualisasi/trend-bulanan').then(r => r.json());

    // kalau API balik kosong, fallback
    if (!Array.isArray(rows) || rows.length === 0) throw new Error('Data trend kosong');

    const labels  = rows.map(r => `${String(r.bulan).padStart(2,'0')}/${r.tahun}`);
    const totals  = rows.map(r => Number(r.total || 0));
    const selesai = rows.map(r => Number(r.selesai || 0));

    new Chart(document.getElementById('monthlyTrendChart'), {
      type: 'line',
      data: {
        labels,
        datasets: [
          {
            label: 'Total Pengaduan',
            data: totals,
            borderColor: '#6B21A8',
            backgroundColor: 'rgba(107,33,168,0.12)',
            tension: 0.35,
            fill: true
          },
          {
            label: 'Selesai',
            data: selesai,
            borderColor: '#10b981',
            backgroundColor: 'rgba(16,185,129,0.10)',
            tension: 0.35,
            fill: true
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: { legend: { position: 'top' } }
      }
    });

  } catch (e) {
    console.warn('Trend bulanan gagal, pakai placeholder:', e);

    // fallback placeholder kalau error
    new Chart(document.getElementById('monthlyTrendChart'), {
      type: 'line',
      data: { labels: ['-'], datasets: [{ label: 'Belum tersedia', data: [0] }] }
    });
  }

  // AVG WAKTU PROSES
  try {
    const res = await fetch('/api/visualisasi/avg-waktu-proses');
    const d = await res.json();

    document.getElementById('avgWaktu').innerText =
      d.avg_hari !== null ? d.avg_hari : '—';
  } catch {
    document.getElementById('avgWaktu').innerText = '—';
  }



});
</script>

<link rel="stylesheet"
 href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection
