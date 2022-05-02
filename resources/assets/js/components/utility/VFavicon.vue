<template>
  <transition-fade :duration="0.2">
    <span
      :key="icon"
      class="icon">
      <i :class="['fas', iconSize, iconType]"/>
      <v-number
        v-if="count"
        :count="count"/>
    </span>
  </transition-fade>
</template>

<script>
import throttle from "lodash/throttle";
import TransitionFade from "../transitions/TransitionFade";
import VNumber from "./VCount";

export default {
  name: "VFavicon",

  components: { TransitionFade, VNumber },

  props: {
    icon: {
      type: String,
      required: true
    },

    size: {
      type: String,
      required: false,
      default: ""
    },

    count: {
      type: Number,
      required: false,
      default: 0
    }
  },

  computed: {
    iconType() {
      return "fa-" + this.icon;
    },

    iconSize() {
      return this.size ? "fa-" + this.size : "";
    }
  }
};
</script>
