<template>
  <div class="column is-three-quarters">
    <v-breadcrumbs/>
    <slot/>
  </div>
</template>

<script>
import InfiniteScroll from "../../mixins/InfiniteScroll";
import VBreadcrumbs from "./VBreadcrumbs";
import { mapActions } from "vuex";

export default {
  name: "VPage",

  components: { VBreadcrumbs },

  mixins: [InfiniteScroll]
};
</script>
