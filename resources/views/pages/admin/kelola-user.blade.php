@extends('layouts.app')

@section('content')
<div class="container-fluid animate-fade-in">
  <!-- Page Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="fw-bold mb-2">Kelola User</h2>
          <p class="text-muted mb-0">Manajemen akun pengguna sistem</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
          <i class="bi bi-person-plus me-2"></i>Tambah User Baru
        </button>
      </div>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm hover-lift">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 55px; height: 55px; background: linear-gradient(135deg, #6B21A8, #7C3AED); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-people text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Total User</small>
                        <h4 class="fw-bold mb-0 counter" data-target="{{ $totalUsers }}" style="color: #6B21A8;">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm hover-lift">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 55px; height: 55px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-person-check text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Mahasiswa</small>
                        <h4 class="fw-bold mb-0 counter" data-target="{{ $totalMahasiswa }}" style="color: #10b981;">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm hover-lift">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 55px; height: 55px; background: linear-gradient(135deg, #0ea5f0, #0284c7); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-person-badge text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Staff</small>
                        <h4 class="fw-bold mb-0 counter" data-target="{{ $totalStaff }}" style="color: #0ea5f0;">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm hover-lift">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 55px; height: 55px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-shield-check text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Admin</small>
                        <h4 class="fw-bold mb-0 counter" data-target="{{ $totalAdmin }}" style="color: #f59e0b;">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

  <!-- Filter & Search -->
  <div class="row mb-4">
      <div class="col-12">
          <div class="card border-0 shadow-sm">
              <div class="card-body p-4">
                  <form action="{{ route('admin.kelola-user') }}" method="GET">
                      <div class="row g-3 align-items-end">
                          <div class="col-md-4">
                              <label class="form-label fw-semibold small">Cari User</label>
                              <div class="input-group">
                                  <span class="input-group-text bg-white border-end-0">
                                      <i class="bi bi-search"></i>
                                  </span>
                                  <input type="text" name="search" class="form-control border-start-0" placeholder="Nama, NIM, atau email..." value="{{ request('search') }}">
                              </div>
                          </div>

                          <div class="col-md-3">
                              <label class="form-label fw-semibold small">Role</label>
                              <select class="form-select" name="jenis_pekerjaan_id">
                                  <option value="" {{ request('jenis_pekerjaan_id') == '' ? 'selected' : '' }}>Semua Role</option>
                                  @foreach($jenisPekerjaan as $kerja)
                                      <option value="{{ $kerja->jenis_pekerjaan_id }}" {{ request('jenis_pekerjaan_id') == $kerja->jenis_pekerjaan_id ? 'selected' : '' }}>
                                          {{ $kerja->nama_pekerjaan }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>

                          <div class="col-md-3">
                              <label class="form-label fw-semibold small">Program Studi</label>
                              <select class="form-select" name="prodi_id">
                                  <option value="" {{ request('prodi_id') == '' ? 'selected' : '' }}>Semua Prodi</option>
                                  @foreach($prodis as $prodi)
                                      <option value="{{ $prodi->prodi_id }}" {{ request('prodi_id') == $prodi->prodi_id ? 'selected' : '' }}>
                                          {{ $prodi->nama_prodi }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>

                          <div class="col-md-2">
                              <button type="submit" class="btn btn-primary w-100">
                                  <i class="bi bi-funnel me-1"></i>Filter
                              </button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <!-- User Table -->
  <div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 p-4">
                <h5 class="fw-bold mb-0">Daftar User</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th class="px-4 py-3">Nama</th>
                                <th class="py-3">NIM/NIP</th>
                                <th class="py-3">Email</th>
                                <th class="py-3">Prodi/Unit</th>
                                <th class="py-3">Role</th>
                                <th class="py-3">Bergabung</th>
                                <th class="py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr class="table-row-hover">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #6B21A8, #0ea5f0); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; margin-right: 12px;">
                                            {{ substr($user->nama, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $user->nama }}</div>
                                            <small class="text-muted">{{ $user->pekerjaanfk->nama_pekerjaan ?? 'User' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">{{ $user->nim ?? '-' }}</td>
                                <td class="py-3">{{ $user->email }}</td>
                                <td class="py-3">{{ $user->prodifk->nama_prodi ?? '-' }}</td>
                                <td class="py-3">
                                    @if($user->pekerjaanfk->nama_pekerjaan == 'Mahasiswa')
                                        <span class="badge bg-success">Mahasiswa</span>
                                    @elseif(in_array($user->pekerjaanfk->nama_pekerjaan, ['Dosen/Peneliti', 'Tendik']))
                                        <span class="badge bg-info">Staff</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $user->pekerjaanfk->nama_pekerjaan }}</span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <small>{{ $user->created_at->format('d M Y') }}</small>
                                </td>
                                <td class="py-3 text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.users.edit', $user->user_id) }}" class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('admin.kelola-user.detail', $user->user_id) }}" class="btn btn-outline-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.kelola-user.destroy', $user->user_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus user ini secara permanen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <h5 class="fw-bold">Tidak ada data user.</h5>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-0 p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} user
                    </small>
                    <nav>
                        {{ $users->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
  </div>
    <div class="col-12 mt-4">
      <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-0 p-4">
              <h5 class="fw-bold mb-0">Daftar Admin</h5>
          </div>
          <div class="card-body p-0">
              <div class="table-responsive">
                  <table class="table table-hover mb-0">
                      <thead style="background: #f8f9fa;">
                          <tr>
                              <th class="px-4 py-3">Nama</th>
                              <th class="py-3">Email</th>
                              <th class="py-3">Role</th>
                              <th class="py-3">Bergabung</th>
                              <th class="py-3 text-center">Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                          @forelse ($admins as $admin)
                          <tr class="table-row-hover">
                              <td class="px-4 py-3">
                                  <div class="d-flex align-items-center">
                                      <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; margin-right: 12px;">
                                          {{ substr($admin->nama, 0, 1) }}
                                      </div>
                                      <div>
                                          <div class="fw-semibold">{{ $admin->nama }}</div>
                                          <small class="text-muted">Administrator</small>
                                      </div>
                                  </div>
                              </td>
                              <td class="py-3">{{ $admin->email }}</td>
                              <td class="py-3">
                                  <span class="badge bg-warning text-dark">Admin</span>
                              </td>
                              <td class="py-3">
                                  <small>{{ $admin->created_at->format('d M Y') }}</small>
                              </td>
                              <td class="py-3 text-center">
                                  <div class="btn-group btn-group-sm">
                                      <a href="#" class="btn btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                      <button class="btn btn-outline-danger" title="Hapus" @if($admin->id == 1) disabled @endif>
                                          <i class="bi bi-trash"></i>
                                      </button>
                                  </div>
                              </td>
                          </tr>
                          @empty
                          <tr>
                              <td colspan="5" class="text-center py-5">
                                  <h5 class="fw-bold">Tidak ada data admin.</h5>
                              </td>
                          </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
          <div class="card-footer bg-white border-0 p-4">
              <div class="d-flex justify-content-between align-items-center">
                  <small class="text-muted">
                      Menampilkan {{ $admins->firstItem() }} - {{ $admins->lastItem() }} dari {{ $admins->total() }} admin
                  </small>
                  <nav>
                      {{ $admins->links() }}
                  </nav>
              </div>
          </div>
      </div>
  </div>

</div>

<!-- Modal Add User -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(135deg, #6B21A8, #0ea5f0); color: white;">
        <h5 class="modal-title">
          <i class="bi bi-person-plus me-2"></i>Tambah User Baru
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form id="formTambahUser" action="{{route('admin.kelola-user.store') }}" method="POST">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Nama Lengkap</label>
              <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Email</label>
              <input type="email" name="email" class="form-control" placeholder="@ftmm.unair.ac.id" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">NIM/NIP</label>
              <input type="text" name="nim" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">No. Telepon</label>
              <input type="tel" name="nomor_telepon" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Role</label>
              <select name="jenis_pekerjaan_id" id="role" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                @foreach ($jenisPekerjaan as $jenis)
                    <option value="{{ $jenis->jenis_pekerjaan_id }}">{{ $jenis->nama_pekerjaan }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Program Studi</label>
              <select name="prodi_id" id="prodi" class="form-select" required>
                <option value="">-- Pilih Prodi --</option>
                @foreach ($prodis as $prodi)
                    <option value="{{ $prodi->prodi_id }}">{{ $prodi->nama_prodi }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" class="form-control" required>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" form="formTambahUser">Simpan User</button>

      </div>
    </div>
  </div>
</div>

<style>
.animate-fade-in {
  animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.hover-lift {
  transition: all 0.3s ease;
}

.hover-lift:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.table-row-hover {
  transition: all 0.2s ease;
}

.table-row-hover:hover {
  background: #f9fafb;
  transform: scale(1.005);
}
</style>

<script>
// Counter Animation
document.addEventListener('DOMContentLoaded', function() {
  const counters = document.querySelectorAll('.counter');
  
  counters.forEach(counter => {
    const target = parseInt(counter.getAttribute('data-target'));
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;

    const updateCounter = () => {
      current += step;
      if (current < target) {
        counter.textContent = Math.floor(current);
        requestAnimationFrame(updateCounter);
      } else {
        counter.textContent = target;
      }
    };
    
    updateCounter();
  });
});
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection