<div id="modalEditKas" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4 sm:p-6">
    <div class="bg-white rounded-2xl border border-slate-200 w-full max-w-md overflow-hidden shadow-xl text-xs animate-in fade-in duration-200 max-h-[90vh] flex flex-col">
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between shrink-0">
            <h3 class="font-bold text-slate-700 text-sm"><i class="fa-solid fa-pen-to-square text-blue-600 mr-1"></i> Perbarui Catatan Transaksi Kas</h3>
            <button type="button" onclick="closeModal('modalEditKas')" class="text-slate-400 hover:text-slate-600 text-base transition-colors"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <form id="formEditKas" method="POST" class="p-4 space-y-3.5 overflow-y-auto flex-1">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Tanggal</label>
                    <input type="date" name="tanggal_transaksi" id="edit_tanggal_transaksi" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-600 bg-slate-50/50">
                </div>
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Kategori Master</label>
                    <select id="edit_kas_kategori_id" name="kategori" required class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-blue-600">
                        <option value="">-- Pilih Master --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->nama_kategori }}" data-tipe="{{ $kat->tipe_kategori }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Jenis Sifat Kas</label>
                    <select id="edit_jenis_transaksi_input" name="jenis_transaksi" required class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-700 font-bold pointer-events-none focus:outline-none">
                        <option value="pemasukan">Pemasukan</option>
                        <option value="pengeluaran">Pengeluaran</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Nominal Transaksi (Rp)</label>
                    <input type="number" name="nominal" id="edit_nominal" min="1" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-600 font-bold text-slate-800">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Metode Arus Pembayaran</label>
                <div class="grid grid-cols-2 gap-3 font-bold text-slate-700">
                    <label class="border border-slate-200 p-2.5 rounded-xl flex items-center justify-center gap-1.5 cursor-pointer hover:bg-slate-50 transition-colors">
                        <input type="radio" name="edit_metode_pembayaran" value="cash" class="text-blue-600 focus:ring-0"> 
                        <span><i class="fa-solid fa-money-bill-wave text-slate-400 mr-0.5"></i>Cash</span>
                    </label>
                    <label class="border border-slate-200 p-2.5 rounded-xl flex items-center justify-center gap-1.5 cursor-pointer hover:bg-slate-50 transition-colors">
                        <input type="radio" name="edit_metode_pembayaran" value="rekening" class="text-blue-600 focus:ring-0"> 
                        <span><i class="fa-solid fa-credit-card text-slate-400 mr-0.5"></i>Rekening</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Keterangan Tambahan / Deskripsi</label>
                <textarea name="keterangan" id="edit_keterangan" rows="2" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-600"></textarea>
            </div>

            <div class="flex gap-2 pt-2 border-t border-slate-100 shrink-0">
                <button type="button" onclick="closeModal('modalEditKas')" class="flex-1 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-colors">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition-colors">Perbarui</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Sinkronisasi otomatis saat form edit diubah kategorinya
    document.getElementById('edit_kas_kategori_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const tipe = selectedOption.getAttribute('data-tipe');
        if (tipe) {
            document.getElementById('edit_jenis_transaksi_input').value = tipe;
        }
    });
</script>