<template>
  <div class="column is-one-quarter">
    <v-menu>
      <thread-filters-menu/>
      <trending-threads-menu :trending="trending"/>
    </v-menu>
  </div>
</template>

<script>
import ThreadFiltersMenu from "./SideBarThreadFiltersMenu";
import TrendingThreadsMenu from "./SideBarTrendingThreadsMenu";
import UserPanelLink from "../utility/VMenuItem";
import VMenu from "../utility/VMenu";

export default {
  name: "SideBar",

  components: { ThreadFiltersMenu, TrendingThreadsMenu, UserPanelLink, VMenu },

  props: {
    trending: {
      type: Array,
      required: true
    }
  }
};
</script>
