<template>
    <div>
        <v-navigation-drawer v-model="drawer" permanent>
            <v-list-item
                :prepend-avatar="profile.avatar"
                :title="profile.name"
            >
                <template v-slot:append>
                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn
                                icon="mdi-chevron-right"
                                v-bind="props"
                                variant="text"
                            ></v-btn>
                        </template>

                        <v-list bg-color="primary" class="list" min-width="200">
                            <v-list-item @click="toProfile">
                                <v-list-item-title>
                                    <v-icon>mdi-account</v-icon>
                                    Profile
                                </v-list-item-title>
                            </v-list-item>

                            <v-list-item @click="logout">
                                <v-list-item-title>
                                    <v-icon color="red">mdi-power</v-icon>
                                    <span class="text-red">Logout</span>
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </template>
            </v-list-item>

            <v-divider></v-divider>

            <v-list v-for="(item, i) in menu" :key="i" density="compact" nav>
                <v-list-item
                    v-if="!item.submenu"
                    :prepend-icon="item.icon"
                    :title="item.title"
                    :to="item.url"
                ></v-list-item>

                <v-list-group v-else :key="i">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            :prepend-icon="item.icon"
                            :title="item.title"
                            v-bind="props"
                        ></v-list-item>
                    </template>

                    <v-list-item
                        v-for="(sub, idx) in item.submenu"
                        :key="idx"
                        :prepend-icon="sub.icon"
                        :title="sub.title"
                        :to="sub.url"
                        class="item_menu"
                    ></v-list-item>
                </v-list-group>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar :elevation="2">
            <template v-slot:prepend>
                <v-app-bar-nav-icon @click.stop="setDrawer"></v-app-bar-nav-icon>
                <p>{{app_name}}</p>
            </template>
            <template v-slot:append>

                <v-tooltip text="Theme">
                    <template v-slot:activator="{ props }">
                        <v-btn :icon="getTheme === 'dark' ?  'mdi-weather-night' : 'mdi-weather-sunny'" v-bind="props"
                               variant="tonal"
                               @click="changeTheme"></v-btn>
                    </template>
                </v-tooltip>
            </template>
        </v-app-bar>
    </div>
</template>

<script>
import {mapActions, mapState, mapWritableState} from 'pinia'
import {useAuthStore} from '../../stores/auth'
import {useProfileStore} from '../../stores/profile'
import {useSettingStore} from '../../stores/setting'
import {changeTheme, logout} from '../../js/layout'
import {setProfile} from '../../js/profile'

export default {
    data() {
        return {
            menu: [
                {
                    title: 'Dashboard',
                    icon: 'mdi-home',
                    url: '/admin/dashboard',
                },
                {
                    title: 'Admin',
                    icon: 'mdi-view-dashboard',
                    url: '/admin/user/admin',
                },
                {
                    title: 'User',
                    icon: 'mdi-view-dashboard',
                    url: '/admin/user',
                },
            ],
            notification: [
                {
                    title: 'abdullah zahid',
                    description: 'Create a new category',
                    avatar: 'https://cdn.vuetifyjs.com/images/john.jpg'
                },
                {
                    title: 'abdullah zahid',
                    description: 'update a new category',
                    avatar: 'https://cdn.vuetifyjs.com/images/john.jpg'
                },
                {
                    title: 'abdullah zahid',
                    description: 'delete a new category',
                    avatar: 'https://cdn.vuetifyjs.com/images/john.jpg'
                }
            ],
            app_name: import.meta.env.VITE_APP_NAME ?? 'Risk analysis'
        }
    },
    mounted() {
        this.setProfileDetails()
    },
    computed: {
        ...mapState(useProfileStore, {profile: 'getProfile', getApiRoutes: 'getApiRoutes',}),
        ...mapState(useSettingStore, {getTheme: 'getTheme'}),
        ...mapWritableState(useSettingStore, {drawer: 'drawer'})
    },
    methods: {
        ...mapActions(useAuthStore, {removeToken: 'removeToken'}),
        ...mapActions(useProfileStore, {setProfile: 'setProfile'}),
        ...mapActions(useSettingStore, {setTheme: 'setTheme', setDrawer: 'setDrawer'}),
        changeTheme() {
            changeTheme(this)
        },
        toProfile() {
            this.$router.push('/admin/profile')
        },
        async logout() {
            await logout(this)
        },
        async setProfileDetails() {
            await setProfile(this)
        }

    },
}
</script>

<style scoped src="../../styles/layout-app.css"></style>
