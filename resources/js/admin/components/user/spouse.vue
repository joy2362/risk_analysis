<template>
    <v-card-text>
        <v-checkbox
            v-model="singleData.spouse_is_alive"
            label="Is Alive?"
            @change="checkAlive"
            :error="!!errors.spouse_is_alive"
            :error-messages="errors.spouse_is_alive"
        ></v-checkbox>
        <div v-if="singleData.spouse_is_alive">
            <v-text-field
                v-model="singleData.spouse_name"
                label="Name"
                :error="!!errors.spouse_name"
                :error-messages="errors.spouse_name"
            ></v-text-field>
            <v-text-field
                v-model="singleData.spouse_dob"
                label="DOB"
                type="date"
                :error="!!errors.spouse_dob"
                :error-messages="errors.spouse_dob"
            ></v-text-field>
            <v-text-field
                v-model="singleData.spouse_nid_number"
                label="NID number"
                type="text"
                :error="!!errors.spouse_nid_number"
                :error-messages="errors.spouse_nid_number"
            ></v-text-field>
            <v-select
                v-model="singleData.spouse_education"
                :items="getEducation"
                item-title="name"
                item-value="value"
                label="Education"
                variant="solo"
                :error="!!errors.spouse_education"
                :error-messages="errors.spouse_education"
            ></v-select>
            <v-select
                v-model="singleData.spouse_profession"
                :items="getProfession"
                item-title="name"
                item-value="value"
                label="Profession"
                variant="solo"
                :error="!!errors.spouse_profession"
                :error-messages="errors.spouse_profession"
            ></v-select>
            <v-text-field
                v-model="singleData.spouse_income"
                label="Income"
                type="number"
                :error="!!errors.spouse_income"
                :error-messages="errors.spouse_income"
            ></v-text-field>
            <v-select
                v-model="singleData.use_of_loan"
                :items="getLoanUsedFor"
                item-title="name"
                item-value="value"
                label="Use of loan"
                variant="solo"
                :error="!!errors.use_of_loan"
                :error-messages="errors.use_of_loan"
            ></v-select>

            <v-text-field
                v-model="singleData.other_loan"
                label="Other Loan"
                type="number"
                :error="!!errors.other_loan"
                :error-messages="errors.other_loan"
            ></v-text-field>
        </div>
    </v-card-text>
</template>
<script>
import { mapState, mapWritableState } from "pinia";
import { useUserStore } from "../../stores/user";

export default {
    name: "user_spouse",
    computed: {
        ...mapState(useUserStore, {
            getEducation: "getEducation",
            getProfession: "getProfession",
            getLoanUsedFor: "getLoanUsedFor",
        }),
        ...mapWritableState(useUserStore, {
            singleData: "singleData",
            errors: "errors",
        }),
    },
    methods: {
        checkAlive() {
            if (!this.singleData.spouse_is_alive) {
                this.singleData.spouse_name = "";
                this.singleData.spouse_dob = "";
                this.singleData.spouse_nid_number = "";
                this.singleData.spouse_income = 0;
                this.singleData.spouse_profession = "";
                this.singleData.spouse_education = "";
            }
        },
    },
};
</script>
