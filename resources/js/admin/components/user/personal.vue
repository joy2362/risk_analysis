<template>
    <v-card-text>
        <v-text-field
            v-model="singleData.name"
            :error="!!errors.name"
            :error-messages="errors.name"
            label="Name"
        ></v-text-field>
        <v-text-field
            v-model="singleData.email"
            :error="!!errors.email"
            :error-messages="errors.email"
            label="Email"
            type="email"
        ></v-text-field>
        <v-text-field
            v-model="singleData.password"
            :error="!!errors.password"
            :error-messages="errors.password"
            label="Password"
        ></v-text-field>
        <v-text-field
            v-model="singleData.dob"
            :error="!!errors.dob"
            :error-messages="errors.dob"
            label="DOB"
            type="date"
        ></v-text-field>
        <v-text-field
            v-model="singleData.nid_number"
            :error="!!errors.nid_number"
            :error-messages="errors.nid_number"
            label="NID number"
            type="text"
        ></v-text-field>
        <v-select
            v-model="singleData.education"
            :error="!!errors.education"
            :error-messages="errors.education"
            :items="getEducation"
            item-title="name"
            item-value="value"
            label="Education"
            variant="solo"
        ></v-select>
        <v-select
            v-model="singleData.profession"
            :error="!!errors.profession"
            :error-messages="errors.profession"
            :items="getMemberProfession"
            item-title="name"
            item-value="value"
            label="Profession"
            variant="solo"
        ></v-select>
        <v-text-field
            v-model="singleData.income"
            :error="!!errors.income"
            :error-messages="errors.income"
            label="Income"
            type="number"
        ></v-text-field>
        <v-file-input
            ref="userAvatarInput"
            :clearable="false"
            :error="!!errors.avatar"
            :error-messages="errors.avatar"
            accept="image/*"
            label="Profile Picture"
            prepend-icon="mdi-camera"
            show-size
            @input="onSelect"
        ></v-file-input>
    </v-card-text>
</template>
<script>
import { mapActions, mapState, mapWritableState } from "pinia";
import { useUserStore } from "../../stores/user";

export default {
    name: "user_personal",
    computed: {
        ...mapState(useUserStore, {
            getEducation: "getEducation",
            getMemberProfession: "getMemberProfession",
        }),
        ...mapWritableState(useUserStore, {
            singleData: "singleData",
            errors: "errors",
        }),
    },
    methods: {
        ...mapActions(useUserStore, {
            setAvatar: "setAvatar",
        }),
        onSelect(event) {
            this.setAvatar(event.target.files[0]);
        },
    },
};
</script>
