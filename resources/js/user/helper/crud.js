const crud = {
    install(app) {
        app.config.globalProperties.$postWithOutuserToken = async (url, payload) => {
            const userToken = localStorage.getItem('userToken')
            let instance = axios.create({
                headers: {
                    Authorization: `Bearer ${userToken}`,
                }
            })
            let response = {
                'data': {},
                'errors': {},
            }
            await instance.post(url, payload).then(res => {
                response.data = res.data
            }).catch(err => {
                response.errors = err.response.data
            })
            return response
        }

        app.config.globalProperties.$get = async (url, payload = []) => {
            const userToken = localStorage.getItem('userToken')
            let instance = axios.create({
                headers: {
                    Authorization: `Bearer ${userToken}`,
                }
            })
            let response = {
                'data': {},
                'errors': {},
            }
            await instance.get(url, {params: payload}).then(res => {
                response.data = res.data
            }).catch(err => {
                response.errors = err.response.data
            })
            return response
        }

        app.config.globalProperties.$delete = async (url) => {
            const userToken = localStorage.getItem('userToken')
            let instance = axios.create({
                headers: {
                    Authorization: `Bearer ${userToken}`,
                }
            })
            let response = {
                'data': {},
                'errors': {},
                'error': {},
            }
            await instance.delete(url).then(res => {
                response.data = res.data
            }).catch(err => {
                if (err.response.status === 422) {
                    response.errors = err.response.data
                } else {
                    response.error = err.response.data
                }
            })
            return response
        }

        app.config.globalProperties.$post = async (url, payload = []) => {
            const userToken = localStorage.getItem('userToken')
            let instance = axios.create({
                headers: {
                    Authorization: `Bearer ${userToken}`,
                    "Content-Type": "multipart/form-data",
                }
            })
            let response = {
                'data': {},
                'errors': {},
            }

            await instance.post(url, payload).then(res => {
                response.data = res.data
            }).catch(err => {
                response.errors = err.response.data
            })
            return response
        }
    }
}

export default crud
