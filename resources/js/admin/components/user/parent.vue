<template>
    <v-card-text>
        <v-checkbox
            v-model="singleData.parent.is_alive"
            label="Is Alive"
        ></v-checkbox>

        <v-checkbox
            v-model="singleData.parent.available"
            label="Are they available"
        ></v-checkbox>

        <v-select
            v-model="singleData.parent.profession"
            :items="getParentProfession"
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
    name: "user_parent",
    computed: {
        ...mapState(useUserStore, {
            getParentProfession: 'getParentProfession',
        }),
        ...mapWritableState(useUserStore, {
            singleData: 'singleData', errors: 'errors',
        }),
    },
}
</script>
