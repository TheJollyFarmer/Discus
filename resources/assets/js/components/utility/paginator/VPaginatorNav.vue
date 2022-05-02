<template>
  <transition-fade>
    <a
      v-show="isValid"
      :class="'pagination-' + type"
      :aria-label="type"
      :rel="type"
      @click.prevent="pageEvent">
      <v-favicon :icon="'chevron-' + iconType"/>
    </a>
  </transition-fade>
</template>

<script>
import TransitionFade from "../../transitions/TransitionFade";
import VFavicon from "../VFavicon";

export default {
  name: "VPaginatorNav",

  components: { TransitionFade, VFavicon },

  props: {
    type: {
      type: String,
      required: false,
      default: "previous"
    }
  },

  computed: {
    iconType() {
      return this.type === "previous" ? "left" : "right";
    },

    isValid() {
      let parentData = this.$parent.$data;
      let type = this.type === "previous" ? 1 : parentData.totalPages;

      return parentData.page !== type;
    }
  },

  methods: {
    pageEvent() {
      this.$emit("select");
    }
  }
};
</script>

<style scoped>
.pagination-previous,
.pagination-next {
  padding: 0;
}
</style>
