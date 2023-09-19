<template>
    <v-container>
        <BreadCrumb :routes="getBreadcrumb"></BreadCrumb>
        <TitleBar
            :route="getRoutes.index"
            title="Show Loanee"
        ></TitleBar>

        <v-row class="mt-12">
            <v-col class="v-col-4">
                <v-card
                    title="Personal"
                    width="400"
                >
                    <v-list-item :title="'Name: ' + getSingleData.name"></v-list-item>
                    <v-list-item :title="'DOB: ' + getSingleData.dob"></v-list-item>
                    <v-list-item :title="'Email: ' + getSingleData.email"></v-list-item>
                    <v-list-item :title="'Nid number: ' + getSingleData.nid_number"></v-list-item>
                    <v-list-item :title="'Education: ' + getSingleData.education"></v-list-item>
                    <v-list-item :title="'Profession: ' + getSingleData.profession"></v-list-item>
                    <v-list-item :title="'Income: ' + getSingleData.income"></v-list-item>
                    <v-list-item :title="'Status: ' + getSingleData.status"></v-list-item>
                    <v-list-item :title="'Score: ' + getSingleData.score"></v-list-item>
                </v-card>
            </v-col>
            <v-col class="v-col-4">
                <v-card
                    title="Spouse"
                    width="400"
                >
                    <v-list-item :title="'Is alive: ' +( getSingleData.spouse_is_alive ? 'YES' : 'NO')"></v-list-item>
                    <v-list-item v-if="getSingleData.spouse_is_alive"
                                 :title="'Name: ' + getSingleData.spouse_name"></v-list-item>
                    <v-list-item v-if="getSingleData.spouse_is_alive"
                                 :title="'DOB: ' + getSingleData.spouse_dob"></v-list-item>
                    <v-list-item v-if="getSingleData.spouse_is_alive"
                                 :title="'Nid number: ' + getSingleData.spouse_nid_number"></v-list-item>
                    <v-list-item v-if="getSingleData.spouse_is_alive"
                                 :title="'Education: ' + getSingleData.spouse_education"></v-list-item>
                    <v-list-item v-if="getSingleData.spouse_is_alive"
                                 :title="'Profession: ' + getSingleData.spouse_profession"></v-list-item>
                    <v-list-item v-if="getSingleData.spouse_is_alive"
                                 :title="'Income: ' + getSingleData.spouse_income"></v-list-item>
                    <v-list-item v-if="getSingleData.spouse_is_alive"
                                 :title="'Other loan: ' + (getSingleData.other_loan ?? 0)"></v-list-item>
                    <v-list-item v-if="getSingleData.spouse_is_alive"
                                 :title="'Use of loan: ' + (getSingleData.use_of_loan ?? 'None')"></v-list-item>

                </v-card>
            </v-col>
            <v-col class="v-col-4">
                <v-card
                    title="Parent"
                    width="400"
                >
                    <v-list-item :title="'Is alive: ' + ( getSingleData.parent_is_alive ? 'YES' : 'NO')"></v-list-item>
                    <v-list-item v-if="getSingleData.parent_is_alive"
                                 :title="'Are they available? : ' + (getSingleData.parent_is_alive ? 'They stay Combine' : 'They stay Separate')"></v-list-item>
                    <v-list-item v-if="getSingleData.parent_is_alive"
                                 :title="'Profession: ' + getSingleData.parent_profession"></v-list-item>
                </v-card>
            </v-col>
            <v-col class="v-col-4">
                <v-card
                    title="Children"
                    width="400"
                >
                    <v-list-item :title="'Total childern: ' + getSingleData.no_of_child "></v-list-item>
                    <v-list-item v-if="getSingleData.no_of_child > 0"
                                 :title="'Profession : ' + getSingleData.children_profession "></v-list-item>
                </v-card>
            </v-col>
            <v-col class="v-col-4">
                <v-card
                    title="Residence"
                    width="400"
                >
                    <v-list-item :title="'Own house: ' + ( getSingleData.own_house ? 'YES' : 'NO') "></v-list-item>
                    <v-list-item :title="'Total land : ' + getSingleData.total_land "></v-list-item>
                    <v-list-item :title="'House made of : ' + getSingleData.house_made_of "></v-list-item>
                </v-card>
            </v-col>

            <v-col class="v-col-4">
                <v-card
                    title="Other"
                    width="400"
                >
                    <v-list-item :title="'Other earning member: ' + ( getSingleData.other_earning_member ? 'YES' : 'NO') "></v-list-item>
                    <v-list-item :title="'Other member have bank account: ' + ( getSingleData.other_member_have_bank_account ? 'YES' : 'NO') "></v-list-item>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import BreadCrumb from "../../components/common/BreadCrumb.vue";
import TitleBar from "../../components/common/TitleBar.vue";
import {mapActions, mapState} from "pinia";
import {useUserStore} from "../../stores/user";
import {useGlobalStore} from "../../stores/global";
import {getSingleUser} from "../../js/user";


export default ({
    name: "admin.user.show",
    mounted() {
        this.setBradCrumb("show");
        this.init();
    },
    components: {
        TitleBar,
        BreadCrumb,
    },
    computed: {
        ...mapState(useUserStore, {
            getBreadcrumb: "getBreadcrumb",
            getRoutes: "getRoutes",
            getApiRoutes: "getApiRoutes",
            getSingleData: "getSingleData",
            getStepTitle: "getStepTitle",
        }),
    },
    methods: {
        ...mapActions(useUserStore, {
            setBradCrumb: "setBradCrumb",
            setPermissions: "setPermissions",
            resetSingleData: "resetSingleData",
            setAvatar: "setAvatar",
            setSingleData: "setSingleData",
        }),
        ...mapActions(useGlobalStore, {setGlobalLoading: "setGlobalLoading"}),
        async init() {
            this.setGlobalLoading(true);
            await getSingleUser(this, this.$route.params.id);
            this.setGlobalLoading(false);
        },
    },
})
</script>

<style scoped>

</style>
