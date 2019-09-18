<template>
    <div class="container p-20">
        <div class="flex flex-col justify-center">
            <div class="mb-10 text-gray-800">
                <div class="mb-4">
                    <h1 class="text-center text-5xl text-indigo-500 font-semibold">Welcome to <span class="font-bold text-6xl text-indigo-600 underline">jot</span></h1>
                </div>
                
                <p class="text-center text-gray-700 text-2xl">
                    A simple web application wherein you can add, edit, and remove a contact
                </p>
            </div>

            <div ass="overflow-hidden">
                <img
                    :src="peopleImgSrc"
                    alt="Contacts"
                    class="h-64 w-full"
                >
            </div>

            <div class="mt-20 text-center">
                <router-link to="/contacts/create" class="px-5 py-2 border-2 bg-blue-100 border-blue-700 shadow-lg hover:bg-blue-600 focus:outline-none focus:shadow-outline text-blue-700 hover:text-blue-100 font-bold uppercase tracking-wide rounded-full">
                    Get Started
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name : 'Home',

        data : function () {
            return {
                peopleImgSrc : '/assets/images/undraw_people_search_wctu.svg'
            }
        }
    }
</script>