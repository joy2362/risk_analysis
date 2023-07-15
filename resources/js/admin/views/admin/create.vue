<template>
    <v-container>
        <GlobalLoading/>
        <BreadCrumb :routes="getBreadcrumb"></BreadCrumb>
        <TitleBar :route="getRoutes.index" :title="$route.params.id ? 'Update Role': 'Create Role'"></TitleBar>
        <v-card>
            <v-card-text>
                <v-text-field v-model="singleData.name"
                              :error="!!errors.name" :error-messages="errors.name" label="Name"></v-text-field>
                <v-text-field v-model="singleData.email" :error="!!errors.email" :error-messages="errors.email"
                              label="Email" type="email"></v-text-field>
                <v-text-field v-model="singleData.password" :error="!!errors.password" :error-messages="errors.password"
                              label="password" type="password"></v-text-field>

                <v-file-input
                    accept="image/*"
                    :clearable="false"
                    :error="!!errors.avatar"
                    :error-messages="errors.avatar"
                    label="Profile Picture"
                    prepend-icon="mdi-camera"
                    show-size
                    @input="onSelect"
                    ref="avatarInput"
                ></v-file-input>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" variant="tonal" @click="submit"> Save</v-btn>
                </v-card-actions>
            </v-card-text>
        </v-card>
    </v-container>
</template>
<script>
import BreadCrumb from "../../components/common/BreadCrumb.vue";
import TitleBar from "../../components/common/TitleBar.vue";
import {mapActions, mapState, mapWritableState} from "pinia";
import {useGlobalStore} from "../../stores/global";
import {useAdminStore} from "../../stores/admin";
import {createAdmin} from "../../js/admin";

export default {
    name: 'admin.user.admin.store',
    components: {TitleBar, BreadCrumb},
    methods: {
        ...mapActions(useAdminStore, {
            setBradCrumb: 'setBradCrumb',
            setPermissions: 'setPermissions',
            setSingleData: 'setSingleData',
            setAvatar: 'setAvatar',
        }),
        ...mapActions(useGlobalStore, {setGlobalLoading: 'setGlobalLoading'}),
        onSelect(event) {
            this.setAvatar(event.target.files[0])
        },
        async submit () {
            await createAdmin(this)
        },
    },
    computed: {
        ...mapState(useAdminStore, {
            getBreadcrumb: 'getBreadcrumb',
            getRoutes: 'getRoutes',
            getApiRoutes: 'getApiRoutes',
            getSingleData: 'getSingleData',
        }),
        ...mapWritableState(useAdminStore, {
            singleData: 'singleData', errors: 'errors'
        }),
    },

    mounted() {
        this.setBradCrumb('create')
    }
}
</script>
<style scoped>

</style>
