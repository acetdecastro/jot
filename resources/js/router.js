import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from './views/home/Home'

import ContactsIndex from './views/contacts/ContactsIndex'
import ContactsCreate from './views/contacts/ContactsCreate'
import ContactsShow from './views/contacts/ContactsShow'
import ContactsEdit from './views/contacts/ContactsEdit'

import BirthdaysIndex from './views/birthdays/BirthdaysIndex'

import Logout from './actions/Logout'

Vue.use(VueRouter)

export default new VueRouter({
    routes : [
        {
            path : '/',
            component : Home,
            meta : {
                title : 'Home'
            }
        },
        {
            path : '/contacts',
            component : ContactsIndex,
            meta : {
                title : 'Contacts'
            }
        },
        {
            path : '/contacts/create',
            component : ContactsCreate,
            meta : {
                title : 'Add New Contact'
            }
        },
        {
            path : '/contacts/:id',
            component : ContactsShow,
            meta : {
                title : 'Contact Details'
            }
        },
        {
            path : '/contacts/:id/edit',
            component : ContactsEdit,
            meta : {
                title : 'Edit Contact'
            }
        },
        {
            path : '/birthdays',
            component : BirthdaysIndex,
            meta : {
                title : 'This month\'s Birthdays'
            }
        },
        {
            path : '/logout',
            component : Logout,
            meta : {
                title : 'Logout'
            }
        },
    ],
    mode : 'history'
})