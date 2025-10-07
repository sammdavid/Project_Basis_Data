@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <!-- Page Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex align-items-center">
        @if(Auth::guard('admin')->check())
          <a href="{{ route('admin.kelola-pengaduan') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
          </a>
        @else
          <a href="{{ route('riwayat') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
          </a>
        @endif
        <div>
          <h2 class="fw-bold mb-1">Edit Pengaduan</h2>
          <p class="text-muted mb-0">Ubah detail pengaduan Anda sebelum diproses</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <!-- Alert Info -->
      <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-info-circle-fill me-2"></i>
        <div>
          Anda hanya dapat mengedit pengaduan yang belum diproses oleh admin.
        </div>
      </div>

      <!-- Form Card -->
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
          {{-- Ini untuk cek yang update user atau admin --}}
          <form action="{{ Auth::guard('admin')->check() ? route('admin.pengaduan.update', $pengaduan) : route('pengaduan.update', $pengaduan) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if(Auth::guard('admin')->check())
            <div class="p-3 rounded mb-4" style="background-color: #f8f9fa;">
                <h5 class="fw-bold">Panel Admin</h5>
                <hr>

                @if($pengaduan->tindakLanjut->isNotEmpty())
                <div class="mb-4">
                    <label class="form-label fw-semibold">Riwayat Tindak Lanjut</label>
                    <div class="list-group">
                        @foreach($pengaduan->tindakLanjut->sortByDesc('created_at') as $tindakLanjut)
                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                                <p class="mb-1">{{ $tindakLanjut->deskripsi }}</p>
                                <small class="text-nowrap">{{ $tindakLanjut->created_at->diffForHumans() }}</small>
                            </div>
                            <small class="text-muted">Oleh: Admin ID {{ $tindakLanjut->admin_id }}</small>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ubah Status Pengaduan</label>
                    <select name="status_pengaduan" class="form-select form-select-lg" required>
                        @foreach(['Menunggu', 'Diproses', 'Selesai'] as $status)
                            <option value="{{ $status }}" @if(old('status_pengaduan', $pengaduan->status_pengaduan) == $status) selected @endif>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tambah Catatan Tindak Lanjut Baru</label>
                    <textarea name="deskripsi_tindak_lanjut" rows="4" required class="form-control form-control-lg">{{ old('deskripsi_tindak_lanjut') }}</textarea>
                    <small class="text-muted">Catatan ini akan ditambahkan sebagai riwayat baru.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Upload Bukti Investigasi (Opsional)</label>
                    <input type="file" name="bukti[]" multiple class="form-control" accept="image/*,.pdf">
                    <small class="text-muted">Bukti yang di-upload di sini akan ditandai sebagai bukti dari admin.</small>
                </div>
            </div>
            @endif

            <!-- Kategori -->
            <div class="mb-4">
              <label class="form-label fw-semibold">Kategori Pengaduan</label>
              <select name="kategori_komplain_id" class="form-select form-select-lg" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori_komplain as $k)
                  <option value="{{ $k->kategori_komplain_id }}" @if($pengaduan->kategori_komplain_id == $k->kategori_komplain_id) selected @endif>
                    {{ $k->jenis_komplain }}
                  </option>
