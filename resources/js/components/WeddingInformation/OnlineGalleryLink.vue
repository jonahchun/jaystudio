<template>
    <div v-if="this.link.length">
        <a :href="link" style="color:blue; text-decoration: underline;" target="_blank">{{ name }}</a>
    </div>

</template>

<script>
import axios from "axios";

export default {
    props: ['link', 'name']
}
</script>
