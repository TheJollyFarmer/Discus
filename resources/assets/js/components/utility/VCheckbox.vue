<template>
  <label class="checkbox">
    <input 
      :checked="checked"
      :required="required"
      :name="name"
      type="checkbox"
      @change="changeEvent">
    {{ label }}
  </label>
</template>

<script>
export default {
  name: "VCheckbox",

  model: {
    prop: "checked",
    event: "change"
  },

  props: {
    checked: {
      type: Boolean,
      required: false,
      default: false
    },

    label: {
      type: String,
      required: true
    },

    type: {
      type: String,
      required: false,
      default: ""
    },

    required: {
      type: Boolean,
      required: false,
      default: false
    },

    name: {
      type: String,
      required: false,
      default: "checkbox"
    }
  },

  methods: {
    changeEvent({ target }) {
      this.$emit("change", target.checked);
    }
  }
};
</script>
