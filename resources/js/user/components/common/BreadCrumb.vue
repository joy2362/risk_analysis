<template>
  <v-breadcrumbs :items="routes">
    <template v-slot:title="{ item }">
      {{ item.title.toUpperCase() }}
    </template>
    <template v-slot:divider>
      <v-icon icon="mdi-chevron-right"></v-icon>
    </template>
  </v-breadcrumbs>
</template>

<script>
export default {
  name: 'BreadCrumb',
  props: {
    routes: {
      type: Array,
      required: true,
    },
  }
}
</script>

<style scoped>

</style>