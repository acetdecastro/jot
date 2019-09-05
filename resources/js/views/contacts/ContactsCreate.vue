<template>
    <div class="container mt-12">
        <form @submit.prevent='submitForm'>
            <InputField
                v-for="(inputField, index) in inputFields"
                :key="index"
                :fieldName=inputField.name
                :label=inputField.label
                :placeholder=inputField.placeholder
                :errors="errors"
                @update:field="updateFormValues(inputField.name, $event)"
            />

            <div class="pt-4 flex justify-end">
                <button class="btn btn-cancel">
                    Cancel
                </button>

                <button class="btn btn-primary ml-5">
                    Add New Contact
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    import InputField from './../../components/form/InputField'

    export default {
        name : 'ContactsCreate',

        components : {
            InputField
        },

        data : function () {
            return {
                inputFields : [
                    {
                        'name' : 'name',
                        'label' : 'Name',
                        'placeholder' : 'ex: Juan Dela Cruz',
                    },
                    {
                        'name' : 'email',
                        'label' : 'email',
                        'placeholder' : 'ex: robertbrown@gmail.com',
                    },
                    {
                        'name' : 'company',
                        'label' : 'company',
                        'placeholder' : 'Brown Catering Services',
                    },
                    {
                        'name' : 'birthday',
                        'label' : 'birthday',
                        'placeholder' : 'MM/DD/YYYY',
                    },
                ],

                form : {
                    'name' : '',
                    'email' : '',
                    'company' : '',
                    'birthday' : '',
                },

                errors : null
            }
        },

        methods : {
            updateFormValues : function (fieldName, value) {
                Object.defineProperty(this.form, fieldName, {
                    value
                })
            },

            submitForm : function () {
                axios.post('/api/contacts', this.form)
                    .then(response =>{
                        
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors
                    })
            }
        }
    }
</script>