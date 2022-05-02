<template>
  <v-scroll
    ref="scrollbar"
    textarea
    @created="setScroll">
    <textarea
      ref="textarea"
      v-autofocus="autofocus"
      :placeholder="placeholder"
      :cols="cols"
      :rows="rows"
      :type="type"
      :class="['textarea' , customClass]"
      autofocus
      spellcheck
      @input="inputEvent"
      @keydown.enter.exact.prevent="enterEvent"/>
  </v-scroll>
</template>

<script>
import VScroll from "./VScroll";

export default {
  name: "VTextarea",

  components: { VScroll },

  props: {
    value: {
      type: [String, Number],
      required: false,
      default: ""
    },

    type: {
      type: String,
      required: false,
      default: "is-primary"
    },

    placeholder: {
      type: String,
      required: false,
      default: "Type something here..."
    },

    size: {
      type: String,
      required: false,
      default: ""
    },

    cols: {
      type: String,
      required: false,
      default: ""
    },

    rows: {
      type: String,
      required: false,
      default: ""
    },

    autofocus: {
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

  data() {
    return {
      scroll: null
    };
  },

  methods: {
    inputEvent(e) {
      this.$emit("input", e.target.value);

      this.$refs.textarea.scrollHeight <= 130
        ? this.isDynamic(true, "hidden", "auto")
        : this.isDynamic(false, "auto", "130px");
    },

    enterEvent(e) {
      this.$emit("onEnter");

      e.target.value = "";

      this.isDynamic(true, "hidden", "auto");
    },

    isDynamic(dynamicity, visibility, height) {
      let elStyle = this.$refs.scrollbar.$el.firstChild.style;

      this.scroll.options("textarea.dynHeight", dynamicity);
      this.scroll.options("scrollbars.visibility", visibility);

      elStyle.height = height;

      dynamicity
        ? elStyle.removeProperty("min-height")
        : (elStyle.minHeight = height);
    },

    setScroll(instance) {
      this.scroll = instance;
    }
  }
};
</script>
