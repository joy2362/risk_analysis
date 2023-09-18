<template>
    <v-card-text>
        <v-text-field
            v-model="singleData.no_of_child"
            label="No of child"
            type="number"
            :error="!!errors.no_of_child"
            :error-messages="errors.no_of_child"
            @change="checkChile"
        ></v-text-field>
        <v-select
            v-if="singleData.no_of_child > 0"
            v-model="singleData.children_profession"
            :items="getChildProfession"
            :error="!!errors.children_profession"
            :error-messages="errors.children_profession"
            item-title="name"
            item-value="value"
            label="Profession of older child"
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
    methods: {
        checkChile() {
            if (this.singleData.no_of_child == 0) {
                this.singleData.children_profession = ''
            }
        }
    }
}
</script>
