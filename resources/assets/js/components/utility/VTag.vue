<template>
  <div 
    v-if="attached && closeable"
    class="tags has-addons">
    <span :class="classes">
      <slot/>
    </span>
    <a
      :class="['tag', 'is-delete', customClass]"
      @click="close()"/>
  </div>
  <span 
    v-else
    :class="classes">
    <slot/>
    <a
      v-if="closeable"
      class="delete is-small"
      @click="close()"/>
  </span>
</template>

<script>
export default {
  name: "VTag",

  props: {
    type: {
      type: String,
      required: false,
      default: "is-primary"
    },

    size: {
      type: String,
      required: false,
      default: ""
    },

    rounded: {
      type: Boolean,
      required: false,
      default: false
    },

    closeable: {
      type: Boolean,
      required: false,
      default: false
    },

    attached: {
      type: Boolean,
      required: false,
      default: false
    },

    customClass: {
      type: String,
      required: false,
      default: ""
    }
  },

  computed: {
    classes() {
      return [
        "tag",
        this.type,
        this.size,
        {
          "is-rounded": this.rounded,
          "is-closeable": this.rounded
        }
      ];
    }
  },

  methods: {
    close() {
      this.$emit("onClose");
    }
  }
};
</script>
