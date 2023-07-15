<template>
    <v-card-text>
        <v-checkbox
            label="Alive"
            v-model="singleData.spouse.is_alive"
        ></v-checkbox>
        <v-text-field
            v-model="singleData.spouse.name"
            label="Name"
        ></v-text-field>
        <v-text-field
            v-model="singleData.spouse.dob"
            label="DOB"
            type="date"
        ></v-text-field>
        <v-select
            v-model="singleData.spouse.gender"
            :items="getGender"
            item-title="name"
            item-value="value"
            label="Gender"
            variant="solo"
        ></v-select>
        <v-text-field
            v-model="singleData.spouse.nid_number"
            label="NID number"
            type="text"
        ></v-text-field>
        <v-select
            v-model="singleData.spouse.education"
            :items="getEducation"
            item-title="name"
            item-value="value"
            label="Education"
            variant="solo"
        ></v-select>
        <v-select
            v-model="singleData.spouse.profession"
            :items="getProfession"
            item-title="name"
            item-value="value"
            label="Profession"
            variant="solo"
        ></v-select>
        <v-text-field
            v-model="singleData.spouse.income"
            label="Income"
            type="number"
        ></v-text-field>

    </v-card-text>
</template>
<script>
import {mapState, mapWritableState} from "pinia";
import {useUserStore} from "../../stores/user";

export default {
    name: "user_spouse",
    computed: {
        ...mapState(useUserStore, {
            getGender: 'getGender', getEducation: 'getEducation', getProfession: 'getProfession'
        }),
        ...mapWritableState(useUserStore, {
            singleData: 'singleData', errors: 'errors',
        }),
    },
}
</script>
