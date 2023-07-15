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
                    label: 'Gender',
                    field: 'gender',
                    sortable: true,
                },
                {
                    label: 'Email',
                    field: 'email',
                    sortable: true,
                },
                {
                    label: 'Score',
                    field: 'score',
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
                    name: 'Create User',
                    to: '/admin/user/store',
                    icon: 'mdi-plus'
                },
                index: {
                    name: 'All User',
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
                education: '',
                profession: '',
                income: 0,
                gender: 'female',
                spouse: {
                    name: '',
                    is_alive: true,
                    dob: '',
                    nid_number: '',
                    education: '',
                    profession: '',
                    income: 0,
                    gender: 'male'
                },
                other: {
                    other_member_have_bank_account: true,
                    other_earning_member: true,
                },
                residence: {
                    own_house: true,
                    total_land: 0,
                    house_made_of: '',
                },
                parent: {
                    is_alive: true,
                    available: 0,
                    profession: '',
                },
                member: {
                    name: '',
                    dob: '',
                    nid_number: '',
                    education: '',
                    profession: '',
                    income: 0,
                    gender: 'male'
                },
                child:{
                    no_of_child: 1,
                    profession: '',
                }
            },
            step: 0,
            step_title: [
                'Personal', 'Spouse', 'Parent', 'Child', 'Member', 'Residence', 'Other'
            ],
            gender: [
                {
                    name: 'Male', value: "male"
                },
                {
                    name: 'Female', value: "female"
                },
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
            showAction: true,
            deleteBtn: true,
            apiRoutes: {
                index: '/api/admin/users',
                create: '/api/admin/users',
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
        getGender(state) {
            return state.gender
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
        }
    },
    actions: {
        setData(role) {
            this.data = role.data
            this.total = role.total
        },
        setSingleData(data) {
            this.singleData = data
        },
        setAvatar(payload) {
            this.singleData.avatar = payload
        },
        setBradCrumb(type = 'index') {
            this.breadCrumb.splice(1)
            this.breadCrumb.push(
                {
                    title: 'User',
                    disabled: type === 'index',
                    href: type === 'index' ? '' : '/admin/user',
                }
            )
            if (type !== 'index') {
                this.breadCrumb.push(
                    {
                        title: type === 'create' ? 'Create Role' : type === 'update' ? 'Update User' : 'View User',
                        disabled: true,
                        href: '',
                    }
                )
            }
        },
    }
})
