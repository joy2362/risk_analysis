<template>
    <v-card-text>
        <v-checkbox
            v-model="singleData.other_earning_member"
            label="Is there any others earning member of the family?"
            :error="!!errors.other_earning_member"
            :error-messages="errors.other_earning_member"
        ></v-checkbox>
        <v-checkbox
            v-model="singleData.other_member_have_bank_account"
            label="Is there any other member are already member of the Bank?"
            :error="!!errors.other_member_have_bank_account"
            :error-messages="errors.other_member_have_bank_account"
        ></v-checkbox>
    </v-card-text>
</template>
<script>
import { mapWritableState } from "pinia";
import { useUserStore } from "../../stores/user";

export default {
    name: "user_other",
    computed: {
        ...mapWritableState(useUserStore, {
            singleData: "singleData",
            errors: "errors",
        }),
    },
};
</script>
