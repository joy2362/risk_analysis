<template>
    <v-app>
        <GlobalLoading/>
        <div class="main-bg">
            <div>
                <h2 class="text-center mb-4">
                    Welcome to Automation of loan management system
                </h2>
                <v-card
                    class="card-login"
                    elevation="2"
                >
<!--                    <v-card-title class="d-flex justify-center">-->
<!--                        <img :src="getLogo" alt="Logo" class="login-logo">-->
<!--                    </v-card-title>-->

                    <v-form
                        class="form-width"
                        @submit.prevent="submit"
                    >

                        <div class="form-login">
                            <v-text-field
                                v-model="login.email"
                                :error="!!errors.email"
                                :error-messages="errors.email"
                                color="primary"
                                density="compact"
                                label="Email"
                                type="email"
                                variant="underlined"
                            ></v-text-field>

                            <v-text-field
                                v-model="login.password"
                                :append-icon="showBtn.loginPass ? 'mdi-eye' : 'mdi-eye-off'"
                                :error="!!errors.password"
                                :error-messages="errors.password"
                                :type="showBtn.loginPass ? 'text' : 'password'"
                                color="primary"
                                density="compact"
                                label="Password"
                                variant="underlined"
                                @click:append="showBtn.loginPass = !showBtn.loginPass"
                            ></v-text-field>
                        </div>
                        <div class="login-button">

                            <v-btn
                                class="ma-2"
                                color="primary"
                                type="submit"
                            >
                                Login
                            </v-btn>
                        </div>
                    </v-form>
                </v-card>
            </div>

        </div>
    </v-app>
</template>

<script>
import {mapActions, mapState, mapWritableState} from 'pinia'
import {useUserAuthStore} from '../../stores/auth'
import {useGlobalStore} from '../../stores/global'
import {login} from '../../js/auth'

export default {
    computed: {
        ...mapWritableState(useUserAuthStore, {login: 'login', errors: 'errors', showBtn: 'showBtn'}),
        ...mapState(useUserAuthStore, {
            getLoginData: 'getLoginData',
            getApiRoutes: 'getApiRoutes'
        }),
        ...mapState(useGlobalStore, {getLogo: 'getLogo'})
    },
    methods: {
        ...mapActions(useUserAuthStore, {setToken: 'setToken', setErrors: 'setErrors', clearLogin: 'clearLogin'}),
        ...mapActions(useGlobalStore, {setGlobalLoading: 'setGlobalLoading'}),
        async submit() {
            await login(this)
        }
    }
}
</script>

<style scoped src="../../styles/auth.css"></style>
