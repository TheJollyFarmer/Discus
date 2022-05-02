<template>
  <article 
    class="media" 
    @click="clickEvent"
    @mouseenter="toggleHover"
    @mouseleave="toggleHover">
    <div :class="['media-left', alignSelf]">
      <slot name="mediaLeft">
        <v-avatar
          v-if="avatar"
          :path="avatar"
          :dimension="dimension"/>
      </slot>
    </div>
    <div :class="['media-content', mediaContentClasses]">
      <slot/>
    </div>
    <div 
      v-if="mediaRight" 
      :class="['media-right', alignSelf]">
      <slot 
        :hover="hover" 
        name="mediaRight"/>
    </div>
  </article>
</template>

<script>
import VAvatar from "./VAvatar";

export default {
  name: "VMediaObject",

  components: { VAvatar },

  props: {
    avatar: {
      type: String,
      required: false,
      default: null
    },

    dimension: {
      type: String,
      required: false,
      default: "42"
    },

    isVCentered: {
      type: Boolean,
      required: false,
      default: true
    },

    mediaIsRight: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  data() {
    return {
      hover: false
    };
  },

  computed: {
    mediaRight() {
      return !!this.$scopedSlots["mediaRight"];
    },

    mediaContentClasses() {
      return {
        "has-text-right": this.mediaIsRight,
        "is-vcentered": this.isVCentered
      };
    },

    alignSelf() {
      return { "is-vcentered": this.isVCentered };
    }
  },

  methods: {
    clickEvent() {
      this.$emit("onClick");
    },

    toggleHover() {
      this.hover = !this.hover;
    }
  }
};
</script>

<style scoped>
.media-left:not(.is-vcentered) {
  padding-top: 0.1em;
}

.media-right {
  margin-left: 0;
}

.is-vcentered {
  align-self: center;
}
</style>
