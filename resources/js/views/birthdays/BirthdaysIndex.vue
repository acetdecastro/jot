<template>
    <div>
        <ContactsList
            :endPoint="'/api/birthdays'"
        />
    </div>
</template>

<script>
    import ContactsList from './../../components/contacts/ContactsList';

    export default {
        name : 'BirthdaysIndex',
        
        components : {
            ContactsList
        },
    }
</script>