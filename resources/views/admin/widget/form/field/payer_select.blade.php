<select 
    class="form-control"
    name="{{ $name }}"
    @if(!empty($required))
    required
    @endif
    data-value="{{ $value }}"
></select>
<script type="text/javascript">
$(function() {
    var payerSelect = {
        url: "{{ route('admin.payments.invoices.payers', ['customer' => '__customer__']) }}",
        init: function() {
            this.customerSelect = $('select[name="customer_id"]');
            this.payerSelect = $('select[name="{{ $name }}"]');
            this.customerSelect.change(this.updatePayerSelect.bind(this));
            this.updatePayerSelect();
        },
        updatePayerSelect: function() {
            this.customerId = this.customerSelect.val();
            var url = this.url.replace('__customer__', this.customerId);
            var _this = this;
            $.ajax({
                url: url,
                success: function(response) {
                    _this.payerSelect.html('');
                    $(response.newlyweds).each(function(index, data) {
                        _this._addOption(data, 'newlywed');
                    });
                    $(response.contacts).each(function(index, data) {
                        _this._addOption(data, 'contact');
                    });
                    _this.payerSelect.trigger('change');
                }
            });
        },
        _addOption: function(data, type) {
            var option = $('<option></option>');
            option.html(data.first_name + ' ' + data.last_name);
            var value = type + '_' + data.id;
            option.attr('value', value);
            if(value == this.payerSelect.data('value')) {
                option.attr('selected', 'selected');
            }
            this.payerSelect.append(option);
        },
    };
    payerSelect.init();
});
</script>