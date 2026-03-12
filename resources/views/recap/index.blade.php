@extends('layouts.dashboard')
@section('title', 'RECAP / SUMMARY OF PROPERTY, PLANT AND EQUIPMENT')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="max-w-[1600px] mx-auto px-2 sm:px-4 py-4 space-y-6">
    <div class="bg-white p-4 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="space-y-1">
                <p class="text-[9px] sm:text-[10px] font-black uppercase tracking-[0.2em] sm:tracking-[0.3em] text-indigo-600">Department Of Science & Technology</p>
                <h1 class="text-lg sm:text-xl font-black text-slate-900 leading-tight uppercase tracking-tight">
                    PAGASA - PROPERTY, PLANT AND EQUIPMENT <br class="hidden sm:block">
                    <span class="text-slate-400">RECAP / SUMMARY REPORT</span>
                </h1>
                <p class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-widest mt-2">
                    As of December 31, {{ $year }}
                </p>
            </div>
        </div>
    </div>

    <form id="recapForm" method="POST" action="{{ route('ppe-recap.store') }}">
        @csrf
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full border-collapse text-[10px] sm:text-[11px] min-w-[1200px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="p-4 border-r border-slate-200 font-black text-slate-500 uppercase tracking-widest sticky left-0 bg-slate-50 z-20">Acct Code New</th>
                            <th class="p-4 border-r border-slate-200 font-black text-slate-500 uppercase tracking-widest">Acct Code Old</th>
                            <th class="p-4 border-r border-slate-200 text-left font-black text-slate-500 uppercase tracking-widest min-w-[200px]">Classification</th>
                            <th class="p-4 border-r border-slate-200 font-black text-indigo-600 uppercase tracking-widest bg-indigo-50/30 text-center">Beginning Balance {{ $year }}</th>
                            <th class="p-4 border-r border-slate-200 font-black text-slate-500 uppercase tracking-widest text-center">Purchases {{ $year }}</th>
                            <th class="p-4 border-r border-slate-200 font-black text-slate-500 uppercase tracking-widest text-center min-w-[120px]">Reclassified From Other Accouts</th>
                            <th class="p-4 border-r border-slate-200 font-black text-slate-500 uppercase tracking-widest text-center min-w-[120px]">Reclassified To Other Accounts</th>
                            <th class="p-4 border-r border-slate-200 font-black text-slate-500 uppercase tracking-widest text-center">Disposed</th>
                            <th class="p-4 border-r border-slate-200 font-black text-slate-500 uppercase tracking-widest text-center">Donated</th>
                            <th class="p-4 border-r border-slate-200 font-black text-slate-500 uppercase tracking-widest text-center">Cancelled / Adjustments</th>
                            <th class="p-4 bg-slate-900 font-black text-white uppercase tracking-widest sticky right-0 z-20 text-center">Total as of 12/31/{{ $year }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($records as $i => $r)
                        @php
                            $isFund101 = $r->acct_code_new === 'FUND-101';
                            $isMooe101 = $r->acct_code_new === 'MOOE-101';
                        @endphp
                        <tr class="hover:bg-indigo-50/40 transition-colors group {{ $isFund101 ? 'fund101 bg-slate-50 font-bold' : '' }} {{ $isMooe101 ? 'mooe101 italic' : '' }}">
                            <td class="p-3 border-r border-slate-100 text-center sticky left-0 z-10 {{ $isFund101 ? 'bg-slate-100' : 'bg-white group-hover:bg-indigo-50' }}">
                                {{ $r->acct_code_new }}
                                <input type="hidden" name="data[{{ $i }}][acct_code_new]" value="{{ $r->acct_code_new }}">
                                <input type="hidden" name="data[{{ $i }}][year]" value="{{ $year }}">
                                <input type="hidden" name="data[{{ $i }}][classification]" value="{{ $r->classification }}">
                                <input type="hidden" name="data[{{ $i }}][acct_code_old]" value="{{ $r->acct_code_old }}">
                            </td>
                            <td class="p-3 border-r border-slate-100 text-center font-mono text-slate-400">{{ $r->acct_code_old }}</td>
                            <td class="p-3 border-r border-slate-100 font-semibold text-slate-700 leading-tight uppercase">{{ $r->classification }}</td>
                            
                            <td class="p-1 border-r border-slate-100 bg-indigo-50/10">
                                <input name="data[{{ $i }}][beginning_balance]" value="{{ $r->beginning_balance }}"
                                       class="calc beginning w-full text-right px-3 py-2 bg-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-lg outline-none transition-all {{ $isFund101 ? 'font-black' : '' }}"
                                       {{ $isFund101 ? 'readonly' : '' }}>
                            </td>
                            <td class="p-1 border-r border-slate-100"><input name="data[{{ $i }}][purchases]" value="{{ $r->purchases }}" class="calc purchase w-full text-right px-3 py-2 bg-transparent focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-lg outline-none transition-all" {{ $isFund101 ? 'readonly' : '' }}></td>
                            <td class="p-1 border-r border-slate-100"><input name="data[{{ $i }}][reclass_from]" value="{{ $r->reclass_from }}" class="calc refrom w-full text-right px-3 py-2 bg-transparent focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-lg outline-none transition-all" {{ $isFund101 ? 'readonly' : '' }}></td>
                            <td class="p-1 border-r border-slate-100"><input name="data[{{ $i }}][reclass_to]" value="{{ $r->reclass_to }}" class="calc reto w-full text-right px-3 py-2 bg-transparent focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-lg outline-none transition-all" {{ $isFund101 ? 'readonly' : '' }}></td>
                            <td class="p-1 border-r border-slate-100"><input name="data[{{ $i }}][disposed]" value="{{ $r->disposed }}" class="calc disposed w-full text-right px-3 py-2 bg-transparent focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-lg outline-none transition-all" {{ $isFund101 ? 'readonly' : '' }}></td>
                            <td class="p-1 border-r border-slate-100"><input name="data[{{ $i }}][donated]" value="{{ $r->donated }}" class="calc donated w-full text-right px-3 py-2 bg-transparent focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-lg outline-none transition-all" {{ $isFund101 ? 'readonly' : '' }}></td>
                            <td class="p-1 border-r border-slate-100"><input name="data[{{ $i }}][adjustments]" value="{{ $r->adjustments }}" class="calc adjust w-full text-right px-3 py-2 bg-transparent focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-lg outline-none transition-all" {{ $isFund101 ? 'readonly' : '' }}></td>
                            
                            <td class="p-1 bg-slate-50 sticky right-0 z-10 border-l border-slate-200 shadow-[-4px_0_10px_rgba(0,0,0,0.02)]">
                                <input name="data[{{ $i }}][total]" class="total w-full text-right px-3 py-2 bg-transparent font-black text-slate-900 outline-none" readonly>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-900 text-white font-black uppercase tracking-widest text-[9px] sm:text-[10px] sticky bottom-0 z-30">
                        <tr class="divide-x divide-white/10">
                            <td colspan="3" class="p-5 text-right">GRAND TOTAL</td>
                            <td class="p-3 text-right text-indigo-400" id="gt_beginning"></td>
                            <td class="p-3 text-right" id="gt_purchase"></td>
                            <td class="p-3 text-right" id="gt_refrom"></td>
                            <td class="p-3 text-right" id="gt_reto"></td>
                            <td class="p-3 text-right" id="gt_disposed"></td>
                            <td class="p-3 text-right" id="gt_donated"></td>
                            <td class="p-3 text-right" id="gt_adjust"></td>
                            <td class="p-5 text-right bg-indigo-600 sticky right-0 z-40" id="gt_total"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="flex justify-center sm:justify-end py-8">
            <button type="button" onclick="confirmSave()" class="w-full sm:w-auto flex items-center justify-center gap-3 px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black text-xs sm:text-sm uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-2xl shadow-indigo-200 transition-all transform hover:-translate-y-1 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                Save Inventory Recap
            </button>
        </div>
    </form>
</div>

<style>
    /* User-Friendly Scrolling */
    .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Print Optimization */
    @media print {
        aside, header, .shadow-sm, button { display: none !important; }
        .rounded-3xl, .rounded-2xl { border-radius: 0 !important; border: none !important; }
        body { background: white !important; }
        .max-w-\[1600px\] { max-width: 100% !important; padding: 0 !important; }
    }
</style>

<script>
// --- MATH UTILITIES (ORIGINAL LOGIC) ---
function n(v){
    return parseFloat((v || '0').toString().replace(/,/g,'')) || 0;
}

function f(v){
    return v.toLocaleString('en-US',{minimumFractionDigits:2, maximumFractionDigits:2});
}

// --- CALCULATION LOGIC (ORIGINAL LOGIC - UNCHANGED) ---
function computeTotals() {
    let f101 = { b:0, tot:0 }; 
    let mooe = { b:0, p:0, rf:0, rt:0, d:0, do:0, adj:0, tot:0 };
    let landToJica = { p:0, rf:0, rt:0, d:0, do:0, adj:0 }; 

    document.querySelectorAll('tbody tr').forEach(r => {
        const code = r.querySelector('input[name*="acct_code_new"]')?.value;
        if (code === 'FUND-101') return;

        let b   = n(r.querySelector('.beginning').value);
        let p   = n(r.querySelector('.purchase').value);
        let rf  = n(r.querySelector('.refrom').value);
        let rt  = n(r.querySelector('.reto').value);
        let d   = n(r.querySelector('.disposed').value);
        let doo = n(r.querySelector('.donated').value);
        let a   = n(r.querySelector('.adjust').value);

        let rowTotal = (b + p + rf) - (rt + d + doo) + a;
        r.querySelector('.total').value = f(rowTotal);

        if (code === 'MOOE-101') {
            mooe = { b, p, rf, rt, d, do:doo, adj:a, tot:rowTotal };
        } else {
            f101.b += b;
            f101.tot += rowTotal;
            landToJica.p += p; landToJica.rf += rf; landToJica.rt += rt;
            landToJica.d += d; landToJica.do += doo; landToJica.adj += a;
        }
    });

    let fundRow = document.querySelector('.fund101');
    if (fundRow) {
        fundRow.querySelector('.beginning').value = f(f101.b);
        fundRow.querySelector('.total').value     = f(f101.tot);
        ['.purchase', '.refrom', '.reto', '.disposed', '.donated', '.adjust'].forEach(cls => {
            fundRow.querySelector(cls).value = "0.00";
        });
    }

    document.getElementById('gt_beginning').innerText = f(f101.b + mooe.b);
    document.getElementById('gt_purchase').innerText  = f(landToJica.p + mooe.p);
    document.getElementById('gt_refrom').innerText    = f(landToJica.rf + mooe.rf);
    document.getElementById('gt_reto').innerText      = f(landToJica.rt + mooe.rt);
    document.getElementById('gt_disposed').innerText  = f(landToJica.d + mooe.d);
    document.getElementById('gt_donated').innerText   = f(landToJica.do + mooe.do);
    document.getElementById('gt_adjust').innerText    = f(landToJica.adj + mooe.adj);
    document.getElementById('gt_total').innerText     = f(f101.tot + mooe.tot);
}

// --- SWEETALERT & LISTENERS ---
function confirmSave() {
    Swal.fire({
        title: 'Save Inventory Recap?',
        text: "This will record the data for the fiscal year {{ $year }}.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, save it!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Processing...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            document.getElementById('recapForm').submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Saved!', text: "{{ session('success') }}", timer: 2500, showConfirmButton: false });
    @endif
    computeTotals();
});

document.addEventListener('focus', e => {
    if(e.target.classList.contains('calc') && n(e.target.value) === 0) e.target.value = '';
}, true);

document.addEventListener('blur', e => {
    if(e.target.classList.contains('calc') && e.target.value.trim() === '') {
        e.target.value = '0';
        computeTotals();
    }
}, true);

document.addEventListener('input', e => {
    if(e.target.classList.contains('calc')) computeTotals();
});
</script>
@endsection