<template>
    <div class="p-4" v-if="! hiddenDetails.includes(label)">
        <label class="tracking-wider uppercase text-gray-600 text-sm font-bold">
            {{ label }}
        </label>
        
        <p class="mt-1 text-blue-500 text-xl">
            {{ detail }}
        </p>
    </div>
</template>

<script>
    export default {
        name : 'ContactsDetail',

        data : function () {
            return {
                hiddenDetails : [
                    'id',
                    'Name'
                ]
            }
        },
        
        props : [
            'label',
            'detail',
        ]
    }
</script>