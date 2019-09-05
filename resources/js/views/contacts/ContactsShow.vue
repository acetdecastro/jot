<template>
    <div class="container mt-4 px-32">
        <div v-if="isLoading">
            <h1>Loading...</h1>
        </div>

        <div v-else class="p-12">
            <!-- Sub Nav -->
            <div class="flex justify-between items-center border-b-2 pb-4">
                <div>
                    <a href="#" @click="$router.back()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="btn-back" viewBox="0 0 20 20"><path d="M7.05 9.293L6.343 10 12 15.657l1.414-1.414L9.172 10l4.242-4.243L12 4.343z"/></svg>
                    </a>
                </div>
                
                <div class="flex justify-between">
                    <router-link to="/" class="relative w-10 h-10 rounded-full hover:bg-blue-300 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 m-2 w-6 h-6 fill-current hover:text-white" viewBox="0 0 20 20"><path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg>
                    </router-link>

                    <a href="#" class="relative ml-2 pt-2 rounded-full w-10 h-10 flex justify-center hover:bg-red-300 hover:text-white">
                        <svg 
                            xmlns="http://www.w3.org/2000/svg"
                            class="absolute w-6 h-6 fill-current"
                            viewBox="0 0 20 20"
                        >
                            <path d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Contact Details -->
            <div class="mt-4">

                <div class="flex justify-center items-center">
                    <UserCircle
                        :name="contact.name"
                        :comingFrom="'contactsShowComponent'"
                    />

                    <span class="ml-3 text-2xl font-bold">{{ contact.name }}</span>
                </div>
                
                <ContactsDetail
                    v-for="(value, name, index) in contact"
                    :key="name"
                    :label="labels[index]"
                    :detail="value"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import UserCircle from './../../components/user/UserCircle'
    import ContactsDetail from './ContactsDetail'

    export default {
        name : 'ContactsShow',

        components : {
            UserCircle,
            ContactsDetail,
        },
        
        data : function () {
            return {
                isLoading : true,

                labels : [
                    'id',
                    'Name',
                    'E-mail',
                    'company',
                    'birthday',
                    'Last Updated',
                ],

                contact : null,
            }
        },

        mounted () {
            axios.get('/api/contacts/' + this.$route.params.id)
                .then(response => {
                    this.isLoading = false

                    this.contact = response.data.data
                })
                .catch(errors => {

                })
        }
    }
</script>