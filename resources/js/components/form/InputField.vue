<template>
    <div class="relative pb-4">
        <label :for="name" class="pt-2 absolute uppercase text-sm font-bold text-blue-400">
            {{ label }}
        </label>

        <input 
            type="text"
            class="pt-10 pb-2 w-full border-b-2 bg-gray-100 focus:outline-none focus:border-blue-400"
            :id="name"
            :placeholder="placeholder"
            v-model='value'
            @input="updateField()"
        >
    </div>
</template>

<script>
    export default {
        name : 'InputField',

        props : [
            'name',
            'label',
            'placeholder',
        ],

        data : function () {
            return {
                value : ''
            }
        },

        methods : {
            updateField : function() {
                this.$emit('update:field', this.value)
            }
        }
    }
</script>