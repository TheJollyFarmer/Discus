<template>
  <transition-fade>
    <button
      v-tooltip:left="tooltipText"
      :class="['button', toggleClass]"
      type="button"
      @click.stop="toggle">
      <v-favicon icon="circle"/>
    </button>
  </transition-fade>
</template>

<script>
import VFavicon from "./VFavicon";
import TransitionFade from "../transitions/TransitionFade";

export default {
  name: "VToggle",

  components: { TransitionFade, VFavicon },

  props: {
    classActive: {
      type: String,
      required: false,
      default: "is-circle-active"
    },

    classInactive: {
      type: String,
      required: false,
      default: "is-circle-inactive"
    },

    isActive: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  data() {
    return {
      toggleState: this.isActive
    };
  },

  computed: {
    toggleClass() {
      return this.toggleState ? this.classActive : this.classInactive;
    },

    tooltipText() {
      return this.toggleState ? "Unmark As Read" : "Mark As Read";
    }
  },

  methods: {
    toggle() {
      this.toggleState = !this.toggleState;

      this.$emit("toggled");
    }
  }
};
</script>

<style scoped>
.is-circle-active,
.is-circle-inactive {
  background-color: transparent;
  border: none;
  padding-right: 0.3em;
}

.is-circle-active:focus,
.is-circle-inactive:focus {
  box-shadow: none;
}

.is-circle-active {
  color: #00d1b2;
}

.is-circle-inactive {
  color: white;
}
</style>
