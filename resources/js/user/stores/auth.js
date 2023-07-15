import {defineStore} from 'pinia'

export const useUserAuthStore = defineStore('userAuth', {
    state: () => {
        return {
            token: localStorage.getItem('userToken') ?? '',
            login: {
                email: '',
                password: '',
            },
            showBtn: {
                loginPass: false,
            },
            apiRoutes: {
                login: '/api/login',
                logout: '/api/logout',
            },
            errors: [],
        }
    },
    getters: {
        getToken(state) {
            return state.token
        },
        getLoginData(state) {
            return state.login
        },
        getApiRoutes(state) {
            return state.apiRoutes
        },
        getErrors(state) {
            return state.errors
        }
    },
    actions: {
        setToken(token) {
            localStorage.setItem('userToken', token)
            this.token = localStorage.getItem('userToken') ?? ''
        },
        removeToken() {
            localStorage.removeItem('userToken')
            this.token = ''
        },
        setErrors(payload = []) {
            this.errors = payload
        },
        clearLogin() {
            this.login.email = ''
            this.login.password = ''
        },
    }
})
