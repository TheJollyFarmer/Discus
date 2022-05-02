<template>
  <transition-fade>
    <a
      :class="['delete', type, isLeftDelete]"
      @click="clickEvent"/>
  </transition-fade>
</template>

<script>
import TransitionFade from "../transitions/TransitionFade";
export default {
  name: "VDelete",
  components: { TransitionFade },
  props: {
    type: {
      type: String,
      required: false,
      default: "has-background-black"
    },

    isLeft: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  computed: {
    isLeftDelete() {
      return this.isLeft ? "is-left" : "";
    }
  },

  methods: {
    clickEvent() {
      this.$emit("onClick");
    }
  }
};
</script>

<style scoped>
.delete {
  position: absolute;
  top: -10px;
  right: -9px;
}

.is-left {
  left: -10px;
  right: inherit;
}
</style>
