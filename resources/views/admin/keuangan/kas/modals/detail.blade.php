<div id="modalDetailKas" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4 sm:p-6">
    <div class="bg-white rounded-2xl border border-slate-200 w-full max-w-md overflow-hidden shadow-2xl text-xs animate-in fade-in zoom-in-95 duration-150 max-h-[85vh] flex flex-col">
        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between shrink-0">
            <h3 class="font-bold text-slate-700 text-sm flex items-center gap-1">
                <i class="fa-solid fa-receipt text-emerald-600"></i> Informasi Rincian Transaksi
            </h3>
            <button type="button" onclick="closeModal('modalDetailKas')" class="text-slate-400 hover:text-slate-600 text-base transition-colors"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="p-5 space-y-4 overflow-y-auto flex-1">
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-center space-y-1.5">
                <p class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Nominal Dana</p>
                <h4 id="detail_nominal" class="text-lg font-black text-slate-800">Rp 0</h4>
                <div class="inline-block">
                    <span id="detail_jenis_badge" class="px-2.5 py-0.5 rounded-full font-black text-[9px] uppercase">
                        -
                    </span>
                </div>
            </div>

            <div class="divide-y divide-slate-100 text-[11px] font-medium text-slate-600">
                <div class="py-2.5 flex justify-between gap-4">
                    <span class="text-slate-400 font-semibold"><i class="fa-regular fa-calendar-days mr-1 w-4 text-slate-300"></i>Tanggal Transaksi</span>
                    <span id="detail_tanggal" class="text-slate-800 font-bold text-right">-</span>
                </div>
                <div class="py-2.5 flex justify-between gap-4">
                    <span class="text-slate-400 font-semibold"><i class="fa-solid fa-tag mr-1 w-4 text-slate-300"></i>Kategori Transaksi</span>
                    <span id="detail_kategori" class="text-slate-800 font-extrabold text-right">-</span>
                </div>
                <div class="py-2.5 flex justify-between gap-4">
                    <span class="text-slate-400 font-semibold"><i class="fa-solid fa-wallet mr-1 w-4 text-slate-300"></i>Metode Pembayaran</span>
                    <span id="detail_metode" class="text-slate-800 font-bold text-right">-</span>
                </div>
                <div class="py-2.5 flex justify-between gap-4">
                    <span class="text-slate-400 font-semibold"><i class="fa-solid fa-user-check mr-1 w-4 text-slate-300"></i>Petugas Bendahara</span>
                    <span id="detail_bendahara" class="text-slate-800 font-bold text-right">-</span>
                </div>
                <div class="py-3 flex flex-col gap-1">
                    <span class="text-slate-400 font-semibold"><i class="fa-solid fa-align-left mr-1 w-4 text-slate-300"></i>Keterangan Lengkap / Alasan</span>
                    <p id="detail_keterangan" class="text-slate-700 bg-slate-50/50 p-2.5 border border-dashed border-slate-200/80 rounded-xl leading-relaxed mt-1 font-normal whitespace-pre-line text-xs">
                        -
                    </p>
                </div>
            </div>
        </div>

        <div class="p-3 bg-slate-50 border-t border-slate-100 text-center shrink-0">
            <button type="button" onclick="closeModal('modalDetailKas')" class="w-full py-2 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl shadow-sm transition-colors">
                Selesai & Tutup
            </button>
        </div>
    </div>
</div>