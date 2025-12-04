<script>
    // Static Mapping
    const mapping = {
       "10601000":{acct_code_old: "201", classification_code: "Land"},
       "10602990":{acct_code_old: "202", classification_code: "Land Improvement"},
       "10604010":{acct_code_old: "211", classification_code: "Building and Structure*"},
       "10604990":{acct_code_old: "215", classification_code: "Other Structures*"},
       "10605020":{acct_code_old: "221", classification_code: "Office Equipment*"},
       "10605110":{acct_code_old: "233", classification_code: "Medical, Dental & Laboratory Equipment"},
       "10606010":{acct_code_old: "241", classification_code: "Motor Vehicles *"},
       "10605140":{acct_code_old: "236", classification_code: "Technical    & Scientific Equipment *"},
       "10605990":{acct_code_old: "240", classification_code: "Other Machineries & Equipment"},
       "10605130":{acct_code_old: "235", classification_code: "Sports Equipment"},
       "10605030":{acct_code_old: "223", classification_code: "Information and Communication Tech. Equip*"},
       "10605070":{acct_code_old: "229", classification_code: "Communication Equipment"},
       "10699990":{acct_code_old: "250", classification_code: "Other PPE / Industrial Machines & Implements / Hand Tools"},
       "225-E":{acct_code_old:    "254", classification_code: "Artesian Wells"},
       "10607010":{acct_code_old: "222", classification_code: "Office Furnitures *"},
       "10605120":{acct_code_old: "", classification_code: "Printing Equipment"},   
       "10605010":{acct_code_old: "", classification_code: "Machinery & Equipment"},
       "10603060":{acct_code_old: "", classification_code: "Communication Network GIA-13"},      
       "218":{acct_code_old: "", classification_code: "Donation - JICA"}
       
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