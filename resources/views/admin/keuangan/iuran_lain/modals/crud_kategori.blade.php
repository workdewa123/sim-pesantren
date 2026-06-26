<div id="modalTambahKategori" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl border border-slate-200 w-full max-w-md overflow-hidden shadow-xl text-xs">
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-700 text-sm"><i class="fa-solid fa-folder-plus text-amber-600 mr-1"></i> Tambah Program Iuran</h3>
            <button type="button" onclick="closeModal('modalTambahKategori')" class="text-slate-400 hover:text-slate-600 text-base"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.keuangan.iuran_lain.store') }}" method="POST" class="p-4 space-y-4">
            @csrf
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Nama Program Iuran</label>
                <input type="text" name="nama_iuran" placeholder="Contoh: RENOVASI MUSHOLLA / KITAB BULANAN" required class="w-full px-3 py-1.5 rounded-xl border border-slate-200 uppercase focus:outline-none focus:border-amber-600">
            </div>
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Tahun Hijriyah</label>
                <input type="number" name="tahun_hijriyah" value="1447" required class="w-full px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeModal('modalTambahKategori')" class="px-4 py-2 bg-slate-100 rounded-xl font-bold text-slate-600">Batal</button>
                <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-xl font-bold shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditKategori" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl border border-slate-200 w-full max-w-md overflow-hidden shadow-xl text-xs">
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-700 text-sm"><i class="fa-solid fa-pen-to-square text-blue-600 mr-1"></i> Edit Program Iuran</h3>
            <button type="button" onclick="closeModal('modalEditKategori')" class="text-slate-400 hover:text-slate-600 text-base"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="formEditKategori" method="POST" class="p-4 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Nama Program Iuran</label>
                <input type="text" name="nama_iuran" id="edit_nama_iuran" required class="w-full px-3 py-1.5 rounded-xl border border-slate-200 uppercase focus:outline-none focus:border-blue-600">
            </div>
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Tahun Hijriyah</label>
                <input type="number" name="tahun_hijriyah" id="edit_tahun_hijriyah" required class="w-full px-3 py-1.5 rounded-xl border border-slate-200 focus:outline-none">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeModal('modalEditKategori')" class="px-4 py-2 bg-slate-100 rounded-xl font-bold text-slate-600">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-bold shadow-sm">Perbarui</button>
            </div>
        </form>
    </div>
</div>