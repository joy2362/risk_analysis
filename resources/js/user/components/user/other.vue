<template>
    <v-card-text>
        <v-checkbox
            v-model="singleData.other.other_earning_member"
            label="Is there any others earning member of the family"
        ></v-checkbox>
        <v-checkbox
            v-model="singleData.other.other_member_have_bank_account"
            label="Is there any other member are already member of the Bank"
        ></v-checkbox>
    </v-card-text>
</template>
<script>
import {mapWritableState} from "pinia";
import {useUserStore} from "../../stores/user";

export default {
    name: "user_other",
    computed: {
        ...mapWritableState(useUserStore, {
            singleData: 'singleData', errors: 'errors',
        }),
    },
}
</script>
