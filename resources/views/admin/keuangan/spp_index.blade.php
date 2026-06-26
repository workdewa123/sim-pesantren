@extends('layouts.keuangan')

@section('title', 'Manajemen Syahriyah')
@section('page_title', 'Pencatatan Khusus Syahriyah / SPP')

@section('content')
<div class="space-y-4 text-xs">
    @if(session('success'))
        <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl font-medium">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.keuangan.spp.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-5 gap-3 items-end">
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Cari Nama Santri</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama santri..." class="w-full px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600">
            </div>
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Bulan Hijriyah</label>
                <select name="bulan" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600">
                    <option value="">-- Semua Bulan --</option>
                    @foreach([1=>'Muharram','Safar','Rabiul Awal','Rabiul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Syaban','Ramadhan','Syawal','Dzulqaidah','Dzulhijjah'] as $key => $val)
                        <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Kelas</label>
                <select name="kelas_id" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($daftarKelas as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Tipe Santri</label>
                <select name="jenis_santri" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600">
                    <option value="">-- Semua Tipe --</option>
                    <option value="mukim" {{ request('jenis_santri') == 'mukim' ? 'selected' : '' }}>Mukim</option>
                    <option value="non-mukim" {{ request('jenis_santri') == 'non-mukim' ? 'selected' : '' }}>Non-Mukim</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-emerald-800 hover:bg-emerald-900 text-white font-bold rounded-xl py-2 shadow-sm transition-colors">
                    <i class="fa-solid fa-filter mr-1"></i> Saring
                </button>
                <button type="button" onclick="openModalPembayaran()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl py-2 shadow-sm transition-colors text-center">
                    <i class="fa-solid fa-plus mr-1"></i> Bayar SPP
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold uppercase text-slate-400 tracking-wider">
                    <tr>
                        <th class="p-3">Santri & Identitas</th>
                        <th class="p-3 text-center">Bulan Hijriyah</th>
                        <th class="p-3 text-center">Metode</th>
                        <th class="p-3 text-right">Nominal</th>
                        <th class="p-3 text-center">Penerima Kas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($daftarSpp as $row)
                    @php
                        $listBulan = [1=>'Muharram','Safar','Rabiul Awal','Rabiul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Syaban','Ramadhan','Syawal','Dzulqaidah','Dzulhijjah'];
                    @endphp
                    <tr class="hover:bg-slate-50/40">
                        <td class="p-3">
                            <p class="font-bold text-slate-800">{{ $row->santri->nama_santri ?? 'Santri Terhapus' }}</p>
                            <p class="text-[10px] text-slate-400 font-medium">
                                Kelas: {{ $row->santri->kelas->nama_kelas ?? 'Tanpa Kelas' }} | 
                                <span class="capitalize">{{ $row->santri->jenis_santri ?? '-' }}</span>
                            </p>
                        </td>
                        <td class="p-3 text-center text-slate-600 font-medium whitespace-nowrap">
                            {{ $listBulan[$row->bulan] ?? $row->bulan }} {{ $row->tahun }} H
                        </td>
                        <td class="p-3 text-center whitespace-nowrap">
                            <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase {{ $row->metode_pembayaran == 'cash' ? 'bg-amber-100 text-amber-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $row->metode_pembayaran }}
                            </span>
                        </td>
                        <td class="p-3 text-right font-bold text-emerald-700 whitespace-nowrap">
                            Rp {{ number_format($row->nominal_bayar, 0, ',', '.') }}
                        </td>
                        <td class="p-3 text-center whitespace-nowrap text-slate-500">
                            {{ $row->nama_bendahara }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-slate-400 font-medium">Tidak ada riwayat pembayaran Syahriyah.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($daftarSpp->hasPages())
        <div class="p-3 bg-slate-50 border-t border-slate-100">{{ $daftarSpp->links() }}</div>
        @endif
    </div>
</div>

<div id="modalPembayaran" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl border border-slate-200 w-full max-w-md overflow-hidden shadow-xl text-xs animate-in fade-in duration-200">
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-700 text-sm"><i class="fa-solid fa-cash-register text-emerald-600 mr-1"></i> Loket Kasir Pembayaran</h3>
            <button type="button" onclick="closeModalPembayaran()" class="text-slate-400 hover:text-slate-600 text-base"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.keuangan.spp.store') }}" method="POST" class="p-4 space-y-3.5">
            @csrf
            <div>
                <label class="block font-semibold text-slate-600 mb-1">1. Pilih Kamar/Kelas Target</label>
                <select name="kelas_id" id="modal_kelas_id" required onchange="loadSantriByKelas(this.value)" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($daftarKelas as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">2. Pilih Nama Santri Aktif</label>
                <select name="santri_id" id="modal_santri_id" required onchange="autoFillNominal()" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600" disabled>
                    <option value="">-- Pilih Kelas Terlebih Dahulu --</option>
                </select>
            </div>

            <div class="bg-slate-50 p-2.5 border border-slate-100 rounded-xl flex justify-between items-center">
                <span class="font-medium text-slate-500">Nominal Kewajiban Bulanan:</span>
                <span id="label_nominal" class="font-extrabold text-slate-800 text-sm">Rp 0</span>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Bulan Hijriyah</label>
                    <select name="bulan" required class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600">
                        @foreach([1=>'1. Muharram','2. Safar','3. Rabiul Awal','4. Rabiul Akhir','5. Jumadil Awal','6. Jumadil Akhir','7. Rajab','8. Syaban','9. Ramadhan','10. Syawal','11. Dzulqaidah','12. Dzulhijjah'] as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Tahun Hijriyah</label>
                    <input type="number" name="tahun" required value="1447" placeholder="Contoh: 1447" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Metode Alur Dana (Jalur Penyimpanan)</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="border border-slate-200 p-2 rounded-xl flex items-center gap-2 cursor-pointer hover:bg-slate-50">
                        <input type="radio" name="metode_pembayaran" value="cash" checked class="text-emerald-600 focus:ring-0">
                        <div>
                            <p class="font-bold text-slate-700">Cash / Tunai</p>
                            <p class="text-[10px] text-slate-400">Pegang Fisik di Kasir</p>
                        </div>
                    </label>
                    <label class="border border-slate-200 p-2 rounded-xl flex items-center gap-2 cursor-pointer hover:bg-slate-50">
                        <input type="radio" name="metode_pembayaran" value="rekening" class="text-emerald-600 focus:ring-0">
                        <div>
                            <p class="font-bold text-slate-700">Transfer Bank</p>
                            <p class="text-[10px] text-slate-400">Masuk Saldo Rekening</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-2 flex gap-2">
                <button type="button" onclick="closeModalPembayaran()" class="flex-1 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-colors">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow-sm transition-colors">Simpan & Bukukan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalPembayaran() {
        document.getElementById('modalPembayaran').classList.remove('hidden');
    }
    function closeModalPembayaran() {
        document.getElementById('modalPembayaran').classList.add('hidden');
    }

    // Dynamic AJAX Dependent Dropdown (Kelas -> Santri)
    function loadSantriByKelas(kelasId) {
        const santriSelect = document.getElementById('modal_santri_id');
        santriSelect.innerHTML = '<option value="">-- Memuat Data Santri... --</option>';
        santriSelect.disabled = true;
        
        if(!kelasId) {
            santriSelect.innerHTML = '<option value="">-- Pilih Kelas Terlebih Dahulu --</option>';
            return;
        }

        fetch(`{{ url('admin/keuangan/spp/get-santri-by-kelas') }}/${kelasId}`)
            .then(res => res.json())
            .then(data => {
                santriSelect.innerHTML = '<option value="">-- Pilih Nama Santri --</option>';
                if(data.length === 0) {
                    santriSelect.innerHTML = '<option value="">Tidak ada santri aktif di kelas ini</option>';
                    return;
                }
                data.forEach(santri => {
                    // Menyimpan data biaya awal pada attribute element option
                    santriSelect.innerHTML += `<option value="${santri.id}" data-biaya="${santri.pilihan_biaya}">${santri.nama_santri} (${santri.jenis_santri})</option>`;
                });
                santriSelect.disabled = false;
            });
    }

    // Auto Fill Nominal Berdasarkan Data Pilihan Biaya Santri Terpilih
    function autoFillNominal() {
        const selectSantri = document.getElementById('modal_santri_id');
        const selectedOption = selectSantri.options[selectSantri.selectedIndex];
        const biaya = selectedOption.getAttribute('data-biaya');
        
        if(biaya) {
            const formatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(biaya);
            document.getElementById('label_nominal').innerText = formatted;
        } else {
            document.getElementById('label_nominal').innerText = 'Rp 0';
        }
    }
</script>
@endsection