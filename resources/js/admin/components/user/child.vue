<template>
    <v-card-text>

        <v-text-field
            v-model="singleData.child.no_of_child"
            label="No of child"
            type="number"
        ></v-text-field>
        <v-select
            v-model="singleData.child.profession"
            :items="getChildProfession"
            item-title="name"
            item-value="value"
            label="Profession"
            variant="solo"
        ></v-select>
    </v-card-text>
</template>
<script>
import {mapState, mapWritableState} from "pinia";
import {useUserStore} from "../../stores/user";

export default {
    name: "user_child",
    computed: {
        ...mapState(useUserStore, {
            getChildProfession: 'getChildProfession'
        }),
        ...mapWritableState(useUserStore, {
            singleData: 'singleData', errors: 'errors',
        }),
    },
}
</script>
