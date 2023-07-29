export const getUser = async (_this, payload) => {
    const res = await _this.$get(_this.getApiRoutes.index, payload)
    _this.setData(res.data?.success ? {
        data: res.data.users.data,
        total: res.data.users.total,
    } : {})
}


export const createUser = async (_this) => {
    _this.setGlobalLoading(true)

    const payload = new FormData();

    // Append other form fields
    Object.entries(_this.getSingleData).forEach(([key, value]) => {
        payload.append(key, value);
    });

    const res = await _this.$post(_this.getApiRoutes.create, payload)
    if (res.data?.success) {
        _this.$success(res.data.message)
         _this.resetSingleData()
        _this.$router.push('/admin/user')
    }
    if (res.errors?.error) {
        _this.$error(res.errors?.error)
    }
    if (res.error) {
        _this.$error(res.error)
    }
    if (res.errors?.errors) {
        _this.errors = res.errors?.errors
        _this.step = 0
        _this.$error('Check the form again')
    }
    _this.setGlobalLoading(false)
}
