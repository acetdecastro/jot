<template>
    <div class="container pt-12">
        <form @submit.prevent='submitForm'>
            <InputField
                name='name'
                label='Name'
                placeholder='ex: Juan Dela Cruz'
                @update:field='form.name = $event'
            />
            <InputField
                name='email'
                label='E-Mail'
                placeholder='ex: juandelacruz@email.com'
                @update:field='form.email = $event'
            />
            <InputField
                name='company'
                label='Company'
                placeholder='ex: ABC Holdings'
                @update:field='form.company = $event'
            />
            <InputField
                name='birthday'
                label='Birthday'
                placeholder='MM/DD/YYYY'
                @update:field='form.birthday = $event'
            />

            <div class="pt-4 flex justify-end">
                <button class="text-red-600 px-3 rounded shadow-md border-2 border-red-600 focus:outline-none focus:shadow-outline hover:bg-red-200 font-bold">
                    Cancel
                </button>

                <button class="ml-5 border-2 text-blue-600 rounded shadow-md border-blue-600 py-1 px-3 font-bold focus:shadow-outline hover:bg-blue-200 ">
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
                form : {
                    'name' : '',
                    'email' : '',
                    'company' : '',
                    'birthday' : '',
                }
            }
        },

        methods :{
            submitForm : function () {
                axios.post('/api/contacts', this.form)
                    .then(response =>{

                    })
                    .catch(errors => {

                    })
            }
        }
    }
</script>