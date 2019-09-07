<template>
    <div class="container mt-4 px-32">
        <div v-if="isLoading">
            <Loading />
        </div>

        <div v-else-if="noContentFound">
            <NoContentFound />
        </div>

        <div v-else class="p-12">
            <!-- Sub Nav -->
            <div class="flex justify-between items-center border-b-2 pb-4">
                <!-- Back Right Caret Button -->
                <div>
                    <a href="#" @click="$router.back()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="btn-back" viewBox="0 0 20 20"><path d="M7.05 9.293L6.343 10 12 15.657l1.414-1.414L9.172 10l4.242-4.243L12 4.343z"/></svg>
                    </a>
                </div>
                
                <div class="flex justify-between">
                    <!-- Edit Pencil Button -->
                    <router-link :to="'/contacts/' + contact.id + '/edit'" class="relative w-10 h-10 rounded-full hover:bg-blue-300 hover:text-white active:bg-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 m-2 w-6 h-6 text-gray-800 fill-current hover:text-white" viewBox="0 0 20 20"><path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg>
                    </router-link>

                    <!-- Delete Trash Button -->
                    <div class="relative">
                        <a 
                            href="#"
                            class="text-gray-800 fill-current relative ml-2 pt-2 rounded-full w-10 h-10 flex justify-center hover:bg-red-300 hover:text-white active:bg-red-600"
                            :class="[deleteModal ? 'btn-delete-active' : '']"
                            @click="toggleDeleteModal()"
                        >
                            <svg 
                                xmlns="http://www.w3.org/2000/svg"
                                class="absolute w-6 h-6 fill-current"
                                viewBox="0 0 20 20"
                            >
                                <path d="M6 2l2-2h4l2 2h4v2H2V2h4zM3 6h14l-1 14H4L3 6zm5 2v10h1V8H8zm3 0v10h1V8h-1z"/>
                            </svg>
                        </a>

                        <!-- Delete Modal -->
                        <div
                            v-if="deleteModal"
                            class="absolute z-20 right-0 font-bold bg-red-400 w-48 px-4 py-4 text-gray-900 border-2 mt-2 mr-6 border-red-500 shadow-lg rounded-lg text-center"
                        >
                            <!-- Close Button Modal -->
                            <div class="flex justify-end mr-1">
                                <button
                                    class="focus:outline-none hover:text-white"
                                    @click="toggleDeleteModal()"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
                                </button>
                            </div>

                            <p class="mt-4 tracking-wide">Delete this contact?</p>

                            <div class="mt-4 flex justify-end text-sm">
                                <!-- Close Button Modal -->
                                <button
                                    class="py-2 px-2 rounded-full shadow-lg focus:outline-none hover:text-white"
                                    @click="toggleDeleteModal()"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
                                </button>

                                <!-- Delete Contact Check Button Modal -->
                                <button
                                    class="ml-2 py-2 px-2 border-b-2 border-green-700 shadow-lg rounded-full focus:outline-none hover:text-green-600 hover:border-green-600"
                                    @click="deleteContact()"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Dimmed Modal Effect -->
                    <div 
                        class="bg-black opacity-25 absolute inset-0 z-10"
                        v-if="deleteModal"
                        @click="toggleDeleteModal()"
                    >
                    </div>
                </div>
            </div>
            
            <!-- Contact Details -->
            <div class="mt-4">

                <div class="flex justify-center items-center">
                    <UserCircle
                        :name="contact.name"
                        :comingFrom="'contactsShowComponent'"
                    />

                    <span class="ml-3 text-2xl text-gray-800 font-bold">{{ contact.name }}</span>
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
    import Loading from './../../components/loading/Loading'
    import NoContentFound from './../../components/error404/NoContentFound'
    import UserCircle from './../../components/user/UserCircle'
    import ContactsDetail from './ContactsDetail'

    export default {
        name : 'ContactsShow',

        components : {
            Loading,
            NoContentFound,
            UserCircle,
            ContactsDetail,
        },

        mounted () {
            axios.get('/api/contacts/' + this.$route.params.id)
                .then( response => {
                    this.isLoading = false
                    this.noContentFound = false

                    this.contact = response.data.data
                })
                .catch( errors => {
                    this.isLoading = false

                    if (errors.response.status === 404) {
                        this.noContentFound = true
                    }
                })
        },

        data : function () {
            return {
                isLoading : true,
                noContentFound : false,
                deleteModal : false,

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
        
        methods : {
            toggleDeleteModal : function () {
                this.deleteModal = ! this.deleteModal
            },

            deleteContact : function () {
                axios.delete('/api/contacts/' + this.contact.id)
                    .then( response => {
                        this.$router.push('/contacts')
                    })
                    .catch( error => {
                        alert('Unable to delete contact.')
                    })
            },
        },
    }
</script>

<style scoped>
    .btn-delete-active {
        @apply bg-red-600 text-white
    }
</style>