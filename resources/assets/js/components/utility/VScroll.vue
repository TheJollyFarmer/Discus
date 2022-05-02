<template>
  <div ref="scroll">
    <slot/>
  </div>
</template>

<script>
import OverlayScrollbars from "overlayscrollbars/js/OverlayScrollbars.js";

export default {
  name: "VScroll",

  props: {
    options: {
      type: [Object],
      required: false,
      default: () => ({})
    },

    textarea: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  data() {
    return {
      defaultOptions: {
        className: "os-theme-dark scrollbar",
        scrollbars: { autoHide: "scroll" },
        overflowBehavior: { x: "hidden" }
      }
    };
  },

  computed: {
    optionsMerged() {
      return { ...this.defaultOptions, ...this.options };
    }
  },

  mounted() {
    let el = this.textarea ? this.$slots.default[0].elm : this.$refs.scroll;
    let scroll = OverlayScrollbars(el, this.optionsMerged);

    this.$emit("created", scroll);
  }
};
</script>

<style lang="scss">
.scrollbar > .os-scrollbar > .os-scrollbar-track > .os-scrollbar-handle {
  border-radius: 0;
  background: rgba(0, 209, 178, 0.8);
}

.scrollbar > .os-scrollbar > .os-scrollbar-track > .os-scrollbar-handle:hover {
  background: rgba(0, 209, 178, 1);
}

.scrollbar > .os-scrollbar-vertical {
  bottom: 0;
  right: -2px;
}

.os-host-textarea {
  border-color: #4a4a4a;
  border-width: 1px 0 0 0;
  box-shadow: 0 -1px 1px rgba(0, 0, 0, 0.1);
  min-height: 0 !important;
  padding: calc(0.375em - 1px) calc(0.625em - 1px) calc(0.375em - 1px)
    calc(0.625em - 1px);
  &:hover {
    border-color: #4a4a4a;
    border-width: 1px 0 0 0;
  }
}
</style>