<<<<<<< HEAD
=======
                  <option value="{{ $k->kategori_komplain_id }}" @if($pengaduan->kategori_komplain_id == $k->kategori_komplain_id) selected @endif>
                    {{ $k->jenis_komplain }}
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
              <label class="form-label fw-semibold">Deskripsi Kejadian</label>
              <textarea name="deskripsi_kejadian" rows="6" required class="form-control form-control-lg">{{ $pengaduan->deskripsi_kejadian }}</textarea>
              <small class="text-muted">Jelaskan secara rinci mengenai kejadian yang anda alami</small>
            </div>

            <!-- Tanggal Kejadian -->
            <div class="mb-4">
              <label class="form-label fw-semibold">Tanggal Kejadian</label>
              <input type="date" name="tanggal_kejadian" value="{{ $pengaduan->tanggal_kejadian }}" class="form-control form-control-lg">
            </div>

            <!-- Status Pelapor -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Status Pelapor <span class="text-danger">*</span></label>
                <select name="status_pelapor" required class="form-select form-select-lg">
                    <option value="">-- Pilih Status --</option>
                    <option value="Korban" {{ old('status_pelapor', $pengaduan->status_pelapor) == 'Korban' ? 'selected' : '' }}>Korban</option>
                    <option value="Keluarga" {{ old('status_pelapor', $pengaduan->status_pelapor) == 'Keluarga' ? 'selected' : '' }}>Keluarga Korban</option>
                    <option value="Teman" {{ old('status_pelapor', $pengaduan->status_pelapor) == 'Teman' ? 'selected' : '' }}>Teman/Kenalan</option>
                    <option value="Saksi" {{ old('status_pelapor', $pengaduan->status_pelapor) == 'Saksi' ? 'selected' : '' }}>Saksi Mata</option>
                </select>
                <small class="text-muted">Anda sebagai apa dalam kejadian ini?</small>
            </div>

            <!-- Upload Bukti -->
            @if(!Auth::guard('admin')->check())
                <div class="mb-4">
                    <label class="form-label fw-semibold">Upload Bukti Tambahan (Opsional)</label>
                    <input type="file" name="bukti[]" multiple class="form-control" accept="image/*,.pdf">
                    <small class="text-muted">Biarkan kosong jika tidak ingin menambah bukti</small>
                </div>
            @endif

            <!-- Existing Files -->
            @if($pengaduan->bukti && count($pengaduan->bukti) > 0)
            <div class="mb-4">
                <label class="form-label fw-semibold">Bukti yang Sudah Ada</label>
                <div class="file-preview-list mt-2"> 
                    @foreach($pengaduan->bukti as $bukti)
                        @php
                            $filePath = asset('storage/' . $bukti->file_path);
                            $fileName = $bukti->nama_file;
                            $fileSizeKB = (isset($bukti->ukuran_file)) ? round($bukti->ukuran_file / 1024, 2) : null;
                            $extension = strtolower(pathinfo($bukti->file_path, PATHINFO_EXTENSION));
                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
                            $isImage = in_array($extension, $imageExtensions);
                        @endphp

                        <div class="file-item" id="existing-file-{{ $bukti->bukti_pengaduan_id }}">
                            
                            @if($isImage)
                                <img src="{{ $filePath }}" alt="{{ $fileName }}" class="file-thumbnail" onclick="showImageModal('{{ $filePath }}')">
                            @else
                                <i class="bi bi-file-earmark-text"></i>
                            @endif

                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $fileName }}</div>
                                @if($fileSizeKB)
                                    <small class="text-muted">{{ $fileSizeKB }} KB</small>
                                @endif
                            </div>

                            <a href="{{ $filePath }}" target="_blank" class="ms-2 text-muted" title="Buka di tab baru">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>

                            <i class="bi bi-x-circle remove-file" 
                              onclick="markForDeletion(this, {{ $bukti->bukti_pengaduan_id }})"></i>
                            
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

