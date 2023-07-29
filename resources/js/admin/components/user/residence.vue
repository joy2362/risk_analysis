<template>
    <v-card-text>
        <v-checkbox
            v-model="singleData.own_house"
            label="Do you stay own home"
            :error="!!errors.own_house"
            :error-messages="errors.own_house"
        ></v-checkbox>
        <v-text-field
            v-model="singleData.total_land"
            label="Total lands Do you have?"
            type="number"
            :error="!!errors.total_land"
            :error-messages="errors.total_land"
        ></v-text-field>
        <v-select
            v-model="singleData.house_made_of"
            :items="getMaterial"
            :error="!!errors.house_made_of"
            :error-messages="errors.house_made_of"
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
