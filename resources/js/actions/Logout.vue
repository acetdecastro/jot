<template>
    <div class="container h-full flex justify-center items-center py-12">
        <h1 class="text-4xl font-bold tracking-wide text-blue-500">Good bye and see you again!</h1>
    </div>
</template>

<script>
    export default {
        name : 'Logout',

        created () {
            axios.post('/logout', {})
                .finally( error => {
                    window.location = '/login'
                })
        }
    }
</script>