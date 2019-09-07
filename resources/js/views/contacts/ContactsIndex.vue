<template>
    <div class="h-full">
        <div v-if="isLoading">
            <Loading />
        </div>

        <div v-else>
            <div v-if="contacts.length === 0">
                <div class="m-auto h-full flex justify-center items-center flex-col py-12">
                    <h1 class="text-4xl font-bold tracking-wide text-blue-500">No contacts yet.</h1>
                    
                    <div class="pt-12">
                        <router-link to="/contacts/create" class="px-5 py-2 border-2 bg-blue-200 border-blue-700 shadow-lg hover:bg-blue-600 focus:outline-none focus:shadow-outline text-gray-800 hover:text-blue-100 text-3xl font-bold tracking-wide rounded-full">
                            Get Started
                        </router-link>
                    </div>
                </div>
            </div>

            <div v-else>
                <router-link 
                    class="relative"
                    v-for="contact in contacts"
                    :to="'/contacts/' + contact.data.id"
                    :key="contact.data.id"
                >
                    <div class="flex items-center justify-between py-4 px-4 border-b border-gray-400 hover:bg-indigo-100 active:bg-indigo-200">
                        <div class="flex items-center">
                            <UserCircle 
                                :name="contact.data.name"
                                :comingFrom="'contactIndexComponent'"
                            />

                            <div class="flex flex-col pl-6">
                                <h1 class="font-bold tracking-wide text-blue-500">
                                    {{ contact.data.name }}
                                </h1>
                                <h1 class="text-gray-600">
                                    {{ contact.data.company }}
                                </h1>
                            </div>
                        </div>

                        <div class="flex justify-end pr-8">
                            <!-- Edit Pencil Button -->
                            <router-link :to="'/contacts/' + contact.data.id + '/edit'" class="relative w-10 h-10 rounded-full hover:bg-blue-300 hover:text-white active:bg-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 m-2 w-6 h-6 text-gray-800 fill-current hover:text-white" viewBox="0 0 20 20"><path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg>
                            </router-link>
                        </div>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import Loading from './../../components/loading/Loading'
    import UserCircle from './../../components/user/UserCircle'

    export default {
        name : 'ContactsIndex',

        components : {
            Loading,
            UserCircle,
        },

        mounted () {
            axios.get('/api/contacts')
                .then( response => {
                    this.isLoading = false

                    this.contacts = response.data.data
                })
                .catch( error => {
                    console.log(error)
                })
        },

        data : function () {
            return {
                isLoading : true,
                showDeleteModal : false,
                
                contacts : null,
            }
        },
    }
</script>