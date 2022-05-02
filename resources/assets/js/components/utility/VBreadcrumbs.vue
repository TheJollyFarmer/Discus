<template>
  <nav 
    class="breadcrumb is-medium"
    aria-label="breadcrumbs">
    <ul>
      <template v-for="(breadcrumb, index) in breadcrumbs">
        <v-breadcrumb 
          :key="index"
          :breadcrumb="breadcrumb"
          :is-active="isActive(breadcrumb, index)"/>
      </template>
    </ul>
  </nav>
</template>

<script>
import VBreadcrumb from "./VBreadcrumb";
import { mapGetters } from "vuex";

export default {
  name: "VBreadcrumbs",

  components: { VBreadcrumb },

  computed: mapGetters({
    breadcrumbs: "getBreadcrumbs"
  }),

  methods: {
    isActive(breadcrumb, index) {
      return index === this.breadcrumbs.length - 1 || !breadcrumb.route;
    }
  }
};
</script>

<style lang="scss" scoped>
.breadcrumb ul {
  align-items: center;
  ::v-deep li:first-of-type > a {
    padding: 0;
  }
}
</style>
