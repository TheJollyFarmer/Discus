<template>
  <li :class="[{ 'is-active': isActive }]">
    <a :href="setRoute">
      <v-favicon :icon="breadcrumb.icon"/>
      <span class="is-uppercase">
        {{ breadcrumb.label }}
      </span>
    </a>
  </li>
</template>

<script>
import api from "../../api/index";
import VFavicon from "./VFavicon";

export default {
  name: "VBreadcrumb",

  components: { VFavicon },

  props: {
    breadcrumb: {
      type: Object,
      required: true
    },

    isActive: {
      type: Boolean,
      required: true
    }
  },

  computed: {
    setRoute() {
      return this.breadcrumb.route || this.breadcrumb.linkData
        ? this.route(this.breadcrumb.route, this.breadcrumb.linkData)
        : false;
    }
  },

  methods: {
    route: api.route
  }
};
</script>
