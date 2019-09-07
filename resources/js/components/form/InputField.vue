<template>
    <div class="relative pb-4">
        <label :for="fieldName" class="pt-2 absolute uppercase text-sm font-bold text-blue-400 tracking-wider">
            {{ label }}
        </label>

        <input 
            type="text"
            class="pt-10 pb-1 w-full border-b-2 bg-gray-100 focus:outline-none focus:border-blue-400 text-gray-800 text-xl"
            :class="errorClassObject()"
            :id="fieldName"
            :placeholder="placeholder"
            v-model="value"
            @input="updateField()"
        >

        <p
            class="form-field-text-error"
            v-text="showErrorMsg()"
        >
        </p>
    </div>
</template>

<script>
    export default {
        name : 'InputField',

        props : [
            'fieldName',
            'label',
            'placeholder',
            'errors',
            'contactData',
        ],

        data : function () {
            return {
                value : ''
            }
        },
        
        computed : {
            hasError : function () {
                return this.errors && this.errors[this.fieldName] && this.errors[this.fieldName].length
            }
        },

        methods : {
            updateField : function () {
                this.clearErrorMsg(this.fieldName)

                this.$emit('update:field', this.value)
            },

            showErrorMsg : function () {
                if (this.hasError) {
                    return this.errors[this.fieldName][0]
                }
            }, 

            clearErrorMsg : function () {
                if (this.hasError) {
                    this.errors[this.fieldName] = null
                }
            },

            errorClassObject : function () {
                return {
                    'form-field-line-error' : this.hasError
                }
            },
        },

        watch : {
            contactData : function (val) {
                this.value = val
            }
        }
    } 
</script>