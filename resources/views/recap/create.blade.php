@extends('layouts.dashboard')

@section('title', 'Add Recap')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <!-- Page Heading -->
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">
        Add Recap
    </h1>

    <!-- Card / Form -->
    <div class="bg-white shadow rounded-xl p-6">
        <form action="{{ route('recap.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Grid of Inputs -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- ACCT.CODE NEW (Dropdown with mapping) -->
                <div>
                    <label for="acct_code_new" class="block text-sm font-medium text-gray-700 mb-1">
                        Acct.Code New <span class="text-red-500">*</span>
                    </label>
                    <select name="acct_code_new" id="acct_code_new"
                            class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">-- Select --</option>
                        <option value="10601000">10601000</option>
                        <option value="10602990">10602990</option>
                        <option value="10604010">10604010</option>
                        <option value="10604990">10604990</option>
                        <option value="10605020">10605020</option>
                        <option value="10605110">10605110</option>
                        <option value="10606010">10606010</option>
                        <option value="10605140">10605140</option>
                        <option value="10605990">10605990</option>
                        <option value="10605130">10605130</option>
                        <option value="10605030">10605030</option>
                        <option value="10605070">10605070</option>
                        <option value="10699990">10699990</option>
                        <option value="10607010">10607010</option>
                        <option value="10605120">10605120</option>
                        <option value="10605010">10605010</option>
                        <option value="10603060">10603060</option>
                        <option value="225-E">225-E</option>
                        <option value="218">218</option>
                    </select>
                    @error('acct_code_new')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ACCT.CODE OLD (auto-filled) -->
                <div>
                    <label for="acct_code_old" class="block text-sm font-medium text-gray-700 mb-1">
                        Acct.Code Old
                    </label>
                    <input type="text" name="acct_code_old" id="acct_code_old"
                           value="{{ old('acct_code_old') }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           readonly>
                    @error('acct_code_old')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Classification Code (auto-filled) -->
                <div>
                    <label for="classification_code" class="block text-sm font-medium text-gray-700 mb-1">
                        Classification Code
                    </label>
                    <input type="text" name="classification_code" id="classification_code"
                           value="{{ old('classification_code') }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           readonly>
                    @error('classification_code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Beginning Balance -->
                <div>
                    <label for="beginning_balance" class="block text-sm font-medium text-gray-700 mb-1">
                        Beginning Balance
                    </label>
                    <input type="number" step="0.01" name="beginning_balance" id="beginning_balance"
                           value="{{ old('beginning_balance') }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Purchases -->
                <div>
                    <label for="purchase_2024" class="block text-sm font-medium text-gray-700 mb-1">
                        Purchases
                    </label>
                    <input type="number" step="0.01" name="purchase_2024" id="purchase_2024"
                           value="{{ old('purchase_2024') }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Reclassified from Other Accounts -->
                <div>
                    <label for="reclassified_from_other" class="block text-sm font-medium text-gray-700 mb-1">
                        Reclassified from Other Accounts
                    </label>
                    <input type="number" step="0.01" name="reclassified_from_other" id="reclassified_from_other"
                           value="{{ old('reclassified_from_other') }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Reclassified to Other Accounts -->
                <div>
                    <label for="reclassified_to_other" class="block text-sm font-medium text-gray-700 mb-1">
                        Reclassified to Other Accounts
                    </label>
                    <input type="number" step="0.01" name="reclassified_to_other" id="reclassified_to_other"
                           value="{{ old('reclassified_to_other') }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Disposed -->
                <div>
                    <label for="disposed" class="block text-sm font-medium text-gray-700 mb-1">
                        Disposed
                    </label>
                    <input type="number" step="0.01" name="disposed" id="disposed"
                           value="{{ old('disposed') }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Donated -->
                <div>
                    <label for="donated" class="block text-sm font-medium text-gray-700 mb-1">
                        Donated
                    </label>
                    <input type="number" step="0.01" name="donated" id="donated"
                           value="{{ old('donated') }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Called / Adjustment -->
                <div>
                    <label for="cancelled_adjustment" class="block text-sm font-medium text-gray-700 mb-1">
                        Called / Adjustment
                    </label>
                    <input type="number" step="0.01" name="cancelled_adjustment" id="cancelled_adjustment"
                           value="{{ old('cancelled_adjustment') }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Total 2024 -->
                <div>
                    <label for="total_2024" class="block text-sm font-medium text-gray-700 mb-1">
                        Total 2024
                    </label>
                    <input type="number" step="0.01" name="total_2024" id="total_2024"
                           value="{{ old('total_2024') }}"
                           class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

            </div><!-- end grid -->

              <!-- Buttons -->
            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('recap.index') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                   Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center px-6 py-2 rounded-lg bg-gradient-to-r bg-blue-500 hover:bg-blue-600 text-white font-bold">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Mapping Script -->
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

    document.getElementById('acct_code_new').addEventListener('change', function () {
        const selected = this.value;
        if (mapping[selected]) {
            document.getElementById('acct_code_old').value = mapping[selected].acct_code_old;
            document.getElementById('classification_code').value = mapping[selected].classification_code;
        } else {
            document.getElementById('acct_code_old').value = "";
            document.getElementById('classification_code').value = "";
        }
    });
</script>
@endsection