<div id="modalEditSpp" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 items-center justify-center hidden p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl border border-slate-200 w-full max-w-sm my-auto overflow-hidden shadow-xl text-xs animate-in fade-in zoom-in-95 duration-200">
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-700 text-sm">Ubah Rekam Syahriyah</h3>
            <button type="button" onclick="closeModal('modalEditSpp')" class="text-slate-400 hover:text-slate-600 text-base"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="formEditSpp" method="POST" class="p-4 space-y-4 max-h-[85vh] overflow-y-auto">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-semibold text-slate-500 mb-1">Nama Santri (Tetap)</label>
                <input type="text" id="edit_spp_nama_santri" disabled class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Baran/Bulan</label>
                    <select name="bulan" id="edit_spp_bulan" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white">
                        @foreach([1=>'Muharram','Safar','Rabiul Awal','Rabiul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Syaban','Ramadhan','Syawal','Dzulqaidah','Dzulhijjah'] as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Tahun Hijriyah</label>
                    <input type="number" name="tahun" id="edit_spp_tahun" class="w-full px-3 py-2 rounded-xl border border-slate-200">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Nominal Iuran (Rp)</label>
                <input type="number" name="nominal_bayar" id="edit_spp_nominal" required class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold text-slate-800">
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Tanggal Bayar Masehi (Optional)</label>
                <input type="date" name="tanggal_bayar" id="edit_spp_tanggal_masehi" class="w-full px-3 py-2 rounded-xl border border-slate-200">
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Petugas Penerima (Bendahara)</label>
                <input type="text" name="nama_bendahara" value="{{ Auth::user()->name }}" readonly class="w-full px-3 py-2 rounded-xl bg-slate-100 border border-slate-200 font-bold text-slate-600 cursor-not-allowed">
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Status Pembayaran</label>
                <div class="flex gap-4 pt-1">
                    <label class="flex items-center gap-1.5 cursor-pointer font-medium text-slate-700">
                        <input type="radio" name="status_pembayaran" value="Belum Lunas" id="edit_status_belum" class="text-emerald-600 focus:ring-emerald-500"> Belum Lunas
                    </label>
                    <label class="flex items-center gap-1.5 cursor-pointer font-medium text-emerald-700">
                        <input type="radio" name="status_pembayaran" value="Lunas" id="edit_status_lunas" class="text-emerald-600 focus:ring-emerald-500"> Lunas
                    </label>
                </div>
            </div>

            <div class="flex gap-2 pt-2">
                <button type="button" onclick="closeModal('modalEditSpp')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 font-bold rounded-xl transition-colors">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition-colors">Perbarui Rekam</button>
            </div>
        </form>
    </div>
</div>