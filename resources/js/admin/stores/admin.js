import {defineStore} from 'pinia'

export const useAdminStore = defineStore('admin', {
    state: () => {
        return {
            dashboard: [],
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
                    name: 'Create Admin',
                    to: '/admin/user/admin/store',
                    icon: 'mdi-plus'
                },
                index: {
                    name: 'All Admin',
                    to: '/admin/user/admin',
                    icon: 'mdi-eye'
                },

                Dashboard: {
                    name: 'Dashboard',
                    to: '/',
                    icon: 'mdi-eye'
                },
            },
            errors: [],
            singleData: {
                name: '',
                email: '',
                password: '',
                avatar: '',
            },
            showAction: true,
            deleteBtn: true,
            apiRoutes: {
                index: '/api/admin/admins',
                create: '/api/admin/admins',
                delete: '/api/admin/admins',
                dashboard: '/api/admin/profile/dashboard',
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

        getDashboardDatas(state){
            return state.dashboard
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
    },
    actions: {
        setDashboardData(data){
            this.dashboard = data
        },
        setData(role) {
            this.data = role.data
            this.total = role.total
        },
        setSingleData(data) {
            this.singleData = data
        },
        setAvatar (payload) {
            this.singleData.avatar = payload
        },
        setBradCrumb(type = 'index') {
            this.breadCrumb.splice(1)
            this.breadCrumb.push(
                {
                    title: 'Admin',
                    disabled: type === 'index',
                    href: type === 'index' ? '' : '/admin/user/admin',
                }
            )
            if (type !== 'index') {
                this.breadCrumb.push(
                    {
                        title: type === 'create' ? 'Create Role' : type === 'update' ? 'Update Admin' : 'View Admin',
                        disabled: true,
                        href: '',
                    }
                )
            }
        },
    }
})
