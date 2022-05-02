<template>
  <v-media-object :avatar="item.avatar_path">
    <span class="is-size-6">
      {{ item.username }}
    </span>
    <template #mediaRight>
      <v-favicon
        icon="times"
        class="has-text-danger"
        @click.native="clickEvent"/>
    </template>
  </v-media-object>
</template>

<script>
import VFavicon from "../utility/VFavicon";
import VMediaObject from "../utility/VMediaObject";

export default {
  name: "UsersListItem",

  components: { VFavicon, VMediaObject },

  props: {
    item: {
      type: Object,
      required: true
    }
  },

  methods: {
    clickEvent() {
      this.$emit("onClick");
    }
  }
};
</script>

<style scoped>
</style>
