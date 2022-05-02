<template>
  <transition-fade>
    <div class="form-buttons">
      <v-button
        icon="check"
        @onClick="submitEvent"/>
      <v-button
        icon="times"
        class="is-danger"
        @onClick="closeEvent"/>
    </div>
  </transition-fade>
</template>

<script>
import VButton from "../utility/VButton";
import TransitionFade from "../transitions/TransitionFade";

export default {
  name: "VFormButtons",

  components: { TransitionFade, VButton },

  methods: {
    submitEvent() {
      this.$emit("submit");
    },

    closeEvent() {
      this.$emit("close");
    }
  }
};
</script>

<style scoped>
.form-buttons {
  display: flex;
  margin-left: auto;
}
</style>
