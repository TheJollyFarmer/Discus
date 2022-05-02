<template>
  <div :class="['field', classes]">
    <label 
      v-if="label" 
      class="label">{{ label }}</label>
    <slot/>
    <p 
      v-if="message" 
      class="help">{{ message }}</p>
  </div>
</template>

<script>
export default {
  name: "VField",

  props: {
    type: {
      type: [String, Object],
      required: false,
      default: ""
    },

    label: {
      type: String,
      required: false,
      default: null
    },

    message: {
      type: String,
      required: false,
      default: null
    },

    addons: {
      type: Boolean,
      required: false,
      default: false
    },

    grouped: {
      type: Boolean,
      required: false,
      default: false
    },

    multiline: {
      type: Boolean,
      required: false,
      default: false
    },

    horizontal: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  computed: {
    classes() {
      return {
        "has-addons": this.addons,
        "is-grouped": this.grouped,
        "is-grouped-multiline": this.multiline,
        "is-horizontal": this.horizontal
      };
    }
  }
};
</script>

<style scoped>
</style>
