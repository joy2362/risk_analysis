import {defineStore} from 'pinia'

export const useUserProfileStore = defineStore('userProfile', {
    state: () => {
        return {
            profile: [],
            apiRoutes: {
                getProfile: '/api/profile',
            },
        }
    },
    getters: {
        getProfile(state) {
            return state.profile
        },
        getApiRoutes(state) {
            return state.apiRoutes
        },

    },
    actions: {
        setProfile(payload = []) {
            this.profile = payload?.profile ?? []
            this.form = {
                name: payload?.profile.name ?? '',
                email: payload?.profile.email ?? ''
            }
        },
    }
})
