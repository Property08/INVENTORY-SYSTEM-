@extends('layouts.dashboard')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6">
    <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">
        Edit RECAP / SUMMARY Record
    </h2>

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="max-w-3xl mx-auto mb-6 rounded-lg border border-red-300 bg-red-50 p-4 text-red-700">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('recap.update', $recap->id) }}" method="POST"
          class="bg-white shadow-md rounded-xl p-8 max-w-4xl mx-auto">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Acct. Code New --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Acct. Code New</label>
                <select id="acct_code_new" name="acct_code_new"
                        class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                    <option value="">-- Select --</option>
                    <option value="10601000" {{ $recap->acct_code_new == "10601000" ? 'selected' : '' }}>10601000</option>
                    <option value="10602990" {{ $recap->acct_code_new == "10602990" ? 'selected' : '' }}>10602990</option>
                    <option value="10604010" {{ $recap->acct_code_new == "10604010" ? 'selected' : '' }}>10604010</option>
                    <option value="10604990" {{ $recap->acct_code_new == "10604990" ? 'selected' : '' }}>10604990</option>
                    <option value="10605020" {{ $recap->acct_code_new == "10605020" ? 'selected' : '' }}>10605020</option>
                    <option value="10605110" {{ $recap->acct_code_new == "10605110" ? 'selected' : '' }}>10605110</option>
                    <option value="10606010" {{ $recap->acct_code_new == "10606010" ? 'selected' : '' }}>10606010</option>
                    <option value="10605140" {{ $recap->acct_code_new == "10605140" ? 'selected' : '' }}>10605140</option>
                    <option value="10605990" {{ $recap->acct_code_new == "10605990" ? 'selected' : '' }}>10605990</option>
                    <option value="10605130" {{ $recap->acct_code_new == "10605130" ? 'selected' : '' }}>10605130</option>
                    <option value="10605030" {{ $recap->acct_code_new == "10605030" ? 'selected' : '' }}>10605030</option>
                    <option value="10605070" {{ $recap->acct_code_new == "10605070" ? 'selected' : '' }}>10605070</option>
                    <option value="10699990" {{ $recap->acct_code_new == "10699990" ? 'selected' : '' }}>10699990</option>
                    <option value="225-E"    {{ $recap->acct_code_new == "225-E" ? 'selected' : ''    }}>225-E</option>
                    <option value="10607010" {{ $recap->acct_code_new == "10607010" ? 'selected' : '' }}>10607010</option>
                    <option value="10605120" {{ $recap->acct_code_new == "10605120" ? 'selected' : '' }}>10605120</option>
                    <option value="10605010" {{ $recap->acct_code_new == "10605010" ? 'selected' : '' }}>10605010</option>
                    <option value="10603060" {{ $recap->acct_code_new == "10603060" ? 'selected' : '' }}>10603060</option>  
                    <option value="218"      {{ $recap->acct_code_new == "218" ? 'selected' : ''      }}>218</option>
                </select>
            </div>

            {{-- Acct. Code Old --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Acct. Code Old</label>
                <input type="text" id="acct_code_old" name="acct_code_old"
                       value="{{ $recap->acct_code_old }}"
                       class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       readonly>
            </div>

            {{-- Classification Code --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Classification Code</label>
                <input type="text" id="classification_code" name="classification_code"
                       value="{{ $recap->classification_code }}"
                       class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       readonly>
            </div>

            {{-- Beginning Balance --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Beginning Balance</label>
                <input type="number" step="0.01" name="beginning_balance" value="{{ $recap->beginning_balance }}"
                       class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            {{-- Purchases --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Purchases</label>
                <input type="number" step="0.01" name="purchase_2024" value="{{ $recap->purchase_2024 }}"
                       class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            {{-- Reclassified From Other Accounts --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Reclassified From Other Accounts</label>
                <input type="number" step="0.01" name="reclassified_from_other" value="{{ $recap->reclassified_from_other }}"
                       class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            {{-- Reclassified To Other Accounts --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Reclassified To Other Accounts</label>
                <input type="number" step="0.01" name="reclassified_to_other" value="{{ $recap->reclassified_to_other }}"
                       class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            {{-- Disposed --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Disposed</label>
                <input type="number" step="0.01" name="disposed" value="{{ $recap->disposed }}"
                       class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            {{-- Donated --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Donated</label>
                <input type="number" step="0.01" name="donated" value="{{ $recap->donated }}"
                       class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            {{-- Cancelled / Adjustment --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cancelled / Adjustment</label>
                <input type="number" step="0.01" name="cancelled_adjustment" value="{{ $recap->cancelled_adjustment }}"
                       class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            {{-- Total 2024 --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total 2024</label>
                <input type="number" step="0.01" name="total_2024" value="{{ $recap->total_2024 }}"
                       class="w-full rounded-lg border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        {{-- Buttons --}}
        <div class="mt-8 flex justify-center gap-4">
            <button type="submit"
                    class="px-6 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                Update
            </button>
            <a href="{{ route('recap.index') }}"
               class="px-6 py-2 rounded-lg bg-gray-500 text-white font-semibold hover:bg-gray-600 transition">
                Cancel
            </a>
        </div>
    </form>
</div>

{{-- Mapping Script --}}
<script>
    const mapping = {
         "10601000": { acct_code_old: "201", classification_code: "Land" },
        "10602990": { acct_code_old: "202", classification_code: "Land Improvement" },
        "10604010": { acct_code_old: "211", classification_code: "Building and Structure*" },
        "10604990": { acct_code_old: "215", classification_code: "Other Structures*" },
        "10605020": { acct_code_old: "221", classification_code: "Office Equipment*" },
        "10605110": { acct_code_old: "233", classification_code: "Medical, Dental & Laboratory Equipment" },
        "10606010": { acct_code_old: "241", classification_code: "Motor Vehicles *" },
        "10605140": { acct_code_old: "246", classification_code: "Technical & Scientific Equipment *" },
        "10605990": { acct_code_old: "240", classification_code: "Other Machineries & Equipment" },
        "10605130": { acct_code_old: "235", classification_code: "Sports Equipment" },
        "10605030": { acct_code_old: "223", classification_code: "Information and Communication Tech. Equip*" },
        "10605070": { acct_code_old: "229", classification_code: "Communication Equipment" },
        "10699990": { acct_code_old: "250", classification_code: "Other Property Plant & Equipment / Industrial Machines & Implements / Hand Tools" },
        "225-E":    { acct_code_old: "254", classification_code: "Artesian Wells" },
        "10607010": { acct_code_old: "222", classification_code: "Office Furnitures *" },
        "10605120": {acct_code_old: "", classification_code: "Printing Equipment"},   
        "10605010": {acct_code_old: "", classification_code: "Machinery & Equipment"},
        "10603060":  {acct_code_old: "", classification_code: "Communication Network GIA-13"},      
        "218":       {acct_code_old: "", classification_code: "Donation - JICA"}
    };

    const acctCodeNew = document.getElementById('acct_code_new');
    const acctCodeOld = document.getElementById('acct_code_old');
    const classificationCode = document.getElementById('classification_code');

    // Update on change
    acctCodeNew.addEventListener('change', function () {
        const selected = this.value;
        if (mapping[selected]) {
            acctCodeOld.value = mapping[selected].acct_code_old;
            classificationCode.value = mapping[selected].classification_code;
        } else {
            acctCodeOld.value = "";
            classificationCode.value = "";
        }
    });

    // Trigger once on load (in case record has value)
    if (mapping[acctCodeNew.value]) {
        acctCodeOld.value = mapping[acctCodeNew.value].acct_code_old;
        classificationCode.value = mapping[acctCodeNew.value].classification_code;
    }
</script>
@endsection