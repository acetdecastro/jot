<template>
    <div>
        <input
            type="text"
            placeholder="Search contact..."
            id="searchTerm"
            v-model="searchTerm"
            @input="searchContact"
        />
    </div>
</template>

<script>
    export default {
        name : 'SearchBar',

        data : function () {
            return {
                searchTerm : ''
            }
        },

        methods : {
            searchContact : function () {
                axios.post('/api/search-contact', {searchTerm : this.searchTerm})
                    .then( response => {
                        console.log(response.data)
                    })
                    .catch( error => {

                    })
            }
        }
    }
</script>