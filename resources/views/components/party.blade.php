<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>

.form-group {
    display: flex;
    align-items: center;
    justify-content: flex-end; /* Align items to the right */
    margin-bottom: 10px;
}

.form-group label {
    margin-left: 68%; /* Add some spacing between label and select */
}

.party-select-container {
    width: 25%; /* Adjust width as needed */
    margin-left: auto; /* Push select to the right */
}

.party-select {
    width: 100%; /* Ensure select takes up full width */
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    cursor: pointer;
}

.party-select option {
    padding: 8px;
}

</style>

<div class="form-group">
    <label for="partySelect"><b>Party :</b></label>
    <div class="party-select-container">
        <select id="partySelect" class="party-select">
            <option value="" disabled selected>Choose an option</option>
            @foreach($options as $key => $value)
                <option value="{{ $key }}"{{ $selected == $key ? ' selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>




<script>
$(document).ready(function() {
    $('.party-select-container select').select2({
        closeOnSelect : true,
        placeholder : "Choose an option",
        allowHtml: true,
        allowClear: true,
        tags: true
    });
});
</script>