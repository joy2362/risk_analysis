<template>
    <v-container>
        <BreadCrumb :routes="getBreadcrumb"></BreadCrumb>
        <TitleBar
            :route="getRoutes.create"
            :title="getRoutes.index.name"
        ></TitleBar>
        <DataTable
            :columns="getData.columns"
            :updateBtn="getData.updateBtn"
            :deleteBtn="getData.deleteBtn"
            :showBtn="getData.showBtn"
            :required_action="getData.showAction"
            :rows="getData.data"
            :deleteUrl="getApiRoutes.delete"
            :updateUrl="getApiRoutes.updateUrl"
            :total="getData.total"
            title="User"
            @search="search"
        />
    </v-container>
</template>
<script>
import { mapActions, mapState } from "pinia";
import BreadCrumb from "../../components/common/BreadCrumb.vue";
import DataTable from "../../components/common/DataTable.vue";
import TitleBar from "../../components/common/TitleBar.vue";
import { getUser } from "../../js/user";
import { useDataTableStore } from "../../stores/dataTable";
import { useUserStore } from "../../stores/user";

export default {
    name: "admin.user.index",
    components: { TitleBar, DataTable, BreadCrumb },
    methods: {
        ...mapActions(useUserStore, {
            setData: "setData",
            setBradCrumb: "setBradCrumb",
        }),
        async search() {
            await getUser(this, this.getSearch);
        },
    },
    computed: {
        ...mapState(useUserStore, {
            getData: "getData",
            getBreadcrumb: "getBreadcrumb",
            getRoutes: "getRoutes",
            getApiRoutes: "getApiRoutes",
        }),
        ...mapState(useDataTableStore, {
            getSearch: "getSearch",
        }),
    },
    mounted() {
        this.setBradCrumb();
        this.search();
    },
};
</script>
<style scoped></style>
