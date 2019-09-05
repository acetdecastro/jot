<template>
    <div class="container mt-12 px-40">
        <div v-if="isLoading">
            <h1>Loading...</h1>
        </div>

        <div v-else>
            <!-- Sub Nav -->
            <div class="flex justify-between items-center">
                <div>
                    <a href="#" @click="$router.back()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="btn-back" viewBox="0 0 20 20"><path d="M7.05 9.293L6.343 10 12 15.657l1.414-1.414L9.172 10l4.242-4.243L12 4.343z"/></svg>
                    </a>
                </div>
                
                <div class="flex justify-between">

                    <router-link to="/">
                        <div class="relative w-10 h-10 rounded-full hover:bg-blue-300 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 m-2 w-6 h-6 fill-current hover:text-white" viewBox="0 0 20 20"><path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg>
                        </div>
                    </router-link>
                    
                    <a href="#" class="ml-6">
                        <div class="relative hover:bg-red-300 rounded-full w-10 h-10">
                            <div class="absolute inset-0 my-4 mx-1 bg-red-600 rounded-lg w-8 h-2"></div>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- Contact Details -->
            <div class="mt-4 p-12">
                <div class="p-4">
                    <label class="tracking-wider uppercase text-gray-600 text-sm font-semibold">
                        Name
                    </label>
                    
                    <p class="mt-1 text-blue-500 text-xl">
                        {{ contact.name  }}
                    </p>    
                </div>
                
                <div class="p-4">
                    <label class="tracking-wider uppercase text-gray-600 text-sm font-semibold">
                        E-mail
                    </label>
                    
                    <p class="mt-1 text-blue-500 text-xl">
                        {{ contact.email  }}
                    </p>
                </div>
                
                <div class="p-4">
                    <label class="tracking-wider uppercase text-gray-600 text-sm font-semibold">
                        Company
                    </label>
                    
                    <p class="mt-1 text-blue-500 text-xl">
                        {{ contact.company  }}
                    </p>
                </div>
                
                <div class="p-4">
                    <label class="tracking-wider uppercase text-gray-600 text-sm font-semibold">
                        Birthday
                    </label>
                    
                    <p class="mt-1 text-blue-500 text-xl">
                        {{ contact.birthday  }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name : 'ContactsShow',
        
        data : function () {
            return {
                isLoading : true,


                contact : null
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