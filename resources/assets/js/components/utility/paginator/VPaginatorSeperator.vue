<template>
  <transition-fade>
    <li>
      <span
        v-show="isValid"
        class="pagination-ellipsis"
        v-html="type"/>
    </li>
  </transition-fade>
</template>

<script>
import TransitionFade from "../../transitions/TransitionFade";

export default {
  name: "VPaginatorSeperator",

  components: { TransitionFade },

  props: {
    type: {
      type: String,
      required: false,
      default: "&hellip;"
    }
  },

  computed: {
    isValid() {
      return this.$parent.$data.totalPages > 5;
    }
  }
};
</script>
