<template>
    <v-container>
        <BreadCrumb :routes="getBreadcrumb"></BreadCrumb>
        <TitleBar :route="getRoutes.create" :title="getRoutes.index.name"></TitleBar>
        <DataTable :columns='getData.columns' :deleteBtn="getData.deleteBtn" :required_action="getData.showAction"
                   :rows='getData.data'
                   :deleteUrl='getApiRoutes.delete'
                   :total="getData.total" title="Admin" @search="search"/>
    </v-container>
</template>
<script>
import BreadCrumb from "../../components/common/BreadCrumb.vue";
import DataTable from "../../components/common/DataTable.vue";
import TitleBar from "../../components/common/TitleBar.vue";
import {mapActions, mapState} from "pinia";
import {useAdminStore} from "../../stores/admin";
import {useDataTableStore} from "../../stores/dataTable";
import {getAdmins} from "../../js/admin";

export default {
    name: 'admin.user.admin.index',
    components: {TitleBar, DataTable, BreadCrumb},
    methods: {
        ...mapActions(useAdminStore, {
            setData: 'setData',
            setBradCrumb: 'setBradCrumb',
        }),
        async search() {
            await getAdmins(this, this.getSearch)
        },
    },
    computed: {
        ...mapState(useAdminStore, {
            getData: 'getData',
            getBreadcrumb: 'getBreadcrumb',
            getRoutes: 'getRoutes',
            getApiRoutes: 'getApiRoutes',
        }),
        ...mapState(useDataTableStore, {
            getSearch: 'getSearch',
        }),
    },
    mounted() {
        this.setBradCrumb()
        this.search()
    }
}
</script>
<style scoped>

</style>
