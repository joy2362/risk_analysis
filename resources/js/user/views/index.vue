<template>
  <div>
    <v-container>
      <TitleBar :routes="routes" :title="title" class="mb"></TitleBar>
      <v-row>
        <v-col cols="cols">
          <panelComponentVue
              title="Your score"
              :value="profile.score"
          ></panelComponentVue>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import panelComponentVue from '../components/dashboard/panel-component.vue'
import chartComponentVue from '../components/dashboard/chart-component.vue'
import popularProductComponentVue from '../components/dashboard/popular-product-component.vue'
import trafficComponentVue from '../components/dashboard/traffic-component.vue'
import activityComponent from '../components/dashboard/activity-component.vue'
import TitleBar from "../components/common/TitleBar.vue";
import {mapState} from "pinia";
import {useUserProfileStore} from "../stores/profile";

export default {
  components: {
      TitleBar,
    panelComponentVue,
    chartComponentVue,
    popularProductComponentVue,
    trafficComponentVue,
    activityComponent,
  },
    computed: {
        ...mapState(useUserProfileStore, {profile: 'getProfile'}),
    },
    data () {
    return {
      title: 'Dashboard',
      routes: [
        {
          title: 'Dashboard',
          disabled: false,
          href: '/',
        },
      ],
    }
  },
}
</script>

<style scoped>
.mb {
  margin-bottom: 15px;
}

</style>
