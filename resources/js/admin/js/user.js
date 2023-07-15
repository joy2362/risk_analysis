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

        if (key === 'spouse') {
            Object.entries(_this.getSingleData.spouse).forEach(([key, value]) => {
                payload.append(`spouse[${key}]`, value);
            });
        } else if (key === 'parent') {
            Object.entries(_this.getSingleData.parent).forEach(([key, value]) => {
                payload.append(`parent[${key}]`, value);
            });
        } else if (key === 'residence') {
            Object.entries(_this.getSingleData.residence).forEach(([key, value]) => {
                payload.append(`residence[${key}]`, value);
            });
        } else if (key === 'child') {
            Object.entries(_this.getSingleData.child).forEach(([key, value]) => {
                payload.append(`child[${key}]`, value);
            });
        } else if (key === 'member') {
            Object.entries(_this.getSingleData.member).forEach(([key, value]) => {
                payload.append(`member[${key}]`, value);
            });
        } else if (key === 'other') {
            Object.entries(_this.getSingleData.other).forEach(([key, value]) => {
                payload.append(`other[${key}]`, value);
            });
        } else {
            payload.append(key, value);
        }
    });

    const res = await _this.$post(_this.getApiRoutes.create, payload)
    if (res.data?.success) {
        _this.$success(res.data.message)
        // _this.setSingleData({avatar: '', name: '', email: '', password: ''})
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
