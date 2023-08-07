<template>
    <v-container>
        <GlobalLoading />
        <BreadCrumb :routes="getBreadcrumb"></BreadCrumb>
        <TitleBar
            :route="getRoutes.index"
            :title="$route.params.id ? 'Update Loanee' : 'Create Loanee'"
        ></TitleBar>
        <v-card class="mx-auto">
            <v-card-title
                class="text-h6 font-weight-regular justify-space-between"
            >
                <v-avatar
                    color="primary"
                    size="x-small"
                    v-text="step + 1"
                ></v-avatar>
                <span class="mx-2" v-text="getStepTitle[step]"></span>
            </v-card-title>

            <v-window v-model="step">
                <v-window-item :value="0">
                    <user_personal></user_personal>
                </v-window-item>
                <v-window-item :value="1">
                    <user_spouse></user_spouse>
                </v-window-item>
                <v-window-item :value="2">
                    <user_parent></user_parent>
                </v-window-item>
                <v-window-item :value="3">
                    <user_child></user_child>
                </v-window-item>
                <v-window-item :value="4">
                    <user_residence></user_residence>
                </v-window-item>
                <v-window-item :value="5">
                    <user_other></user_other>
                </v-window-item>
            </v-window>

            <v-divider></v-divider>

            <v-card-actions>
                <v-btn v-if="step > 0" variant="text" @click="step--">
                    Back
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    v-if="step < 5"
                    color="primary"
                    variant="flat"
                    @click="step++"
                >
                    Next
                </v-btn>
                <v-btn v-else color="primary" variant="flat" @click="submit">
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
        <div class="my-5">
            <footer-section></footer-section>
        </div>
    </v-container>
</template>
<script>
import { mapActions, mapState, mapWritableState } from "pinia";
import BreadCrumb from "../../components/common/BreadCrumb.vue";
import TitleBar from "../../components/common/TitleBar.vue";
import FooterSection from "../../components/footer/FooterSection.vue";
import User_child from "../../components/user/child.vue";
import User_other from "../../components/user/other.vue";
import User_parent from "../../components/user/parent.vue";
import User_personal from "../../components/user/personal.vue";
import User_residence from "../../components/user/residence.vue";
import User_spouse from "../../components/user/spouse.vue";
import { createUser, getSingleUser, updateUser } from "../../js/user";
import { useGlobalStore } from "../../stores/global";
import { useUserStore } from "../../stores/user";

export default {
    name: "admin.user.store",
    components: {
        User_child,
        User_parent,
        User_residence,
        User_other,
        FooterSection,
        User_spouse,
        User_personal,
        TitleBar,
        BreadCrumb,
    },
    methods: {
        ...mapActions(useUserStore, {
            setBradCrumb: "setBradCrumb",
            setPermissions: "setPermissions",
            resetSingleData: "resetSingleData",
            setAvatar: "setAvatar",
            setSingleData: "setSingleData",
        }),
        ...mapActions(useGlobalStore, { setGlobalLoading: "setGlobalLoading" }),
        onSelect(event) {
            this.setAvatar(event.target.files[0]);
        },
        async submit() {
            if (this.$route.params.id) {
                await updateUser(this, this.$route.params.id);
            } else {
                await createUser(this);
            }
        },
        async init() {
            this.setGlobalLoading(true);
            if (this.$route.params.id) {
                await getSingleUser(this, this.$route.params.id);
            }
            this.setGlobalLoading(false);
        },
    },
    computed: {
        ...mapState(useUserStore, {
            getBreadcrumb: "getBreadcrumb",
            getRoutes: "getRoutes",
            getApiRoutes: "getApiRoutes",
            getSingleData: "getSingleData",
            getStepTitle: "getStepTitle",
        }),
        ...mapWritableState(useUserStore, {
            singleData: "singleData",
            errors: "errors",
            step: "step",
        }),
    },

    mounted() {
        this.setBradCrumb(this.$route.params.id ? "update" : "create");
        this.init();
    },
};
</script>
<style scoped></style>
