<template>
  <v-media-object
    :avatar="item.avatar_path"
    @onClick="clickEvent">
    <span class="is-size-6">
      {{ item.username }}
    </span>
    <template #mediaRight>
      <v-favicon
        v-if="isActive"
        class="has-text-primary"
        icon="circle"/>
    </template>
  </v-media-object>
</template>

<script>
import VFavicon from "../utility/VFavicon";
import VMediaObject from "../utility/VMediaObject";

export default {
  name: "SearchHitsListItem",

  components: { VFavicon, VMediaObject },

  props: {
    item: {
      type: Object,
      required: true
    },

    isActive: {
      type: Boolean,
      required: true
    }
  },

  methods: {
    clickEvent() {
      this.$emit("onClick");
      // this.toggleState();
    },

    toggleState() {
      this.isActive = !this.isActive;
    }
  }
};
</script>
