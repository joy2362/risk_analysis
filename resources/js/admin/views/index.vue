<template>
    <v-container>
        <TitleBar class="mb" title="Dashboard"></TitleBar>
        <v-row>
            <v-col cols="cols">
                <panel_component
                    :value="getDashboardDatas.totalAdmin"
                    icon="mdi-account"
                    title="Total Admins"
                ></panel_component>
            </v-col>
            <v-col cols="cols">
                <panel_component
                    :value="getDashboardDatas.totalUser"
                    icon="mdi-account"
                    title="Total User"
                ></panel_component>
            </v-col>
            <v-col cols="cols">
                <panel_component
                    :value="getDashboardDatas.acceptedUser"
                    icon="mdi-account"
                    title="Total Accepted User"
                ></panel_component>
            </v-col>
            <v-col cols="cols">
                <panel_component
                    :value="getDashboardDatas.conditionallyAcceptedUser"
                    icon="mdi-account"
                    title="Total Conditionally accepted user"
                ></panel_component>
            </v-col>
            <v-col cols="cols">
                <panel_component
                    :value="getDashboardDatas.rejectedUser"
                    icon="mdi-account"
                    title="Total Rejected user"
                ></panel_component>
            </v-col>
        </v-row>
        <v-row class="mt-12">
            <v-col>
                <v-card>
                    <v-card-title class="text-center">Accepted User</v-card-title>
                    <v-table>
                        <thead>
                        <tr>
                            <th class="text-left">
                                Name
                            </th>
                            <th class="text-left">
                                Score
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="item in getDashboardDatas.acceptedUserData"
                            :key="item.name"
                        >
                            <td>{{ item.name }}</td>
                            <td>{{ item.score }}</td>
                        </tr>
                        </tbody>
                    </v-table>
                </v-card>
            </v-col>
            <v-col>
                <v-card>
                    <v-card-title class="text-center">Conditionally accepted user</v-card-title>
                    <v-table height="300px">
                        <thead>
                        <tr>
                            <th class="text-left">
                                Name
                            </th>
                            <th class="text-left">
                                Score
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="item in getDashboardDatas.conditionallyAcceptedUserData"
                            :key="item.name"
                        >
                            <td>{{ item.name }}</td>
                            <td>{{ item.score }}</td>
                        </tr>
                        </tbody>
                    </v-table>
                </v-card>

            </v-col>
            <v-col>
                <v-card>
                    <v-card-title class="text-center">Rejected user</v-card-title>
                    <v-table height="300px">
                        <thead>
                        <tr>
                            <th class="text-left">
                                Name
                            </th>
                            <th class="text-left">
                                Score
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="item in getDashboardDatas.rejectedUserData"
                            :key="item.name"
                        >
                            <td>{{ item.name }}</td>
                            <td>{{ item.score }}</td>
                        </tr>
                        </tbody>
                    </v-table>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import TitleBar from "../components/common/TitleBar.vue";
import {getDashboardData} from "../js/admin";
import {mapActions, mapState} from "pinia";
import {useAdminStore} from "../stores/admin";
import Panel_component from "../components/dashboard/panel-component.vue";

export default {
    name: 'admin.dashboard',
    components: {
        Panel_component,
        TitleBar,
    },

    computed: {
        ...mapState(useAdminStore, {
            getApiRoutes: 'getApiRoutes',
            getDashboardDatas: 'getDashboardDatas',
        }),
    },
    methods: {
        ...mapActions(useAdminStore, {
            setDashboardData: 'setDashboardData',
        }),
    },
    mounted() {
        getDashboardData(this)
    }
}
</script>

<style scoped>
.mb {
    margin-bottom: 15px;
}

</style>
