<template>
    <div v-if="this.initial_links.length">
        <div class="table-responsive">
            <table class="info-table">
                <thead>
                    <tr>
                        <td>Type</td>
                        <td>Link</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="link in this.initial_links">
                        <td width="30%">{{ link.type }}</td>
                        <td><a :href="link.link" style="color:blue;    text-decoration: underline;" target="_blank">{{ link.link }}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div v-else>There are no links in you list</div>

</template>

<script>
import axios from "axios";
    
export default {
    props: ['initial_links']
}
</script>
