<template>
  <v-menu-list 
    label="Filter" 
    icon="filter">
    <v-menu-item 
      v-for="(filter, index) in filters"
      :key="index"
      :icon="filter.icon"
      :label="filter.label"
      :link-data="filter.linkData"
      :list-active="isActive(filter.linkData)"
      @onClick="setFilter"/>
    <v-menu-item
      :list-active="displayChannels"
      has-list
      label="Channels" 
      icon="tv"
      @onClick="toggleChannels">
      <v-menu-item
        v-for="channel in channels"
        :key="channel.id"
        :label="channel.name"
        :icon-colour="channel.color"
        :link-data="{ channel: channel.slug }"
        :list-active="isActive({ channel: channel.slug })"
        icon="circle"
        @onClick="setFilter"/>
    </v-menu-item>
  </v-menu-list>
</template>

<script>
import ThreadFilters from "../../constants/ThreadFilters";
import VMenuItem from "../utility/VMenuItem";
import VMenuList from "../utility/VMenuList";
import { mapActions, mapGetters, mapState } from "vuex";

export default {
  name: "ThreadFilters",

  components: { VMenuItem, VMenuList },

  data() {
    return {
      displayChannels: false,
      filters: ThreadFilters
    };
  },

  computed: {
    ...mapGetters({
      isLoggedIn: "auth/isLoggedIn",
      isActive: "threads/isActiveFilter"
    }),

    ...mapState({
      user: state => (state.auth.user ? state.auth.user.name : ""),
      channels: state => state.channels
    })
  },

  created() {
    this.applyUserToFilter();
  },

  methods: {
    ...mapActions("threads", ["setFilter"]),

    toggleChannels() {
      this.displayChannels = !this.displayChannels;
    },

    applyUserToFilter() {
      this.$set(this.filters.PERSONAL.linkData, "by", this.user);
    }
  }
};
</script>
