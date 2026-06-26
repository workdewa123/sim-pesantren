<div id="modalLoketBayar" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl border border-slate-200 w-full max-w-md overflow-hidden shadow-xl text-xs">
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-700 text-sm"><i class="fa-solid fa-cash-register text-emerald-600 mr-1"></i> Loket Pembayaran Non-SPP</h3>
            <button type="button" onclick="closeModal('modalLoketBayar')" class="text-slate-400 hover:text-slate-600 text-base"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.keuangan.iuran_lain.bayar') }}" method="POST" class="p-4 space-y-3.5">
            @csrf
            <div>
                <label class="block font-semibold text-slate-600 mb-1">1. Pilih Kelas/Kamar Santri</label>
                <select name="kelas_id" required onchange="loadSantriIuranLain(this.value)" class="w-full px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none">
                    <option value="">-- Pilih Rumpun Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold text-slate-600 mb-1">2. Nama Santri Pembayar</label>
                <select name="santri_id" id="loket_santri_id" required disabled class="w-full px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none">
                    <option value="">-- Pilih Kelas Terlebih Dahulu --</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold text-slate-600 mb-1">3. Pilih Alokasi Program Iuran</label>
                <select name="iuran_lain_id" required class="w-full px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none">
                    <option value="">-- Pilih Program Iuran Aktif --</option>
                    @php $listIuran = \App\Models\IuranLain::orderBy('tahun_hijriyah', 'desc')->get(); @endphp
                    @foreach($listIuran as $il)
                        <option value="{{ $il->id }}">{{ $il->nama_iuran }} ({{ $il->tahun_hijriyah }}H)</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold text-slate-600 mb-1">4. Nominal Pembayaran (Rp)</label>
                <input type="number" name="nominal_bayar" placeholder="Contoh: 50000" required class="w-full px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none">
            </div>
            <div>
                <label class="block font-semibold text-slate-600 mb-1">5. Tanggal Transaksi</label>
                <input type="date" name="tanggal_bayar" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none">
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
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeModal('modalLoketBayar')" class="px-4 py-2 bg-slate-100 rounded-xl font-bold text-slate-600">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold shadow-sm">Simpan & Bukukan Kas</button>
            </div>
        </form>
    </div>
</div>

<script>
function loadSantriIuranLain(kelasId) {
    const sSelect = document.getElementById('loket_santri_id');
    sSelect.innerHTML = '<option value="">-- Memuat... --</option>'; sSelect.disabled = true;
    if(!kelasId) return;

    fetch(`{{ url('admin/keuangan/spp/get-santri-by-kelas') }}/${kelasId}`)
        .then(res => res.json())
        .then(data => {
            sSelect.innerHTML = '<option value="">-- Pilih Nama Santri --</option>';
            data.forEach(s => { 
                sSelect.innerHTML += `<option value="${s.id}">${s.nama_santri.toUpperCase()}</option>`; 
            });
            sSelect.disabled = false;
        });
}
</script>