<div id="deletedBuktiContainer"></div>

            <!-- Buttons -->
            <div class="d-flex gap-3">
              <button type="submit" class="btn btn-lg text-white px-5" style="background: linear-gradient(135deg, #6B21A8, #7C3AED); border: none;">
                <i class="bi bi-save me-2"></i>Simpan Perubahan
              </button>
              @if(Auth::guard('admin')->check())
              <a href="{{ route('admin.kelola-pengaduan') }}" class="btn btn-lg btn-outline-secondary px-4">
                Batal
              </a>
              @else
              <a href="{{ route('riwayat') }}" class="btn btn-lg btn-outline-secondary px-4">
                Batal
              </a>
              @endif
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
        <div class="card-body p-4 text-white">
          <h6 class="fw-bold mb-3">
            <i class="bi bi-exclamation-triangle me-2"></i>Perhatian
          </h6>
          <ul class="mb-0 ps-3" style="font-size: 0.9rem;">
            <li class="mb-2">Setelah diproses admin, pengaduan tidak dapat diedit</li>
            <li class="mb-2">Pastikan informasi yang Anda berikan akurat</li>
            <li class="mb-0">Perubahan akan langsung tersimpan</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
    .file-item {
        display: flex;
        align-items: center;
        padding: 10px;
        background: #f9fafb;
        border-radius: 8px;
        margin-bottom: 8px;
        gap: 10px;
        border: 1px solid #eee;
        margin-top: 8px;
    }
    .file-thumbnail {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
        cursor: pointer;
    }
    .file-item > .bi {
        font-size: 1.5rem;
        color: #6c757d;
        width: 40px;
        text-align: center;
    }
    .file-item .flex-grow-1 {
        overflow: hidden;
    }
    .file-item .flex-grow-1 .fw-semibold {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .remove-file {
        margin-left: auto;
        cursor: pointer;
        color: #ef4444;
        font-size: 1.25rem;
    }
    .remove-file:hover {
        color: #a71d2a;
    }
    .image-preview-modal {
        display: none;
        position: fixed;
        z-index: 1001;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.85);
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .modal-image-container {
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
        background-color: transparent;
        line-height: 0;
    }
    .modal-content {
        display: block;
        object-fit: contain;
        max-width: 90%;
        max-height: 90vh;
        animation-name: zoom;
        animation-duration: 0.3s;
        cursor: default;
    }
    @keyframes zoom {
        from {transform: scale(0.8)}
        to {transform: scale(1)}
    }
    .close-modal-btn {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }
    .close-modal-btn:hover,
    .close-modal-btn:focus {
        color: #bbb;
        text-decoration: none;
    }
</style>

<script>
const buktiInput = document.getElementById('buktiInput');
const filePreview = document.getElementById('filePreview');
const modal = document.getElementById('imageModal');
const modalImage = document.getElementById('modalImage');

let allFiles = []; 

buktiInput.addEventListener('change', function(e) {
  const newFiles = Array.from(e.target.files);
  allFiles = allFiles.concat(newFiles);
  const dt = new DataTransfer();
  allFiles.forEach(file => dt.items.add(file));
  buktiInput.files = dt.files;
  renderFilePreview(allFiles);
});

function renderFilePreview(files) {
  filePreview.innerHTML = ''; 
    Array.from(files).forEach((file, index) => {
    const fileItem = document.createElement('div');
    fileItem.className = 'file-item';
        if (file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const imageUrl = e.target.result;
        fileItem.innerHTML = `
          <img src="${imageUrl}" alt="${file.name}" class="file-thumbnail" onclick="showImageModal('${imageUrl}')">
          <div class="flex-grow-1">
            <div class="fw-semibold">${file.name}</div>
            <small class="text-muted">${(file.size / 1024).toFixed(2)} KB</small>
          </div>
          <i class="bi bi-x-circle remove-file" onclick="removeFile(${index})"></i>
        `;
      };
      reader.readAsDataURL(file);
    } else {
      fileItem.innerHTML = `
        <i class="bi bi-file-earmark-text"></i>
        <div class="flex-grow-1">
          <div class="fw-semibold">${file.name}</div>
          <small class="text-muted">${(file.size / 1024).toFixed(2)} KB</small>
        </div>
        <i class="bi bi-x-circle remove-file" onclick="removeFile(${index})"></i>
      `;
    }
    filePreview.appendChild(fileItem);
  });
}
function markForDeletion(iconElement, buktiId) {
  if (!confirm('Anda yakin ingin menghapus bukti ini? File akan dihapus permanen saat Anda menyimpan perubahan.')) {
      return;
  }
  
  // 1. Temukan elemen .file-item terdekat
  const fileItem = iconElement.closest('.file-item');
  if (fileItem) {
      // Sembunyikan dari tampilan
      fileItem.style.display = 'none';
  }
  
  const container = document.getElementById('deletedBuktiContainer');
  
  const hiddenInput = document.createElement('input');
  hiddenInput.type = 'hidden';
  hiddenInput.name = 'delete_bukti[]';
  hiddenInput.value = buktiId;
  container.appendChild(hiddenInput);
}
function showImageModal(src) {
  modal.style.display = "flex";
  modalImage.src = src;
}

function closeImageModal(event) {
  if (event) {
    event.stopPropagation(); 
  }
  modal.style.display = "none";
}
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection