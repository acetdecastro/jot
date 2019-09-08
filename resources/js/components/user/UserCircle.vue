<template>
    <div :class="userCircleClassObject">
        <span>{{ userCircleName }}</span>
    </div>
</template>

<script>
    export default {
        name : 'UserCircle',   

        props : ['name', 'comingFrom'],

        computed : {
            userCircleName : function () {
                return this.name.match(/[A-Z]/g).slice(0, 2).join('')
            },

            userCircleClassObject : function () {
                return {
                    'user-circle-header' : this.comingFrom === 'appComponent',
                    'user-circle-contact-show' : this.comingFrom === 'contactsShowComponent',
                    'user-circle-contact-index' : this.comingFrom === 'contactIndexComponent',
                    'user-circle-contact-search' : this.comingFrom === 'searchResultModal',
                } 
            }
        }
    }
</script>