<template>
  <div :class="['control', iconClasses()]">
    <input
      ref="input"
      v-autofocus="autofocus"
      :value="value"
      :type="newType"
      :placeholder="placeholder"
      :class="['input', size, customClass, inputErrorClass]"
      :style="{ width : width }"
      required
      @blur="blurEvent"
      @input="inputEvent"
      @focus="focusEvent"
      @keydown="typingEvent"
      @keyup.down="keyDownEvent"
      @keyup.up="keyUpEvent"
      @keyup.enter="enterEvent"
      @tribute-replaced="mentionEvent">
    <v-favicon
      v-if="iconLeft"
      :icon="iconLeft"
      class="is-small is-left"/>
    <v-favicon
      v-if="iconType"
      v-tooltip:right="errorBag"
      :icon="iconType"
      :class="['is-small is-right', iconErrorClass]"
      @onClick="togglePasswordVisibility"/>
  </div>
</template>

<script>
import VFavicon from "./VFavicon";

export default {
  name: "VInput",

  components: { VFavicon },

  props: {
    value: {
      type: [String, Number],
      required: false,
      default: ""
    },

    type: {
      type: String,
      required: false,
      default: "text"
    },

    placeholder: {
      type: String,
      required: false,
      default: "Type your message here..."
    },

    size: {
      type: String,
      required: false,
      default: ""
    },

    width: {
      type: String,
      required: false,
      default: ""
    },

    iconLeft: {
      type: String,
      required: false,
      default: ""
    },

    iconRight: {
      type: String,
      required: false,
      default: null
    },

    customClass: {
      type: String,
      required: false,
      default: ""
    },

    autofocus: {
      type: Boolean,
      required: false,
      default: false
    },

    validation: {
      type: Boolean,
      required: false,
      default: true
    },

    errors: {
      type: String,
      required: false,
      default: ""
    }
  },

  data() {
    return {
      newType: this.type,
      isPasswordVisible: false,
      isValid: false,
      errorBag: ""
    };
  },

  computed: {
    iconErrorClass() {
      return {
        "has-text-danger": this.errorBag,
        "has-text-primary": this.isValid
      };
    },

    inputErrorClass() {
      return {
        "is-danger": this.errorBag,
        "is-primary": this.isValid
      };
    },

    iconType() {
      if (this.iconRight) return this.iconRight;

      if (this.type === "password") {
        return this.isPasswordVisible ? "eye-slash" : "eye";
      }

      if (this.isValid) return "check";

      if (this.errorBag) return "exclamation-circle";
    }
  },

  watch: {
    errors() {
      this.errorBag = this.errors;
      this.isValid = false;
    }
  },

  methods: {
    togglePasswordVisibility() {
      if (this.type === "password") {
        this.isPasswordVisible = !this.isPasswordVisible;

        this.newType = this.isPasswordVisible ? "text" : "password";

        this.$nextTick(() => {
          this.$refs.input.focus();
        });
      }
    },

    validate(input) {
      input.checkValidity()
        ? this.setState("", true)
        : this.setState(input.validationMessage, false);
    },

    setState(errors, validity) {
      this.errorBag = errors;
      this.isValid = validity;
    },

    blurEvent(e) {
      this.$emit("blur", e);

      if (this.validation) {
        this.validate(e.target);
      }
    },

    inputEvent({ target }) {
      this.$emit("input", target.value);
    },

    enterEvent() {
      this.$emit("onEnter");
    },

    focusEvent() {
      this.$emit("focus");
    },

    typingEvent(e) {
      this.$emit("typing", e);
    },

    mentionEvent(e) {
      this.$emit("mention", e);
    },

    keyDownEvent() {
      if (this.value) {
        this.$emit("keyDown", "down");
      }
    },

    keyUpEvent() {
      if (this.value) {
        this.$emit("keyUp", "up");
      }
    },

    iconClasses() {
      return {
        "has-icons-left": !!this.iconLeft,
        "has-icons-right": !!(this.iconRight || this.iconType)
      };
    }
  }
};
</script>

<style scoped>
.control.has-icons-right .icon {
  pointer-events: initial;
  cursor: pointer;
}
</style>
