<template>
  <transition-fade>
    <li>
      <a
        :aria-label="'Goto page' + page"
        :class="['pagination-link', isActive]"
        @click="pageEvent">
        {{ page }}
      </a>
    </li>
  </transition-fade>
</template>

<script>
import TransitionFade from "../../transitions/TransitionFade";

export default {
  name: "VPaginatorItem",

  components: { TransitionFade },

  props: {
    page: {
      type: Number,
      required: true
    }
  },

  computed: {
    isActive() {
      return this.$parent.$data.page === this.page ? "is-current" : "";
    }
  },

  methods: {
    pageEvent() {
      this.$emit("select", this.page);
    }
  }
};
</script>
