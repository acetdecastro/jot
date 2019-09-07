<template>
    <div>
        <ContactsList
            :endPoint="'/api/contacts'"
        />
    </div>
</template>

<script>
    import ContactsList from './../../components/contacts/ContactsList'

    export default {
        name : 'ContactsIndex',

        components : {
            ContactsList,
        },
    }
</script>