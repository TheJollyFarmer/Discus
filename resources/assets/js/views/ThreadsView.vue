<template>
  <v-page @fetch="getData">
    <threads-list/>
  </v-page>
</template>

<script>
import breadcrumbs from "../constants/Breadcrumbs";
import ThreadsList from "../components/lists/ThreadsList";
import VPage from "../components/utility/VPage";
import { mapActions, mapState } from "vuex";

export default {
  name: "ThreadsView",

  components: { ThreadsList, VPage },

  computed: {
    ...mapState("threads", ["breadcrumb"])
  },

  watch: {
    breadcrumb(newValue, oldValue) {
      if (newValue !== oldValue) {
        let breadcrumb = breadcrumbs[this.breadcrumb]
          ? breadcrumbs[this.breadcrumb]
          : this.generateChannelCrumb(newValue);

        this.replaceBreadcrumb(breadcrumb);
      }
    }
  },

  mounted() {
    this.addBreadcrumbs([breadcrumbs.THREADS, breadcrumbs[this.breadcrumb]]);
  },

  methods: {
    ...mapActions({
      addBreadcrumbs: "addBreadcrumbs",
      replaceBreadcrumb: "replaceBreadcrumb",
      getData: "threads/getData"
    }),

    generateChannelCrumb(channel) {
      return { icon: "tv", label: channel };
    }
  }
};
</script>
