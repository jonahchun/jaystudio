<template>
<div v-if="invoices.data.length">
    <div class="table-responsive">
        <table class="info-table">
            <colgroup>
                <col v-for="column in columns" :style="getColStyle(column)"></col>
            </colgroup>
            <thead>
                <tr>
                    <td v-for="column in columns">{{ column.label }}</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="invoice in this.invoices.data">
                    <td>{{ invoice.invoice_id }}</td>
                    <td>
                        <svg v-show="invoice.type == 1" class="icon icon-card"><use xlink:href="#icon-card"></use></svg>
                        <svg v-show="invoice.type == 2" class="icon icon-cash"><use xlink:href="#icon-cash"></use></svg>
                    </td>
                    <td>{{ invoice.due_date_formated }}</td>
                    <!-- <td>${{ invoice.tax_amount }}</td> -->
                    <td><b>${{ invoice.amount }}</b></td>
                    <td>
                        <span :class="'label-' + invoice.status_label.toLowerCase()">{{ invoice.status_label }}</span>
                    </td>
                    <td><button class="btn-default" @click="viewDetails(invoice)">Details</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <pagination v-if="is_listing" :paginator="invoices" @load="loadInvoices" entityTitle="Invoices" />
</div>
<div v-else>There are no invoices right now</div>
</template>

<script>
import axios from "axios";
    
export default {
    props: ['initial_invoices', 'detail_url', 'is_listing'],
    data() {
        return {
            columns: [
                {label: 'Number', width: '28'},
                {label: 'Type', width: '17'},
                {label: 'Due Date', width: '20'},
                {label: 'Total', width: '17'},
                {label: 'Status', width: '18'},
                {label: '', width: ''},
            ],
            invoices : this.invoices
        };
    },
    beforeMount() {
        console.log(this.detail_url)
        this.invoices = this.initial_invoices;
    },
    methods: {
        loadInvoices: function(urlLink) {
            axios.get(urlLink)
                .then(response => {
                    this.invoices = response.data;
                });
        },
        viewDetails: function(invoice) {
            window.location.href = this.detail_url.replace('__id__', invoice.id);
        },
        getColStyle: function(column) {
            return column.width ? 'width:' + column.width + '%;' : '';
        }
    }
}
</script>
