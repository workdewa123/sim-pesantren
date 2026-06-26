<div id="modalEditKategori" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl border border-slate-200 w-full max-w-sm overflow-hidden shadow-xl text-xs">
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-700 text-sm">Ubah Data Kategori</h3>
            <button type="button" onclick="closeModal('modalEditKategori')" class="text-slate-400 hover:text-slate-600 text-base"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="formEditKategori" method="POST" class="p-4 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="edit_nama_kategori" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600">
            </div>
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Jenis Sifat Aliran Kas</label>
                <select name="tipe_kategori" id="edit_tipe_kategori" required class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-emerald-600">
                    <option value="pemasukan">Pemasukan (Uang Masuk)</option>
                    <option value="pengeluaran">Pengeluaran (Uang Keluar)</option>
                </select>
            </div>
            <div class="flex gap-2 pt-2">
                <button type="button" onclick="closeModal('modalEditKategori')" class="flex-1 py-2 bg-slate-100 text-slate-600 font-bold rounded-xl">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-blue-600 text-white font-bold rounded-xl shadow-sm">Perbarui</button>
            </div>
        </form>
    </div>
</div>