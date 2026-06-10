<div id="modalEdit" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-2xl w-full max-w-xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
        
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-start">
            <div class="flex gap-4">
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-700 shrink-0 border border-amber-100/50">
                    <i class="fa-solid fa-pen-to-square text-base"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-slate-800 tracking-tight">Koreksi Berita Kegiatan</h3>
                    <p class="text-slate-400 text-[11px] mt-0.5 font-medium">Lakukan perbaikan redaksional tulisan atau perbarui lampiran foto.</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modalEdit')" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg hover:bg-slate-50 cursor-pointer">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <form id="formEditKegiatan" method="POST" enctype="multipart/form-data" class="text-xs">
            @csrf
            @method('PUT')
            <div class="px-6 py-4 space-y-4 max-h-[65vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pb-3 border-b border-slate-50">
                    <div class="md:col-span-2">
                        <label class="block font-semibold text-slate-700 mb-1.5">Judul Kegiatan / Agenda</label>
                        <input type="text" name="judul_kegiatan" id="edit_judul" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-amber-600 focus:ring-4 focus:ring-amber-600/5 transition-all">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_kegiatan" id="edit_tanggal" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-amber-600 focus:ring-4 focus:ring-amber-600/5 transition-all">
                    </div>
                </div>

                <div class="pb-3 border-b border-slate-50">
                    <label class="block font-semibold text-slate-700 mb-1.5">Deskripsi Singkat Pengantar</label>
                    <textarea name="text" id="edit_deskripsi" rows="2" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-amber-600 focus:ring-4 focus:ring-amber-600/5 transition-all"></textarea>
                </div>

                <div class="pb-3 border-b border-slate-50">
                    <label class="block font-semibold text-slate-700 mb-1.5">Konten Berita Lengkap</label>
                    <textarea name="konten_lengkap" id="edit_konten" rows="5" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-amber-600 focus:ring-4 focus:ring-amber-600/5 transition-all leading-relaxed"></textarea>
                </div>

                <div class="pb-1">
                    <label class="block font-semibold text-slate-700 mb-1.5">Ganti Foto Dokumentasi Baru <span class="text-slate-400 font-normal">(Biarkan kosong jika tidak ingin diubah)</span></label>
                    <input type="file" name="foto_kegiatan" class="w-full px-2 py-2 rounded-xl border border-slate-200 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-amber-50 file:text-amber-700">
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50/60 border-t border-slate-100 flex justify-end gap-2">
                <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2.5 bg-white text-slate-600 border border-slate-200 rounded-xl font-bold cursor-pointer hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold shadow-sm cursor-pointer">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>