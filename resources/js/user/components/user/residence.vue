<template>
    <v-card-text>
        <v-checkbox
            v-model="singleData.residence.own_house"
            label="Do you stay own home"
        ></v-checkbox>
        <v-text-field
            v-model="singleData.residence.total_land"
            label="Total lands Do you have?"
            type="number"
        ></v-text-field>
        <v-select
            v-model="singleData.residence.house_made_of"
            :items="getMaterial"
            item-title="name"
            item-value="value"
            label="House is made of"
            variant="solo"
        ></v-select>
    </v-card-text>
</template>
<script>
import {mapState, mapWritableState} from "pinia";
import {useUserStore} from "../../stores/user";

export default {
    name: "user_residence",
    computed: {
        ...mapState(useUserStore, {
            getMaterial: 'getMaterial'
        }),
        ...mapWritableState(useUserStore, {
            singleData: 'singleData', errors: 'errors',
        }),
    },
}
</script>
