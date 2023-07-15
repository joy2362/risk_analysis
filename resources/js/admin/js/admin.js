export const getAdmins = async (_this, payload) => {
    const res = await _this.$get(_this.getApiRoutes.index, payload)
    _this.setData(res.data?.success ? {
        data: res.data.admins.data,
        total: res.data.admins.total,
    } : {})
}

export const createAdmin = async (_this) => {
    _this.setGlobalLoading(true)
    const formData = new FormData()
    formData.append('avatar', _this.getSingleData.avatar)
    formData.append('name', _this.getSingleData.name)
    formData.append('email', _this.getSingleData.email)
    formData.append('password', _this.getSingleData.password)

    const res = await _this.$post(_this.getApiRoutes.create, formData)
    if (res.data?.success) {
        _this.$success(res.data.message)
        _this.setSingleData({avatar: '', name: '', email: '', password: ''})
        _this.$refs.avatarInput.reset()
        _this.$router.push('/admin/user/admin')
    }
    if (res.errors?.error) {
        _this.$error(res.errors?.error)
    }
    if (res.error) {
        _this.$error(res.error)
    }
    if (res.errors?.errors) {
        _this.errors = res.errors?.errors
    }
    _this.setGlobalLoading(false)
}
