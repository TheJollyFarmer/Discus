<template>
  <div class="body">
    <transition-fade>
      <div
        v-if="editing"
        key="edit">
        <input
          :id="uniqueId"
          :value="value"
          :name="name"
          type="hidden">
        <trix-editor
          ref="trix"
          :placeholder="placeholder"
          :input="uniqueId"
          required
          @trix-change="change"/>
      </div>
      <div
        v-else
        key="read"
        v-html="value"/>
    </transition-fade>
  </div>
</template>

<script>
import Trix from "trix";
import uuid from "lodash/uniqueId";
import TransitionFade from "../transitions/TransitionFade";

export default {
  name: "VWysiwyg",

  components: { TransitionFade },

  props: {
    value: {
      type: [String, Number],
      required: false,
      default: ""
    },

    placeholder: {
      type: String,
      required: false,
      default: "Have something to say?"
    },

    name: {
      type: String,
      required: false,
      default: "Edit body."
    },

    editing: {
      type: Boolean,
      required: false,
      default: true
    },

    autofocus: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  computed: {
    uniqueId() {
      return uuid("trix-");
    }
  },

  watch: {
    value(val) {
      if (val === "") {
        this.$refs.trix.value = "";
      }
    },

    editing() {
      this.focusInput();
    },

    autofocus() {
      this.focusInput();
    }
  },

  methods: {
    change({ target }) {
      this.$emit("input", target.value);
    },

    focusInput() {
      if (this.editing) {
        setTimeout(() => {
          this.$refs.trix.focus();

          if (this.value) {
            this.$refs.trix.editor.setSelectedRange(this.value.length);
          }
        }, 600);
      }
    }
  }
};
</script>

<style scoped>
.body {
  margin-bottom: 0.75rem;
}
</style>
