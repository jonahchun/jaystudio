@php
    $format = !empty($format) ? $format : 'Y-m-d';
@endphp
<input
    @if(!empty($id))
        id="{{ $id }}"
    @endif
    type="text"
    name="{{ $name }}"
    class="form-control"
    value="{{ $value instanceof \Illuminate\Support\Carbon ? $value->format($format) : $value }}"
    data-type="datepicker"
    @if(!empty($required))
        required
    @endif
    @if(!empty($readonly))
        readonly
    disabled
    @endif
/>
@php
    $format = str_replace('Y', 'yyyy', $format);
    $format = str_replace('m', 'mm', $format);
    $format = str_replace('d', 'dd', $format);
@endphp
<script type="text/javascript">
    $(function () {
        const elem = $('input[name="{{ $name }}"]');

        elem.datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(e) {
            elem.datepicker('hide');
        });

        let isProcessing = false;
        elem.on('input paste change', function (e) {
            if (isProcessing) return;

            const isPasteEvent = e.type === 'paste';
            validateInput(elem, isPasteEvent)

        });

        function validateInput(inputElem, shouldOpenPicker = false) {
            const inputDate = inputElem.val().trim();
            if (!inputDate) return;

            isProcessing = true;

            if (isValidDateFormat(inputDate)) {
                const parsedDate = parseMultiFormatDate(inputDate);
                if (parsedDate) {
                    inputElem.datepicker('update', parsedDate);
                    if (shouldOpenPicker) {
                        setTimeout(() => {
                            inputElem.datepicker('show');
                        }, 50);
                    }
                }
            }

            isProcessing = false;
        }

        function isValidDateFormat(dateStr) {
            return /^(0[1-9]|1[0-2])([\/-])(0[1-9]|[12][0-9]|3[01])\2(\d{2}|\d{4})$/.test(dateStr);
        }

        function parseMultiFormatDate(dateStr) {
            if (!dateStr) return null;
            dateStr = dateStr.trim();

            const separator = dateStr.includes('/') ? '/' :
                dateStr.includes('-') ? '-' : null;
            if (!separator) return null;

            const parts = dateStr.split(separator);
            if (parts.length !== 3) return null;

            let [month, day, year] = parts;
            if (year.length === 2) {
                year = (parseInt(year) > 50) ? `19${year}` : `20${year}`;
            }

            const date = new Date(year, month - 1, day);
            return isNaN(date.getTime()) ? null : date;
        }
    });
</script>
