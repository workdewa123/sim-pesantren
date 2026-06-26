<div id="modalCreateSpp" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 items-center justify-center hidden p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl border border-slate-200 w-full max-w-md my-auto overflow-hidden shadow-xl text-xs animate-in fade-in zoom-in-95 duration-200">
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-700 text-sm"><i class="fa-solid fa-cash-register text-emerald-600 mr-1"></i> Loket Pembayaran SPP</h3>
            <button type="button" onclick="closeModal('modalCreateSpp')" class="text-slate-400 hover:text-slate-600 text-base"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.keuangan.spp.store') }}" method="POST" class="p-4 space-y-3.5 max-h-[85vh] overflow-y-auto">
            @csrf
            <div>
                <label class="block font-semibold text-slate-600 mb-1">1. Pilih Kamar/Kelas Target</label>
                <select name="kelas_id" id="modal_kelas_id" required onchange="loadSantriByKelas(this.value)" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($daftarKelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">2. Nama Santri / Pembayar</label>
                <select name="santri_id" id="modal_santri_id" required disabled onchange="autoFillNominal()" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white disabled:bg-slate-50 disabled:text-slate-400 font-medium">
                    <option value="">-- Pilih Nama Santri --</option>
                </select>
            </div>

            <div class="bg-slate-50 border border-slate-200/60 p-3 rounded-xl flex items-center justify-between">
                <div>
                    <p class="font-semibold text-slate-500 text-[10px] uppercase tracking-wider">Tarif Wajib Bulanan</p>
                    <p id="label_nominal" class="text-base font-black text-emerald-700 mt-0.5">Rp 0</p>
                </div>
                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg font-bold text-[10px]">Tarif Berkelompok</span>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Target Bulan Hijriyah</label>
                    <select name="bulan" required class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white">
                        @foreach([1=>'Muharram','Safar','Rabiul Awal','Rabiul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Syaban','Ramadhan','Syawal','Dzulqaidah','Dzulhijjah'] as $k => $v)
                            <option value="{{ $k }}" {{ $k == 4 ? 'selected':'' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Tahun Hijriyah</label>
                    <input type="number" name="tahun" required value="1447" class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold text-slate-800">
                </div>
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Tanggal Pembayaran (Masehi)</label>
                    <input type="date" name="tanggal_bayar" required value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 font-medium text-slate-800">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Metode Setor</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="border p-2 rounded-xl flex items-center justify-center gap-1.5 cursor-pointer hover:bg-slate-50 font-medium text-slate-700">
                        <input type="radio" name="metode_pembayaran" value="cash" checked class="text-emerald-600 focus:ring-emerald-500"> <span>Tunai / Cash</span>
                    </label>
                    <label class="border p-2 rounded-xl flex items-center justify-center gap-1.5 cursor-pointer hover:bg-slate-50 font-medium text-slate-700">
                        <input type="radio" name="metode_pembayaran" value="rekening" class="text-emerald-600 focus:ring-emerald-500"> <span>Transfer Bank</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Petugas Pembukuan (Bendahara)</label>
                <input type="text" name="nama_bendahara" value="{{ Auth::user()->name }}" readonly class="w-full px-3 py-2 rounded-xl bg-slate-100 border border-slate-200 font-bold text-slate-600 cursor-not-allowed">
            </div>

            <div class="pt-2 flex gap-2">
                <button type="button" onclick="closeModal('modalCreateSpp')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 font-bold rounded-xl transition-colors">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow-sm transition-colors">Simpan & Bukukan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function loadSantriByKelas(kelasId) {
        const sSelect = document.getElementById('modal_santri_id');
        sSelect.innerHTML = '<option value="">-- Memuat... --</option>'; sSelect.disabled = true;
        if(!kelasId) return;

        fetch(`{{ url('admin/keuangan/spp/get-santri-by-kelas') }}/${kelasId}`)
            .then(res => res.json())
            .then(data => {
                sSelect.innerHTML = '<option value="">-- Pilih Nama Santri --</option>';
                data.forEach(s => { 
                    sSelect.innerHTML += `<option value="${s.id}" data-biaya="${s.pilihan_biaya}">${s.nama_santri}</option>`; 
                });
                sSelect.disabled = false;
            });
    }

    function autoFillNominal() {
        const select = document.getElementById('modal_santri_id');
        if(select.selectedIndex <= 0) {
            document.getElementById('label_nominal').innerText = 'Rp 0';
            return;
        }
        const biaya = select.options[select.selectedIndex].getAttribute('data-biaya');
        if(biaya) {
            document.getElementById('label_nominal').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(biaya);
        } else {
            document.getElementById('label_nominal').innerText = 'Rp 0';
        }
    }
</script>