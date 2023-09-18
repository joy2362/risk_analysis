import {defineStore} from 'pinia'

export const useUserStore = defineStore('user', {
    state: () => {
        return {
            data: [],
            total: 0,
            columns: [
                {
                    label: 'Name',
                    field: 'name',
                    sortable: true,
                },
                {
                    label: 'Email',
                    field: 'email',
                    sortable: true,
                },
                {
                    label: 'Nid',
                    field: 'nid_number',
                    sortable: true,
                },
                {
                    label: 'Profession',
                    field: 'profession',
                    sortable: true,
                },
                {
                    label: 'Status',
                    field: 'status',
                    sortable: true,
                },
                {
                    label: 'Score',
                    field: 'score',
                    sortable: true,
                },
            ],
            breadCrumb: [
                {
                    title: 'Dashboard',
                    disabled: false,
                    href: '/admin/dashboard',
                }
            ],
            routes: {
                create: {
                    name: 'Create Loanee',
                    to: '/admin/user/store',
                    icon: 'mdi-plus'
                },
                index: {
                    name: 'All Loanee',
                    to: '/admin/user',
                    icon: 'mdi-eye'
                },
            },
            errors: [],
            singleData: {
                name: '',
                email: '',
                password: '',
                avatar: '',
                dob: '',
                nid_number: '',
                education: 'no education',
                profession: 'home maker',
                income: 0,

                parent_is_alive: true,
                parent_available: 1,
                parent_profession: 'farming',

                spouse_is_alive: true,
                spouse_name: '',
                spouse_dob: '',
                spouse_nid_number: '',
                spouse_income: 0,
                spouse_profession: 'rickshaw puller',
                spouse_education: 'no education',
                other_loan: 0,
                use_of_loan: 'cow',

                no_of_child: 1,
                children_profession: 'age less than 5 years',

                own_house: true,
                total_land: 0,
                house_made_of: 'only tin',

                other_earning_member: true,
                other_member_have_bank_account: true,
            },
            step: 6,
            step_title: [
                'Personal', 'Spouse', 'Parent', 'Child', 'Residence', 'Other'
            ],
            education: [
                {
                    name: 'No Education',
                    value: 'no education'
                },
                {
                    name: 'Pass PSC',
                    value: 'pass PSC'
                },
                {
                    name: 'Pass JSC',
                    value: 'pass JSC'
                },
                {
                    name: 'SSC pass',
                    value: 'SSC pass'
                },
                {
                    name: 'HSC Pass',
                    value: 'HSC Pass'
                },
                {
                    name: 'Graduation',
                    value: 'graduation'
                },
                {
                    name: 'Post-Graduation',
                    value: 'post-graduation'
                },
            ],
            profession: [
                {
                    name: 'Rickshaw puller',
                    value: 'rickshaw puller'
                },
                {
                    name: 'Unemployed',
                    value: 'unemployed'
                },
                {
                    name: 'Private Job holder',
                    value: 'private Job holder'
                },
                {
                    name: 'Job seeker',
                    value: 'job seeker'
                },
                {
                    name: 'Garments Sector',
                    value: 'garments sector'
                },
                {
                    name: 'Driver',
                    value: 'driver'
                },
                {
                    name: 'Farming',
                    value: 'farming'
                },
                {
                    name: 'Business',
                    value: 'business'
                },
                {
                    name: 'Wanted to go abroad',
                    value: 'wanted to go abroad'
                },
            ],
            material: [
                {
                    name: 'Only Tin', value: "only tin"
                },
                {
                    name: 'Tin and Concrete', value: "tin and concrete"
                },
                {
                    name: 'Building', value: "building"
                },
                {
                    name: 'Tin and Bamboo without concrete floor', value: "tin and Bamboo without concrete floor"
                },
            ],
            parentProfession: [
                {
                    name: 'Farming', value: "farming"
                },
                {
                    name: 'Job Holder', value: "job holder"
                },
                {
                    name: 'More than 55 years', value: "more than 55 years"
                },
            ],
            memberProfession: [
                {
                    name: 'Home Maker', value: "home maker"
                },
                {
                    name: 'Job holder', value: "job holder"
                },
            ],
            childProfession: [
                {
                    name: 'Age Less than 5 years', value: "age less than 5 years"
                },
                {
                    name: 'Student class 1-5', value: "student class 1-5"
                },
                {
                    name: 'Student Class 6 to high', value: "student class 6 to high"
                },
                {
                    name: 'Job Holder', value: "job Holder"
                },
            ],
            parentAvailable: [
                {
                    name: 'They stay Combine', value: 1
                },
                {
                    name: 'They stay Separate', value: 0
                },
            ],
            loanUsedFor: [
                {
                    name: 'Cow',
                    value: 'cow',
                },
                {
                    name: 'Car',
                    value: 'car',
                },
                {
                    name: 'Not Sure',
                    value: 'not sure',
                },
                {
                    name: 'Other',
                    value: 'other',
                },
                {
                    name: 'Agriculture',
                    value: 'agriculture',
                },
                {
                    name: 'Plotly farm',
                    value: 'plotly farm',
                },
                {
                    name: "Business",
                    value: "business"
                }

            ],
            showAction: true,
            updateBtn: true,
            deleteBtn: true,
            updateUrl: '/admin/user/store',
            apiRoutes: {
                index: '/api/admin/users',
                create: '/api/admin/users',
                update: '/api/admin/users',
                delete: '/api/admin/users',
            }
        }
    },
    getters: {
        getData(state) {
            return {
                data: state.data,
                total: state.total,
                columns: state.columns,
                showAction: state.showAction,
                deleteBtn: state.deleteBtn,
                updateBtn: state.updateBtn,
                updateUrl: state.updateUrl,
            }
        },
        getBreadcrumb(state) {
            return state.breadCrumb
        },
        getRoutes(state) {
            return state.routes
        },
        getApiRoutes(state) {
            return state.apiRoutes
        },
        getSingleData(state) {
            return state.singleData
        },
        getStepTitle(state) {
            return state.step_title
        },
        getEducation(state) {
            return state.education
        },
        getProfession(state) {
            return state.profession
        },
        getMaterial(state) {
            return state.material
        },
        getParentProfession(state) {
            return state.parentProfession
        },
        getMemberProfession(state) {
            return state.memberProfession
        },
        getChildProfession(state) {
            return state.childProfession
        },
        getParentAvailable(state) {
            return state.parentAvailable
        },
        getLoanUsedFor(state) {
            return state.loanUsedFor
        }
    },
    actions: {
        setData(role) {
            this.data = role.data
            this.total = role.total
        },
        resetSingleData() {
            this.singleData = {
                name: '',
                email: '',
                password: '',
                avatar: '',
                dob: '',
                nid_number: '',
                education: '',
                profession: '',
                income: 0,

                parent_is_alive: true,
                parent_available: 0,
                parent_profession: '',

                spouse_is_alive: true,
                spouse_name: '',
                spouse_dob: '',
                spouse_nid_number: '',
                spouse_income: 0,
                spouse_profession: '',
                spouse_education: '',

                no_of_child: 0,
                children_profession: '',

                own_house: true,
                total_land: 0,
                house_made_of: '',

                other_earning_member: true,
                other_member_have_bank_account: true,
            };
            this.step = 0;
            this.errors = [];

        },
        setAvatar(payload) {
            this.singleData.avatar = payload
        },
        setSingleData(data) {
            this.singleData = {
                name: data.name,
                email: data.email,
                password: '',
                avatar: '',
                dob: data.dob,
                nid_number: data.nid_number,
                education: data.education,
                profession: data.profession,
                income: data.income,

                parent_is_alive: !!data.parent_is_alive,
                parent_available: !!data.parent_available ? 'yes' : 'no',
                parent_profession: data.parent_profession,

                spouse_is_alive: !!data.spouse_is_alive,
                spouse_name: data.spouse_name,
                spouse_dob: data.spouse_dob,
                spouse_nid_number: data.spouse_nid_number,
                spouse_income: data.spouse_income,
                spouse_profession: data.spouse_profession,
                other_loan: data.other_loan,
                use_of_loan: data.use_of_loan,

                no_of_child: data.no_of_child,
                children_profession: data.children_profession,

                own_house: !!data.own_house,
                total_land: data.total_land,
                house_made_of: data.house_made_of,

                other_earning_member: !!data.other_earning_member,
                other_member_have_bank_account: !!data.other_member_have_bank_account,
            };
        },
        setBradCrumb(type = 'index') {
            this.breadCrumb.splice(1)
            this.breadCrumb.push(
                {
                    title: 'Loanee',
                    disabled: type === 'index',
                    href: type === 'index' ? '' : '/admin/user',
                }
            )
            if (type !== 'index') {
                this.breadCrumb.push(
                    {
                        title: type === 'create' ? 'Create Loanee' : type === 'update' ? 'Update Loanee' : 'View Loanee',
                        disabled: true,
                        href: '',
                    }
                )
            }
        },
    }
})
