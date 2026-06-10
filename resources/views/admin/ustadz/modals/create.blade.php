<div id="modal-create-ustadz" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full sm:max-w-xl border border-slate-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Pendaftaran Pengajar Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Masukkan profil lengkap dewan asatidzah pondok.</p>
                </div>
                <button type="button" onclick="closeModal('create')" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <form action="{{ route('admin.ustadz.store') }}" method="POST" class="p-6 space-y-4 text-sm">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap & Gelar</label>
                    <input type="text" name="nama_ustadz" required class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all" placeholder="Contoh: Ustadz Ahmad Fauzi, S.Pd.I">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Keahlian / Spesialisasi</label>
                        <input type="text" name="spesialisasi" required class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all" placeholder="Contoh: Kitab Fathul Qorib">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">No. HP / WA</label>
                        <input type="text" name="no_hp" required class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all" placeholder="085xxx">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Alamat Rumah</label>
                    <textarea name="alamat" rows="3" required class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all" placeholder="Nama jalan, kelurahan, kota asal"></textarea>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('create')" class="px-4 py-2 border border-slate-200 text-slate-500 rounded-xl text-xs font-semibold hover:bg-slate-50 transition-colors">Batal</button>
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-sm">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>