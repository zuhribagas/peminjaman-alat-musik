@extends('layouts.app')

@section('title', 'Ajukan Sewa')

@section('sidebar')
    @include('user.components.sidebar')
@endsection

@section('navbar')
    @include('layouts.navigation')
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-premium">
                <div class="card-header border-bottom-0 pt-4 pb-0">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-dark">Formulir Peminjaman</h3>
                        <p class="text-muted">Isi detail di bawah untuk menyewa alat</p>
                    </div>
                </div>

                <div class="card-body p-4 pt-0">
                    <form action="{{ route('user.peminjaman.store') }}" method="POST" id="peminjamanForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase small text-muted">1. Pilih Alat Pancing</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <select class="form-select form-select-lg border-start-0 ps-0 bg-light" id="alat_id" name="alat_id" required style="border-radius: 0 8px 8px 0;">
                                    <option value="">Cari alat yang tersedia...</option>
                                    @foreach($alats as $alat)
                                        <option value="{{ $alat->id }}" 
                                                {{ old('alat_id') == $alat->id ? 'selected' : '' }}
                                                data-stok="{{ $alat->stok_tersedia }}"
                                                data-harga="{{ $alat->harga_sewa_per_hari }}"
                                                data-nama="{{ $alat->nama_alat }}"
                                                data-img="{{ $alat->foto ? asset('storage/'.$alat->foto) : '' }}">
                                            {{ $alat->nama_alat }} - Rp {{ number_format($alat->harga_sewa_per_hari, 0) }}/hari
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase small text-muted">2. Tentukan Durasi</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small text-muted mb-1">Mulai Pinjam</label>
                                    <input type="date" class="form-control form-control-lg" 
                                           id="tanggal_pinjam" name="tanggal_pinjam" 
                                           value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" 
                                           min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-muted mb-1">Rencana Kembali</label>
                                    <input type="date" class="form-control form-control-lg" 
                                           id="tanggal_kembali_rencana" name="tanggal_kembali_rencana" 
                                           value="{{ old('tanggal_kembali_rencana') }}" 
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>
                            </div>
                            <div class="mt-2 d-none" id="durationBadge">
                                <span class="badge badge-soft-info px-3 py-2">
                                    <i class="bi bi-clock-history me-2"></i>Durasi: <span id="durasiText">0 Hari</span>
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase small text-muted">3. Informasi Tambahan</label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="1" min="1" placeholder="Jumlah (Unit)" required>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="keperluan" placeholder="Tujuan peminjaman (Opsional)" >
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 bg-primary bg-opacity-10 rounded-4 mb-4" id="priceCalculator" style="display: none;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-receipt me-2"></i>Rincian Biaya</h5>
                                    <span class="badge bg-white text-primary shadow-sm" id="calc_nama_badge">-</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 opacity-75">
                                    <span>Harga Sewa</span>
                                    <span id="calc_harga_per_hari">Rp 0 x 0 hari</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 opacity-75">
                                    <span>Biaya Layanan</span>
                                    <span>Rp 0</span>
                                </div>
                                <hr class="border-primary opacity-25 my-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">Total Pembayaran</span>
                                    <span class="fs-3 fw-bold text-primary" id="calc_total">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-premium btn-lg py-3 shadow-lg">
                                Ajukan Peminjaman Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('peminjamanForm');
    const alatSelect = document.getElementById('alat_id');
    const tanggalPinjam = document.getElementById('tanggal_pinjam');
    const tanggalKembali = document.getElementById('tanggal_kembali_rencana');
    const jumlahInput = document.getElementById('jumlah');
    const priceCalculator = document.getElementById('priceCalculator');
    const durationBadge = document.getElementById('durationBadge');
    const submitBtn = document.querySelector('button[type="submit"]');

    // Helper: Format Rupiah
    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    function calculatePrice() {
        // Kalkulasi harga hanya visual, tidak blocking form submit
        const selectedOption = alatSelect.options[alatSelect.selectedIndex];
        
        if (!selectedOption.value || !tanggalPinjam.value || !tanggalKembali.value) {
            priceCalculator.style.display = 'none';
            return;
        }

        const hargaPerHari = parseFloat(selectedOption.dataset.harga) || 0;
        const namaAlat = selectedOption.dataset.nama || '-';
        const jumlah = parseInt(jumlahInput.value) || 1;

        const date1 = new Date(tanggalPinjam.value);
        const date2 = new Date(tanggalKembali.value);

        // Jika tanggal kembali < pinjam, user mungkin belum selesai input, biarkan saja (jangan return error blocking)
        // Hidden calculator jika invalid date logic
        if (date2 <= date1) {
            priceCalculator.style.display = 'none';
            durationBadge.classList.add('d-none');
            return;
        }

        const diffTime = Math.abs(date2 - date1);
        const diffDays = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
        const totalBiaya = hargaPerHari * diffDays * jumlah;

        // Update UI
        document.getElementById('calc_nama_badge').textContent = namaAlat;
        document.getElementById('calc_harga_per_hari').textContent = `${formatRupiah(hargaPerHari)} x ${diffDays} hari x ${jumlah} unit`;
        document.getElementById('calc_total').textContent = formatRupiah(totalBiaya);
        document.getElementById('durasiText').textContent = `${diffDays} Hari`;
        priceCalculator.style.display = 'block';
        durationBadge.classList.remove('d-none');
    }

    // Event Listeners sederhana
    alatSelect.addEventListener('change', function() {
        // Update max stok visual
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const stok = parseInt(selectedOption.dataset.stok) || 0;
            jumlahInput.max = stok;
            if (parseInt(jumlahInput.value) > stok) jumlahInput.value = stok;
            
            // Info stok
            let helpText = document.getElementById('stokHelp');
            if(!helpText) {
                helpText = document.createElement('div');
                helpText.id = 'stokHelp';
                helpText.className = 'form-text text-info fw-bold';
                jumlahInput.parentNode.appendChild(helpText);
            }
            helpText.innerHTML = `Stok: ${stok} Unit`;
        }
        calculatePrice();
    });

    tanggalPinjam.addEventListener('change', calculatePrice);
    tanggalKembali.addEventListener('change', calculatePrice);
    jumlahInput.addEventListener('input', calculatePrice);

    // Form Submit "Akalin"
    form.addEventListener('submit', function(e) {
        // Validasi Basic Stok
        const selectedOption = alatSelect.options[alatSelect.selectedIndex];
        const stok = parseInt(selectedOption.dataset.stok) || 999; // Default 999 if fail
        const jumlah = parseInt(jumlahInput.value) || 1;

        if (jumlah > stok) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Stok Kurang',
                text: 'Jumlah melebihi stok tersedia!',
                confirmButtonColor: '#d33'
            });
            return;
        }

        // UX: Ganti text tombol
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
        
        // JANGAN DISABLE LANGSUNG! 
        // Delay sedikit agar event submit terkirim ke browser/server
        setTimeout(() => {
            submitBtn.classList.add('disabled');
            submitBtn.style.pointerEvents = 'none'; // Prevent double click css way
        }, 100);
        
        // Biarkan form submit berjalan (no e.preventDefault)
    });
});
</script>
@endsection
