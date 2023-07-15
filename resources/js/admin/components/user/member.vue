<template>
    <v-card-text>
        <v-text-field
            v-model="singleData.member.name"
            label="Name"
        ></v-text-field>
        <v-text-field
            v-model="singleData.member.dob"
            label="DOB"
            type="date"
        ></v-text-field>
        <v-select
            v-model="singleData.member.gender"
            :items="getGender"
            item-title="name"
            item-value="value"
            label="Gender"
            variant="solo"
        ></v-select>
        <v-text-field
            v-model="singleData.member.nid_number"
            label="NID number"
            type="text"
        ></v-text-field>
        <v-select
            v-model="singleData.member.education"
            :items="getEducation"
            item-title="name"
            item-value="value"
            label="Education"
            variant="solo"
        ></v-select>
        <v-select
            v-model="singleData.member.profession"
            :items="getMemberProfession"
            item-title="name"
            item-value="value"
            label="Profession"
            variant="solo"
        ></v-select>
        <v-text-field
            v-model="singleData.member.income"
            label="Income"
            type="number"
        ></v-text-field>

    </v-card-text>
</template>
<script>
import {mapState, mapWritableState} from "pinia";
import {useUserStore} from "../../stores/user";

export default {
    name: "user_member",
    computed: {
        ...mapState(useUserStore, {
            getGender: 'getGender', getEducation: 'getEducation', getMemberProfession: 'getMemberProfession'
        }),
        ...mapWritableState(useUserStore, {
            singleData: 'singleData', errors: 'errors',
        }),
    },
}
</script>
