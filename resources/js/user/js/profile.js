
export const setProfile = async (_this) => {
  const res = await _this.$get(_this.getApiRoutes.getProfile)
  if (res.data?.success) {
    _this.setProfile(res.data)
  }
}
