<template>
    <div>
        <!-- Transparent background -->
        <div
            class="bg-black opacity-0 absolute inset-0 z-10"
            v-if="showResultsModal"
            @click="toggleResultsModal"
        >

        </div>

        <!-- Magnifying Icon and Search -->
        <div class="relative z-10">
            <div class="absolute pl-3 pt-3">
                <svg viewBox="0 0 24 24" class="w-5 h-5 fill-current text-blue-600">
                    <path d="M20.2 18.1l-1.4 1.3-5.5-5.2 1.4-1.3 5.5 5.2zM7.5 12c-2.7 0-4.9-2.1-4.9-4.6s2.2-4.6 4.9-4.6 4.9 2.1 4.9 4.6S10.2 12 7.5 12zM7.5.8C3.7.8.7 3.7.7 7.3s3.1 6.5 6.8 6.5c3.8 0 6.8-2.9 6.8-6.5S11.3.8 7.5.8z"/>
                </svg>
            </div>

            <input
                type="text"
                placeholder="Search contact..."
                id="searchTerm"
                class="text-gray-800 w-96 h-10 border pl-10 rounded-full focus:shadow focus:outline-none focus:shadow-outline bg-gray-300 focus:bg-blue-100"
                v-model="searchTerm"
                @input="searchContact"
                @focus="toggleResultsModal"
            />

            <!-- Results Modal -->
            <div 
                v-if="showResultsModal"
                class="absolute z-20 bg-blue-100 border-2 border-blue-500 rounded text-gray-800 p-4 w-96 mr-6 mt-2"
            >
                <p
                    v-if="searchTerm === ''"
                    class="text-sm text-center"
                >
                    Type your contact's name
                </p>

                <p
                    v-else-if="results.length === 0"
                    class="text-sm text-center"
                >
                    No results found with '<span class="text-indigo-600">{{ searchTerm }}</span>'
                </p>

                <div v-else>
                    <router-link
                        class="block p-2 hover:bg-blue-200 hover:shadow-lg rounded"
                        v-for="result in results"
                        :key="result.data.id"
                        :to="result.links.self"
                    >
                        <div 
                            class="flex items-center"
                            @click="toggleResultsModal"
                        >
                            <UserCircle
                                :name="result.data.name"
                                :comingFrom="'searchResultModal'"
                            />

                            <div class="flex flex-col text-sm leading-none text-left ml-6">
                                <span class="font-bold">
                                    {{ result.data.name }}
                                </span>
                                <span class="font-semibold text-gray-600">
                                    {{ result.data.company }}
                                </span>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { debounce } from 'lodash'
    import UserCircle from './../user/UserCircle';

    export default {
        name : 'SearchBar',

        components : {
            UserCircle
        },

        data : function () {
            return {
                searchTerm : '',

                showResultsModal :  false,

                results : [],
            }
        },

        methods : {
            toggleResultsModal : function() {
                this.showResultsModal = ! this.showResultsModal
            },
            
            searchContact : debounce(function () {
                if (this.searchTerm.length < 2) {
                    return
                }

                axios.post('/api/search', {searchTerm : this.searchTerm})
                    .then( response => {
                        this.results = response.data.data
                    })
                    .catch( error => {
                        console.log(error.response)
                    })
            }, 100)
        }
    }
</script>