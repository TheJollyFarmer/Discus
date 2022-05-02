<template>
  <v-menu-list
    label="Trending" 
    icon="fire">
    <div
      v-for="(thread, index) in trending"
      :key="thread.id">
      <v-menu-item
        :number="index"
        :label="thread.title | truncate(18)"
        :link-data="{ channel: thread.channel, thread: thread.slug }"
        @onClick="goToThread"/>
    </div>
  </v-menu-list>
</template>

<script>
import api from "../../api";
import filters from "../../utils/filters.js";
import VMenuItem from "../utility/VMenuItem";
import VMenuList from "../utility/VMenuList";

export default {
  name: "TrendingThreadsMenu",

  filters: {
    truncate: filters.truncate
  },

  components: { VMenuItem, VMenuList },

  props: {
    trending: {
      type: Array,
      required: true
    }
  },

  methods: {
    goToThread(params) {
      api.goTo("threads.show", params);
    }
  }
};
</script>
