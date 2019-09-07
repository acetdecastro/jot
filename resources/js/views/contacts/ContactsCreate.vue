<template>
    <div class="container mt-12">
        <!-- Sub Nav -->
        <div class="flex justify-between items-center px-40">
            <!-- Back Right Caret Button -->
            <div>
                <a href="#" @click="$router.back()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="btn-back" viewBox="0 0 20 20"><path d="M7.05 9.293L6.343 10 12 15.657l1.414-1.414L9.172 10l4.242-4.243L12 4.343z"/></svg>
                </a>
            </div>
        </div>

        <div class="text-center">
            <h1 class='text-blue-500 text-4xl uppercase tracking-wide font-bold'>Add Contact</h1>
        </div>

        <div class="px-40 py-8">
            <form @submit.prevent='submitForm'>
                <InputField
                    v-for="(inputField, index) in inputFields"
                    :key="index"
                    :fieldName="inputField.name"
                    :label="inputField.label"
                    :placeholder="inputField.placeholder"
                    :errors="errors"
                    @update:field="updateFormValues(inputField.name, $event)"
                />

                <div class="pt-4 flex justify-end">
                    <button class="btn btn-primary">
                        Add New Contact
                    </button>
                </div>
            </form>
        </div>
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
                        'placeholder' : 'ex: Robert J. Brown',
                    },
                    {
                        'name' : 'email',
                        'label' : 'email',
                        'placeholder' : 'ex: robertjbrown@gmail.com',
                    },
                    {
                        'name' : 'company',
                        'label' : 'company',
                        'placeholder' : 'ex: Brown Catering Services',
                    },
                    {
                        'name' : 'birthday',
                        'label' : 'birthday',
                        'placeholder' : 'ex: 03/17/1993 (MM/DD/YYYY)',
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
            /*
            * Takes the fieldName as well as the value typed on the input field
            * Updates by redifining the property as well as its value
            * ex: 'name' : <value>
            */
            updateFormValues : function (fieldName, value) {
                Object.defineProperty(this.form, fieldName, {
                    value
                })
            },

            clearFormValues : function (e) {
                this.form = {
                    'name' : '',
                    'email' : '',
                    'company' : '',
                    'birthday' : '',
                },
                
                e.preventDefault()
            },

            submitForm : function () {
                axios.post('/api/contacts', this.form)
                    .then( response =>{
                        this.$router.push(response.data.links.self)
                    })
                    .catch( errors => {
                        this.errors = errors.response.data.errors
                    })
            },
        }
    }
</script>