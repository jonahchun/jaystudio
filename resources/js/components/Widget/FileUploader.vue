<template>
    <div class="details-forms__file form-control-wrap file-upload">
        <div class="file-upload-container">
            <input type="hidden" :name="name" ref="fileValue" :value="files.join('|')"/>
            <input type="file" class="custom-file-input" :id="`choose-file-${name}`" ref="file" @change="uploadFile" accept="image/*,application/pdf,.docx,.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" multiple />
            <label class="form-control-label" :for="`choose-file-${name}`">
                <span v-if="!files.length">Choose file...</span>
                <!--<span v-else-if="value && !files.length">{{ getUploadedFileName(value) }}</span>-->
                <span v-else v-for="(file,index) in files" :key="file">
                {{ getUploadedFileName(file) }}
                <span type="button" class="btn-remove" @click="removeFile(index)">
                    <svg class="icon icon-trash"><use xlink:href="#icon-trash"></use></svg>
                </span>
            </span>
            </label>
        </div>
        <div v-if="uploadPercentage" class="details-forms__upload">
            {{ `Uploading: ${uploadPercentage}%` }}
            <div class="details-forms__upload-indicator">
                <span :style="{transform: 'translateX('+uploadPercentage+'%)'}"
                      class="details-forms__upload-indicator-bar"></span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['name', 'value'],
    data() {
        return {
            files: [],
            uploadPercentage: 0,
        }
    },
    watch: {
        value(){
            this.files = [];
            if(this.value){
                // console.log('file value',this.value)
                if(this.value.includes('|')){
                    let values = this.value.split('|');
                    values.forEach(v=>this.files.push(v))
                }else{
                    this.files.push(this.value);
                }
            }

        }
    },
    mounted(){
        this.files = [];
        if(this.value){
            // console.log('file value',this.value)
            if(this.value.includes('|')){
                let values = this.value.split('|');
                values.forEach(v=>this.files.push(v))
            }else{
                this.files.push(this.value);
            }
        }
    },
    methods: {
        async uploadFile() {
            if (typeof this.$refs.file.files[0] != 'undefined') {
                this.uploadPercentage = 0;
                for (let num = 0; num < this.$refs.file.files.length; num++) {

                    let file = this.$refs.file.files[num];
                    let formData = new FormData();
                    formData.append('file', file);

                    await axios.post('/file/upload',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            },
                            onUploadProgress: function (progressEvent) {
                                this.uploadPercentage = parseInt(Math.round((progressEvent.loaded / progressEvent.total) * 100)) / this.$refs.file.files.length + (100 / this.$refs.file.files.length) * num;
                                this.uploadPercentage = Math.round(this.uploadPercentage);
                            }.bind(this),
                        }
                    ).then(({data}) => {
                        if (data.success) {
                            console.log(data.file)
                            this.files.push(data.file);
                        }
                    });
                }
            }
        },
        getUploadedFileName(fileName) {
            // console.log(fileName)
            fileName = fileName.split('/');
            return fileName[fileName.length - 1];
        },
        removeFile(index) {
            this.files.splice(index, 1);
            console.log('files',this.files);
        },
    }
}
</script>
