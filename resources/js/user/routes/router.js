import {createRouter, createWebHistory} from 'vue-router'

const routes = [
    {
        path: '/login',
        name: 'login',
        meta: {
            title: 'Login',
            redirectIfAuthenticated: true,
        },
        component: () => import(/* webpackChunkName: "login" */'../views/auth/login.vue'),
    },

    {
        path: '/',
        component: () => import('../layouts/Main.vue'),
        name: 'layout',
        children: [
            {
                path: '/',
                name: 'dashboard',
                meta: {
                    title: 'Dashboard',
                    requireAuth: true
                },
                component: () => import(/* webpackChunkName: "dashboard" */ '../views/index.vue'),
            },
        ],
    },
]

function setTitle(title) {
    document.title = title ? title + ' | ' + import.meta.env.VITE_APP_NAME : import.meta.env.VITE_APP_NAME ?? 'cms'
}

const token = () => {
    return localStorage.getItem('userToken') ?? ''
}

const clearToken = () => {
    localStorage.removeItem('userToken')
}

export const userRouter = createRouter({
    history: createWebHistory(),
    routes
})

userRouter.beforeEach((to, from, next) => {
    if (to.meta.title) {
        setTitle(to.meta.title)
    }
    if (to.meta.requireAuth) {
        if (token()) {
            axios.get('/api/me', {
                headers: {
                    Authorization: `Bearer ${token()}`
                }
            }).then(() => {
                next()
            }).catch(err => {
                if (err.response.status === 401) {
                    clearToken()
                    next({name: 'login'})
                }
            })
        } else {
            next({name: 'login'})
        }
    } else if (to.meta.redirectIfAuthenticated) {
        if (!token()) {
            next()
        } else {
            next({name: 'dashboard'})
        }
    } else {
        next()
    }

})
