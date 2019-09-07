import Vue from 'vue'
import VueRouter from 'vue-router'

import ContactsIndex from './views/contacts/ContactsIndex'
import ContactsCreate from './views/contacts/ContactsCreate'
import ContactsShow from './views/contacts/ContactsShow'
import ContactsEdit from './views/contacts/ContactsEdit'

import BirthdaysIndex from './views/birthdays/BirthdaysIndex'

Vue.use(VueRouter)

export default new VueRouter({
    routes : [
        {
            path : '/',
            component : ContactsIndex
        },
        {
            path : '/contacts',
            component : ContactsIndex
        },
        {
            path : '/contacts/create',
            component : ContactsCreate
        },
        {
            path : '/contacts/:id',
            component : ContactsShow
        },
        {
            path : '/contacts/:id/edit',
            component : ContactsEdit
        },
        {
            path : '/birthdays',
            component : BirthdaysIndex
        },
    ],
    mode : 'history'
})