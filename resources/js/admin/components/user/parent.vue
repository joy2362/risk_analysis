<template>
    <v-card-text>
        <v-checkbox
            v-model="singleData.parent_is_alive"
            label="Is Alive"
            @change="checkAlive"
            :error="!!errors.parent_is_alive"
            :error-messages="errors.parent_is_alive"
        ></v-checkbox>

        <div v-if="singleData.parent_is_alive">
            <v-checkbox
                v-model="singleData.parent_available"
                label="Are they available"
                :error="!!errors.parent_available"
                :error-messages="errors.parent_available"
            ></v-checkbox>
            <v-select
                v-model="singleData.parent_profession"
                :items="getParentProfession"
                :error="!!errors.parent_profession"
                :error-messages="errors.parent_profession"
                item-title="name"
                item-value="value"
                label="Profession"
                variant="solo"
            ></v-select>
        </div>
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
    methods: {
        checkAlive() {
            if (!this.singleData.parent_is_alive) {
                this.singleData.parent_available = 0;
                this.singleData.parent_profession = '';
            }
        }
    }
}
</script>
